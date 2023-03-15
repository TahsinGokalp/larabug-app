<?php

namespace App\Console\Commands;

use App\Services\Command\RotateExceptionService;
use Illuminate\Console\Command;

class RotateExceptions extends Command
{
    protected $signature = 'rotate:exceptions';

    protected $description = 'Rotates all the exceptions that are expired';

    public function __construct(protected RotateExceptionService $rotateExceptionService)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        if (! $this->rotateExceptionService->isEnabled()) {
            $this->info('Rotate exceptions is disabled!');

            return;
        }

        $rotate = $this->rotateExceptionService->delete();

        $this->info('Rotated ' . $rotate . ' exceptions!');
    }
}
