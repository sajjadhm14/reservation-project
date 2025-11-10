<?php

namespace App\Http\Controllers\User\Transactions\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Transactions\PaymentRequest;
use App\Models\Wallet;
use App\Models\WalletPayment;

class StartPaymentController extends Controller
{



    public function paymentPost(PaymentRequest $request)
    {

        $valid = $request->validated();
        $user = Auth()->user();
        Wallet::firstOrCreate(['user_id'=>$user->id]);
        $amount = $valid['amount'];
        $ref_id = random_int(100000, 999999);


        return view('user.dashboard.transactions.payment', ['ref_id' => $ref_id , 'amount' => $amount]);
    }







}
