<?php

namespace App\Console\Commands;

use App\Services\Command\SendExceptionEmailService;
use Illuminate\Console\Command;

class MailExceptions extends Command
{
    protected $signature = 'mail:exceptions';

    protected $description = 'Send exception email notifications';

    public function __construct(protected SendExceptionEmailService $sendExceptionEmailService)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $this->sendExceptionEmailService->sendEmails();
    }
}
