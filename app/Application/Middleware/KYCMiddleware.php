<?php

namespace App\Application\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class KYCMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || $request->user()->verification_status !== 'approved') {
            return response()->json([
                'message' => 'Identity verification (KYC) required for this action.',
                'kyc_url' => '/dashboard/kyc'
            ], 403);
        }

        return $next($request);
    }
}
