<?php

namespace App\Http\Controllers\User\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Reservation::where('status' , 'approved')->get();
        return view('user.dashboard.pages.payment', compact('payments'));
    }
}
