<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFcmToken extends Model
{
    use HasFactory;

    public $casts = [
        'token' => 'encrypted',
        'device' => 'array',
    ];

    public $fillable = [
        'token',
        'device',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
