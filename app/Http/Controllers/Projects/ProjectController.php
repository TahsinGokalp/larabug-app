<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Services\Project\ProjectService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct(protected ProjectService $projectService)
    {
    }

    public function index()
    {
        $search = request()->only('search');
        $projects = $this->projectService->paginatedProjects($search);

        return inertia('Projects/Index', [
            'filters' => $search,
            'projects' => $projects,
        ]);
    }

    public function create()
    {
        return inertia('Projects/Create');
    }

    public function store(ProjectRequest $request): RedirectResponse
    {
        $input = $request->only([
            'title',
            'url',
            'description',
            'receive_email',
            'notifications_enabled',
            'telegram_notification_enabled',
        ]);
        $project = $this->projectService->create($input);

        return redirect()->route('projects.installation', $project);
    }

    public function show(Request $request, $id)
    {
        $project = $this->projectService->findWithCount($id);

        $filters = request()->all('search', 'status');

        $exceptions = $this->projectService->exceptions($project, $filters);

        return inertia('Projects/Show', [
            'project' => $project,
            'exceptions' => $exceptions->appends($request->except('page')),
            'filters' => $filters,
        ]);
    }

    public function edit($id)
    {
        $project = $this->projectService->find($id);

        return inertia('Projects/Edit', [
            'project' => $project,
        ]);
    }

    public function update(ProjectRequest $request, $id): RedirectResponse
    {
        $project = $this->projectService->find($id);

        $this->projectService->update($project, $request->all());

        return redirect()->route('projects.show', $project)->with('success', 'Project has been updated');
    }

    public function destroy($id): RedirectResponse
    {
        $project = $this->projectService->find($id);

        $this->projectService->delete($project);

        return redirect()->route('projects.index')->with('success', 'Project has been removed');
    }
}
