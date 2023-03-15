<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Services\Project\ProjectService;
use Illuminate\Http\RedirectResponse;

class ProjectRefreshTokenController extends Controller
{
    public function __construct(protected ProjectService $projectService){}
    public function index($id): RedirectResponse
    {
        $project = $this->projectService->find($id);

        $this->projectService->refreshToken($project);

        return redirect()->back()->with('success', 'A new API token has been generated');
    }
}
