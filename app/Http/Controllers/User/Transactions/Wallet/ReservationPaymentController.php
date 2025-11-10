<?php

namespace App\Http\Controllers\User\Transactions\Wallet;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Dashboard\PayReservationRequest;
use App\Models\Reservation;
use App\Models\ReservationPayment;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;

class ReservationPaymentController extends Controller
{
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $wallets = Reservation::where('user_id' ,Auth::guard('web')->id())
            ->where('status' , 'approved')
            ->get();
        return view('user.dashboard.transactions.reservation-payment' , compact('wallets'));
    }


    public function paymentPost($id)
    {
        $user = Auth::guard('web')->user();
        $wallet = Wallet::where('user_id' , $user->id)->first();
        $reservation = Reservation::where('id' , $id)
            ->where('user_id' , $user->id)
            ->where('status' , 'approved')
            ->first();

        if($wallet == null){
            $notification = [
                'message' => 'charge your wallet first' ,
                'alert-type' => 'error'
            ];
            return redirect()->route('wallet.charge')->with($notification);
        }

        if($wallet->current_balance < $reservation->amount ){

            $notification =[
                'message' => 'your wallet current amount is not enough charge it first',
                'alert-type' => 'error',
            ];
            return redirect()->route('wallet.charge')->with($notification);
        }
        $wallet->current_balance -= $reservation->amount;

        $totalPaid = $user->reservations()->where('status' , 'paid')->sum('amount') + $reservation->amount;

        $remainingBalance = $wallet->current_balance - $totalPaid;

        $wallet->remaining_balance = $remainingBalance;
        $wallet->save();

        ReservationPayment::create([
           'reservation_id' => $id,
           'user_id' => $user->id,
           'status' => 'paid',
        ]);

        $reservation->status = 'paid';
        $reservation->save();

        $notification =[
            'message'=>'Your reservation payment has been paid successfully',
            'alert-type'=>'success'
        ];

        return redirect()->route('user.dashboard')->with($notification);
    }
}
