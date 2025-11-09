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
        $calenders = Calender::where('status', 'pending')->get();
        return view('user.dashboard.pages.reservation' , compact('consulters'  , 'calenders'));
    }

    public function reservationPost(ReservationRequest $request)
    {
        $user = Auth::id();
        $valid=$request->validated();

        $exists = Reservation::where('consulter_id' , $valid['consulter_id'])
                               ->where('calender_id' , $valid['calender_id'])
                               ->where('amount' , $valid['amount'])
                               ->where('date' , $valid['date'])
                               ->where('start_time' , $valid['start_time'])
                               ->where('end_time' , $valid['end_time'])
                               ->exists();
        if($exists){
            return response()->json([
                'success' => false,
                'message' => 'Surry selected time is fulled',
            ]);
        }

        $reservation = Reservation::create([
           'user_id' => $user,
           'consulter_id' => $valid['consulter_id'],
            'calender_id'=> $valid['calender_id'],
            'date'=> $valid['date'],
            'amount'=>$valid['amount'],
            'start_time' =>$valid['start_time'],
            'end_time'  => $valid['end_time'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Your time reserved successfully',
            'data' => $reservation
        ]);

    }
}
