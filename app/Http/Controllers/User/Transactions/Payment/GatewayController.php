<?php

namespace App\Http\Controllers\User\Transactions\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Transactions\UserCallbackRequest;
use App\Models\Wallet;
use App\Models\WalletPayment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;

class GatewayController extends Controller
{

    /**
     * @param UserCallbackRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function callbackPost(UserCallbackRequest $request)
    {

        $data = $request->validated();
        $ref_id = $data['ref_id'];
        $payment = WalletPayment::getPaymentRefId($data['ref_id']);
        $status = $data['status'];

        if (!$payment) {
            $notification = [
                'message' => 'Payment not found or already processed.',
                'alert-type' => 'error',
            ];
            return redirect()->route('wallet')->with($notification);
        }


        if($status == 'failed'){
            $this->failedStatus($payment);
            $notification =[
                'message' => 'Your Payment Failed',
                'alert-type' => 'error',
            ];
            return redirect()->route('wallet')->with($notification);
        }


        if($status === 'cancelled'){
            $this->CanceledStatus($payment);
            $notification = [
                'message' => 'Your Payment cancelled successfully',
                'alert-type' => 'error',
            ];
            return redirect()->route('wallet')->with($notification);
        }

        $this->successStatus($payment);

        $notification =[
            'message' => 'Your Payment done successfully',
            'alert-type' => 'success',
        ];


        return redirect()->route('gateway.callback' , ['ref_id' => $ref_id])->with($notification);

    }

    /**
     * @param $payment
     * @return mixed
     */
    private function failedStatus($payment)
    {
        return $payment->update(['status' => 'failed']);
    }

    /**
     * @param $payment
     * @return mixed
     */
    private function CanceledStatus($payment)
    {
        return $payment->update(['status' => 'cancelled']);
    }

    /**
     * @param $payment
     * @return void
     */
    private function successStatus($payment)
    {

        $ref_number = Str::random(6);
        $payment ->update([
            'status' => 'success',
            'ref_number' => $ref_number,
        ]);
        $wallet = Wallet::find($payment->wallet_id);
        $wallet->increment('current_balance', $payment->amount);
    }
    /**
     * Display mock callback page (for simulated gateway interaction)
     */
    public function callback()
    {
        return view('user.dashboard.wallet.transactions.callback');
    }
}
