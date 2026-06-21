<?php

namespace App\Application\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Domains\Campaigns\Models\Campaign;

class CampaignLimitMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (!$user) return response()->json(['message' => 'Unauthorized'], 401);

        // Standard users can only have 3 active campaigns. Elite users are unlimited.
        if (!$user->is_premium) {
            $activeCount = Campaign::where('owner_id', $user->id)
                ->where('status', 'active')
                ->count();

            if ($activeCount >= 3) {
                return response()->json(['message' => 'Campaign limit reached. Upgrade to Elite to launch more.'], 403);
            }
        }

        return $next($request);
    }
}
