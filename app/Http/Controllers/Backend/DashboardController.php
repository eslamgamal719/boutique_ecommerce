<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\AdminRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class DashboardController extends Controller
{
    
    public function index()
    {
        return view('backend.index');
    }

    public function account_settings()
    {
        return view('backend.account_settings');
    }

    public function update_account_settings(AdminRequest $request)
    {
        $data['first_name'] = $request->first_name;        
        $data['last_name']  = $request->last_name;
        $data['username']   = $request->username;
        $data['email']      = $request->email;
        $data['mobile']     = $request->mobile;

        if($request->password != '') {
            $data['password'] = bcrypt($request->password);
        }

        if($image = $request->user_image) {
            if(auth()->user()->user_image != null && File::exists('assets/supervisors/' . auth()->user()->user_image)) {
                unlink('assets/supervisors/' . auth()->user()->user_image);
            }
            $file_name = Str::slug($request->username) . "." . $image->getClientOriginalExtension();
            $path = public_path('assets/supervisors/' . $file_name);
            Image::make($image->getRealPath())->resize(300, null, function($constraint) {
                $constraint->aspectRatio();
            })->save($path, 100);
            $data['user_image'] = $file_name;
        }
        auth()->user()->update($data);

        return redirect()->route('admin.account.settings')->with([
            'message'    => 'Updated successfully',
            'alert-type' => 'success'
        ]);
    }

    public function remove_image(Request $request)
    {
        $admin = Admin::findOrFail($request->admin_id);
        if(File::exists("assets/supervisors/" . $admin->user_image)) {
            unlink("assets/supervisors/" . $admin->user_image);
            $admin->user_image = null;
            $admin->save();
        }
        return true;
    }
}
