<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class ProjectRefreshTokenController extends Controller
{
    public function index($id): RedirectResponse
    {
        $project = Project::findOrFail($id);

        $project->key = Str::random(50);
        $project->save();

        return redirect()->back()->with('success', 'A new API token has been generated');
    }
}
