<?php

namespace App\Http\Controllers\Consulter\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Consulter\Auth\ConsulterLoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsulterLoginController extends Controller
{
    /**
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        if(Auth::guard('consulter')->check()){

            return redirect()->route('consulter.dashboard');
        }

        return view('consulter.auth.consulter-login');
    }

    /**
     * this method for validating consulter login data
     *
     * @param ConsulterLoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */

    public function loginPost(ConsulterLoginRequest $request)
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
