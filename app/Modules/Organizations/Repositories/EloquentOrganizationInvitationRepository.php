<?php

namespace App\Modules\Organizations\Repositories;

use App\Modules\Organizations\Contracts\OrganizationInvitationRepositoryInterface;
use App\Modules\Organizations\Models\OrganizationInvitation;

final class EloquentOrganizationInvitationRepository implements OrganizationInvitationRepositoryInterface
{
    public function findPendingByTokenOrFail(string $token): OrganizationInvitation
    {
        return OrganizationInvitation::query()
            ->where('token', $token)
            ->whereNull('accepted_at')
            ->where('expires_at', '>', now())
            ->firstOrFail();
    }

    public function update(OrganizationInvitation $invitation, array $attributes): OrganizationInvitation
    {
        $invitation->update($attributes);

        return $invitation->refresh();
    }
}
