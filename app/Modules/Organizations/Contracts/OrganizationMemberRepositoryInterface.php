<?php

namespace App\Modules\Organizations\Contracts;

// use App\Models\User;
use App\Modules\Organizations\Models\OrganizationMember;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface OrganizationMemberRepositoryInterface
{
    public function paginateForOrganization(string $organizationId, int $perPage = 15): LengthAwarePaginator;

    public function findForOrganizationOrFail(string $organizationId, string $id): OrganizationMember;

    public function findByOrganizationAndUserOrFail(string $organizationId, string $userId): OrganizationMember;

    public function create(array $attributes): OrganizationMember;

    public function update(OrganizationMember $member, array $attributes): OrganizationMember;

    // public function getUserByEmail(string $email): OrganizationMember;

    public function delete(OrganizationMember $member): void;
}
