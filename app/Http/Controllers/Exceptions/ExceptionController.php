<?php

namespace App\Http\Controllers\Exceptions;

use App\Http\Controllers\Controller;
use App\Services\Exception\ExceptionService;
use App\Services\Project\ProjectService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ExceptionController extends Controller
{
    public function __construct(protected ProjectService $projectService, protected ExceptionService $exceptionService)
    {
    }

    public function index(Request $request, $id): LengthAwarePaginator
    {
        $project = $this->projectService->find($id);

        return $this->exceptionService->paginatedExceptions($request, $project);
    }

    public function show($id, $exception)
    {
        $project = $this->projectService->find($id);

        $exception = $this->exceptionService->findWithCount($project, $exception);

        $this->exceptionService->markExceptionAsRead($exception);

        $this->exceptionService->markExceptionAsMailed($exception);

        return inertia('Exceptions/Show', [
            'project' => $project,
            'exception' => $exception,
        ]);
    }

    public function destroy($id, $exception): RedirectResponse
    {
        $project = $this->projectService->find($id);

        $this->exceptionService->delete($project, $exception);

        return redirect()->route('projects.show', $project->id)->with('success', 'Exception has been removed');
    }
}
