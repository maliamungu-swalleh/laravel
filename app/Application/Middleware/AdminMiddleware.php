<?php

namespace App\Application\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !in_array('admin', $request->user()->roles)) {
            return response()->json(['message' => 'Restricted to administrators only.'], 403);
        }

        return $next($request);
    }
}
