<?php

declare(strict_types=1);

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(
    basePath: dirname(__DIR__)
)

->withRouting(
    web: __DIR__ . '/../routes/web.php',
    api: __DIR__ . '/../routes/api.php',
    commands: __DIR__ . '/../routes/console.php',
    channels: __DIR__ . '/../routes/channels.php',
    health: '/up',
)

->withMiddleware(function (Middleware $middleware): void {

    /*
    |--------------------------------------------------------------------------
    | Global Middleware
    |--------------------------------------------------------------------------
    */

    $middleware->append([
        \Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \Illuminate\Foundation\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ]);

    /*
    |--------------------------------------------------------------------------
    | Web Middleware Group
    |--------------------------------------------------------------------------
    */

    $middleware->group('web', [
        \Illuminate\Cookie\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ]);

    /*
    |--------------------------------------------------------------------------
    | API Middleware Group
    |--------------------------------------------------------------------------
    */

    $middleware->group('api', [
        \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ]);

    /*
    |--------------------------------------------------------------------------
    | Middleware Aliases
    |--------------------------------------------------------------------------
    */

    $middleware->alias([

        // Authentication
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'guest' => \Illuminate\Auth\Middleware\RedirectIfAuthenticated::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,

        // Roles & Permissions
        'role' => \App\Application\Middleware\RoleMiddleware::class,
        'capability' => \App\Application\Middleware\CapabilityMiddleware::class,
        'verified.user' => \App\Application\Middleware\VerifiedMiddleware::class,

        // Subscription
        'premium' => \App\Application\Middleware\PremiumMiddleware::class,
        'subscription' => \App\Application\Middleware\SubscriptionMiddleware::class,
        'feature' => \App\Application\Middleware\FeatureAccessMiddleware::class,

        // KYC
        'kyc' => \App\Application\Middleware\KYCMiddleware::class,
        'kyc.level1' => \App\Application\Middleware\KYCLevelOneMiddleware::class,
        'kyc.level2' => \App\Application\Middleware\KYCLevelTwoMiddleware::class,

        // Campaign
        'campaign.limit' => \App\Application\Middleware\CampaignLimitMiddleware::class,
        'campaign.owner' => \App\Application\Middleware\CampaignOwnerMiddleware::class,

        // Wallet
        'wallet.active' => \App\Application\Middleware\ActiveWalletMiddleware::class,
        'wallet.verified' => \App\Application\Middleware\WalletVerifiedMiddleware::class,

        // Escrow
        'escrow.access' => \App\Application\Middleware\EscrowAccessMiddleware::class,

        // Booking
        'booking.access' => \App\Application\Middleware\BookingAccessMiddleware::class,

        // Donation
        'donation.access' => \App\Application\Middleware\DonationAccessMiddleware::class,

        // Academy
        'academy.access' => \App\Application\Middleware\AcademyAccessMiddleware::class,

        // Chat
        'chat.access' => \App\Application\Middleware\ChatAccessMiddleware::class,

        // Events
        'event.access' => \App\Application\Middleware\EventAccessMiddleware::class,

        // Affiliate
        'affiliate.access' => \App\Application\Middleware\AffiliateAccessMiddleware::class,

        // Services Marketplace
        'service.access' => \App\Application\Middleware\ServiceAccessMiddleware::class,

        // Verification
        'bluecheck' => \App\Application\Middleware\BlueCheckMiddleware::class,

        // Admin
        'admin' => \App\Application\Middleware\AdminMiddleware::class,
        'super.admin' => \App\Application\Middleware\SuperAdminMiddleware::class,
    ]);

    /*
    |--------------------------------------------------------------------------
    | Middleware Priority
    |--------------------------------------------------------------------------
    */

    $middleware->priority([
        \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \Illuminate\Auth\Middleware\Authorize::class,
    ]);
})

->withExceptions(function (Exceptions $exceptions): void {

    /*
    |--------------------------------------------------------------------------
    | Force JSON Response For API
    |--------------------------------------------------------------------------
    */

    $exceptions->shouldRenderJsonWhen(
        fn (Request $request, Throwable $e): bool =>
            $request->expectsJson()
            || $request->is('api/*')
    );

    /*
    |--------------------------------------------------------------------------
    | Business Exceptions
    |--------------------------------------------------------------------------
    */

    $exceptions->reportable(function (
        \App\Application\Exceptions\BusinessException $e
    ): void {

        Log::warning('Business Exception', [
            'message' => $e->getMessage(),
            'code' => $e->getCode(),
        ]);
    });

    /*
    |--------------------------------------------------------------------------
    | Wallet Exceptions
    |--------------------------------------------------------------------------
    */

    $exceptions->reportable(function (
        \App\Domain\Wallet\Exceptions\InsufficientBalanceException $e
    ): void {

        Log::warning('Wallet Exception', [
            'user_id' => auth()->id(),
            'message' => $e->getMessage(),
        ]);
    });

    /*
    |--------------------------------------------------------------------------
    | Subscription Exceptions
    |--------------------------------------------------------------------------
    */

    $exceptions->reportable(function (
        \App\Domain\Subscription\Exceptions\FeatureLimitExceededException $e
    ): void {

        Log::info('Feature Limit Reached', [
            'user_id' => auth()->id(),
            'message' => $e->getMessage(),
        ]);
    });

    /*
    |--------------------------------------------------------------------------
    | Campaign Exceptions
    |--------------------------------------------------------------------------
    */

    $exceptions->reportable(function (
        \App\Domain\Campaign\Exceptions\CampaignException $e
    ): void {

        Log::warning('Campaign Exception', [
            'message' => $e->getMessage(),
        ]);
    });

    /*
    |--------------------------------------------------------------------------
    | Escrow Exceptions
    |--------------------------------------------------------------------------
    */

    $exceptions->reportable(function (
        \App\Domain\Escrow\Exceptions\EscrowException $e
    ): void {

        Log::warning('Escrow Exception', [
            'message' => $e->getMessage(),
        ]);
    });

    /*
    |--------------------------------------------------------------------------
    | Payment Exceptions
    |--------------------------------------------------------------------------
    */

    $exceptions->reportable(function (
        \App\Domain\Payment\Exceptions\PaymentException $e
    ): void {

        Log::error('Payment Exception', [
            'message' => $e->getMessage(),
        ]);
    });

    /*
    |--------------------------------------------------------------------------
    | Fallback
    |--------------------------------------------------------------------------
    */

    $exceptions->reportable(function (Throwable $e): void {

        Log::error('Unhandled Exception', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ]);
    });
})

->create();