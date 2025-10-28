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

        if (Auth::guard('consulter')->attempt($request->only('email', 'password'))) {
            return redirect()->route('consulter.dashboard');
        }

        return redirect()->route('consulter.login');
    }
}
