<?php

namespace App\Modules\Organizations\Actions;

use App\Modules\Organizations\Contracts\OrganizationRepositoryInterface;
use App\Modules\Organizations\DTOs\UpdateOrganizationData;
use App\Modules\Organizations\Models\Organization;

final class UpdateOrganizationAction
{

    public function __construct(private OrganizationRepositoryInterface $organizations){

    }
    public function execute(Organization $organization, UpdateOrganizationData $data): Organization
    {
        return $this->organizations->update($organization, $data->toArray());
    }
}
