<?php

namespace App\Modules\Projects\Contracts;

use App\Modules\Projects\Models\Project;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProjectRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function findOrFail(string $id): Project;

    /** @param array<string, mixed> $attributes */
    public function create(array $attributes): Project;

    /** @param array<string, mixed> $attributes */
    public function update(Project $project, array $attributes): Project;

    public function delete(Project $project): void;
}
