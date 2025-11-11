<?php

namespace App\Http\Controllers\User\Transactions\Wallet;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Dashboard\PayReservationRequest;
use App\Models\Reservation;
use App\Models\ReservationPayment;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;

class UserReservationPaymentController extends Controller
{
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $user = Auth::guard('web')->id();

        $wallets=$this->checkUserReservation($user);

        return view('user.dashboard.wallet.reservation-payment' , compact('wallets'));
    }

    private function checkUserReservation($user)
    {
        return Reservation::where('user_id' ,$user)
            ->where('status' , 'approved')
            ->get();
    }


    public function paymentPost($id)
    {
        $user = Auth::guard('web')->id();
        $reservation = $this->getApprovedReservation($id , $user);

        $wallet=$this->failWallet($user);

        if($this->insufficientBalance($wallet ,$reservation->amount)){
            $notification = [
              'message'=> 'you dont have enough balance charge your wallet',
              'alert-type' => 'error'
            ];
            return redirect()->route('wallet.charge')->with($notification);
        }


       $this->proccessToPayment($wallet,$reservation,$user,$id);


        $notification =[
            'message'=>'Your reservation payment has been paid successfully',
            'alert-type'=>'success'
        ];

        return redirect()->route('user.dashboard')->with($notification);
    }

    private function getApprovedReservation($id , $user): void
    {
        Reservation::where('id' , $id)
            ->where('user_id' , $user->id)
            ->where('status' , 'approved')
            ->firstOrFail();
    }

    private function failWallet($user)
    {
        $wallet = Wallet::where('user_id' , $user->id)->first();

        if(!$wallet){
            $notification = [
                'message' => 'charge your wallet first',
                'alert-type' => 'error'
            ];
            return redirect()->route('wallet.charge')->with($notification);
        }
        return $user;
    }

    private function insufficientBalance($wallet , $amount)
    {

            return $wallet->current_balance < $amount;

    }

    private function proccessToPayment($wallet , $reservation , $user,$id)
    {
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
    }
}
