<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| UGCFYP Web Routes
|--------------------------------------------------------------------------
|
| Web routes are minimal since UGCFYP is primarily an API platform
| with a Next.js frontend. These routes handle:
|   - Filament Admin Panel
|   - Public certificate verification
|   - Affiliate link redirects
|   - Social OAuth callbacks
|   - Health checks
|   - File downloads
|
*/

// ─────────────────────────────────────────────────
// HOME (Redirect to Frontend)
// ─────────────────────────────────────────────────
Route::get('/', function () {
    return redirect(config('app.frontend_url', 'http://localhost:3000'));
});

// ─────────────────────────────────────────────────
// HEALTH CHECK
// ─────────────────────────────────────────────────
Route::get('/up', function () {
    return response()->json([
        'status'  => 'ok',
        'version' => config('app.version', '1.0.0'),
        'timestamp' => now()->toIso8601String(),
    ]);
});

Route::get('/health', function () {
    return response()->json([
        'status'    => 'healthy',
        'app'       => config('app.name'),
        'env'       => config('app.env'),
        'debug'     => config('app.debug'),
        'timezone'  => config('app.timezone'),
        'timestamp' => now()->toIso8601String(),
    ]);
});

// ─────────────────────────────────────────────────
// PING (Load Balancer Health Check)
// ─────────────────────────────────────────────────
Route::get('/ping', function () {
    return response('pong', 200);
});

// ─────────────────────────────────────────────────
// PUBLIC CERTIFICATE VERIFICATION
// ─────────────────────────────────────────────────
Route::get('/verify/{code}', function (string $code) {
    $certificate = \Domain\Academy\Models\Certificate::where('verification_code', $code)
        ->where('is_revoked', false)
        ->with(['user', 'course'])
        ->first();

    if (!$certificate) {
        return view('certificates.invalid', ['code' => $code]);
    }

    $certificate->increment('views_count');

    return view('certificates.verify', [
        'certificate' => $certificate,
    ]);
})->name('certificate.verify');

// ─────────────────────────────────────────────────
// PUBLIC CERTIFICATE VIEW (Shareable Link)
// ─────────────────────────────────────────────────
Route::get('/certificate/{shareableLink}', function (string $shareableLink) {
    $certificate = \Domain\Academy\Models\Certificate::where('shareable_link', $shareableLink)
        ->where('is_revoked', false)
        ->where('is_public', true)
        ->with(['user', 'course'])
        ->firstOrFail();

    $certificate->increment('views_count');

    return view('certificates.show', [
        'certificate' => $certificate,
    ]);
})->name('certificate.show');

// ─────────────────────────────────────────────────
// AFFILIATE LINK REDIRECT (Click Tracking)
// ─────────────────────────────────────────────────
Route::get('/ref/{code}', function (string $code, Request $request) {
    $link = \Domain\Affiliate\Models\AffiliateLink::where('code', $code)
        ->where('status', 'active')
        ->first();

    if (!$link) {
        return redirect(config('app.frontend_url'));
    }

    // Track the click
    \Domain\Affiliate\Services\TrackingService::trackClick(
        $link,
        $request->ip(),
        $request->userAgent(),
        $request->header('Referer')
    );

    // Redirect to the event or campaign page
    $redirectUrl = $link->event_id
        ? config('app.frontend_url') . "/events/{$link->event_id}"
        : config('app.frontend_url') . "/campaigns/{$link->campaign_id}";

    return redirect($redirectUrl);
})->name('affiliate.redirect');

// ─────────────────────────────────────────────────
// EVENT PUBLIC PAGE REDIRECT
// ─────────────────────────────────────────────────
Route::get('/e/{event}', function (\Domain\Event\Models\Event $event, Request $request) {
    // Check for affiliate referral code
    if ($request->has('ref')) {
        $code = $request->get('ref');
        \Domain\Affiliate\Services\TrackingService::trackClickByCode(
            $code,
            $request->ip(),
            $request->userAgent(),
            $request->header('Referer')
        );
    }

    return redirect(config('app.frontend_url') . "/events/{$event->id}");
})->name('event.public');

