<?php

namespace App\Providers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
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
    public function boot()
    {
        if (request()->header('X-Forwarded-Proto') == 'https') {
            URL::forceScheme('https');
        }

        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');
    }
}
