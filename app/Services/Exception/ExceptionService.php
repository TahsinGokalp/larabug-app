<?php

namespace App\Services\Exception;

use App\Enums\ExceptionStatusEnum;
use App\Models\Exception;
use App\Models\Project;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class ExceptionService
{
    public function paginatedExceptions(Request $request, $project): LengthAwarePaginator
    {
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

    public function findWithCount(Project $project, $id): Exception
    {
        return $project->exceptions()
            ->withCount('occurences')
            ->findOrFail($id);
    }

    public function markExceptionAsRead(Exception $exception): void
    {
        if (! $exception->status || $exception->status === ExceptionStatusEnum::Open) {
            $exception->markAsRead();
        }
    }

    public function markExceptionAsMailed(Exception $exception): void
    {
        if (! $exception->isMarkedAsMailed()) {
            $exception->markAsMailed();
        }
    }

    public function delete(Project $project, $id): void
    {
        $exception = $project->exceptions()->findOrFail($id);

        $exception->delete();
    }
}
