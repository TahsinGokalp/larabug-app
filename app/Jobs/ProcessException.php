<?php

namespace App\Jobs;

use App\Models\Project;
use App\Services\Api\HandleExceptionService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class ProcessException implements ShouldQueue, ShouldBeEncrypted
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public Project $project;

    public array $data;

    public Carbon $date;

    public HandleExceptionService $handleExceptionService;

    public function __construct(array $data, Project $project, Carbon $date)
    {
        $this->data = $data;
        $this->project = $project;
        $this->date = $date;
        $this->handleExceptionService = new HandleExceptionService;
    }

    public function handle(): void
    {
        $this->handleExceptionService->handle($this->data, $this->project, $this->date);
    }
}
