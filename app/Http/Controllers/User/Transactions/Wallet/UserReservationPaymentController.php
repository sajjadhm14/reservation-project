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
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $user = Auth::guard('web')->id();

        $wallets=Reservation::getUserReservationStatus($user);

        return view('user.dashboard.wallet.reservation-payment' , compact('wallets'));
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function paymentPost($id)
    {
        $user = Auth::guard('web')->user();
        $reservation = Reservation::getUserPaymentStatus($user);


        $wallet = Wallet::GetUserWallet($user->id);
        if (!$wallet){
            $notification =[
              'message' => 'charge your account first',
              'alert-type' => 'warning',
            ];

            return redirect()->route('wallet.charge')->with($notification);
        }


        if($this->insufficientBalance($wallet  ,$reservation->amount)){

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


    /**
     * @param $wallet
     * @param $amount
     * @return bool
     */

    private function insufficientBalance($wallet , $amount)
    {
        return $wallet->current_balance < $amount;
    }

    /**
     * @param $wallet
     * @param $reservation
     * @param $user
     * @param $id
     * @return void
     */
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
