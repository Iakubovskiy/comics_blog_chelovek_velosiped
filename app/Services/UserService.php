<?php
namespace App\Services;

use App\Models\User;
use App\Repositories\RepositoryInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;

class UserService
{
    protected $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
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
        $token = $user->createToken('auth_token')->plainTextToken;

        return ['user' => $user, 'token' => $token];
    }

    public function login(array $data)
    {
        $credentials = ['email' => $data['email'], 'password' => $data['password']];

        if (!Auth::attempt($credentials)) {
             return ['error' => 'Невірний логін чи пароль'];
        }

        $user = Auth::user();

        $token = $user->createToken('auth_token')->plainTextToken;

        return ['user' => $user, 'token' => $token];
    }

    public function logout()
    {
        $user = Auth::user();

        if ($user) {
            $user->tokens()->delete();
            Cookie::queue(Cookie::forget('XSRF-TOKEN'));
            Cookie::queue(Cookie::forget('laravel_session'));
        }

        return redirect()->route('login')->with('success', 'Ви вийшли з системи!');
    }
}
