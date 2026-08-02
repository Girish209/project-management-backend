<?php

namespace App\Modules\Organizations\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Organizations\Actions\AcceptOrganizationInvitationAction;
use App\Modules\Organizations\DTOs\AcceptOrganizationInvitationData;
use App\Modules\Organizations\Http\Requests\AcceptOrganizationInvitationRequest;
use App\Modules\Organizations\Http\Resources\OrganizationMemberResource;

class OrganizationInvitationController extends Controller
{
    public function accept(
        AcceptOrganizationInvitationRequest $request,
        AcceptOrganizationInvitationAction $action,
    ) {
        try {
            $member = $action->execute(
                AcceptOrganizationInvitationData::fromArray($request->validated())
            );

            return $this->respondWithData(
                new OrganizationMemberResource($member->load('user')),
                'Invitation accepted successfully',
            );
        } catch (\Throwable $th) {
            return $this->respondBadRequest($th->getMessage());
        }
    }
}
