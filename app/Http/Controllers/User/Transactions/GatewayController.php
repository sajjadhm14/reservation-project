<?php

namespace App\Http\Controllers\User\Transactions;

use App\Http\Controllers\Controller;

use App\Http\Requests\User\Dashboard\PaymentRequest;
use App\Models\WalletPayment;
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
            $amount = $request->amount;
            $ref = $request->random_int(100000, 999999);


           return view('user.dashboard.transactions.payment');
   }

   public function callback(PaymentRequest $request)
   {
       $wallet = WalletPayment::get();
       if ($wallet->status !== 'success') {
           return view('user.dashboard.transactions.wallet');
       }elseif ($wallet->status == 'success') {
           $ref = $reguest->$ref;

           return view('user.dashboard.transactions.wallet');
       }

   }





}
