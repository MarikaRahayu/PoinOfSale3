<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // cek role user
        if (!in_array($request->user()->role?->name, $roles)) {
            abort(403, 'Akses ditolak');
        }

        return $next($request);
    }
}