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

        $result = $this->userService->register($data);

        return response()
            ->redirectToRoute('login')
            ->cookie('auth_token', $result['token'], 60 * 24)
            ->with('success', 'Реєстрація успішна!');
    }

    public function login(Request $request)
    {
        $data = $request->only(['email', 'password']);

        $result = $this->userService->login($data);

        if (isset($result['token'])) {
            $role = $result['user']->role->name;
            $redirectRoute = $role === 'Адміністратор' ? 'admin' : '/toms';
    
            return response()
                ->redirectTo($redirectRoute)
                ->cookie('auth_token', $result['token'], 60 * 24)
                ->with('success', 'Вхід успішний!');
        }
    
        return redirect()->back()->withErrors(['error' => 'Не вдалося увійти!'])->withInput();
    }

    public function logout(Request $request)
    {
        return $this->userService->logout()
            ->cookie('auth_token', '', -1);
    }
}

