<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(Request $request)
    {
        $data = $request->only(['name', 'login', 'email', 'password', 'c_password', 'phone']);

        return $this->userService->register($data);
    }

    public function login(Request $request)
    {
        $data = $request->only(['email', 'password']);
        $this->userService->login($data);
        $token = $request->cookie('jwt_token');
        if ($token) {
            return redirect()->route('admin')->withHeaders([
                'Authorization' => 'Bearer ' . $token
            ]);
        }
    
        return redirect()->route('login');
    }

    public function authenticate(Request $request)
    {
        $token = $request->bearerToken(); 
        return $this->userService->authenticateUser($token);
    }

    public function logout(Request $request)
    {
        return $this->userService->logout();
    }
}
