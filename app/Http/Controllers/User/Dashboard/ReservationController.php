<?php

namespace App\Http\Controllers\User\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Dashboard\ReservationRequest;
use App\Models\Calender;
use App\Models\Consulter;
use App\Models\Reservation;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index()
    {
        $consulters = Consulter::all();
        $calenders = Calender::all();
        return view('user.dashboard.pages.reservation' , compact('consulters' , 'calenders'));
    }

    public function reservationPost(ReservationRequest $request)
    {
        $user = Auth::id();
        $request->validated();

        $exists = Reservation::where('consulter_id' , $request->consulter_id)
                               ->where('date' , $request->date)
                               ->where('start_time' , $request->start_time)
                               ->where('end_time' , $request->end_time)
                               ->exists();
        if($exists){
            return response()->json([
                'success' => false,
                'message' => 'Surry selected time is fulled',
            ]);
        }

        $reservation = Reservation::create([
           'user_id' => $user,
           'consulter_id' => $request->consulter_id,
            'date'=> $request->date,
            'start_time' =>$request->start_time,
            'end_time'  => $request->end_time,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Your time reserved successfully',
            'data' => $reservation
        ]);

    }
}
