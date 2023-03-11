<?php

namespace App\Http\Controllers;

use App\Enums\ExceptionStatusEnum;
use App\Models\Exception;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ExceptionController extends Controller
{
    public function index(Request $request, $id)
    {
        $project = Project::findOrFail($id, [
            'id',
            'title',
        ]);

        $exceptions = $project
            ->exceptions();

        if (! $request->input('status')) {
            $exceptions = $exceptions->whereNotIn('status', [
                ExceptionStatusEnum::Fixed->value
            ]);
        } else {
            $exceptions = $exceptions->filter($request->all());
        }

        return $exceptions
            ->latest()
            ->paginateFilter(15, [
                'id',
                'status',
                'exception',
                'project_id',
                'publish_hash',
                'created_at',
                'method',
                'class',
                'line',
                'fullUrl',
                'file',
            ]);
    }

    public function show($id, $exception)
    {
        $project = Project::findOrFail($id);

        $exception = $project->exceptions()
            ->with('feedback')
            ->withCount('occurences')
            ->findOrFail($exception);

        //Mark exception as read
        if (! $exception->status || $exception->status === ExceptionStatusEnum::Open) {
            $exception->markAsRead();
        }

        // If it was not mailed yet (delay in cronjob which is ok), then mark as e-mail, saves resources & emails :)
        if (! $exception->isMarkedAsMailed()) {
            $exception->markAsMailed();
        }

        return inertia('Exceptions/Show', [
            'project' => $project,
            'exception' => $exception,
        ]);
    }

    public function destroy($id, $exception): RedirectResponse
    {
        $project = Project::findOrFail($id);

        $exception = $project->exceptions()->findOrFail($exception);

        $exception->delete();

        return redirect()->route('projects.show', $project->id)->with('success', 'Exception has been removed');
    }

    public function fixed($id, $exception): RedirectResponse
    {
        $project = Project::findOrFail($id);

        $exception = $project->exceptions()->findOrFail($exception);

        $exception->markAs(ExceptionStatusEnum::Fixed);

        /*
         * Also mark as mailed because the user would already know about this exception
         */
        $exception->markAsMailed();

        /*
         * Return redirect back to save filter
         */
        return redirect()->route('exceptions.show', [$id, $exception])->with('success', 'Exception has been marked as fixed');
    }

    public function togglePublic(Request $request, $id, $exception)
    {
        $project = Project::findOrFail($id);

        $exception = $project->exceptions()->findOrFail($exception);

        if ($exception->publish_hash) {
            $exception->removePublic();

            return redirect()->back()->withSuccess('Exception has been removed from public view');
        }

        $exception->makePublic();

        return redirect()->back()->withSuccess('URL has been generated');
    }

    public function markAllAsFixed(Request $request, $id): RedirectResponse
    {
        $project = Project::findOrFail($id);

        $total = $project->exceptions()
            ->where('status', '!=', ExceptionStatusEnum::Fixed)
            ->update(['status' => ExceptionStatusEnum::Fixed]);

        if ($total === 0) {
            return redirect()->route('projects.show', $id)->with('info', 'There are no exceptions to mark as fixed');
        }

        return redirect()->route('projects.show', $id)->with('success', $total . ' exception(s) have been marked as fixed');
    }

    public function markAllAsRead(Request $request, $id): RedirectResponse
    {
        $project = Project::findOrFail($id);

        $total = $project->exceptions()
            ->where('status', '!=', ExceptionStatusEnum::Read)
            ->where('status', '!=', ExceptionStatusEnum::Fixed)
            ->update(['status' => ExceptionStatusEnum::Read]);

        if ($total === 0) {
            return redirect()->route('projects.show', $id)->with('info', 'There are no exceptions to mark as read');
        }

        return redirect()->route('projects.show', $id)->with('success', $total . ' exception(s) have been marked as read');
    }

    public function markAs(Request $request, $id): RedirectResponse
    {
        $project = Project::findOrFail($id);

        foreach ($request->input('exceptions') as $exception) {
            $exception = $project->exceptions()->findOrFail($exception);

            if ((string)$request->input('type') === ExceptionStatusEnum::Fixed->value) {
                $exception->markAs(ExceptionStatusEnum::Fixed);

                /*
                 * Also mark as mailed because the user would already know about this exception
                 */
                $exception->markAsMailed();
            } else {
                $exception->markAs(ExceptionStatusEnum::Read);
            }
        }

        return redirect()->back();
    }

    public function snooze(Request $request, $id, $exceptionId): RedirectResponse
    {
        $project = Project::findOrFail($id);

        $exception = $project->exceptions()->findOrFail($exceptionId);

        $exception->snooze($request->input('snooze', 30));

        return redirect()->route('exceptions.show', [$id, $exceptionId])->with('success', 'Exception is now snoozed');
    }

    public function unSnooze(Request $request, $id, $exceptionId): RedirectResponse
    {
        $project = Project::findOrFail($id);

        $exception = $project->exceptions()->findOrFail($exceptionId);

        $exception->unsnooze();

        return redirect()->route('exceptions.show', [$id, $exceptionId])->with('success', 'Snooze status has been removed for this exception');
    }

    public function deleteAll(Request $request, $id): RedirectResponse
    {
        $project = Project::findOrFail($id);

        $project->exceptions()->delete();

        return redirect()->route('projects.show', $id)->with('success', 'All exceptions have been cleared up');
    }

    public function deleteFixed(Request $request, $id): RedirectResponse
    {
        $project = Project::findOrFail($id);

        $project->exceptions()->where('status', ExceptionStatusEnum::Fixed)->delete();

        return redirect()->route('projects.show', $id)->with('success', 'All exceptions marked as fixed have been cleared up');
    }

    public function deleteSelected(Request $request, $id): RedirectResponse
    {
        $project = Project::indOrFail($id);

        $project->exceptions()
            ->whereIn('id', $request->get('exceptions'))
            ->delete();

        return redirect()->route('projects.show', $id)->with('success', 'The selected exceptions have been cleared up');
    }
}
