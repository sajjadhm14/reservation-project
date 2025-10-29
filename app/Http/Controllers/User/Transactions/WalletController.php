<?php

namespace App\Http\Controllers\User\Transactions;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Dashboard\WalletRequest;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function index()
    {
        $historys = Wallet::where('user_id' , Auth::guard('web')->id())->get();
        return view('user.dashboard.transactions.wallet' , compact('historys'));
    }
    public function walletCharge()
    {
        return view('user.dashboard.transactions.wallet-charge');
    }
    public function walletPost(WalletRequest $request): \Illuminate\Http\RedirectResponse
    {
        $user = auth()->user();

        $wallet = Wallet::firstOrCreate(['user_id' => $user->id]);

        $wallet->current_balance += $request->amount;
        $wallet->save();

        $totalPaid = $user->reservations()->sum('amount');
        $remainingBalance = $wallet->current_balance - $totalPaid;

         $wallet->remaining_balance = $remainingBalance;
         $wallet->save();

        return redirect('user/dashboard')->with([
            'success' => "Transaction successful! \${$request->amount} has been added to your wallet.",
            'remaining_balance' => $remainingBalance,
        ]);
    }


}
