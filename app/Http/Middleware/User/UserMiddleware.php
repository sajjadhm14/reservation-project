<?php

namespace App\Http\Middleware\User;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!Auth::guard('web')->check()){
            return redirect()->route('user.login');
        }
        $isUser = User::where( 'id' ,Auth::guard('web')->id())->exists();

        if (!$isUser) {
            // Logged in as a regular user, but trying to access a consulter page.
            // You might want to redirect them to their regular dashboard instead of a 403.
            return redirect('user.login')->with('error', 'You do not have access to the user section.');
            // or keep the abort(403) if you prefer.
        }
        return $next($request);
    }
}
