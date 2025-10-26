<?php

namespace App\Http\Controllers\Consulter\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Auth\RegisterReguest;
use App\Models\Consulter;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ConsulterRegisterController extends Controller
{
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('consulter.auth.consulter-register');
    }

    public function registerPost(RegisterReguest $request)
    {
        $data=$request->validated();

        $consulter = Consulter::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'specialty' => $data['specialty'],
        ]);

        event(new Registered($consulter));
        Auth::login($consulter);

        return redirect(route('consulter.login', absolute: false));
    }
}
