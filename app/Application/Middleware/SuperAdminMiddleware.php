<?php

namespace App\Application\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // For this ecosystem, 'super-admin' is the highest tier of the Guard Suite
        if (!$request->user() || !in_array('super-admin', $request->user()->roles)) {
            return response()->json(['message' => 'Restricted to system super-admins.'], 403);
        }

        return $next($request);
    }
}
