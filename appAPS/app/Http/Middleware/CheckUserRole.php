<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // $user = $request->user();

        // if ($user && in_array($user->role->name, $roles)) {
        //     return $next($request);
        // }else{
        //     return redirect('/login');
        // }

        // if (!auth()->check()) {
        //     return redirect()->route('/login');
        // }

        // $user = auth()->user();

        // if (in_array($user->role_id, $roles)) {
        //     return $next($request);
        // }

        // return redirect('/login'); // Redirect to a default page if not authorized

        // Check if the user is authenticated
        if (Auth::check()) {
            // Get the user's role_id
            $user = Auth::user()->role_id;

            // Check if the user's role matches any of the allowed roles
            if (in_array($user, $roles)) {
                return $next($request);
            }
        }

        // Redirect or return an error for unauthorized access
        return redirect('/login')->withErrors('You are not authorized to access this page.');
    }
}
