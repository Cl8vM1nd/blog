<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AjaxCheck
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
        // Check if auth hash is ok
        if(!\AjaxAuth::checkHash($request->header('Auth'))) {
            return abort(401, 'Bad Request');
        }

        return $next($request);
    }
}
