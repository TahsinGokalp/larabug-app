<?php

namespace App\Services\Project;

use App\Models\Project;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProjectService
{
    public function paginatedProjects($search): LengthAwarePaginator
    {
        return Project::select(['id', 'title', 'total_exceptions'])
            ->withCount('unreadExceptions')
            ->filter($search)
            ->latest('last_error_at')
            ->latest('created_at')
            ->paginate(6);
    }

    public function create($input){
        return Project::create($input);
    }

    public function update($project, $input): void
    {
        $project->update($input);
    }

    public function findWithCount($id): Model|Collection|array|Project|Builder|null
    {
        return Project::withCount('unreadExceptions')->findOrFail($id);
    }

    public function find($id): Model|Collection|array|Project|Builder|null
    {
        return Project::findOrFail($id);
    }

    public function delete(Project $project): void
    {
        $project->delete();
    }

    public function exceptions(Project $project, array $filters): LengthAwarePaginator
    {
        return $project
            ->exceptions()
            ->filter($filters)
            ->withCount('feedback')
            ->latest()
            ->paginate(10);
    }

    public function refreshToken(Project $project): void
    {
        $project->key = Str::random(50);
        $project->save();
    }
}
