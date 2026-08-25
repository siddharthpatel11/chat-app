<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        // Force HTTPS and dynamic App URL when accessed via ngrok or proxy
        if (request()->server('HTTP_X_FORWARDED_PROTO') == 'https' || request()->secure()) {
            URL::forceScheme('https');
        }
        
        // Dynamically set the root URL to the current domain + folder path
        // This prevents redirects from sending the app to a 404 page when using XAMPP htdocs
        if (request()->getHost()) {
            URL::forceRootUrl(request()->getSchemeAndHttpHost() . request()->getBaseUrl());
        }
    }
}
