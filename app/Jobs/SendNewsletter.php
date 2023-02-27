<?php

namespace App\Jobs;

use App\Models\Newsletter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

class SendNewsletter implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $users;

    protected $subject;

    protected $content;

    protected $newsletter;

    /**
     * Create a new job instance.
     */
    public function __construct(Collection $users, $subject, $content, Newsletter $newsletter)
    {
        $this->users = $users;
        $this->subject = $subject;
        $this->content = nl2br($content);
        $this->newsletter = $newsletter;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $subject = $this->subject;

        foreach ($this->users as $user) {
            $user->newsletters()->save($this->newsletter);

            Mail::queue('emails.newsletter', ['user' => $user, 'subject' => $subject, 'content' => $this->content], function ($message) use ($user, $subject) {
                $message->to($user['email'], $user['name']);

                $message->subject($subject);
            });
        }
    }
}
