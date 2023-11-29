<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next, string ...$guards): Response
    // {
    //     $guards = empty($guards) ? [null] : $guards;

        // foreach ($guards as $guard) {
        //     if (Auth::guard($guard)->check()) {
        //         return redirect(RouteServiceProvider::HOME);
        //     }
        //}
    // }
//}

    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            switch (auth()->user()->role_id) {
                case 1:
                    return redirect()->route("superadmin.dashboard");
                case 2:
                    return redirect()->route("sekda.dashboard");
                case 3:
                    return redirect()->route("opd.dashboard");
                default:
                    return redirect("/login");
            }
        }

        return $next($request);
    }
}
