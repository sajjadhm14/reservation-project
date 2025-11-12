<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Auth\UserLoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserLoginController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {

        if(Auth::guard('web')->check()){
            return redirect()->route('user.dashboard');
        }
        return view('user.auth.login');
    }

    /**
     * @throws ValidationException
     */
    public function loginPost(UserLoginRequest $request): \Illuminate\Http\RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $notification = [
            'message' => 'User login successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('user.dashboard')->with($notification);
    }
}
