<?php

namespace App\Application\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProfileApprovedMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || $request->user()->verification_status !== 'approved') {
            return response()->json(['message' => 'Action restricted to approved professional profiles.'], 403);
        }

        return $next($request);
    }
}
