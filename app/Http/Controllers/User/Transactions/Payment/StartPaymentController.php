<?php

namespace App\Http\Controllers\User\Transactions\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Dashboard\PaymentRequest;
use App\Models\Wallet;
use App\Models\WalletPayment;
use Illuminate\Support\Str;

class StartPaymentController extends Controller
{

    public function index(PaymentRequest $request)
    {

        $amount = $request->amount;
        $ref_id = $request->ref_id;


        return view('user.dashboard.transactions.payment' , compact('amount' , 'ref_id'));
    }

    public function paymentPost(PaymentRequest $request)
    {

        $valid = $request->validated();
        $user = Auth()->user();
        $wallet = Wallet::firstOrCreate(['user_id'=>$user->id]);
        $amount = $valid['amount'];
        $ref_id = random_int(100000, 999999);

        WalletPayment::create([
            'wallet_id' => $wallet->id,
            'amount' => $amount,
            'ref_id' => $ref_id,
            'user_id' =>$user->id,
            'status' => 'pending',
            'ref_number' => null,
        ]);


        return redirect()->route('start.payment', ['ref_id' => $ref_id , 'amount' => $amount]);
    }



}
