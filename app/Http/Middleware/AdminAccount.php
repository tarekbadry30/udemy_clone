<?php

namespace App\Http\Middleware;

use Closure;

class AdminAccount
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
        if(get_auth_user()->isAdmin())
            return $next($request);
        return returnErrorMessage(translate('notHavePermission'),403);
    }
}
