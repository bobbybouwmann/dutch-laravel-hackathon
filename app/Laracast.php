<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Laracast extends Model
{
    protected $fillable = [
        'username',
        'experience',
        'lessons',
        'best_replies',
        'badge_beginner',
        'badge_intermediate',
        'badge_advanced',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
