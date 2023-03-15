<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Services\Project\ProjectService;

class ProjectInstallationController extends Controller
{
    public function __construct(protected ProjectService $projectService){}
    public function index($id)
    {
        $project = $this->projectService->find($id);

        return inertia('Projects/Installation', [
            'project' => $project,
        ]);
    }
}
