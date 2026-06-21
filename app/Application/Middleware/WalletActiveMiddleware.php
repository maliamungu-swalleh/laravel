<?php

namespace App\Application\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WalletActiveMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Logic to check if wallet is suspended due to fraud signals
        if ($request->user() && $request->user()->wallet_suspended) {
            return response()->json(['message' => 'Your financial wallet is currently locked pending audit.'], 403);
        }

        return $next($request);
    }
}
