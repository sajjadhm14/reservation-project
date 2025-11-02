<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservationPayment extends Model
{
    protected $fillable =  [
        'reservation_id',
        'user_id',
        'status',
    ];
}
