<?php

namespace App\Modules\Organizations\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Organizations\Contracts\OrganizationRepositoryInterface;
use App\Modules\Organizations\Actions\CreateOrganizationAction;
use App\Modules\Organizations\Actions\UpdateOrganizationAction;
use App\Modules\Organizations\DTOs\StoreOrganizationData;
use App\Modules\Organizations\DTOs\UpdateOrganizationData;
use App\Modules\Organizations\Http\Requests\StoreOrganizationRequest;
use App\Modules\Organizations\Http\Requests\UpdateOrganizationRequest;
use App\Modules\Organizations\Http\Resources\OrganizationResource;
use App\Modules\Organizations\Models\Organization;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function index(Request $request, OrganizationRepositoryInterface $organizations)
    {
        try {
            return $this->respondWithData(OrganizationResource::collection(
                $organizations->paginateForOwner($request->user()->id)
            ));
        } catch (\Throwable $th) {
            return $this->respondBadRequest($th->getMessage());
        }
    }

    public function store(StoreOrganizationRequest $request, CreateOrganizationAction $action)
    {
        try {
            $organization = $action->execute(StoreOrganizationData::fromArray($request->validated()), $request->user()->id);
            return $this->respondCreated(new OrganizationResource($organization));
        } catch (\Throwable $th) {
            return $this->respondBadRequest($th->getMessage());
        }
    }

    public function show(Request $request, Organization $organization)
    {
        try {
            return $this->respondWithData(new OrganizationResource($organization->load('owner')));
        } catch (\Throwable $th) {
            return $this->respondBadRequest($th->getMessage());
        }
    }

    public function update(UpdateOrganizationRequest $request, Organization $organization, UpdateOrganizationAction $action)
    {
        try {
            // $this->ensureOwner($request, $organization);
            $updatedOrganization = $action->execute($organization, UpdateOrganizationData::fromArray($request->validated()));

            return $this->respondWithData(new OrganizationResource($updatedOrganization));
        } catch (\Throwable $th) {
            return $this->respondBadRequest($th->getMessage(), null);
        }
    }

    public function destroy(Request $request, Organization $organization, OrganizationRepositoryInterface $organizations)
    {
        try {
            $organizations->delete($organization);
            return $this->respondWithMessage("Deleted Successfully", 200);
        } catch (\Throwable $th) {
            return $this->respondBadRequest($th->getMessage());
        }
    }
}
