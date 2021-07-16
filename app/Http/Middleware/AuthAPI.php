<?php

namespace App\Http\Middleware;

use Closure;

class AuthAPI
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   if(!$request->has('api_token')|| !get_auth_user())
            return response(returnErrorMessage('login failed please try to login'),403);
        return $next($request);
    }
}
