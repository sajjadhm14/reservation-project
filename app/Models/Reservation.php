<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    protected $fillable = [
        'consulter_id',
        'consulter_name',
        'consulter_speciality',
        'user_id',
        'date',
        'start_time',
        'end_time',
    ];

    public function user():belongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function consulter():belongsTo
    {
        return $this->belongsTo(Consulter::class);
    }
}
