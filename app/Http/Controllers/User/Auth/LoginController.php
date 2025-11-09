<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
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
    public function loginPost(LoginRequest $request): \Illuminate\Http\RedirectResponse
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
