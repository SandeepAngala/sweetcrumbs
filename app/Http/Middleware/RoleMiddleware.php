<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(401, 'Unauthenticated.');
        }

        if ($user->is_blocked) {
            abort(403, 'Your account has been blocked.');
        }

        $allowed = collect($roles)->flatMap(fn ($r) => explode('|', $r));

        $hasRole = $allowed->contains($user->role)
            || $allowed->some(fn ($role) => $user->hasRole($role));

        if ($hasRole || ($allowed->contains('admin') && $user->isAdmin())) {
            return $next($request);
        }

        abort(403, 'Unauthorized. Insufficient role permissions.');
    }
}
