<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Laracast extends Model
{
    protected $fillable = [
        'experience',
        'lessons',
        'best_replies',
        'badge_beginner',
        'badge_intermediate',
        'badge_advanced',
    ];

    protected $dates = ['date_of_certification'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
