<?php

namespace App\Modules\Projects\Repositories;

use App\Modules\Projects\Contracts\ProjectRepositoryInterface;
use App\Modules\Projects\Models\Project;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class EloquentProjectRepository implements ProjectRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Project::query()->latest()->paginate($perPage);
    }

    public function findOrFail(string $id): Project
    {
        return Project::query()->findOrFail($id);
    }

    public function create(array $attributes): Project
    {
        return Project::query()->create($attributes);
    }

    public function update(Project $project, array $attributes): Project
    {
        $project->update($attributes);

        return $project->refresh();
    }

    public function delete(Project $project): void
    {
        $project->delete();
    }
}
