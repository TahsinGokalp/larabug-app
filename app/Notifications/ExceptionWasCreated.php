<?php

namespace App\Notifications;

use App\Models\Exception;
use App\Notifications\CustomWebhook\WebhookChannel;
use App\Notifications\CustomWebhook\WebhookMessage;
use App\Notifications\Discord\DiscordChannel;
use App\Notifications\Discord\DiscordMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\AndroidFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidNotification;
use NotificationChannels\Fcm\Resources\ApnsConfig;
use NotificationChannels\Fcm\Resources\ApnsFcmOptions;

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
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        $array = [];

        if ($notifiable->slack_webhook_enabled && $notifiable->slack_webhook) {
            $array[] = 'slack';
        }

        if ($notifiable->discord_webhook_enabled && $notifiable->discord_webhook) {
            $array[] = DiscordChannel::class;
        }

        if ($notifiable->custom_webhook_enabled && $notifiable->custom_webhook) {
            $array[] = WebhookChannel::class;
        }

        if ($notifiable->mobile_notifications_enabled && $notifiable->users()->wherePivot('owner', true)->first()?->fcmTokens()->exists()) {
            $array[] = FcmChannel::class;
        }

        return $array;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return SlackMessage
     */
    public function toSlack($notifiable)
    {
        return (new SlackMessage())
            ->error()
            ->content('['.$this->project->title.'] New exception thrown')
            ->attachment(function ($attachment) {
                $attachment->title($this->exception->exception, $this->exception->route_url)
                    ->fields([
                        'Class' => $this->exception->class,
                        'Date'  => $this->exception->created_at->format('Y-m-d H:i:s').' (UTC)',
                        'File'  => $this->exception->file,
                        'Line'  => $this->exception->line,
                    ]);
            });
    }

    public function toDiscord($notifiable)
    {
        return (new DiscordMessage())
            ->from('larabug.com')
            ->image(asset('images/larabug-logo-small.png'))
            ->embeds([
                [
                    'color'       => 13772369,
                    'title'       => '['.$this->project->title.'] New exception thrown',
                    'description' => $this->exception->exception,
                    'fields'      => [
                        [
                            'name'   => 'Class',
                            'value'  => $this->exception->class ?? 'no value',
                            'inline' => true,
                        ],
                        [
                            'name'   => 'Date',
                            'value'  => $this->exception->created_at->format('Y-m-d H:i:s').' (UTC)',
                            'inline' => true,
                        ],
                        [
                            'name'   => 'File',
                            'value'  => $this->exception->file,
                            'inline' => false,
                        ],
                        [
                            'name'   => 'Line',
                            'value'  => $this->exception->line,
                            'inline' => false,
                        ],
                        [
                            'name'   => 'View',
                            'value'  => $this->exception->route_url,
                            'inline' => false,
                        ],
                    ],
                ],
            ]);
    }

    /**
     * Get the webhook representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return WebhookMessage
     */
    public function toWebhook($notifiable)
    {
        return WebhookMessage::create()
            ->data([
                'Exception' => $this->exception->exception,
                'RouteUrl'  => $this->exception->route_url,
                'Class'     => $this->exception->class,
                'Date'      => $this->exception->created_at->format('Y-m-d H:i:s').' (UTC)',
                'File'      => $this->exception->file,
                'Line'      => $this->exception->line,
            ])
            ->userAgent('LaraBug');
    }

    public function toFcm($notifiable)
    {
        return FcmMessage::create()
            ->setData(['exception_id' => $this->exception->id, 'project_id' => $this->project->id])
            ->setNotification(
                \NotificationChannels\Fcm\Resources\Notification::create()
                    ->setTitle('New exception in project '.$this->project->title)
                    ->setBody(Str::limit($this->exception->exception))
                    ->setImage('https://www.larabug.com/favicon.ico')
            )
            // Android sound
            ->setAndroid(
                AndroidConfig::create()
                    ->setTtl(4 * 604800)
                    ->setFcmOptions(AndroidFcmOptions::create()->setAnalyticsLabel('analytics'))
                    ->setNotification(AndroidNotification::create()->setSound('default'))
            )
            // Apple sound
            ->setApns(
                ApnsConfig::create()
                    ->setFcmOptions(ApnsFcmOptions::create()->setAnalyticsLabel('analytics_ios'))
                    ->setPayload(['aps' => ['sound' => 'default']])
            );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
