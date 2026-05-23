<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user && $user->isStaff()) {
            if ($user->is_blocked) {
                abort(403, 'Your account has been blocked.');
            }

            return $next($request);
        }

        abort(403, 'Unauthorized access. Admins only.');
    }
}
