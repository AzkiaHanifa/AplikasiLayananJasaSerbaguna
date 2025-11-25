<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            return redirect('login');
        }

        // cek apakah role user termasuk dalam role yang diizinkan
        if (!in_array(auth()->user()->roles, $roles)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}