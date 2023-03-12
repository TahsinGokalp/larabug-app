<?php

namespace App\Models;

use App\Enums\ExceptionStatusEnum;
use App\Notifications\ExceptionWasCreated;
use DateTimeInterface;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * App\Models\Exception
 *
 * @property string $id
 * @property string|null $host
 * @property string|null $method
 * @property string|null $fullUrl
 * @property string|null $exception
 * @property string|null $environment
 * @property string|null $error
 * @property string|null $line
 * @property string|null $file
 * @property array|null $storage
 * @property string $file_type
 * @property string|null $class
 * @property ExceptionStatusEnum|null $status
 * @property bool $mailed
 * @property array|null $additional
 * @property string|null $published_at
 * @property string|null $publish_hash
 * @property string|null $previousUrl
 * @property string|null $publish_password
 * @property array|null $executor
 * @property string|null $snooze_until
 * @property string|null $project_version
 * @property string|null $issue_id
 * @property string $project_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Feedback> $feedback
 * @property-read int|null $feedback_count
 * @property-read string $executor_output
 * @property-read string $human_date
 * @property-read string|null $issue_route_url
 * @property-read string $markup_language
 * @property-read string $project_route_url
 * @property-read string|null $public_route_url
 * @property-read string $route_url
 * @property-read string $short_exception_text
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Exception> $occurences
 * @property-read int|null $occurences_count
 * @property-read \App\Models\Project $project
 *
 * @method static \Database\Factories\ExceptionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Exception filter(array $input = [], $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Exception newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Exception newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Exception paginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Exception query()
 * @method static \Illuminate\Database\Eloquent\Builder|Exception simplePaginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Exception whereAdditional($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exception whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Exception whereClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exception whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exception whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Exception whereEnvironment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exception whereError($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exception whereException($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exception whereExecutor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exception whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exception whereFileType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exception whereFullUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exception whereHost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exception whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exception whereIssueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exception whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Exception whereLine($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exception whereMailed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exception whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exception wherePreviousUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exception whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exception whereProjectVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exception wherePublishHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exception wherePublishPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exception wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exception whereSnoozeUntil($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exception whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exception whereStorage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exception whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Exception extends Model
{
    use HasUuids;
    use Filterable;
    use HasFactory;

    /**
     * @var array
     */
    protected $guarded = [
        'created_at',
        'updated_at',
        'published_at',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'user' => 'array',
        'storage' => 'array',
        'executor' => 'array',
        'mailed' => 'boolean',
        'additional' => 'array',
        'status' => ExceptionStatusEnum::class,
    ];

    protected $appends = [
        'human_date',
        'public_route_url',
        'issue_route_url',
        'project_route_url',
        'route_url',
        'short_exception_text',
        'executor_output',
        'markup_language',
    ];

    /*
    public function scopeNotMailed($query)
    {
        return $query->whereMailed(false);
    }


    public function scopeNew($query)
    {
        return $query->whereStatus(self::OPEN);
    }

    public function issue(): BelongsTo
    {
        return $this->belongsTo(Issue::class);
    }

    public function isPublic()
    {
        return $this->publish_hash ? true : false;
    }

    public function snooze(int $minutes)
    {
        $this->snooze_until = now()->addMinutes($minutes);
        $this->save();

        return true;
    }

    public function unsnooze()
    {
        $this->snooze_until = null;
        $this->save();

        return true;
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function isGitCommit()
    {
        return strlen($this->project_version) === 7;
    }

    */

    public static function boot()
    {
        parent::boot();

        static::creating(function ($exception) {
            $exception->status = ExceptionStatusEnum::Open->value;
        });

        static::created(function ($exception) {
            if ($exception->project && $exception->project->notifications_enabled) {
                //TODO : Control
                //$exception->project->notify(new ExceptionWasCreated($exception));
            }
        });
    }

    public function occurences(): HasMany
    {
        return $this->hasMany(self::class, 'exception', 'exception')
            ->whereRaw('id != exceptions.id and line = exceptions.line and project_id = exceptions.project_id')
            ->where('created_at', '>', now()->subMonth());
    }

    public function markAsRead(): void
    {
        $this->status = ExceptionStatusEnum::Read;
        $this->save();
    }

    public function markAsMailed(): void
    {
        $this->mailed = true;
        $this->save();
    }

    public function isMarkedAsMailed(): bool
    {
        return $this->mailed;
    }

    public function markAs($status = ExceptionStatusEnum::Fixed): void
    {
        $this->status = $status;
        $this->save();
    }

    public function makePublic(): static
    {
        $this->publish_hash = Str::random(15);
        $this->published_at = now();
        $this->save();

        return $this;
    }

    public function removePublic(): static
    {
        $this->publish_hash = null;
        $this->published_at = null;
        $this->save();

        return $this;
    }

    public function getHumanDateAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    public function getPublicRouteUrlAttribute(): ?string
    {
        if (! $this->publish_hash) {
            return null;
        }

        return route('public.exception', $this);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function getIssueRouteUrlAttribute(): ?string
    {
        if (! $this->issue_id) {
            return null;
        }

        return route('issues.show', $this->issue_id);
    }

    public function getRouteUrlAttribute(): string
    {
        return route('exceptions.show', [$this->project_id, $this]);
    }

    public function getProjectRouteUrlAttribute(): string
    {
        return route('projects.show', $this->project_id);
    }

    public function getShortExceptionTextAttribute(): string
    {
        if (! $this->exception) {
            return '-No exception text-';
        }

        return Str::limit($this->exception, 75);
    }

    public function getExecutorOutputAttribute(): string
    {
        return implode(PHP_EOL, collect($this->executor)->map(function ($line) {
            return preg_replace(
                '/^[0-9]{1,}[.]/i',
                '',
                str_replace(
                    "\n",
                    '',
                    Arr::get($line, 'line')
                )
            );
        })->toArray());
    }

    public function getMarkupLanguageAttribute(): string
    {
        $pathInfo = pathinfo($this->file);

        $extension = (string) Arr::get($pathInfo, 'extension');

        if ($extension === 'php') {
            return 'language-php';
        }

        if ($extension === 'html') {
            return 'language-html';
        }

        return 'language-php';
    }

    public function feedback(): HasMany
    {
        return $this->hasMany(Feedback::class);
    }
}
