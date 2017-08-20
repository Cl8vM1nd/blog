<?php
# CrEaTeD bY FaI8T IlYa      
# 2017  
namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Http\Request;

class Authenticate
{
    /**
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $guard = \Auth::getDefaultDriver();
        $guest = true;

        if (func_num_args() > 2) {

            // Get guards list from route middleware and default driver
            $checkGuards = array_unique(array_slice(func_get_args(), 2));

            foreach ($checkGuards as $checkGuard) {
                if (!\Auth::guard($checkGuard)->guest()) {
                    \Auth::setDefaultDriver($guard = $checkGuard);
                    $guest = false;
                    break;
                }
            }
        } else {
            $guest = \Auth::guard($guard)->guest();
        }

        if ($guest) {
            if ($guard === 'admin' || (isset($checkGuards) && in_array('admin', $checkGuards))) {
                return \Redirect::guest('/admin/login');
            } else {
                \Redirect::guest('/login');
            }
        }

        return $next($request);
    }
}