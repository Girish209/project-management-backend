<?php

namespace App\Modules\Organizations\Actions;

use App\Modules\Organizations\DTOs\UpdateOrganizationMemberData;
use App\Modules\Organizations\Contracts\OrganizationMemberRepositoryInterface;
use App\Modules\Organizations\Models\OrganizationMember;

final class UpdateOrganizationMemberAction
{
    public function __construct(private OrganizationMemberRepositoryInterface $members)
    {
    }

    public function execute(
        string $organizationId,
        string $memberId,
        UpdateOrganizationMemberData $data,
    ): OrganizationMember
    {
        $member = $this->members->findForOrganizationOrFail($organizationId, $memberId);

        return $this->members->update($member, $data->toArray());
    }
}
