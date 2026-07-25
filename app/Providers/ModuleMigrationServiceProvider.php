<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleMigrationServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom([
            app_path('Modules/Identity/Database/Migrations'),
            app_path('Modules/Organizations/Database/Migrations'),
            app_path('Modules/Teams/Database/Migrations'),
            app_path('Modules/Tasks/Database/Migrations'),
            app_path('Modules/Activity/Database/Migrations'),
            app_path('Modules/Notifications/Database/Migrations'),
            app_path('Modules/Reports/Database/Migrations'),
            app_path('Modules/Billing/Database/Migrations'),
            app_path('Modules/Files/Database/Migrations'),
            app_path('Modules/AccessControl/Database/Migrations'),
        ]);
    }
}
