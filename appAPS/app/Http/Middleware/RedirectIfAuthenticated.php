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

    public function handle($request, Closure $next)
    {
        if (auth()->check()) {
            $role = auth()->user()->role_id;

            if ($role == 1) {
                return redirect()->route('dashboard.superadmin'); // Redirect superadmin to their dashboard
            } elseif ($role == 2) {
                return redirect()->route('dashboard.sekda'); // Redirect sekda to their dashboard
            } elseif ($role == 3) {
                return redirect()->route('dashboard.opd'); // Redirect opd to their dashboard
            } else{
                return redirect()->route('login');
            }
        }

        return $next($request);
    }
}
