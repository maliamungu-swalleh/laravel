<?php

namespace App\Application\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WalletVerifiedMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // For withdrawals, KYC 'approved' is a hard requirement.
        if (!$request->user() || $request->user()->verification_status !== 'approved') {
            return response()->json(['message' => 'Wallet settlements require an approved professional profile.'], 403);
        }

        return $next($request);
    }
}
