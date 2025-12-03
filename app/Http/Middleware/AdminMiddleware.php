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
<<<<<<< HEAD
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
=======
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (!auth()->user()->isAdmin()) {
            abort(403, 'غير مصرح لك بالوصول إلى هذه الصفحة');
>>>>>>> 07d468d8af2e220903f1160b2f1d5d84afb5fd1d
        }

        return $next($request);
    }
}
