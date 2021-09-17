<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CouponRequest;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function __construct()
    {
      
        $this->middleware('permission:show_coupons', ['only' => ['index']]);
        $this->middleware('permission:create_coupon', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_coupon', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_coupon', ['only' => ['destroy']]);
        $this->middleware('permission:display_coupon', ['only' => ['show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {     
        $coupons = Coupon::query()

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

        return view('backend.coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CouponRequest $request)
    {
        Coupon::create($request->validated());  //all data return form validation

        return redirect()->route('admin.coupons.index')->with([
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
    public function show(Coupon $coupon)
    {
        return view('backend.coupons.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {

        return view('backend.coupons.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CouponRequest $request, Coupon $coupon)
    {
        $coupon->update($request->validated());

        return redirect()->route('admin.coupons.index')->with([
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
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return redirect()->route('admin.coupons.index')->with([
            'message' => 'Deleted Successfully',
            'alert-type' => 'success'
        ]);
    }


}
