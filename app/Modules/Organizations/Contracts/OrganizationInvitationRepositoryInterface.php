<?php

namespace App\Modules\Organizations\Contracts;

use App\Modules\Organizations\Models\OrganizationInvitation;

interface OrganizationInvitationRepositoryInterface
{
    public function findPendingByTokenOrFail(string $token): OrganizationInvitation;

    /** @param array<string, mixed> $attributes */
    public function update(OrganizationInvitation $invitation, array $attributes): OrganizationInvitation;
}
