<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ExceptionEmail extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public $collection;

    /**
     * Create a new message instance.
     */
    public function __construct(array $collection)
    {
        $this->collection = $collection;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->to($this->collection['email'], $this->collection['name'])
            ->subject('New exceptions in projects '.$this->collection['projects']->take(3)->pluck('title')->implode(', '))
            ->markdown('emails.exception');
    }
}
