<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Services\Product\ProductService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->singleton(ProductService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
