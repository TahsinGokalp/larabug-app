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
        'user'       => 'array',
        'storage'    => 'array',
        'executor'   => 'array',
        'mailed'     => 'boolean',
        'additional' => 'array',
        'status' => ExceptionStatusEnum::class,
    ];

    protected $appends = [
        'human_date',
        'public_route_url',
        'issue_route_url',
        'route_url',
        'short_exception_text',
        'executor_output',
        'markup_language',
    ];

    public function getHumanDateAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    public function getPublicRouteUrlAttribute(): ?string
    {
        if (!$this->publish_hash) {
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
        if (!$this->issue_id) {
            return null;
        }

        return route('issues.show', $this->issue_id);
    }

    public function getRouteUrlAttribute(): string
    {
        return route('exceptions.show', [$this->project_id, $this]);
    }

    public function getShortExceptionTextAttribute(): string
    {
        if (!$this->exception) {
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

        $extension = (string)Arr::get($pathInfo, 'extension');

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

    public function occurences()
    {
        return $this->hasMany(self::class, 'exception', 'exception')
            ->whereRaw('id != exceptions.id and line = exceptions.line and project_id = exceptions.project_id')
            ->where('created_at', '>', now()->subMonth());
    }

    public function markAsRead()
    {
        $this->status = self::READ;
        $this->save();
    }


    public function markAs($status = self::FIXED)
    {
        $this->status = $status;
        $this->save();

        if ($status == self::FIXED) {
            Statistic::incrementStatistics('total_fixed_exceptions');
        }
    }


    public function markAsMailed()
    {
        $this->mailed = true;
        $this->save();
    }

    public function isMarkedAsMailed()
    {
        return $this->mailed;
    }

    public function makePublic()
    {
        $this->publish_hash = str_random(15);
        $this->published_at = carbon();
        $this->save();

        return $this;
    }

    public function removePublic()
    {
        $this->publish_hash = null;
        $this->published_at = null;
        $this->save();

        return $this;
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
}
