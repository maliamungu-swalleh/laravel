<?php

namespace App\Application\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Logic for subscription expiry would go here.
        // For the prototype, we rely on the is_premium flag.
        if (!$request->user() || !$request->user()->is_premium) {
            return response()->json(['message' => 'Active subscription required.'], 402);
        }

        return $next($request);
    }
}
