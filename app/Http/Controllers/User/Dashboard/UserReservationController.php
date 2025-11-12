<?php

namespace App\Http\Controllers\User\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Dashboard\UserReservationRequest;
use App\Models\Calender;
use App\Models\Consulter;
use App\Models\Reservation;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserReservationController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $consulters = Consulter::consulterList();
        $calenders = Calender::CheckReservationStatus();
        return view('user.dashboard.pages.reservation' , compact('consulters'  , 'calenders'));
    }

    /**
     * @param UserReservationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function reservationPost(UserReservationRequest $request)
    {
        $user = Auth::guard('web')->id();
        $valid=$request->validated();


        if($this->duplicate($valid)){
            return response()->json([
                'success' => false,
                'message' => 'Surry selected time is fulled',
            ]);
        }

        $reservation =$this->createReservation($user,$valid);
        return response()->json([
            'success' => true,
            'message' => 'Your time reserved successfully',
            'data' => $reservation
        ]);

    }

    /**
     * @param $valid
     * @return bool
     */
    private function duplicate($valid):bool
    {
        return Reservation::where('consulter_id' , $valid['consulter_id'])
            ->where('calender_id' , $valid['calender_id'])
            ->where('amount' , $valid['amount'])
            ->where('date' , $valid['date'])
            ->where('start_time' , $valid['start_time'])
            ->where('end_time' , $valid['end_time'])
            ->exists();
    }

    /**
     * @param int $user
     * @param $valid
     * @return mixed
     */

    private function createReservation(int $user,$valid)
    {
        return Reservation::create([
            'user_id' => $user,
            'consulter_id' => $valid['consulter_id'],
            'calender_id'=> $valid['calender_id'],
            'date'=> $valid['date'],
            'amount'=>$valid['amount'],
            'start_time' =>$valid['start_time'],
            'end_time'  => $valid['end_time'],
        ]);
    }
}
