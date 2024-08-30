<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Interfaces\AuthInterface;
use App\Repositories\AuthRepository;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        $this->app->bind(AuthInterface::class, AuthRepository::class);
        // return User::create($data);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
