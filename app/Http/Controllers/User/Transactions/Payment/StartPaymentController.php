<?php

namespace App\Http\Controllers\User\Transactions\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Transactions\UserPaymentRequest;
use App\Models\Wallet;
use App\Models\WalletPayment;
use Illuminate\Support\Facades\Auth;

class StartPaymentController extends Controller
{


    /**
     * @param UserPaymentRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Random\RandomException
     */
    public function paymentPost(UserPaymentRequest $request)
    {

        $valid = $request->validated();
        $user = Auth::guard('web')->id();
        $wallet= Wallet::createUserWallet($user);
        $amount = $valid['amount'];
        $ref_id = random_int(100000, 999999);
        $this->createPaymentPost($ref_id ,$amount,$wallet ,$user);

        return redirect()->route('payment.page' , ['ref_id'=>$ref_id,'amount'=>$amount  ]);
    }

    /**
     * @param $ref_id
     * @param $amount
     * @param $wallet
     * @param $user
     * @return mixed
     */
    private function createPaymentPost($ref_id ,$amount,$wallet ,$user)
    {
        return  WalletPayment::create([
            'wallet_id' => $wallet->id,
            'amount' => $amount,
            'ref_id' => $ref_id,
            'user_id' =>$user,
            'status' => 'pending',
            'ref_number' => null,
        ]);
    }

    /**
     * @param UserPaymentRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function paymentPage(UserPaymentRequest $request)
    {
        $amount = $request->amount;
        $ref_id = $request->ref_id;
        return view('user.dashboard.wallet.transactions.payment' , compact('amount','ref_id' ,));

    }







}
