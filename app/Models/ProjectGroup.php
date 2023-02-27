<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kblais\Uuid\Uuid;

class ProjectGroup extends Model
{
    use Uuid;

    protected $fillable = [
        'title',
        'description',
    ];

    public function projects()
    {
        return $this->hasMany(Project::class, 'group_id');
    }
}
