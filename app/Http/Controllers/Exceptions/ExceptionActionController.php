<?php

namespace App\Http\Controllers\Exceptions;

use App\Enums\ExceptionStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ExceptionActionController extends Controller
{
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

    public function togglePublic($id, $exception)
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

    public function markAllAsRead($id): RedirectResponse
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

            if ((string) $request->input('type') === ExceptionStatusEnum::Fixed->value) {
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

    public function unSnooze($id, $exceptionId): RedirectResponse
    {
        $project = Project::findOrFail($id);

        $exception = $project->exceptions()->findOrFail($exceptionId);

        $exception->unsnooze();

        return redirect()->route('exceptions.show', [$id, $exceptionId])->with('success', 'Snooze status has been removed for this exception');
    }
}
