<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Mime\MimeTypes;

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
        MimeTypes::setDefault(new MimeTypes());

        // Force HTTPS in production (fixes "not secure" form warnings on Render)
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}