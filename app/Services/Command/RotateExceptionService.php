<?php

namespace App\Services\Command;

use App\Models\Exception;

class RotateExceptionService
{
    public function isEnabled(): bool
    {
        return (bool)config('project.rotate_exceptions_enabled');
    }

    public function delete(): int
    {
        return Exception::query()->where('created_at', '<', now()
            ->subDays((int)config('project.rotate_exceptions_day')))->delete();
    }

}
