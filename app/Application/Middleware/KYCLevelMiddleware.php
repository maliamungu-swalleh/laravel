<?php

namespace App\Application\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class KYCLevelMiddleware
{
    public function handle(Request $request, Closure $next, int $level): Response
    {
        // Level 1: Basic Profile, Level 2: ID Upload, Level 3: Full Audit
        $user = $request->user();
        
        $currentLevel = 0;
        if ($user->verification_status === 'approved') $currentLevel = 3;
        elseif ($user->verification_status === 'pending') $currentLevel = 1;

        if ($currentLevel < $level) {
            return response()->json(['message' => "Higher KYC Level ({$level}) required."], 403);
        }

        return $next($request);
    }
}
