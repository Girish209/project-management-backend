<?php

namespace App\Modules\Organizations\Contracts;

use App\Modules\Organizations\Models\Organization;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface OrganizationRepositoryInterface
{
    public function paginateForOwner(string $ownerId, int $perPage = 15): LengthAwarePaginator;

    public function findOrFail(string $id): Organization;

    public function create(array $attributes): Organization;

    public function update(Organization $organization, array $attributes): Organization;

    // public function getUserByEmail(string $email): User;

    public function delete(Organization $organization): void;
}
