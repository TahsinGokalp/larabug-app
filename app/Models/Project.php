<?php

namespace App\Models;

use App\Notifications\IssueStatusUpdatedNotification;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Notifications\Notifiable;
use Kblais\Uuid\Uuid;

/**
 * App\Models\Project
 *
 * @property string slack_webhook
 * @property string discord_channel
 * @property string discord_webhook
 * @property string title
 * @property mixed pivot
 * @property bool receive_email
 * @property bool notifications_enabled
 * @property bool mobile_notifications_enabled
 * @property bool slack_webhook_enabled
 * @property bool discord_webhook_enabled
 * @property bool custom_webhook_enabled
 * @property string key
 * @property mixed url
 * @property string $id
 * @property string|null $title
 * @property string|null $url
 * @property string|null $key
 * @property string|null $description
 * @property string|null $slack_webhook
 * @property string|null $discord_webhook
 * @property string|null $custom_webhook
 * @property string $total_exceptions
 * @property bool $receive_email
 * @property bool $notifications_enabled
 * @property bool $mobile_notifications_enabled
 * @property bool $slack_webhook_enabled
 * @property bool $discord_webhook_enabled
 * @property bool $custom_webhook_enabled
 * @property string|null $group_id
 * @property int|null $user_id
 * @property string|null $last_error_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property bool $issue_receive_email
 * @property bool $issue_mobile_notifications_enabled
 * @property bool $issue_slack_webhook_enabled
 * @property bool $issue_discord_webhook_enabled
 * @property bool $issue_custom_webhook_enabled
 * @property string|null $issue_slack_webhook
 * @property string|null $issue_discord_webhook
 * @property string|null $issue_custom_webhook
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Exception> $exceptions
 * @property-read int|null $exceptions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Feedback> $feedback
 * @property-read int|null $feedback_count
 * @property-read mixed $feedback_script_html
 * @property-read mixed $route_url
 * @property-read \App\Models\ProjectGroup|null $group
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Issue> $issues
 * @property-read int|null $issues_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Database\Factories\ProjectFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Project filter(array $filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Project newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Project newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Project paginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Project query()
 * @method static \Illuminate\Database\Eloquent\Builder|Project simplePaginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Project wantsEmail()
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereCustomWebhook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereCustomWebhookEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereDiscordWebhook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereDiscordWebhookEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereIssueCustomWebhook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereIssueCustomWebhookEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereIssueDiscordWebhook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereIssueDiscordWebhookEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereIssueMobileNotificationsEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereIssueReceiveEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereIssueSlackWebhook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereIssueSlackWebhookEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereLastErrorAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereMobileNotificationsEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereNotificationsEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereReceiveEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereSlackWebhook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereSlackWebhookEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereTotalExceptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereUserId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Exception> $exceptions
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Feedback> $feedback
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Issue> $issues
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @mixin \Eloquent
 */
class Project extends Model
{
    use Uuid,
        Filterable,
        Notifiable,
        HasFactory;

    protected $fillable = [
        'url',
        'title',
        'description',
        'receive_email',
        'notifications_enabled',
        'slack_webhook',
        'discord_webhook',
        'custom_webhook',
        'mobile_notifications_enabled',
        'slack_webhook_enabled',
        'discord_webhook_enabled',
        'custom_webhook_enabled',
        'issue_receive_email',
        'issue_slack_webhook',
        'issue_discord_webhook',
        'issue_custom_webhook',
        'issue_mobile_notifications_enabled',
        'issue_slack_webhook_enabled',
        'issue_discord_webhook_enabled',
        'issue_custom_webhook_enabled',
    ];

    protected $dates = [
        'last_exception_at',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'receive_email' => 'boolean',
        'notifications_enabled' => 'boolean',
        'mobile_notifications_enabled' => 'boolean',
        'slack_webhook_enabled' => 'boolean',
        'discord_webhook_enabled' => 'boolean',
        'custom_webhook_enabled' => 'boolean',
        'issue_receive_email' => 'boolean',
        'issue_mobile_notifications_enabled' => 'boolean',
        'issue_slack_webhook_enabled' => 'boolean',
        'issue_discord_webhook_enabled' => 'boolean',
        'issue_custom_webhook_enabled' => 'boolean',
    ];

    protected $appends = [
        'route_url',
        'feedback_script_html',
    ];

    public function getRouteUrlAttribute()
    {
        return route('panel.projects.show', $this);
    }

    public function getFeedbackScriptUrl()
    {
        return route('feedback.script', ['project' => $this->id]);
    }

    public function getFeedbackScriptHtmlAttribute()
    {
        return '<script src="'.$this->getFeedbackScriptUrl().'"></script>';
    }

    public function routeNotificationForSlack($notification)
    {
        if ($notification instanceof IssueStatusUpdatedNotification) {
            return $this->issue_slack_webhook;
        }

        return $this->slack_webhook;
    }

    public function routeNotificationForDiscord($notification)
    {
        if ($notification instanceof IssueStatusUpdatedNotification) {
            return $this->issue_discord_webhook;
        }

        return $this->discord_webhook;
    }

    public function routeNotificationForWebhook($notification)
    {
        if ($notification instanceof IssueStatusUpdatedNotification) {
            return $this->issue_custom_webhook;
        }

        return $this->custom_webhook;
    }

    public function isOwner()
    {
        return $this->pivot->owner;
    }

    public function hasNotificationChannelsEnabled()
    {
        return $this->slack_webhook || $this->discord_webhook;
    }

    public function scopeWantsEmail($query)
    {
        return $query->where('receive_email', true);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\User::class)->withPivot('owner');
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(\App\Models\ProjectGroup::class);
    }

    public function exceptions(): HasMany
    {
        return $this->hasMany(\App\Models\Exception::class);
    }

    public function issues(): HasMany
    {
        return $this->hasMany(Issue::class);
    }

    public function unreadExceptions()
    {
        return $this->exceptions()
            ->where(function ($query) {
                return $query
                    ->where('status', \App\Models\Exception::OPEN);
            });
    }

    public function feedback(): HasManyThrough
    {
        return $this->hasManyThrough(Feedback::class, Exception::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', '%'.$search.'%');
            });
        });
    }

    public function routeNotificationForFcm()
    {
        return $this->users()->wherePivot('owner', true)->first()
            ->fcmTokens()
            ->get()
            ->map(function ($fcmToken) {
                return $fcmToken->token;
            })->toArray();
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function (self $project) {
            $project->key = str_random(50);
        });

        static::deleting(function (self $project) {
            $project->exceptions()->delete();
            $project->issues()->delete();
            $project->feedback()->delete();
        });
    }
}
