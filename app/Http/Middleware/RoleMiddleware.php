<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = auth('api')->user();

        // jika belum login
        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized, silakan login'
            ], 401);
        }

        // cek role
        if (!in_array($user->role, $roles)) {
            return response()->json([
                'message' => 'Akses ditolak, role tidak diizinkan'
            ], 403);
        }

        return $next($request);
    }
}