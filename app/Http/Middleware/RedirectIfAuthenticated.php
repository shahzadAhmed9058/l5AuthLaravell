<?php

namespace App\Http\Middleware;

use Closure;
use http\Env\Request;
use Illuminate\Auth\SessionGuard;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
//        dd($request->route('id'));
        switch ($guard)
        {
            case 'admin':
                {
                    if (Auth::guard($guard)->check()) {
                        return redirect('/admin');
                    }
                }
                break;
            default:
                {
                    if (Auth::guard($guard)->check()) {
                        return redirect('/home');
                    }
                }
                break;
        }

        $request->merge(array("guard" => $guard));
        return $next($request);
    }
}
