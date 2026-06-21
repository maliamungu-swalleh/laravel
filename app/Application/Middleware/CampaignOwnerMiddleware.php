<?php

namespace App\Application\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Domains\Campaigns\Models\Campaign;

class CampaignOwnerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $campaignId = $request->route('id') ?? $request->input('campaign_id');
        $campaign = Campaign::find($campaignId);

        if (!$campaign || $campaign->owner_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized access to this campaign brief.'], 403);
        }

        return $next($request);
    }
}
