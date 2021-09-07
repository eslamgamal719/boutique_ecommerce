<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    
    public function login()
    {
        return view('backend.login');
    }

    public function auth_login(Request $request)
    {
        $remember = $request->has('remember') ? true : false;

        if(auth('admin')->attempt(['username' => $request->username, 'password' => $request->password], $remember)) {

            return redirect()->route('admin.index');

        }else {

            return redirect()->back()->with(['error' => 'There are an error. Please try to login again.']);

        }
    }

    public function logout()
    {
        auth('admin')->logout();
        return redirect()->route('admin.login');
    }

    public function forgot_password()
    {
        return view('backend.forgot-password');
    }
}
