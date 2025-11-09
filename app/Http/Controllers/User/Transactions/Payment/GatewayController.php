<?php

namespace App\Http\Controllers\User\Transactions\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Dashboard\CallbackRequest;
use App\Http\Requests\User\Dashboard\PaymentRequest;
use App\Models\Wallet;
use App\Models\WalletPayment;
use Illuminate\Support\Str;

class GatewayController extends Controller
{

   public function callback()
   {
       return view('user.dashboard.transactions.callback');
   }

   public function callbackPost(CallbackRequest $request)
   {

       $valid = $request->validated();
       $ref_id = $valid['ref_id'];
       $status = $valid['status'];
       $payment = WalletPayment::where('ref_id' ,$valid['ref_id'])->firstOrFail();

       if (!$payment) {
           $notification = [
               'message' => 'Payment not found or already processed.',
               'alert-type' => 'error',
           ];
           return redirect()->route('wallet')->with($notification);
       }

       if($status == 'failed'){
           $payment ->update([
               'status' => 'failed'
           ]);
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

       dd($payment);

       return redirect()->route('payment.callback' , ['ref_id' => $ref_id])->with($notification);

   }





}
