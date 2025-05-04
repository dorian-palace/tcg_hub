<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\UserHelper;
use App\Helpers\EventHelper;
use App\Helpers\CardHelper;
use App\Helpers\TransactionHelper;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('userhelper', function ($app) {
            return new UserHelper();
        });

        $this->app->singleton('eventhelper', function ($app) {
            return new EventHelper();
        });

        $this->app->singleton('cardhelper', function ($app) {
            return new CardHelper();
        });

        $this->app->singleton('transactionhelper', function ($app) {
            return new TransactionHelper();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}