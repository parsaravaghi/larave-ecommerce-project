<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\{
    AuthService ,
    UserService ,
    ProductService
};

use App\Interfaces\Services\{
    AuthServiceInterface ,
    UserServiceInterface ,
    ProductServiceInterface
};


class ServiceInterfaceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AuthServiceInterface::class , AuthService::class);
        $this->app->bind(UserServiceInterface::class , UserService::class);
        $this->app->bind(ProductServiceInterface::class , ProductService::class);
    }
}
