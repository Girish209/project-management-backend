<?php

namespace App\Modules\Organizations\Actions;

use App\Modules\Organizations\Contracts\OrganizationRepositoryInterface;
use App\Modules\Organizations\DTOs\StoreOrganizationData;
use App\Modules\Organizations\Models\Organization;

final class CreateOrganizationAction
{

    public function __construct(private OrganizationRepositoryInterface $organization){

    }
    public function execute(StoreOrganizationData $data, string $owner_id): Organization
    {
        return $this->organization->create([
            ...$data->toArray(),
            'owner_id' => $owner_id
        ]);
    }
}
