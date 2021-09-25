<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserAddress;
use App\Models\Country;
use App\Http\Request\Backend\CustomerAddressRequest;
use App\Http\Requests\Backend\CustomerAddressRequest as BackendCustomerAddressRequest;
use App\Models\User;

class CustomerAddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show_customer_addresses', ['only' => ['index']]);
        $this->middleware('permission:create_customer_address', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_customer_address', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_customer_address', ['only' => ['destroy']]);
        $this->middleware('permission:display_customer_address', ['only' => ['show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer_addresses = UserAddress::with('user')

        ->when(request()->keyword != null, function($q) {
            $q->search(request()->keyword);
        })
        ->when(request()->status != null, function($q) {
            $q->whereDefaultAddress(true);
        })
        ->orderBy(request()->sort_by ?? 'id', request()->order_by ?? 'desc')

        ->paginate(request()->limit_by ?? 10);

        return view('backend.customer_addresses.index', compact('customer_addresses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::whereStatus(true)->get(['id', 'name']);
        return view('backend.customer_addresses.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BackendCustomerAddressRequest $request)
    {
        UserAddress::create($request->validated());

        return redirect()->route('admin.customer_addresses.index')->with([
            'message' => 'Created successfully',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(UserAddress $customer_address)
    {
        return view('backend.customer_addresses.show', compact('customer_address'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(UserAddress $customer_address)
    {
        $countries = Country::whereStatus(true)->get(['id', 'name']);
        return view('backend.customer_addresses.edit', compact('customer_address', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BackendCustomerAddressRequest $request, UserAddress $customer_address)
    {
        $customer_address->update($request->validated());

        return redirect()->route('admin.customer_addresses.index')->with([
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserAddress $customer_address)
    {
        $customer_address->delete();

        return redirect()->route('admin.customer_addresses.index')->with([
            'message' => 'Deleted successfully',
            'alert-type' => 'success'
        ]);
    }
}
