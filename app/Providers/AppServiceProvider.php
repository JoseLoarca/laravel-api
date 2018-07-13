<?php

namespace App\Providers;

use App\Product;
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
        \Illuminate\Database\Schema\Builder::defaultStringLength(191);

        Product::updated(function ($product) {
            if ($product->quantity == 0 && $product->isDisponible()) {
                $product->status = Product::NO_DISPONIBLE;

                $product->save();
            }
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
