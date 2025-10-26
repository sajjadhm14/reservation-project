<?php

namespace App\Http\Controllers\Consulter\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsulterDashboardController extends Controller
{
    public function index()
    {

        return view('consulter.dashboard.pages.profile');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('consulter/auth/login');
    }
}
