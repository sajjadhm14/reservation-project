<?php

namespace App\Http\Controllers\Consulter\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Consulter\Auth\ConsulterRegisterRequest;
use App\Models\Consulter;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ConsulterRegisterController extends Controller
{
    /**
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('consulter.auth.consulter-register');
    }

    /**
     * this method for validating consulter register form
     *
     * @param ConsulterRegisterRequest $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */

    public function registerPost(ConsulterRegisterRequest $request): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
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

        return redirect()->route('consulter.login');
    }
}
