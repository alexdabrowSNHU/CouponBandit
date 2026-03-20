<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;
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
        RateLimiter::for('devlog', function (Request $request) {
            $username = (string) $request->input('username', '');
            $ip = (string) $request->ip();

            return Limit::perMinute(3)->by($username !== '' ? "{$username}|{$ip}" : $ip);
        });

        // Keep Vite HMR strictly opt-in so production never depends on a dev server.
        $useViteHot = (bool) env('VITE_USE_HOT', false);
        if ($useViteHot) {
            Vite::useHotFile(storage_path('vite.hot'));
        } else {
            // Point to a non-existent file so @vite always falls back to built assets.
            Vite::useHotFile(storage_path('framework/vite.hot.disabled'));
        }

        $appUrl = (string) config('app.url', '');
        $forceHttps = (bool) env('APP_FORCE_HTTPS', false);

        if ($forceHttps || str_starts_with($appUrl, 'https://')) {
            URL::forceScheme('https');
        }
    }
}
