<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Calender extends Model
{
    protected $fillable = [
        'consulter_id',
        'date',
        'start_time',
        'end_time',
    ];

    public function consulter() :belongsTo
    {
        return $this->belongsTo(Consulter::class);
    }
}
