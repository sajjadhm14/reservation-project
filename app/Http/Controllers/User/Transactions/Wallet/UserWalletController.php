<?php

namespace App\Http\Controllers\User\Transactions\Wallet;

use App\Http\Controllers\Controller;
use App\Models\ReservationPayment;
use App\Models\Wallet;
use App\Models\WalletPayment;
use Illuminate\Support\Facades\Auth;

class UserWalletController extends Controller
{
    /**
     * this method for indexing user wallet
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {

        $historys = WalletPayment::getUserWallet();
        return view('user.dashboard.wallet.wallet' , compact('historys' ));
    }

    /**
     * this method for showing wallet charge page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function walletCharge()
    {
        return view('user.dashboard.wallet.transactions.wallet-charge');
    }



}
