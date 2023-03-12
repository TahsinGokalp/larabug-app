<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Models\Project;

class ProjectInstallationController extends Controller
{
    public function index($id)
    {
        $project = Project::findOrFail($id);

        return inertia('Projects/Installation', [
            'project' => $project,
        ]);
    }

}
