<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Forge extends Model
{
    protected $fillable = [
        'api_token',
        'servers',
        'sites',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
