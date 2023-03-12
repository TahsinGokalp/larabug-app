<?php

namespace App\Notifications;

use App\Models\Issue;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;
use NotificationChannels\Telegram\TelegramMessage;

class IssueStatusUpdatedNotification extends Notification
{
    public function __construct(public Issue $issue)
    {
    }

    public function via($notifiable): array
    {
        $array = [];

        if ($notifiable->telegram_notification_enabled) {
            $array[] = 'telegram';
        }

        return $array;
    }
    public function toTelegram()
    {
        return TelegramMessage::create()
            ->to(config('services.telegram-bot-api.group'))
            ->options([
                'parse_mode' => 'HTML',
                'disable_web_page_preview' => true,
            ])
            ->view('notifications.issue_status_updated', [
                'title' => '['.$this->issue->project->title.'] Issue status changed',
                'description' => $this->issue->exception,
                'status' => $this->issue->status,
            ]);
    }
    public function toArray($notifiable): array
    {
        return [];
    }
}
