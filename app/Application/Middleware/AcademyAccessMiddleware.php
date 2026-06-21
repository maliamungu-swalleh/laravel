<?php

namespace App\Application\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AcademyAccessMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->is_premium) {
            return response()->json(['message' => 'Elite Academy is restricted to Premium members.'], 403);
        }

        return $next($request);
    }
}