// ─────────────────────────────────────────────────
// TICKET QR VERIFICATION PAGE
// ─────────────────────────────────────────────────
Route::get('/ticket/{ticketNumber}', function (string $ticketNumber) {
    $sale = \Domain\Ticket\Models\TicketSale::where('ticket_number', $ticketNumber)
        ->with(['event', 'ticketType'])
        ->first();

    if (!$sale) {
        return view('tickets.invalid');
    }

    return view('tickets.verify', ['sale' => $sale]);
})->name('ticket.verify');

// ─────────────────────────────────────────────────
// SOCIAL OAUTH CALLBACKS
// ─────────────────────────────────────────────────
Route::prefix('social')->group(function () {
    Route::get('/tiktok/callback', function (Request $request) {
        return redirect(config('app.frontend_url') . '/creator/profile/social?' . http_build_query($request->all()));
    });

    Route::get('/instagram/callback', function (Request $request) {
        return redirect(config('app.frontend_url') . '/creator/profile/social?' . http_build_query($request->all()));
    });

    Route::get('/youtube/callback', function (Request $request) {
        return redirect(config('app.frontend_url') . '/creator/profile/social?' . http_build_query($request->all()));
    });

    Route::get('/facebook/callback', function (Request $request) {
        return redirect(config('app.frontend_url') . '/creator/profile/social?' . http_build_query($request->all()));
    });

    Route::get('/twitter/callback', function (Request $request) {
        return redirect(config('app.frontend_url') . '/creator/profile/social?' . http_build_query($request->all()));
    });
});

// ─────────────────────────────────────────────────
// FILE DOWNLOADS (Authenticated)
// ─────────────────────────────────────────────────
Route::middleware(['auth', 'signed'])->group(function () {
    Route::get('/download/certificate/{certificate}', function (\Domain\Academy\Models\Certificate $certificate) {
        if (!Storage::disk('public')->exists($certificate->certificate_path)) {
            abort(404);
        }
        return Storage::disk('public')->download(
            $certificate->certificate_path,
            "UGCFYP-Certificate-{$certificate->certificate_number}.pdf"
        );
    })->name('download.certificate');

    Route::get('/download/license/{purchase}', function (\Domain\Licensing\Models\LicensePurchase $purchase) {
        if ($purchase->buyer_id !== auth()->id()) {
            abort(403);
        }
        return Storage::disk('public')->download(
            $purchase->asset->file_path,
            "UGCFYP-Asset-{$purchase->license_key}"
        );
    })->name('download.license');
});

// ─────────────────────────────────────────────────
// PASSWORD RESET (Web)
// ─────────────────────────────────────────────────
Route::get('/reset-password/{token}', function (string $token) {
    return redirect(config('app.frontend_url') . "/reset-password?token={$token}");
})->name('password.reset');

// ─────────────────────────────────────────────────
// EMAIL VERIFICATION
// ─────────────────────────────────────────────────
Route::get('/verify-email/{id}/{hash}', function (Request $request) {
    return redirect(config('app.frontend_url') . '/email-verified');
})->name('verification.verify');

// ─────────────────────────────────────────────────
// MAINTENANCE MODE BYPASS (Admin)
// ─────────────────────────────────────────────────
Route::get('/admin-bypass/{secret}', function (string $secret) {
    if ($secret === config('app.maintenance.bypass_secret')) {
        session()->put('maintenance_bypass', true);
        return redirect('/');
    }
    abort(404);
});

// ─────────────────────────────────────────────────
// FILAMENT ADMIN PANEL (Auto-discovered)
// ─────────────────────────────────────────────────
// Filament routes are automatically registered.
// Access at: /admin
// No manual route registration needed.

// ─────────────────────────────────────────────────
// FALLBACK (404 for undefined web routes)
// ─────────────────────────────────────────────────
Route::fallback(function () {
    return response()->json([
        'message' => 'Not Found',
        'status'  => 404,
    ], 404);
});