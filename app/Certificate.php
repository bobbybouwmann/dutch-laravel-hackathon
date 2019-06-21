<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    protected $fillable = [
        'date_of_certification',
        'valid',
    ];

    protected $dates = [
        'date_of_certification',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
