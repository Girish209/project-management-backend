<?php

namespace App\Modules\Organizations\Providers;

use App\Modules\Organizations\Contracts\OrganizationMemberRepositoryInterface;
use App\Modules\Organizations\Contracts\OrganizationInvitationRepositoryInterface;
use App\Modules\Organizations\Contracts\OrganizationRepositoryInterface;
use App\Modules\Organizations\Repositories\EloquentOrganizationMemberRepository;
use App\Modules\Organizations\Repositories\EloquentOrganizationInvitationRepository;
use App\Modules\Organizations\Repositories\EloquentOrganizationRepository;
use Illuminate\Support\ServiceProvider;

class OrganizationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(OrganizationRepositoryInterface::class, EloquentOrganizationRepository::class);
        $this->app->bind(OrganizationMemberRepositoryInterface::class, EloquentOrganizationMemberRepository::class);
        $this->app->bind(OrganizationInvitationRepositoryInterface::class, EloquentOrganizationInvitationRepository::class);
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
    }
}
