<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application, used in notifications
    | and other locations as required by the application or its packages.
    |
    */

    'name' => env('APP_NAME', 'UGCFYP'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Frontend & API URLs
    |--------------------------------------------------------------------------
    |
    | Used for CORS, redirects, and cross-origin communication between
    | the Laravel API backend and the Next.js frontend.
    |
    */

    'api_url' => env('API_URL', 'http://localhost:8000/api'),
    'frontend_url' => env('FRONTEND_URL', 'http://localhost:3000'),
    'admin_url' => env('ADMIN_URL', 'http://localhost:8000/admin'),

    'asset_url' => env('ASSET_URL', '/'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application.
    | Set to Africa/Kampala for UGCFYP's primary market (Uganda).
    |
    */

    'timezone' => env('APP_TIMEZONE', 'Africa/Kampala'),

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by Laravel's translation / localization methods.
    |
    */

    'locale' => env('APP_LOCALE', 'en'),

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    /*
    |--------------------------------------------------------------------------
    | Faker Locale
    |--------------------------------------------------------------------------
    |
    | This locale will be used by the Faker PHP library when generating fake
    | data for your database seeds.
    |
    */

    'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode Driver
    |--------------------------------------------------------------------------
    |
    | These configuration options determine the driver used to determine and
    | manage Laravel's "maintenance mode" status. The "cache" driver will
    | allow maintenance mode to be controlled across multiple machines.
    |
    | Supported drivers: "file", "cache"
    |
    */

    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store'  => env('APP_MAINTENANCE_STORE', 'database'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => ServiceProvider::defaultProviders()->merge([
        /*
         * Package Service Providers...
         */
        Spatie\Permission\PermissionServiceProvider::class,
        Spatie\MediaLibrary\MediaLibraryServiceProvider::class,
        Spatie\Activitylog\ActivitylogServiceProvider::class,
        Spatie\Backup\BackupServiceProvider::class,
        Barryvdh\DomPDF\ServiceProvider::class,
        Maatwebsite\Excel\ExcelServiceProvider::class,
        SimpleSoftwareIO\QrCode\QrCodeServiceProvider::class,

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        App\Providers\FilamentServiceProvider::class,
        App\Providers\HorizonServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,

    ])->toArray(),

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => Facade::defaultAliases()->merge([
        'QrCode'    => SimpleSoftwareIO\QrCode\Facades\QrCode::class,
        'Excel'     => Maatwebsite\Excel\Facades\Excel::class,
        'PDF'       => Barryvdh\DomPDF\Facade\Pdf::class,
    ])->toArray(),

    /*
    |--------------------------------------------------------------------------
    | UGCFYP Platform Settings
    |--------------------------------------------------------------------------
    |
    | Custom configuration values for the UGCFYP platform.
    |
    */

    'platform' => [
        'name'               => env('PLATFORM_NAME', 'UGCFYP'),
        'currency'           => env('PLATFORM_CURRENCY', 'KES'),
        'currency_symbol'    => env('PLATFORM_CURRENCY_SYMBOL', 'KES'),
        'minimum_deposit'    => env('PLATFORM_MINIMUM_DEPOSIT', 100),
        'minimum_withdrawal' => env('PLATFORM_MINIMUM_WITHDRAWAL', 1000),
        'commission_rate'    => env('PLATFORM_COMMISSION_RATE', 15),
        'premium_price_yearly' => env('PREMIUM_PRICE_YEARLY', 10.00),
    ],
];