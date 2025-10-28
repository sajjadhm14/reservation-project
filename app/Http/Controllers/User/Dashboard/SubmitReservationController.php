<?php

namespace App\Http\Controllers\User\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Dashboard\SubmitRequest;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmitReservationController extends Controller
{
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $submits = Reservation::where('user_id' , Auth::guard('web')->id())->get();
        return view ('user.dashboard.pages.submit', compact('submits'));
    }

    public function submitPost(SubmitRequest $request , $id): \Illuminate\Http\JsonResponse
    {
        $submit = Reservation::findOrFail($id);
        $status = $request->input("status" , 'pending');

        // If status is Cancelled, delete the reservation instead of updating status
        if($status === 'Cancelled') {

            $calender=$submit->calender;

            $submit->delete();

            if($calender) {
                $calender->status  = 'pending';
                $calender->save();
            }


            return response()->json([
                'status' => 200,
                'message' => 'Reservation cancelled and time slot is now available!'
            ]);
        }



        $submit->status = $status;
        $submit->save();

        if($submit->calender) {
            $submit -> calender->status=$status;
            $submit -> calender->save();
        }

        return response()->json([
            'status' => 200
        ]);
    }
}
