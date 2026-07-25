<?php

namespace App\Modules\Projects\Actions;

use App\Modules\Projects\Contracts\ProjectRepositoryInterface;
use App\Modules\Projects\Models\Project;

final readonly class DeleteProjectAction
{
    public function __construct(private ProjectRepositoryInterface $projects)
    {
    }

    public function execute(Project $project): void
    {
        $this->projects->delete($project);
    }
}
