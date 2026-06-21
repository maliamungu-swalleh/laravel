<?php

namespace App\Application\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CapabilityMiddleware
{
    /**
     * Checks if the user has a specific functional capability.
     * Capabilities are derived from roles + verification status.
     */
    public function handle(Request $request, Closure $next, string $capability): Response
    {
        $user = $request->user();
        if (!$user) return response()->json(['message' => 'Unauthorized'], 401);

        $hasCapability = false;

        switch ($capability) {
            case 'manage_briefs':
                // Brands, Artists, and Admins can create campaigns/hires
                $hasCapability = count(array_intersect(['brand', 'artist', 'admin'], $user->roles)) > 0;
                break;
            case 'monetize':
                // Creators and Artists can participate/monetize if approved
                $hasCapability = $user->isParticipant();
                break;
            case 'provide_services':
                // Talent can sell services if they are approved participants
                $hasCapability = $user->isParticipant();
                break;
            case 'access_treasury':
                $hasCapability = in_array('admin', $user->roles);
                break;
        }

        if (!$hasCapability) {
            return response()->json(['message' => "Your account lacks the '{$capability}' capability or is not yet verified."], 403);
        }

        return $next($request);
    }
}
