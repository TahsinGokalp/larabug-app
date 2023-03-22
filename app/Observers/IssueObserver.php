<?php

namespace App\Observers;

use App\Enums\ExceptionStatusEnum;
use App\Models\Issue;
use App\Notifications\IssueStatusUpdatedNotification;

class IssueObserver
{
    public function updated(Issue $issue): void
    {
        if ($issue->isDirty('status') && $issue->status === ExceptionStatusEnum::Fixed) {
            $issue->exceptions()->update([
                'status' => $issue->status,
            ]);
        }

        if ($issue->isDirty('status') && $issue->status === ExceptionStatusEnum::Read) {
            $issue->exceptions()->where('status', ExceptionStatusEnum::Open)->update([
                'status' => $issue->status,
            ]);
        }

        $issue->project->notify(new IssueStatusUpdatedNotification($issue));
    }
}
