<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasUuids;
    use Filterable;
    use Notifiable;

    protected $fillable = [
        'url',
        'title',
        'description',
        'notifications_enabled',
        'receive_email',
        'telegram_notification_enabled',
    ];

    protected $casts = [
        'receive_email'                       => 'boolean',
        'notifications_enabled'               => 'boolean',
        'telegram_notification_enabled'       => 'boolean',
        'last_error_at'                       => 'datetime',
    ];

    protected $appends = [
        'route_url',
        'feedback_script_html',
    ];

    public function getRouteUrlAttribute(): string
    {
        return route('projects.show', $this);
    }

    public function getFeedbackScriptUrl(): string
    {
        return route('feedback.script', ['project' => $this->id]);
    }

    public function getFeedbackScriptHtmlAttribute(): string
    {
        return '<script src="'.$this->getFeedbackScriptUrl().'"></script>';
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
                    ->where('status', Exception::OPEN);
            });
    }

    public function feedback(): HasManyThrough
    {
        return $this->hasManyThrough(Feedback::class, Exception::class);
    }

    public function scopeFilter($query, array $filters): void
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', '%'.$search.'%');
            });
        });
    }

    public static function boot(): void
    {
        parent::boot();

        static::creating(static function (self $project) {
            $project->key = Str::random(50);
        });

        static::deleting(static function (self $project) {
            $project->exceptions()->delete();
            $project->issues()->delete();
            $project->feedback()->delete();
        });
    }
}
