<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use App\Notifications\TestWebhook;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::select('id', 'title', 'total_exceptions')
            ->withCount('unreadExceptions')
            ->filter(request()->only('search'))
            ->latest('last_error_at')
            ->latest('created_at')
            ->paginate(6);

        return inertia('Projects/Index', [
            'filters' => request()->only('search'),
            'projects' => $projects,
        ]);
    }

    public function create()
    {
        return inertia('Projects/Create');
    }

    public function store(ProjectRequest $request): RedirectResponse
    {
        $project = Project::create($request->only([
            'title',
            'url',
            'description',
            'receive_email',
            'notifications_enabled',
            'telegram_notification_enabled',
        ]));

        return redirect()->route('projects.installation', $project);
    }

    public function show(Request $request, $id)
    {
        $project = Project::withCount('unreadExceptions')
            ->findOrFail($id);

        $exceptions = $project
            ->exceptions()
            ->filter($request->only('search', 'status', 'has_feedback'))
            ->withCount('feedback')
            ->latest()
            ->paginate(10);

        return inertia('Projects/Show', [
            'project' => $project,
            'exceptions' => $exceptions->appends($request->except('page')),
            'filters' => request()->all('search', 'status', 'has_feedback'),
        ]);
    }

    public function edit($id)
    {
        $project = Project::findOrFail($id);

        return inertia('Projects/Edit', [
            'project' => $project,
        ]);
    }

    public function update(ProjectRequest $request, $id): RedirectResponse
    {
        $project = Project::findOrFail($id);

        $project->update($request->all());

        return redirect()->route('projects.show', $project)->with('success', 'Project has been updated');
    }

    public function destroy(Request $request, $id): RedirectResponse
    {
        $project = Project::findOrFail($id);

        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project has been removed');
    }

    public function installation($id)
    {
        $project = Project::findOrFail($id);

        return inertia('Projects/Installation', [
            'project' => $project,
        ]);
    }

    public function refreshToken(Request $request, $id): RedirectResponse
    {
        $project = Project::findOrFail($id);

        $project->key = Str::random(50);
        $project->save();

        return redirect()->back()->with('success', 'A new API token has been generated');
    }
}
