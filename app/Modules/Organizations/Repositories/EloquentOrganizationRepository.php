<?php

namespace App\Modules\Organizations\Repositories;

use App\Modules\Organizations\Contracts\OrganizationRepositoryInterface;
use App\Modules\Organizations\Models\Organization;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class EloquentOrganizationRepository implements OrganizationRepositoryInterface
{
    public function paginateForOwner(string $ownerId, int $perPage = 15): LengthAwarePaginator
    {
        return Organization::query()
            ->where('owner_id', $ownerId)
            ->latest()
            ->paginate($perPage);
    }

    public function findOrFail(string $id): Organization
    {
        return Organization::query()->findOrFail($id);
    }

    /** @param array<string, mixed> $attributes */
    public function create(array $attributes): Organization
    {
        return Organization::query()->create($attributes);
    }

    /** @param array<string, mixed> $attributes */
    public function update(Organization $organization, array $attributes): Organization
    {
        $organization->update($attributes);
        // dd($organization);
        return $organization->refresh();
    }

    public function delete(Organization $organization): void
    {
        $organization->delete();
    }
}
