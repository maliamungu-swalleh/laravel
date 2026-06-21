<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     */
    protected $levels = [
        \App\Domain\Payment\Exceptions\PaymentFailedException::class => 'error',
        \App\Domain\Wallet\Exceptions\InsufficientBalanceException::class => 'warning',
        \App\Domain\Wallet\Exceptions\WalletLockedException::class => 'critical',
        \App\Domain\Subscription\Exceptions\FeatureLimitExceededException::class => 'info',
        \App\Domain\Subscription\Exceptions\SubscriptionRequiredException::class => 'info',
        \App\Domain\Campaign\Exceptions\CampaignClosedException::class => 'info',
        \App\Domain\Campaign\Exceptions\OwnCampaignException::class => 'warning',
        \App\Domain\Campaign\Exceptions\AlreadyAppliedException::class => 'info',
        \App\Domain\Fraud\Exceptions\FraudDetectedException::class => 'critical',
    ];

    /**
     * A list of the exception types that are not reported.
     */
    protected $dontReport = [
        \App\Application\Exceptions\BusinessException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            if (app()->bound('sentry')) {
                \Sentry\Laravel\Integration::captureUnhandledException($e);
            }
        });
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $e): \Illuminate\Http\Response|JsonResponse|\Illuminate\Http\RedirectResponse
    {
        // API responses
        if ($request->expectsJson() || $request->is('api/*')) {
            return $this->renderApiException($request, $e);
        }

        return parent::render($request, $e);
    }

    /**
     * Render API exceptions.
     */
    protected function renderApiException(Request $request, Throwable $e): JsonResponse
    {
        $status = match (true) {
            $e instanceof \Illuminate\Auth\AuthenticationException => 401,
            $e instanceof \Illuminate\Auth\Access\AuthorizationException => 403,
            $e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException => 404,
            $e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException => 404,
            $e instanceof \Illuminate\Validation\ValidationException => 422,
            $e instanceof \App\Domain\Wallet\Exceptions\InsufficientBalanceException => 422,
            $e instanceof \App\Domain\Subscription\Exceptions\FeatureLimitExceededException => 422,
            $e instanceof \App\Domain\Subscription\Exceptions\SubscriptionRequiredException => 402,
            $e instanceof \App\Domain\Campaign\Exceptions\CampaignClosedException => 422,
            $e instanceof \App\Domain\Campaign\Exceptions\OwnCampaignException => 403,
            $e instanceof \App\Domain\Campaign\Exceptions\AlreadyAppliedException => 409,
            $e instanceof \App\Domain\Payment\Exceptions\PaymentFailedException => 422,
            default => 500,
        };

        $response = [
            'message' => $e->getMessage(),
            'status'  => $status,
        ];

        if (config('app.debug')) {
            $response['exception'] = get_class($e);
            $response['file'] = $e->getFile();
            $response['line'] = $e->getLine();
            $response['trace'] = collect($e->getTrace())->take(5)->map(function ($trace) {
                return [
                    'file' => $trace['file'] ?? 'unknown',
                    'line' => $trace['line'] ?? 0,
                    'function' => $trace['function'] ?? '',
                ];
            })->toArray();
        }

        return response()->json($response, $status);
    }
}