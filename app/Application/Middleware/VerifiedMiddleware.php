<?php

namespace App\Application\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifiedMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || $request->user()->verification_status !== 'approved') {
            return response()->json(['message' => 'Professional verification required.'], 403);
        }

        return $next($request);
    }
}
