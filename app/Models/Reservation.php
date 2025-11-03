<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Reservation extends Model
{
    protected $fillable = [
        'consulter_id',
        'consulter_name',
        'consulter_speciality',
        'user_id',
        'calender_id',
        'date',
        'amount',
        'status',
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
    public function calender():belongsTo
    {
        return $this->belongsTo(Calender::class);
    }
    public function reservationPayment():HasOne
    {
        return $this->hasOne(ReservationPayment::class);
    }
}
