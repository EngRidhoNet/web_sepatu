<?php

namespace App\Providers;

use PromoCodeRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\CategoryRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
         $this->app->singleton(CategoryRepositoryInterface::class, \App\Repositories\CategoryRepository::class);

         $this->app->singleton(\App\Repositories\Contracts\ShoeRepositoryInterface::class, \App\Repositories\ShoeRepository::class);

         $this->app->singleton(\App\Repositories\Contracts\OrderRepositoryInterface::class, \App\Repositories\OrderRepository::class);

         $this->app->singleton(\App\Repositories\Contracts\PromoCodeRepositoryInterface::class, \App\Repositories\PromoCodeRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
