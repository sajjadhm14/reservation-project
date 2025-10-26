<?php

namespace App\Http\Middleware\Consulter;

use App\Models\Consulter;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ConsulterMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If user is not authenticated AT ALL (i.e., not logged in),
        // send them to the Consulters-specific login page.
        if (!Auth::guard('consulter')->check()) {
            // Change the redirect target to your new consulter login route
            return redirect()->route('consulter.login')->with('error', 'You must be logged in as a consulter.');
        }


        // After they log in, proceed with the authorization check
        $isConsulter = Consulter::where( 'id' ,Auth::guard('consulter')->id())->exists();

        if (!$isConsulter) {
            // Logged in as a regular user, but trying to access a consulter page.
            // You might want to redirect them to their regular dashboard instead of a 403.
            return redirect('consulter.login')->with('error', 'You do not have access to the consulter section.');
            // or keep the abort(403) if you prefer.
        }
        return $next($request);
    }
}
