<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReservationPayment extends Model
{
    /**
     * @var string[]
     */
    protected $fillable =  [
        'reservation_id',
        'user_id',
        'status',
    ];

    /**
     * @return BelongsTo
     */
    public function reservation():BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }

    /**
     * @return BelongsTo
     */
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
