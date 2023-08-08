<?php

namespace App\Http\Middleware;

use Closure;

class PasswordResetTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->session()->has('reset_password_token')) {
            return redirect()->route('forgot-password')->with('error', 'Please click the password reset link sent to your email.');
        }

        if (!$request->session()->has('reset_link_sent')) {
            return redirect()->route('forgot-password')->with('error', 'Please request a password reset first.');
        }

        return $next($request);
    }
}