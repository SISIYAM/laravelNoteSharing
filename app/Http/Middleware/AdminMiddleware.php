<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    
    public function handle(Request $request, Closure $next): Response
    {
        // check if the user is authenticated
        if (auth()->check()) {
            $user = auth()->user();

            // check if the user has the role of admin (role == 2) or moderator (role == 1)
            if (($user->role == 1 || $user->role == 2) && $user->status == 1) {
                return $next($request);
            } 

            // if the user's status is not active (status == 0), log them out and redirect to login
            auth()->logout();
            return redirect()->route('admin.load.login')->with('error', 'Your account is deactivated. Please contact the administrator.');
        }

        // if the user is not authenticated, redirect to the login page
        return redirect()->route('admin.load.login');
    }

}
