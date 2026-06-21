<?php

namespace App\Application\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!$request->user() || !in_array($role, $request->user()->roles)) {
            return response()->json(['message' => "Restricted to users with the '{$role}' role."], 403);
        }

        return $next($request);
    }
}
