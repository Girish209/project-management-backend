<?php

namespace App\Providers;

use App\Modules\Projects\Providers\ProjectServiceProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(ProjectServiceProvider::class);
        $this->app->register(ModuleMigrationServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
