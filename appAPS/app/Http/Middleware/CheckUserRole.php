<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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

        if (!auth()->check()) {
            return redirect()->route('/login');
        }

        $user = auth()->user();

        if (in_array($user->role_id, $roles)) {
            return $next($request);
        }

        return redirect('/login'); // Redirect to a default page if not authorized
    }
}
