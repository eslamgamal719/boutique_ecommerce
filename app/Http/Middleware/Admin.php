<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //if you did not make login and try to visit dashboard redirect you to login page
        if(!Auth::guard('admin')->check()) {
            return redirect(RouteServiceProvider::ADMINLOGIN);
        }
        return $next($request);
    }
}
