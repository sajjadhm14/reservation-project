<?php

namespace App\Http\Controllers\User\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Dashboard\UserSubmitRequest;
use App\Models\Reservation;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserSubmitReservationController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $user =Auth::guard('web')->id();
        $submits = Reservation::getUserReservations($user);
        return view ('user.dashboard.pages.submit', compact('submits'));
    }

    /**
     * @param UserSubmitRequest $request
     * @param Reservation $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function submitPost(UserSubmitRequest $request ,Reservation $id): \Illuminate\Http\JsonResponse
    {
        $valid = $request->validated();

        $status = $valid['status'] ?? 'pending';

        if($status === 'Cancelled') {

            $this->cancel($id);

            return response()->json([
                'status' => 200,
            ]);
        }

       $this->update($id,$status);

        return response()->json([
            'status' => 200
        ]);
    }

    /**
     * @param Reservation $id
     * @return void
     */
    private function cancel(Reservation $id)
    {
        $calender = $id->calender;
        $id->delete();

        if($calender) {
            $calender ->update(['status'=>'pending']);
        }
    }

    /**
     * @param Reservation $id
     * @param string $status
     * @return void
     */
    private function update(Reservation $id , string $status)
    {
        $id->update(['status'=>$status]);

        if($id->calender()) {
            $id->calender()->update(['status'=>$status]);
        }

    }
}
