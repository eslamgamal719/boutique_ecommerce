<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;

class AdminGuest
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
        //can not visit login page if you made login (login for guests only)
        if(auth()->guard('admin')->check()) {
            return redirect(RouteServiceProvider::ADMINGUEST);
        }
        return $next($request);
    }
}
