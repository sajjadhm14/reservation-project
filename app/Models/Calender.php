<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Calender extends Model
{
    protected $fillable = [
        'consulter_id',
        'status',
        'date',
        'amount',
        'start_time',
        'end_time',
    ];

    public function consulter() :belongsTo
    {
        return $this->belongsTo(Consulter::class);
    }

    public function reservation():HasOne
    {
        return $this->hasOne(Reservation::class);
    }

}
