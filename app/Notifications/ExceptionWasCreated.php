<?php

namespace App\Notifications;

use App\Models\Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class ExceptionWasCreated extends Notification implements ShouldQueue
{
    use Queueable;

    private $project;

    private $exception;

    /**
     * Create a new notification instance.
     */
    public function __construct(Exception $exception)
    {
        $this->project = $exception->project;
        $this->exception = $exception;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $array = [];

        if ($notifiable->telegram_notification_enabled) {
            $array[] = 'telegram';
        }

        return $array;
    }

    public function toTelegram($notifiable)
    {
        return TelegramMessage::create()
            ->to(config('services.telegram-bot-api.group'))
            ->options([
                'parse_mode' => 'HTML',
                'disable_web_page_preview' => true,
            ])
            ->view('notifications.exception_created', [
                'title' => '[' . $this->project->title . '] New exception thrown',
                'exception' => $this->exception->exception,
                'route_url' => $this->exception->route_url,
                'class' => $this->exception->class,
                'date' => $this->exception->created_at->format('Y-m-d H:i:s') . ' (UTC)',
                'file' => $this->exception->file,
                'line' => $this->exception->line,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
