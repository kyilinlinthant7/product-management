<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginMiddleware
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
		if (session()->has('user_id')) {

			$sessionId = session('user_id');
			Auth::loginUsingId($sessionId);

            return $next($request);
			
        }

        return redirect()->route('login'); 
    }
}
