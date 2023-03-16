<?php

namespace App\Http\Controllers\Issues;

use App\Http\Controllers\Controller;
use App\Models\Issue;
use App\Services\Issue\IssueService;
use Illuminate\Http\RedirectResponse;

class IssuesController extends Controller
{
    public function __construct(protected IssueService $issueService)
    {
    }

    public function index()
    {
        $search = request()->only('search');
        $issues = $this->issueService->paginatedIssues($search);

        return inertia('Issues/Index', [
            'filters' => $search,
            'issues' => $issues,
        ]);
    }

    public function show($id)
    {
        $issue = $this->issueService->find($id);

        $exceptions = $this->issueService->exceptions($issue, request()->only('search', 'status'));

        $affectedVersions = $this->issueService->affectedVersions($issue);

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
        $issue = $this->issueService->find($id);

        $this->issueService->updateStatus($issue);

        return redirect()->route('issues.show', $issue->id)->with('success', 'Changed issue status successfully');
    }
}
