<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Package extends Model
{
    protected $fillable = [
        'number_of_packages',
        'github_stars',
        'favers',
        'package_dependents',
        'downloads_total',
        'downloads_monthly',
        'downloads_daily',
    ];

    protected $dates = ['date_of_certification'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
