<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //\\
        $this->app->bind('HelpSpot\API', function ($app) {
            return new User();
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //


    }
}
