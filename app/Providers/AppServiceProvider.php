<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('App\Api\Booking\BookingServiceInterface', 'App\Api\Booking\BookingService');
        $this->app->singleton('App\Api\Classes\ClassesServiceInterface', 'App\Api\Classes\ClassesService');
    }
}
