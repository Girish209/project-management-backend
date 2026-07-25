<?php

namespace App\Modules\Projects\Actions;

use App\Modules\Projects\Contracts\ProjectRepositoryInterface;
use App\Modules\Projects\DTOs\StoreProjectData;
use App\Modules\Projects\Models\Project;

final readonly class CreateProjectAction
{
    public function __construct(private ProjectRepositoryInterface $projects)
    {
    }

    public function execute(StoreProjectData $data): Project
    {
        return $this->projects->create($data->toArray());
    }
}
