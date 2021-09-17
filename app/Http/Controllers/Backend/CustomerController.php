<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CustomerRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;


class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show_customers', ['only' => ['index']]);
        $this->middleware('permission:create_customer', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_customer', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_customer', ['only' => ['destroy']]);
        $this->middleware('permission:display_customer', ['only' => ['show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {     
        $customers = User::query()

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

        return view('backend.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
        $input['first_name'] = $request->first_name;
        $input['last_name'] = $request->last_name;
        $input['username'] = $request->username;
        $input['email'] = $request->email;
        $input['mobile'] = $request->mobile;
        $input['status'] = $request->status;
        $input['password'] = bcrypt($request->password);

        if($image = $request->file('user_image')) {
            $file_name = Str::slug($request->username) . "." . $image->getClientOriginalExtension();
            $path = public_path("assets/customers/" . $file_name);
            Image::make($image->getRealPath())->resize(300, null, function($constraint) {
                $constraint->aspectRatio();
            })->save($path, 100);

            $input['user_image'] = $file_name;
        }

        $customer = User::create($input);
        $customer->markEmailAsVerified();        //email created by admin always verified

        return redirect()->route('admin.customers.index')->with([
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
    public function show(User $customer)
    {
        return view('backend.customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $customer)
    {
        return view('backend.customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, User $customer)
    {
        $input['first_name'] = $request->first_name;
        $input['last_name'] = $request->last_name;
        $input['username'] = $request->username;
        $input['email'] = $request->email;
        $input['mobile'] = $request->mobile;
        $input['status'] = $request->status;
        if(trim($request->password) != '') {
            $input['password'] = bcrypt($request->password);
        }

        if($image = $request->file('user_image')) {
            if($customer->user_image != '' && File::exists('assets/customers/' . $customer->user_image)) {
                unlink('assets/customers/' . $customer->user_image);
            }
            $file_name = Str::slug($request->username) . "." . $image->getClientOriginalExtension();
            $path = public_path("assets/customers/" . $file_name);
            Image::make($image->getRealPath())->resize(300, null, function($constraint) {
                $constraint->aspectRatio();
            })->save($path, 100);

            $input['user_image'] = $file_name;
        }

        $customer->update($input);

        return redirect()->route('admin.customers.index')->with([
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
    public function destroy(User $customer)
    {
        if(File::exists("assets/customers/" . $customer->user_image)) {
            unlink("assets/customers/" . $customer->user_image);
        }
        $customer->delete();

        return redirect()->route('admin.customers.index')->with([
            'message' => 'Deleted Successfully',
            'alert-type' => 'success'
        ]);
    }


    public function remove_image(Request $request)
    {
        $customer = User::findOrFail($request->customer_id);
        if(File::exists("assets/customers/" . $customer->user_image)) {
            unlink("assets/customers/" . $customer->user_image);
            $customer->user_image = null;
            $customer->save();
        }
        return true;
    }
}
