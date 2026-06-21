<?php

namespace App\Application\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlueCheckMiddleware
{
    /**
     * Gated for "Blue Check" verified professionals only.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || $request->user()->verification_status !== 'approved') {
            return response()->json(['message' => 'Restricted to Blue-Check verified partners.'], 403);
        }

        return $next($request);
    }
}
