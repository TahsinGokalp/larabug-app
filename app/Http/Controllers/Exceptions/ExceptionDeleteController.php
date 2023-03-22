<?php

namespace App\Http\Controllers\Exceptions;

use App\Http\Controllers\Controller;
use App\Services\Exception\ExceptionDeleteService;
use App\Services\Project\ProjectService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ExceptionDeleteController extends Controller
{
    public function __construct(protected ProjectService $projectService,
                                protected ExceptionDeleteService $exceptionDeleteService)
    {
    }

    public function deleteAll($id): RedirectResponse
    {
        $project = $this->projectService->find($id);

        $this->exceptionDeleteService->deleteAll($project);

        return redirect()->route('projects.show', $id)
            ->with('success', 'All exceptions have been cleared up');
    }

    public function deleteFixed($id): RedirectResponse
    {
        $project = $this->projectService->find($id);

        $this->exceptionDeleteService->deleteFixed($project);

        return redirect()->route('projects.show', $id)->with('success', 'All exceptions marked as fixed have been cleared up');
    }

    public function deleteSelected(Request $request, $id): RedirectResponse
    {
        $project = $this->projectService->find($id);

        $this->exceptionDeleteService->deleteSelected($project, $request->get('exceptions'));

        return redirect()->route('projects.show', $id)
            ->with('success', 'The selected exceptions have been cleared up');
    }
}
