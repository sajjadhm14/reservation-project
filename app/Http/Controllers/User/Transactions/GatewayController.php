<?php

namespace App\Http\Controllers\User\Transactions;

use App\Http\Controllers\Controller;

use App\Http\Requests\User\Dashboard\PaymentRequest;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GatewayController extends Controller
{
    public function index()
    {
        return view('user.dashboard.transactions.payment');
    }
   public function paymentPost(PaymentRequest $request)
   {

            $user = auth()->user();
            $wallet = Wallet::firstOrCreate(['user_id' => $user->id]);

            $ref = random_int(100000, 999999);
            $ref_number = Str::random(6);
            $amount = $request->amount;
            $reservation_id = $request->reservation_id ?? 1;


            Payment::create([
                'user_id' => $user->id,
                'wallet_id' =>$wallet-> id ?? null ,
                'amount' => $amount,
                'ref_id' => $ref,
                'ref_number' => $ref_number,
                'description' => $request ->description,
            ]);


           $wallet->current_balance += $amount;
           $wallet->save();
           $totalPaid = $user->reservations()->sum('amount');
           $remainingBalance = $wallet->current_balance - $totalPaid;

           $wallet->remaining_balance = $remainingBalance;
           $wallet->save();

            return view('user.dashboard.transactions.callback' , compact('ref' , 'amount' ,'reservation_id' ));

   }





}
