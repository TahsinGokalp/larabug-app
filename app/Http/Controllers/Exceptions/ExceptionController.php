<?php

namespace App\Http\Controllers\Exceptions;

use App\Enums\ExceptionStatusEnum;
use App\Http\Controllers\Controller;
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
                ExceptionStatusEnum::Fixed->value,
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
}
