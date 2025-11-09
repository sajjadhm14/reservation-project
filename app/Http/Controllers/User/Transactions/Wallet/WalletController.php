<?php

namespace App\Http\Controllers\User\Transactions\Wallet;

use App\Http\Controllers\Controller;
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



}
