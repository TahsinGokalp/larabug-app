<?php

namespace App\Http\Controllers\Exceptions;

use App\Http\Controllers\Controller;
use App\Services\Exception\ExceptionActionService;
use App\Services\Project\ProjectService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ExceptionActionController extends Controller
{
    public function __construct(protected ProjectService $projectService,
                                protected ExceptionActionService $exceptionActionService)
    {
    }

    public function fixed($id, $exceptionId): RedirectResponse
    {
        $project = $this->projectService->find($id);

        $exception = $this->exceptionActionService->find($project, $exceptionId);

        $this->exceptionActionService->markAsFixed($exception);

        return redirect()->route('exceptions.show', [$id, $exception])
            ->with('success', 'Exception has been marked as fixed');
    }

    public function togglePublic($id, $exceptionId)
    {
        $project = $this->projectService->find($id);

        $exception = $this->exceptionActionService->find($project, $exceptionId);

        $message = $this->exceptionActionService->togglePublic($project, $exception);

        return redirect()->back()->withSuccess($message);
    }

    public function markAllAsFixed($id): RedirectResponse
    {
        $project = $this->projectService->find($id);

        $total = $this->exceptionActionService->markAllAsFixed($project);

        if ($total === 0) {
            return redirect()->route('projects.show', $id)
                ->with('info', 'There are no exceptions to mark as fixed');
        }

        return redirect()->route('projects.show', $id)
            ->with('success', $total . ' exception(s) have been marked as fixed');
    }

    public function markAllAsRead($id): RedirectResponse
    {
        $project = $this->projectService->find($id);

        $total = $this->exceptionActionService->markAllAsRead($project);

        if ($total === 0) {
            return redirect()->route('projects.show', $id)
                ->with('info', 'There are no exceptions to mark as read');
        }

        return redirect()->route('projects.show', $id)
            ->with('success', $total . ' exception(s) have been marked as read');
    }

    public function markAs(Request $request, $id): RedirectResponse
    {
        $project = $this->projectService->find($id);

        $this->exceptionActionService->markAs($project, $request->input('exceptions'), $request->input('type'));

        return redirect()->back();
    }

    public function snooze(Request $request, $id, $exceptionId): RedirectResponse
    {
        $project = $this->projectService->find($id);

        $exception = $this->exceptionActionService->find($project, $exceptionId);

        $this->exceptionActionService->snooze($exception, $request->input('snooze', 30));

        return redirect()->route('exceptions.show', [$id, $exceptionId])
            ->with('success', 'Exception is now snoozed');
    }

    public function unSnooze($id, $exceptionId): RedirectResponse
    {
        $project = $this->projectService->find($id);

        $exception = $this->exceptionActionService->find($project, $exceptionId);

        $this->exceptionActionService->unsnooze($exception);

        return redirect()->route('exceptions.show', [$id, $exceptionId])
            ->with('success', 'Snooze status has been removed for this exception');
    }
}
