<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtCookieMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the 'jwt_token' cookie exists
        if (!$request->bearerToken() && !$request->hasCookie('jwt_token')) {
            return redirect('/login')->with('error', 'Session expired. Please log in again.');
        }

        // Retrieve JWT token from the cookie and set it in the request header
        if (!$request->bearerToken() && $request->hasCookie('jwt_token')) {
            $token = $request->cookie('jwt_token');
            $request->headers->set('Authorization', 'Bearer ' . $token);
        }

        // Attempt authentication
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return redirect('/login')->with('error', 'Invalid token. Please log in again.');
            }
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Authentication failed. Please log in again.');
        }

        return $next($request);

    }
}
