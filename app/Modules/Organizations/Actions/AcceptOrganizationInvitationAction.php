<?php

namespace App\Modules\Organizations\Actions;

use App\Modules\Identity\Contracts\UserRepositoryInterface;
use App\Modules\Organizations\Contracts\OrganizationInvitationRepositoryInterface;
use App\Modules\Organizations\Contracts\OrganizationMemberRepositoryInterface;
use App\Modules\Organizations\DTOs\AcceptOrganizationInvitationData;
use App\Modules\Organizations\Models\OrganizationMember;
use Illuminate\Support\Facades\DB;

final class AcceptOrganizationInvitationAction
{
    public function __construct(
        private OrganizationInvitationRepositoryInterface $invitations,
        private OrganizationMemberRepositoryInterface $members,
        private UserRepositoryInterface $users,
    ) {
    }

    public function execute(AcceptOrganizationInvitationData $data): OrganizationMember
    {
        return DB::transaction(function () use ($data): OrganizationMember {
            $invitation = $this->invitations->findPendingByTokenOrFail($data->token);
            $user = $this->users->getUserByEmail($invitation->email);

            $this->users->update($user, ['password' => $data->password]);

            $member = $this->members->findByOrganizationAndUserOrFail(
                $invitation->organization_id,
                $user->id,
            );

            $member = $this->members->update($member, [
                'status' => 'active',
                'joined_at' => now(),
            ]);

            $this->invitations->update($invitation, ['accepted_at' => now()]);

            return $member;
        });
    }
}
