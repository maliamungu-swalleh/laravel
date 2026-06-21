<?php

namespace App\Application\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FeatureAccessMiddleware
{
    public function handle(Request $request, Closure $next, string $feature): Response
    {
        $user = $request->user();
        
        // Dynamic feature gating
        if ($feature === 'ai_brief_architect' && !$user->is_premium) {
            return response()->json(['message' => 'AI Brief Architect requires Elite Membership.'], 403);
        }

        return $next($request);
    }
}
