<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class CustomerController extends Controller
{
    
    public function dashboard()
    {
        return view('frontend.customer.index');
    }

    public function profile()
    {
        return view('frontend.customer.profile');
    }

    public function addresses()
    {
        return view('frontend.customer.addresses');
    }

    public function orders()
    {
        return view('frontend.customer.orders');
    }

    public function update_profile(ProfileRequest $request)
    {
        $user = auth()->user();
        $data['first_name'] = $request->first_name;
        $data['last_name'] = $request->last_name;
        $data['mobile'] = $request->mobile;
        $data['email'] = $request->email;

        if($request->password != '' && !Hash::check($request->password, $user->password)) {
            $data['password'] = bcrypt($request->password);
        }

        if($user_image = $request->file('user_image')) {
            if($user->user_image != null && File::exists('assets/customers/' . $user->user_image)) {
                unlink('assets/customers/' . $user->user_image);
            }

            $file_name = $user->username . '.' . $user_image->getClientOriginalExtension();
            $path = public_path('assets/customers/' . $file_name);
            Image::make($user_image->getRealPath())->resize(300, null, function($constraints) {
                $constraints->aspectRatio();
            })->save($path, 100);

            $data['user_image'] = $file_name;
        }
        $user->update($data);

        toast('Profile updated successfully', 'success');
        return redirect()->back();
    }


    public function remove_profile_image()
    {
        $user = auth()->user();
        if($user->user_image != null && File::exists('assets/customers/' . $user->user_image)) {
            unlink('assets/customers/' . $user->user_image);
        }
        $user->user_image = null;
        $user->save();

        toast('Profile image deleted', 'success');
        return redirect()->back();
    }






}
