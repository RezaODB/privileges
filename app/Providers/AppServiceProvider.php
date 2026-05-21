<?php

namespace App\Providers;

use App\Mail\Transport\BrevoApiTransport;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
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
        Model::preventLazyLoading();

        Mail::extend('brevo', fn ($config) => new BrevoApiTransport(
            apiKey: $config['key'] ?? config('services.brevo.key'),
        ));
    }
}
