<?php

namespace App\Modules\Organizations\Repositories;

use App\Modules\Organizations\Contracts\OrganizationMemberRepositoryInterface;
use App\Modules\Organizations\Models\OrganizationMember;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class EloquentOrganizationMemberRepository implements OrganizationMemberRepositoryInterface
{
    public function paginateForOrganization(string $organizationId, int $perPage = 15): LengthAwarePaginator
    {
        return OrganizationMember::query()
            ->where('organization_id', $organizationId)
            ->with('user')
            ->latest()
            ->paginate($perPage);
    }

    public function findForOrganizationOrFail(string $organizationId, string $id): OrganizationMember
    {
        return OrganizationMember::query()
            ->where('organization_id', $organizationId)
            ->with('user')
            ->findOrFail($id);
    }

    public function findByOrganizationAndUserOrFail(string $organizationId, string $userId): OrganizationMember
    {
        return OrganizationMember::query()
            ->where('organization_id', $organizationId)
            ->where('user_id', $userId)
            ->firstOrFail();
    }

    public function create(array $attributes): OrganizationMember
    {
        return OrganizationMember::query()->create($attributes);
    }

    public function update(OrganizationMember $member, array $attributes): OrganizationMember
    {
        $member->update($attributes);
        return $member->refresh();
    }

    // public function getUserByEmail(string $email): User
    // {
    //     return User::where('email', $email)->firstOrFail();
    // }

    public function delete(OrganizationMember $member): void
    {
        $member->delete();
    }

}
