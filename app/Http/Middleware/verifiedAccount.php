<?php

namespace App\Http\Middleware;

use Closure;

class verifiedAccount
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
        if(isset(get_auth_user()->email_verified_at))
            return $next($request);
        return returnErrorMessage(translate('needToVerify'),403);
    }
}
