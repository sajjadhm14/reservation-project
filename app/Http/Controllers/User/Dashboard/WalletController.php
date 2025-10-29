<?php

namespace App\Http\Controllers\User\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Dashboard\WalletRequest;
use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index()
    {
        return view('user.dashboard.pages.wallet');
    }
    public function walletCharge()
    {
        return view('user.dashboard.pages.wallet-charge');
    }
    public function walletPost(WalletRequest $request)
    {
        $request->validated();

        $wallet = Wallet::firstOrCreate(['user_id' => auth()->id()]);
        $wallet->current_balance += $request->amount;
        $wallet->save();

        return redirect('user/dashboard')->with('success', "Payment successful! \${$request->amount} has been added to your wallet.");
    }

}
