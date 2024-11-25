<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthenticateWithJWT
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        //dump( $request->cookies->all());
        $token = $request->cookie('jwt_token');
        
        if (!$token) {
            return response()->json(['error' => 'Token not provided'], 401);
        }
        dump(1);
        try {
            $user = JWTAuth::toUser($token);
        } catch (\Exception $e) {
            dump('JWT Token error', ['error' => $e->getMessage(), 'token' => $token]);
            throw new UnauthorizedHttpException('jwt-auth', 'Token is invalid or expired');
        }
        return $next($request);
    }
}
