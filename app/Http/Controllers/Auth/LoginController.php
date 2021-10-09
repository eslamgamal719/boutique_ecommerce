<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers {
        logout as protected originalLogout;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function logout(Request $request)
    {
        $cart = collect($request->session()->get('cart'));

        /* call original logout method */
        $response = $this->originalLogout($request);

        /* repopulate session with cart */
        if(!config('cart.destroy_on_logout')) {
            $cart->each(function($row, $identifier) use ($request) {
                $request->session()->put('cart.' . $identifier, $row);
            });
        }

        /* return original response */
        return $response;
    }


    public function username()
    {
        return 'username';
    }

}
