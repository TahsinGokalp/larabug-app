<?php

namespace App\Models;

use App\Enums\ExceptionStatusEnum;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

/**
 * App\Models\Project
 *
 * @property string $id
 * @property string|null $title
 * @property string|null $url
 * @property string|null $key
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $last_error_at
 * @property bool $notifications_enabled
 * @property bool $receive_email
 * @property bool $telegram_notification_enabled
 * @property string $total_exceptions
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Exception> $exceptions
 * @property-read int|null $exceptions_count
 * @property-read string $route_url
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Issue> $issues
 * @property-read int|null $issues_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Exception> $unreadExceptions
 * @property-read int|null $unread_exceptions_count
 *
 * @method static \Database\Factories\ProjectFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Project filter(array $input)
 * @method static \Illuminate\Database\Eloquent\Builder|Project newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Project newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Project paginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Project query()
 * @method static \Illuminate\Database\Eloquent\Builder|Project simplePaginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Project wantsEmail()
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereLastErrorAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereNotificationsEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereReceiveEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereTelegramNotificationEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereTotalExceptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereUrl($value)
 *
 * @mixin \Eloquent
 */
class Project extends Model
{
    use HasUuids;
    use Filterable;
    use Notifiable;
    use HasFactory;

    protected $fillable = [
        'url',
        'title',
        'description',
        'notifications_enabled',
        'receive_email',
        'telegram_notification_enabled',
    ];

    protected $casts = [
        'receive_email' => 'boolean',
        'notifications_enabled' => 'boolean',
        'telegram_notification_enabled' => 'boolean',
        'last_error_at' => 'datetime',
    ];

    protected $appends = [
        'route_url',
    ];

    public static function boot(): void
    {
        parent::boot();

        static::creating(static function (self $project) {
            $project->key = Str::random(50);
        });

        static::deleting(static function (self $project) {
            $project->exceptions()->delete();
            $project->issues()->delete();
        });
    }

    public function getRouteUrlAttribute(): string
    {
        return route('projects.show', $this);
    }

    public function scopeWantsEmail($query)
    {
        return $query->where('receive_email', true);
    }

    public function exceptions(): HasMany
    {
        return $this->hasMany(Exception::class);
    }

    public function issues(): HasMany
    {
        return $this->hasMany(Issue::class);
    }

    public function unreadExceptions(): HasMany
    {
        return $this->exceptions()
            ->where(function ($query) {
                return $query
                    ->where('status', ExceptionStatusEnum::Open->value);
            });
    }

    public function scopeFilter($query, array $input): void
    {
        $query->when($input['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%');
            });
        });
    }
}
