<?php

namespace App\Modules\Projects\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Projects\Actions\CreateProjectAction;
use App\Modules\Projects\Actions\DeleteProjectAction;
use App\Modules\Projects\Actions\UpdateProjectAction;
use App\Modules\Projects\Contracts\ProjectRepositoryInterface;
use App\Modules\Projects\DTOs\StoreProjectData;
use App\Modules\Projects\DTOs\UpdateProjectData;
use App\Modules\Projects\Http\Requests\StoreProjectRequest;
use App\Modules\Projects\Http\Requests\UpdateProjectRequest;
use App\Modules\Projects\Http\Resources\ProjectResource;
use App\Modules\Projects\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProjectController extends Controller
{
    public function index(ProjectRepositoryInterface $projects): AnonymousResourceCollection
    {
        return ProjectResource::collection($projects->paginate());
    }

    public function store(StoreProjectRequest $request, CreateProjectAction $action): JsonResponse
    {
        $project = $action->execute(StoreProjectData::fromArray($request->validated()));

        return (new ProjectResource($project))->response()->setStatusCode(201);
    }

    public function show(Project $project): ProjectResource
    {
        return new ProjectResource($project);
    }

    public function update(UpdateProjectRequest $request, Project $project, UpdateProjectAction $action): ProjectResource
    {
        return new ProjectResource($action->execute($project, UpdateProjectData::fromArray($request->validated())));
    }

    public function destroy(Project $project, DeleteProjectAction $action): JsonResponse
    {
        $action->execute($project);

        return response()->json(status: 204);
    }
}
