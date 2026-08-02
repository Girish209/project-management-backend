<?php

namespace App\Modules\Identity\Providers;

use App\Modules\Identity\Contracts\UserRepositoryInterface;
use App\Modules\Identity\Repositories\EloquentUserRepository;
use Illuminate\Support\ServiceProvider;

class IdentityServiceProvider extends ServiceProvider{
    public function register(){
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
    }

    public function boot(){
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
    }
}