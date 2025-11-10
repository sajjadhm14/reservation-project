<?php

namespace App\Http\Controllers\User\Transactions\Wallet;

use App\Http\Controllers\Controller;
use App\Models\ReservationPayment;
use App\Models\Wallet;
use App\Models\WalletPayment;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function index()
    {

        $historys = WalletPayment::where('user_id' , Auth::guard('web')->id())
        ->orderby('created_at' , 'desc')
        ->take(5)
        ->get();
        return view('user.dashboard.transactions.wallet' , compact('historys' ));
    }
    public function walletCharge()
    {
        return view('user.dashboard.transactions.wallet-charge');
    }



}
