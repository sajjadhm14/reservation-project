<?php

namespace App\Http\Controllers\Consulter\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Consulter\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsulterLoginController extends Controller
{
    public function index()
    {
        if(Auth::guard('consulter')->check()){

            return redirect()->route('consulter.dashboard');
        }

        return view('consulter.auth.consulter-login');
    }

    public function loginPost(LoginRequest $request)
    {

        $request->authenticate();

        $request->session()->regenerate();

        $notification = [
            'message' => 'Consulter login successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('consulter.dashboard')->with($notification);
    }
}
