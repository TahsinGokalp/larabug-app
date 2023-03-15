<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use Illuminate\Http\RedirectResponse;

class IssuesController extends Controller
{
    public function index()
    {
        $issues = Issue::query()
            ->with('project:id,title')
            ->filter(request()->only('search'))
            ->orderBy('last_occurred_at', 'desc')
            ->paginate();

        return inertia('Issues/Index', [
            'filters' => request()->only('search'),
            'issues' => $issues,
        ]);
    }

    public function show($id)
    {
        $issue = Issue::findOrFail($id);

        $exceptions = $issue
            ->exceptions()
            ->filter(request()->only('search', 'status', 'has_feedback'))
            ->withCount('feedback')
            ->latest()
            ->paginate(10);

        $affectedVersions = $issue->exceptions()
            ->pluck('project_version')
            ->unique()
            ->filter()
            ->sort()
            ->values()
            ->toArray();

        return inertia('Issues/Show', [
            'issue' => $issue,
            'exceptions' => $exceptions,
            'project' => $issue->project,
            'filters' => request()->only('search'),
            'affected_versions' => implode(', ', $affectedVersions) ?: '-',
            'last_occurrence_human' => $issue->last_occurred_at->diffForHumans(),
            'total_occurrences' => $issue->exceptions()->count(),
        ]);
    }

    public function updateStatus($id): RedirectResponse
    {
        $issue = Issue::findOrFail($id);

        $issue->update([
            'status' => request()->input('status'),
        ]);

        return redirect()->route('issues.show', $issue->id)->with('success', 'Changed issue status successfully');
    }
}
