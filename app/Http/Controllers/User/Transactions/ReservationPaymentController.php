<?php

namespace App\Http\Controllers\User\Transactions;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Dashboard\PayReservationRequest;
use App\Models\Reservation;
use App\Models\ReservationPayment;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function Pest\Laravel\get;

class ReservationPaymentController extends Controller
{
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $wallets = Reservation::where('user_id' ,Auth::guard('web')->id())
            ->where('status' , 'approved')
            ->get();
        return view('user.dashboard.transactions.reservation-payment' , compact('wallets'));
    }


    public function paymentPost(PayReservationRequest $request ,$id)
    {
        $user = Auth::guard('web')->user();
        $wallet = Wallet::where('user_id' , $user->id)->first();
        $reservation = Reservation::where('id' , $id)
            ->where('user_id' , $user->id)
            ->where('status' , 'approved')
            ->first();

        if($wallet == null){
            return redirect()->route('wallet.charge');
        }
        if($wallet->current_balance < $reservation->amount ){
            return redirect('user/wallet/charge')->with('your account balance is not enough');
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


        return redirect('user/dashboard')->with('Congratulations! Your reservation has been paid');
    }
}
