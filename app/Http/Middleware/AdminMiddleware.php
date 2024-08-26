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
        // role == 1 for modarator and role == 2 for admin
        if (auth()->check() && (auth()->user()->role == 1 || auth()->user()->role == 2)) {
            return $next($request);
        }
        return redirect()->route('admin.load.login');
    }
}
