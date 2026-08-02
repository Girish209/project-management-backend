<?php

namespace App\Modules\Organizations\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Organizations\Actions\CreateOrganizationMemberAction;
use App\Modules\Organizations\Actions\UpdateOrganizationMemberAction;
use App\Modules\Organizations\Contracts\OrganizationMemberRepositoryInterface;
use App\Modules\Organizations\DTOs\StoreOrganizationMemberData;
use App\Modules\Organizations\Http\Requests\StoreOrganizationMemberRequest;
use App\Modules\Organizations\Http\Requests\UpdateOrganizationMemberRequest;
use App\Modules\Organizations\Http\Resources\OrganizationMemberResource;
use App\Modules\Organizations\DTOs\UpdateOrganizationMemberData;
use App\Modules\Organizations\Models\Organization;
use Illuminate\Http\Request;

class OrganizationMemberController extends Controller
{
    public function index(Request $request, Organization $organization, OrganizationMemberRepositoryInterface $members)
    {
        try {
            return $this->respondWithData(
                OrganizationMemberResource::collection(
                    $members->paginateForOrganization($organization->id)
                )
            );
        } catch (\Throwable $th) {
            return $this->respondBadRequest($th->getMessage());
        }
    }

    public function store(
        StoreOrganizationMemberRequest $request,
        Organization $organization,
        CreateOrganizationMemberAction $action,
    ) {
        try {
            $member = $action->execute(
                StoreOrganizationMemberData::fromArray($request->validated()),
                $organization->id,
            );

            return $this->respondCreated(
                new OrganizationMemberResource($member->load('user')),
                'Organization member created successfully',
            );
        } catch (\Throwable $th) {
            return $this->respondBadRequest($th->getMessage());
        }
    }

    public function update(
        UpdateOrganizationMemberRequest $request,
        Organization $organization,
        string $member,
        UpdateOrganizationMemberAction $action,
    ) {
        try {
            $updatedMember = $action->execute(
                $organization->id,
                $member,
                UpdateOrganizationMemberData::fromArray($request->validated()),
            );

            return $this->respondWithData(
                new OrganizationMemberResource($updatedMember->load('user')),
                'Organization member updated successfully',
            );
        } catch (\Throwable $th) {
            return $this->respondBadRequest($th->getMessage());
        }
    }

    public function destroy(
        Request $request,
        Organization $organization,
        string $member,
        OrganizationMemberRepositoryInterface $members,
    )
    {
        try {
            $organizationMember = $members->findForOrganizationOrFail($organization->id, $member);
            $members->delete($organizationMember);

            return $this->respondWithMessage('Deleted Successfully');
        } catch (\Throwable $th) {
            return $this->respondBadRequest($th->getMessage());
        }
    }
}
