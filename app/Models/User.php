<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\User.
 *
 * @property mixed plan
 * @property string api_token
 * @property mixed is_admin
 * @property bool plan_notified
 * @property int                             $id
 * @property string|null                     $name
 * @property string                          $email
 * @property string                          $password
 * @property string|null                     $api_token
 * @property int                             $first_setup
 * @property bool                            $receive_email
 * @property string|null                     $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int                             $total_logins
 * @property string|null                     $last_mobile_login_at
 * @property array|null                      $settings
 * @property array|null                      $abilities
 * @property string|null                     $email_verified_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserFcmToken> $fcmTokens
 * @property-read int|null $fcm_tokens_count
 * @property-read mixed $first_name
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectGroup> $projectGroups
 * @property-read int|null $project_groups_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Project> $projects
 * @property-read int|null $projects_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User wantsEmail()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAbilities($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereApiToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstSetup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastMobileLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereReceiveEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSettings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTotalLogins($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserFcmToken> $fcmTokens
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectGroup> $projectGroups
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Project> $projects
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserFcmToken> $fcmTokens
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectGroup> $projectGroups
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Project> $projects
 * @mixin \Eloquent
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use HasFactory;

    protected $fillable = [
        'abilities',
        'name',
        'email',
        'password',
        'receive_email',
        'newsletter',
        'locale',
        'settings',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'google2fa_secret',
    ];

    protected $casts = [
        'settings'             => 'array',
        'is_admin'             => 'boolean',
        'newsletter'           => 'boolean',
        'receive_email'        => 'boolean',
        'plan_notified'        => 'boolean',
        'projects.pivot.owner' => 'boolean',
        'abilities'            => 'array',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'plan_expires_at',
    ];

    protected $appends = [
        'first_name',
        'settings',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function getGravatar($size = 150)
    {
        return 'https://www.gravatar.com/avatar/'.md5(strtolower(trim($this->attributes['email']))).'?s='.(int) $size;
    }

    public function getSettingsAttribute($value)
    {
        if (!$value) {
            return [
                'code_preview' => [
                    'rainbow' => false,
                ],
            ];
        }

        if (is_array($value)) {
            return $value;
        }

        return json_decode($value, true);
    }

    public function getFirstNameAttribute()
    {
        return array_first(explode(' ', $this->name), null, $this->name);
    }

    public function markAsExpired()
    {
        $this->plan_notified = true;
        $this->plan_expires_at = null;
        $this->plan_id = 1;

        $this->save();
    }

    public function generateNewToken()
    {
        $this->api_token = str_random(25);
        $this->save();
    }

    public function scopeWantsEmail($query)
    {
        return $query->where('receive_email', true);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class)->withPivot('owner');
    }

    public function projectGroups()
    {
        return $this->hasMany(ProjectGroup::class);
    }

    public function fcmTokens()
    {
        return $this->hasMany(UserFcmToken::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->api_token = str_random(50);
        });

        static::deleting(function (self $user) {
            foreach ($user->projects as $project) {
                $project->exceptions()->delete();

                $project->users()->detach($user->id);

                $project->delete();
            }
        });
    }

    public function hasAbility($key)
    {
        return isset($this->abilities[$key]) && $this->abilities[$key];
    }
}
