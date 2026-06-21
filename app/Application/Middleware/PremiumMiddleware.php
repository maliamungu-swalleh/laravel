<?php

namespace App\Application\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PremiumMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->is_premium) {
            return response()->json([
                'message' => 'Elite Membership required.',
                'upgrade_url' => '/pricing'
            ], 402); // Payment Required
        }

        return $next($request);
    }
}
