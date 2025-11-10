<?php

namespace App\Http\Controllers\User\Transactions\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Transactions\CallbackRequest;
use App\Models\Wallet;
use App\Models\WalletPayment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;

class GatewayController extends Controller
{
    /**
     * Display mock callback page (for simulated gateway interaction)
     */
    public function callback()
    {
        return view('user.dashboard.transactions.callback');
    }

    /**
     * Handle mock payment gateway callback POST request.
     */
    public function callbackPost(CallbackRequest $request)
    {
        $data = $request->validated();
        $refId = $data['ref_id'];
        $status = $data['status'];

        $payment = WalletPayment::where('ref_id', $refId)->lockForUpdate()->first();

        if (! $payment) {
            Log::warning('Payment not found or already processed', ['ref_id' => $refId]);
            return redirect()->route('wallet')->with([
                'message' => 'Payment not found or already processed.',
                'alert-type' => 'error',
            ]);
        }

        // Prevent duplicate processing
        if (in_array($payment->status, ['success', 'failed', 'cancelled'])) {
            return redirect()->route('wallet')->with([
                'message' => 'This payment has already been processed.',
                'alert-type' => 'info',
            ]);
        }

        DB::beginTransaction();
        try {
            if ($status === 'failed') {
                $payment->update(['status' => 'failed']);
                DB::commit();
                return redirect()->route('wallet')->with([
                    'message' => 'Your payment failed.',
                    'alert-type' => 'error',
                ]);
            }

            if ($status === 'cancelled') {
                $payment->update(['status' => 'cancelled']);
                DB::commit();

                return redirect()->route('wallet')->with([
                    'message' => 'Your payment was cancelled successfully.',
                    'alert-type' => 'error',
                ]);
            }

            // Payment success flow
            $refNumber = Str::upper(Str::random(6));
            $payment->update([
                'status' => 'success',
                'ref_number' => $refNumber,
            ]);

            $wallet = Wallet::find($payment->wallet_id);
            if ($wallet) {
                $wallet->increment('current_balance', $payment->amount);
            }

            DB::commit();

            return redirect()->route('payment.callback', ['ref_id' => $refId])->with([
                'message' => 'Your payment was successful.',
                'alert-type' => 'success',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment callback error', [
                'ref_id' => $refId,
                'exception' => $e->getMessage(),
            ]);

            return redirect()->route('wallet')->with([
                'message' => 'Internal error while processing payment.',
                'alert-type' => 'error',
            ]);
        }
    }
}
