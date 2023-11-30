<?php

namespace App\Providers;

namespace App\Providers;

use App\Repository\Interfaces\UserRepositoryInterface;
use App\Services\User\SignInService\SignInService;
use App\Services\User\SignUpService\SignUpService;
use Illuminate\Support\ServiceProvider;

class ServicesProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SignInService::class, function ($app) {
            return new SignInService;
        });

        $this->app->bind(SignUpService::class, function ($app) {
            return new SignUpService($app->make(UserRepositoryInterface::class));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Additional bootstrapping, if needed
    }
}
