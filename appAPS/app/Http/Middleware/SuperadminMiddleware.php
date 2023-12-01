<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperadminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        //dd(auth()->user());
        if (auth()->check() && auth()->user()->role_id === '1') {
            return $next($request);
        } else {

        return redirect()->route('login')->with('error', 'Unauthorized');
        }
    }
}
