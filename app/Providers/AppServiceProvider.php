<?php

namespace App\Providers;

use App\Services\Cart\Contracts\CartInterface;
use App\Services\Cart\SessionCart;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CartInterface::class, function (Application $app) {
            return new SessionCart('cart');
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
