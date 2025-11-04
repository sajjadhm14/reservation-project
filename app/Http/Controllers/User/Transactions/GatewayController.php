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
            $user = Auth()->user();
            $wallet = Wallet::firstOrCreate(['user_id'=>$user->id]);
            $amount = $request->amount;
            $ref_id = Str::uuid()->toString();


            WalletPayment::create([
               'wallet_id' => $wallet->id,
               'amount' => $amount,
               'ref_id' => $ref_id,
               'user_id' =>$user->id,
               'status' => 'pending',
               'ref_number' => null,
            ]);




           return view('user.dashboard.transactions.payment' , [
               'amount' => $amount,
               'ref_id' => $ref_id,
           ]);
   }

   public function callback(PaymentRequest $request)
   {
          $status = $request ->query('status');
          $ref_id = $request ->query('ref_id');
          $payment = WalletPayment::where('ref_id' ,$ref_id)->first();

          if(!$payment){
              $notification =[
                  'message' => 'Your Payment Failed',
                  'alert-type' => 'error',
              ];
              return redirect()->route('wallet')->with($notification);
          }

           if($status === 'cancelled'){
               $payment ->update([
                   'status' => 'cancelled'
               ]);
               $notification = [
                   'message' => 'Your Payment cancelled successfully',
                   'alert-type' => 'error',
               ];

               return redirect()->route('wallet')->with($notification);
           }


           $ref_number = Str::random(6);
           $payment ->update([
               'status' => 'success',
               'ref_number' => $ref_number,
           ]);

           $wallet = Wallet::find($payment->wallet_id);
           $wallet->increment('current_balance', $payment->amount);
           $notification =[
               'message' => 'Your Payment done successfully',
               'alert-type' => 'success',
           ];
           return view('user.dashboard.transactions.callback' , $notification);

   }





}
