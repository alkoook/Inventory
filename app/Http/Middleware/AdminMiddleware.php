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
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // If user is manager, block access to restricted routes
        if ($user->hasRole('manager')) {
            $restrictedRoutes = [
                'admin.reports.index',
                'admin.users.index',
                'admin.users.create',
                'admin.users.edit',
                'admin.settings',
            ];

            if (in_array($request->route()->getName(), $restrictedRoutes)) {
                abort(403, 'غير مصرح لك بالوصول إلى هذه الصفحة');
            }
        }

        // Allow admin, manager, and worker to access admin panel
        if ($user->hasRole('admin') || $user->hasRole('manager') || $user->hasRole('worker')) {
            return $next($request);
        }

        // Redirect customer to client pages
        if ($user->hasRole('customer')) {
            return redirect()->route('client.catalog');
        }

        abort(403, 'غير مصرح لك بالوصول إلى هذه الصفحة');
    }
}
