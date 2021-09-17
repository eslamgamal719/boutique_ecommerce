<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\SupervisorRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Spatie\Permission\Models\Role;

class SupervisorController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show_supervisors', ['only' => ['index']]);
        $this->middleware('permission:create_supervisor', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_supervisor', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_supervisor', ['only' => ['destroy']]);
        $this->middleware('permission:display_supervisor', ['only' => ['show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {     
        $supervisors = Admin::query()

        //keyword
        ->when(request()->keyword != null, function($query) {
            $query->search(request()->keyword);
        })

        //status
        ->when(request()->status != null, function($query) {
            $query->whereStatus(request()->status);
        })
        
        //sort_by, order_by
        ->orderBy(request()->sort_by ?? 'id', request()->order_by ?? 'desc')
        
        //limit_by
        ->paginate(request()->limit_by ?? 10);

        return view('backend.supervisors.index', compact('supervisors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::select('name')->get();
        return view('backend.supervisors.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupervisorRequest $request)
    {
        $input['first_name'] = $request->first_name;
        $input['last_name']  = $request->last_name;
        $input['username']   = $request->username;
        $input['email']      = $request->email;
        $input['mobile']     = $request->mobile;
        $input['status']     = $request->status;
        $input['role_name']  = $request->role_name;
        $input['password']   = bcrypt($request->password);

        if($image = $request->file('user_image')) {
            $file_name = Str::slug($request->username) . "." . $image->getClientOriginalExtension();
            $path = public_path("assets/supervisors/" . $file_name);
            Image::make($image->getRealPath())->resize(300, null, function($constraint) {
                $constraint->aspectRatio();
            })->save($path, 100);

            $input['user_image'] = $file_name;
        }

        $supervisor = Admin::create($input);
        $supervisor->assignRole($request->role_name);

        return redirect()->route('admin.supervisors.index')->with([
            'message' => 'Created Successfully',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $supervisor)
    {
        return view('backend.supervisors.show', compact('supervisor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $supervisor)
    {
        $roles = Role::select('name')->get();
        return view('backend.supervisors.edit', compact('supervisor', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SupervisorRequest $request, Admin $supervisor)
    {
        $input['first_name'] = $request->first_name;
        $input['last_name']  = $request->last_name;
        $input['username']   = $request->username;
        $input['email']      = $request->email;
        $input['mobile']     = $request->mobile;
        $input['status']     = $request->status;
        $input['role_name']  = $request->role_name;
        if(trim($request->password) != '') {
            $input['password'] = bcrypt($request->password);
        }

        if($image = $request->file('user_image')) {
            if($supervisor->user_image != '' && File::exists('assets/supervisors/' . $supervisor->user_image)) {
                unlink('assets/supervisors/' . $supervisor->user_image);
            }
            $file_name = Str::slug($request->username) . "." . $image->getClientOriginalExtension();
            $path = public_path("assets/supervisors/" . $file_name);
            Image::make($image->getRealPath())->resize(300, null, function($constraint) {
                $constraint->aspectRatio();
            })->save($path, 100);

            $input['user_image'] = $file_name;
        }

        $supervisor->update($input);
        
        DB::table('model_has_roles')->where('model_id', $supervisor->id)->delete();
        $supervisor->assignRole($request->role_name);

        return redirect()->route('admin.supervisors.index')->with([
            'message' => 'Updated Successfully',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $supervisor)
    {
        if(File::exists("assets/supervisors/" . $supervisor->user_image)) {
            unlink("assets/supervisors/" . $supervisor->user_image);
        }
        $supervisor->delete();

        return redirect()->route('admin.supervisors.index')->with([
            'message' => 'Deleted Successfully',
            'alert-type' => 'success'
        ]);
    }


    public function remove_image(Request $request)
    {
        $supervisor = Admin::findOrFail($request->supervisor_id);
        if(File::exists("assets/supervisors/" . $supervisor->user_image)) {
            unlink("assets/supervisors/" . $supervisor->user_image);
            $supervisor->user_image = null;
            $supervisor->save();
        }
        return true;
    }
}
