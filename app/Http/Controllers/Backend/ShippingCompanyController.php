<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ShippingCompanyRequest;
use App\Models\Country;
use App\Models\ShippingCompany;
use Illuminate\Http\Request;

class ShippingCompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show_shipping_companies', ['only' => ['index']]);
        $this->middleware('permission:create_shipping_company', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_shipping_company', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_shipping_company', ['only' => ['destroy']]);
        $this->middleware('permission:display_shipping_company', ['only' => ['show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shipping_companies = ShippingCompany::withCount('countries')

        ->when(request()->keyword != null, function($q) {
            $q->search(request()->keyword);
        })
        ->when(request()->status != null, function($q) {
            $q->whereStatus(true);
        })
        ->orderBy(request()->sort_by ?? 'id', request()->order_by ?? 'desc')

        ->paginate(request()->limit_by ?? 10);

        return view('backend.shipping_companies.index', compact('shipping_companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::orderBy('id', 'asc')->get(['id', 'name']);
        return view('backend.shipping_companies.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShippingCompanyRequest $request)
    {   
        $shipping_company = ShippingCompany::create($request->except('countries', '_token'));
        $shipping_company->countries()->attach($request->countries);

        return redirect()->route('admin.shipping_companies.index')->with([
            'message' => 'Created successfully',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ShippingCompany $shipping_company)
    {
        $shipping_company->with('countries');
        $countries = Country::orderBy('id', 'asc')->get(['id', 'name']);
        return view('backend.shipping_companies.edit', compact('countries', 'shipping_company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ShippingCompanyRequest $request, ShippingCompany $shipping_company)
    {
        $shipping_company->update($request->except('_method', '_token', 'countries'));
        $shipping_company->countries()->sync($request->countries);

        return redirect()->route('admin.shipping_companies.index')->with([
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
    public function destroy(ShippingCompany $shipping_company)
    {
        $shipping_company->delete();

        return redirect()->route('admin.shipping_companies.index')->with([
            'message' => 'Deleted successfully',
            'alert-type' => 'success'
        ]);
    }
}
