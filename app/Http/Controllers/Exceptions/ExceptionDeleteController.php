<?php

namespace App\Http\Controllers\Exceptions;

use App\Enums\ExceptionStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ExceptionDeleteController extends Controller
{
    public function deleteAll($id): RedirectResponse
    {
        $project = Project::findOrFail($id);

        $project->exceptions()->delete();

        return redirect()->route('projects.show', $id)->with('success', 'All exceptions have been cleared up');
    }

    public function deleteFixed($id): RedirectResponse
    {
        $project = Project::findOrFail($id);

        $project->exceptions()->where('status', ExceptionStatusEnum::Fixed)->delete();

        return redirect()->route('projects.show', $id)->with('success', 'All exceptions marked as fixed have been cleared up');
    }

    public function deleteSelected(Request $request, $id): RedirectResponse
    {
        $project = Project::findOrFail($id);

        $project->exceptions()
            ->whereIn('id', $request->get('exceptions'))
            ->delete();

        return redirect()->route('projects.show', $id)->with('success', 'The selected exceptions have been cleared up');
    }
}
