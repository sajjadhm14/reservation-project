<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

class Calender extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'consulter_id',
        'status',
        'date',
        'amount',
        'start_time',
        'end_time',
    ];

    /**
     * @return BelongsTo
     */
    public function consulter() :belongsTo
    {
        return $this->belongsTo(Consulter::class);
    }

    /**
     * @return HasOne
     */
    public function reservation():HasOne
    {
        return $this->hasOne(Reservation::class);
    }

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public static function checkCalenderConflict($id , $data)
    {
        return Calender::where('consulter_id' , $id)
            ->where('date', $data['date'])
            ->where(function ($query) use ($data) {
                $query->whereBetween('start_time', [$data['start_time'], $data['end_time']])
                    ->orWhereBetween('end_time', [$data['start_time'], $data['end_time']])
                    ->orWhere(function ($q) use ($data) {
                        $q->where('start_time', '<=', $data['start_time'])
                            ->where('end_time', '>=', $data['end_time']);
                    });
            })
            ->exists();
    }

    /**
     * @return mixed
     */
    public static function getCalenderData()
    {
        return Calender::where('consulter_id' , Auth::guard('consulter')->id())->get();
    }

    /**
     * @return mixed
     */

    public static function CheckReservationStatus()
    {
        return Calender::where('status','pending')->get();
    }

}
