<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperadminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->role_id == 1) {
            return $next($request);
        }

        return redirect('/login')->with('error','Anda tidak memiliki akses terhadap fitur ini!');

        // if (Auth::check() && Auth::user()->role_id == 1) {
        //     return $next($request);
        // }

        // // Redirect user to login page with an error message
        // return redirect('login')->with(['error' => 'Anda tidak memiliki akses pada halaman ini!']);

    }
}
