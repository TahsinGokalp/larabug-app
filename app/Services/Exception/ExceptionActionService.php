<?php

namespace App\Services\Exception;

use App\Enums\ExceptionStatusEnum;
use App\Models\Exception;
use App\Models\Project;

class ExceptionActionService
{
    public function find(Project $project, $id): Exception
    {
        return $project->exceptions()->findOrFail($id);
    }

    public function markAsFixed($exception): void
    {
        $exception->markAs(ExceptionStatusEnum::Fixed);

        $exception->markAsMailed();
    }

    public function togglePublic(Project $project, $exception): string
    {
        if ($exception->publish_hash) {
            $exception->removePublic();

            return 'Exception has been removed from public view';
        }

        $exception->makePublic();

        return 'URL has been generated';
    }

    public function markAllAsFixed(Project $project): int
    {
        return $project->exceptions()
            ->where('status', '!=', ExceptionStatusEnum::Fixed)
            ->update(['status' => ExceptionStatusEnum::Fixed]);
    }

    public function markAllAsRead(Project $project): int
    {
        return $project->exceptions()
            ->where('status', '!=', ExceptionStatusEnum::Read)
            ->where('status', '!=', ExceptionStatusEnum::Fixed)
            ->update(['status' => ExceptionStatusEnum::Read]);
    }

    public function markAs(Project $project, $exceptions, $type): void
    {
        foreach ($exceptions as $exception) {
            $exception = $project->exceptions()->findOrFail($exception);

            if ((string) $type === ExceptionStatusEnum::Fixed->value) {
                $exception->markAs(ExceptionStatusEnum::Fixed);

                $exception->markAsMailed();
            } else {
                $exception->markAs(ExceptionStatusEnum::Read);
            }
        }
    }

    public function snooze($exception, $snooze): void
    {
        $exception->snooze($snooze);
    }

    public function unsnooze($exception): void
    {
        $exception->unsnooze();
    }
}
