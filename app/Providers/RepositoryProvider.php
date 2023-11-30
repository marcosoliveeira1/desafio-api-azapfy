<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Repository\Interfaces\UserRepositoryInterface::class,
            \App\Repository\Eloquent\UserRepositoryEloquent::class
        );
    }
}
