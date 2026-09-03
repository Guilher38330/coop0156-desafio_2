<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /**
         * Rate limiter para a API geral: 60 requisições por minuto por IP.
         */
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        /**
         * Rate limiter para solicitações de análise de crédito: 15 requisições por minuto por IP.
         * Protege a aplicação contra requisições abusivas, DoS e custos excessivos no Bureau.
         */
        RateLimiter::for('analise-credito', function (Request $request) {
            if (app()->runningUnitTests() && ! $request->hasHeader('X-Test-Rate-Limit')) {
                return Limit::none();
            }

            return Limit::perMinute(15)->by($request->ip())->response(function (Request $request, array $headers) {
                return response()->json([
                    'message' => 'Muitas solicitações de análise de crédito. Por favor, aguarde um instante e tente novamente.',
                ], 429, $headers);
            });
        });
    }
}
