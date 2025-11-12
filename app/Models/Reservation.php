<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

class Reservation extends Model
{
    /**
     * @var string[]
     */
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

    /**
     * @return mixed
     */
    public static function getUserPaidReservations ()
    {
        return Reservation::where('consulter_id', Auth::guard('consulter')->id())
            ->where('status', 'paid')
            ->with('user')
            ->latest()
            ->get();
    }
    /**
     * @param $user
     * @return mixed
     */
    public static function getUserReservationStatus($user)
    {
        return Reservation::where('user_id' ,$user)
            ->where('status' , 'Approved')
            ->get();
    }

    /**
     * @param $user
     * @return mixed
     */
    public static function getUserPaymentStatus($user)
    {
        return Reservation::where('user_id' ,$user->id)
            ->where('status' , 'Approved')
            ->first();
    }

    /**
     * @param $user
     * @return mixed
     */
    public static function getUserReservations($user)
    {
        return Reservation::where('user_id',$user)->get();
    }

    /**
     * @return BelongsTo
     */
    public function user():belongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function consulter():belongsTo
    {
        return $this->belongsTo(Consulter::class);
    }

    /**
     * @return BelongsTo
     */
    public function calender():belongsTo
    {
        return $this->belongsTo(Calender::class);
    }

    /**
     * @return HasOne
     */
    public function reservationPayment():HasOne
    {
        return $this->hasOne(ReservationPayment::class);
    }
}
