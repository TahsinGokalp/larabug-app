<?php

namespace App\Services\Issue;

use App\Models\Issue;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class IssueService
{
    public function paginatedIssues($search): LengthAwarePaginator
    {
        return Issue::query()
            ->with('project:id,title')
            ->filter($search)
            ->orderBy('last_occurred_at', 'desc')
            ->paginate();
    }

    public function find($id): Issue
    {
        return Issue::findOrFail($id);
    }

    public function exceptions(Issue $issue, array $filter): LengthAwarePaginator
    {
        return $issue
            ->exceptions()
            ->filter($filter)
            ->latest()
            ->paginate(10);
    }

    public function affectedVersions(Issue $issue): array
    {
        return $issue->exceptions()
            ->pluck('project_version')
            ->unique()
            ->filter()
            ->sort()
            ->values()
            ->toArray();
    }

    public function updateStatus(Issue $issue): void
    {
        $issue->update([
            'status' => request()->input('status'),
        ]);
    }
}
