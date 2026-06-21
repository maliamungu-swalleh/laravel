<?php

use App\Http\Controllers\Admin\ManageDealController;
use App\Http\Controllers\Admin\ManageDealTypeController;
use App\Http\Controllers\Admin\ManageServiceController;
use App\Http\Controllers\Admin\ManageHiringController;
use App\Http\Controllers\Admin\PartnershipController as AdminPartnershipController;
use App\Http\Controllers\Admin\PlatformSettingsController;
use App\Http\Controllers\Admin\ManageCouponController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
| 
| Routes for admin dashboard, monitoring, and platform configuration.
| All routes are protected by 'auth' and 'role:admin' middleware.
|
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'role:admin'])
    ->group(function () {

    // ═══════════════════════════════════════════════════════════════════════════
    // DEAL ENGINE MANAGEMENT
    // ═══════════════════════════════════════════════════════════════════════════

    Route::prefix('deals')->name('deals.')->group(function () {
        Route::get('/', [ManageDealController::class, 'index'])->name('index');
        Route::get('/{deal}', [ManageDealController::class, 'show'])->name('show');
        Route::post('/{deal}/force-cancel', [ManageDealController::class, 'forceCancel'])->name('force-cancel');
    });

    Route::post('submissions/{di}/force-approve', [ManageDealController::class, 'forceApprove'])->name('submissions.force-approve');

    // Deal Type Management (must come before wildcard routes)
    Route::prefix('deal-types')->name('deal-types.')->group(function () {
        Route::get('/', [ManageDealTypeController::class, 'index'])->name('index');
        Route::post('/', [ManageDealTypeController::class, 'store'])->name('store');
        Route::put('/{dealType}', [ManageDealTypeController::class, 'update'])->name('update');
        Route::delete('/{dealType}', [ManageDealTypeController::class, 'destroy'])->name('destroy');
        Route::post('/{dealType}/toggle', [ManageDealTypeController::class, 'toggle'])->name('toggle');
    });

    // ═══════════════════════════════════════════════════════════════════════════
    // PLATFORM SETTINGS & PRICING
    // ═══════════════════════════════════════════════════════════════════════════

    Route::prefix('settings')->name('settings.')->group(function () {
        // Deal & Shop Pricing
        Route::get('pricing', [PlatformSettingsController::class, 'pricing'])->name('pricing');
        Route::post('pricing', [PlatformSettingsController::class, 'updatePricing'])->name('pricing.update');

        // Service Commission
        Route::post('service-commission', [ManageServiceController::class, 'updateCommission'])->name('service-commission');

        // Hiring Commission
        Route::get('hiring', [ManageHiringController::class, 'settings'])->name('hiring');
        Route::post('hiring', [ManageHiringController::class, 'updateCommission'])->name('hiring.update');
    });

    // ═══════════════════════════════════════════════════════════════════════════
    // CREATOR SERVICES MANAGEMENT
    // ═══════════════════════════════════════════════════════════════════════════

    Route::prefix('services')->name('services.')->group(function () {
        Route::get('/', [ManageServiceController::class, 'index'])->name('index');
        Route::get('/orders', [ManageServiceController::class, 'orders'])->name('orders');
        Route::post('/{service}/remove', [ManageServiceController::class, 'remove'])->name('remove');
        Route::post('/orders/{order}/force-complete', [ManageServiceController::class, 'forceComplete'])->name('force-complete');
    });

    // ═══════════════════════════════════════════════════════════════════════════
    // HIRING CONTRACTS MANAGEMENT
    // ═══════════════════════════════════════════════════════════════════════════

    Route::prefix('hiring')->name('hiring.')->group(function () {
        Route::get('jobs', [ManageHiringController::class, 'jobs'])->name('jobs');
        Route::get('contracts', [ManageHiringController::class, 'contracts'])->name('contracts');
        Route::get('contracts/{contract}', [ManageHiringController::class, 'contractShow'])->name('contracts.show');
        Route::post('contracts/{contract}/release', [ManageHiringController::class, 'forceRelease'])->name('contracts.release');
    });

    // ═══════════════════════════════════════════════════════════════════════════
    // PARTNERSHIPS MANAGEMENT
    // ═══════════════════════════════════════════════════════════════════════════

    Route::prefix('partnerships')->name('partnerships.')->group(function () {
        // Settings MUST come before wildcard {partnership}
        Route::get('settings', [AdminPartnershipController::class, 'settings'])->name('settings');
        Route::post('settings', [AdminPartnershipController::class, 'updateSettings'])->name('settings.update');

        Route::get('/', [AdminPartnershipController::class, 'index'])->name('index');
        Route::post('/{partnership}/cancel', [AdminPartnershipController::class, 'cancel'])->name('cancel');
    });

    // ═══════════════════════════════════════════════════════════════════════════
    // COUPON MANAGEMENT
    // ═══════════════════════════════════════════════════════════════════════════

    Route::prefix('coupons')->name('coupons.')->group(function () {
        Route::get('/', [ManageCouponController::class, 'index'])->name('index');
        Route::get('create', [ManageCouponController::class, 'create'])->name('create');
        Route::post('/', [ManageCouponController::class, 'store'])->name('store');
        Route::get('{coupon}/edit', [ManageCouponController::class, 'edit'])->name('edit');
        Route::put('{coupon}', [ManageCouponController::class, 'update'])->name('update');
        Route::delete('{coupon}', [ManageCouponController::class, 'destroy'])->name('destroy');
    });

});
