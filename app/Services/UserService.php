<?php
namespace App\Services;

use App\Models\User;
use App\Repositories\RepositoryInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserService
{
    protected $repository;
    
    public function __construct(RepositoryInterface $repository) {
        $this->repository = $repository;
    }

    // Реєстрація
    public function register(array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required',
            'login' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'phone' => 'required|unique:users',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $input = $data;
        $input['password'] = bcrypt($input['password']);
        $input['role_id'] = 2;

        $user = User::create($input);
        $token = JWTAuth::fromUser($user);
        return response()->json(['token' => $token, 'user' => $user], 201);
    }

    public function login(array $data)
    {
        
        $credentials = ['email' => $data['email'], 'password' => $data['password']];
        if (!Auth::attempt($credentials)) {
            return redirect()->back()->withErrors(['error' => 'Невірний логін чи пароль'])->withInput();
        }

        $user = Auth::user();
        $token = JWTAuth::fromUser($user);
        return response()->json(['success' => 'Ви увійшли в систему!'])
        ->cookie('jwt_token', $token, 60*24);
    }

    public function authenticateUser($token)
    {
        try {
            if (!$user = JWTAuth::authenticate($token)) {
                return response()->json(['error' => 'User not found'], 404);
            }
            return response()->json(['user' => $user], 200);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Failed to authenticate token'], 500);
        }
    }

    public function logout()
    {
        return redirect()->route('auth.login.view')->with('success', 'Ви вийшли з системи!')->cookie(
            'jwt_token', 
            '', 
            -1
        );
    }

}

