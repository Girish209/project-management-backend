<?php

namespace App\Modules\Projects\Actions;

use App\Modules\Projects\Contracts\ProjectRepositoryInterface;
use App\Modules\Projects\DTOs\UpdateProjectData;
use App\Modules\Projects\Models\Project;

final readonly class UpdateProjectAction
{
    public function __construct(private ProjectRepositoryInterface $projects)
    {
    }

    public function execute(Project $project, UpdateProjectData $data): Project
    {
        return $this->projects->update($project, $data->attributes);
    }
}
