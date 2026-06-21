<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Register event broadcasting channels for real-time features:
|   - Messaging (conversations)
|   - Notifications (admin panel, user dashboard)
|   - Campaign updates
|
*/

// ─── PRIVATE CHANNELS ────────────────────────────

// User-specific channel
Broadcast::channel('users.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Conversation channel
Broadcast::channel('conversations.{conversationId}', function ($user, $conversationId) {
    return \Domain\Messaging\Models\Conversation::where('id', $conversationId)
        ->where(function ($q) use ($user) {
            $q->where('participant_one_id', $user->id)
              ->orWhere('participant_two_id', $user->id);
        })
        ->exists();
});

// Admin channel
Broadcast::channel('admin', function ($user) {
    return $user->hasRole('admin');
});

// ─── PRESENCE CHANNELS ───────────────────────────

// Campaign chat presence
Broadcast::channel('campaigns.{campaignId}', function ($user, $campaignId) {
    $isParticipant = \Domain\Campaign\Models\CampaignParticipant::where('campaign_id', $campaignId)
        ->where('participant_id', $user->id)
        ->whereIn('status', ['accepted', 'active'])
        ->exists();

    $isOwner = \Domain\Campaign\Models\Campaign::where('id', $campaignId)
        ->where('owner_id', $user->id)
        ->exists();

    if ($isParticipant || $isOwner) {
        return [
            'id'   => $user->id,
            'name' => $user->creatorProfile?->display_name ?? $user->name,
            'avatar' => $user->creatorProfile?->avatar,
        ];
    }

    return false;
});