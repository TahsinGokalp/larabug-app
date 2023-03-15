<?php

namespace App\Models;

use App\Enums\ExceptionStatusEnum;
use App\Models\Concerns\HasSparklines;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Issue.
 *
 * @property string                          $id
 * @property string                          $exception
 * @property string                          $line
 * @property string                          $project_id
 * @property string                          $exception_id
 * @property string|null                     $status
 * @property mixed|null                      $tags
 * @property \Illuminate\Support\Carbon|null $last_occurred_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Exception> $exceptions
 * @property-read int|null $exceptions_count
 * @property-read mixed $last_occurred_at_human
 * @property-read mixed $sparkline
 * @property-read mixed $status_text
 * @property-read \App\Models\Project|null $project
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Issue filter(array $input = [], $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Issue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Issue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Issue paginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Issue query()
 * @method static \Illuminate\Database\Eloquent\Builder|Issue simplePaginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Issue whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Issue whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Issue whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Issue whereException($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Issue whereExceptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Issue whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Issue whereLastOccurredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Issue whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Issue whereLine($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Issue whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Issue whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Issue whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Issue whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Issue extends Model
{
    use HasUuids;
    use Filterable;
    use HasSparklines;

    protected $guarded = [
        'id',
        'updated_at',
    ];

    protected $casts = [
        'last_occurred_at' => 'datetime',
        'status' => ExceptionStatusEnum::class,
    ];

    protected $appends = [
        'last_occurred_at_human',
    ];

    public function exceptions(): HasMany
    {
        return $this->hasMany(Exception::class);
    }
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function getLastOccurredAtHumanAttribute(): string
    {
        return $this->last_occurred_at->diffForHumans();
    }

    /*


        public function unreadExceptions()
        {
            return $this->exceptions()
                ->where(function ($query) {
                    return $query
                        ->where('status', \App\Models\Exception::OPEN);
                });
        }




    */
}
