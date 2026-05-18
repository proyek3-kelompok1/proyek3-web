<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // 🔥 PENTING: paksa Laravel pakai HTTPS di production
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }
    }
}