<?php

namespace App\Services\Exception;

use App\Enums\ExceptionStatusEnum;
use App\Models\Project;

class ExceptionDeleteService
{
    public function deleteAll(Project $project): void
    {
        $project->exceptions()->delete();
    }

    public function deleteFixed(Project $project): void
    {
        $project->exceptions()->where('status', ExceptionStatusEnum::Fixed)->delete();
    }

    public function deleteSelected(Project $project, $id): void
    {
        $project->exceptions()
            ->whereIn('id', $id)
            ->delete();
    }
}
