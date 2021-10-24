<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\PaymentMethodRequest;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:show_payments', ['only' => ['index']]);
        $this->middleware('permission:create_payment', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_payment', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_payment', ['only' => ['destroy']]);
        $this->middleware('permission:display_payment', ['only' => ['show']]);
    }

    public function index()
    {
        $payment_methods = PaymentMethod::query()

            ->when(request()->keyword != '', function ($q){
                $q->search(request()->keyword);
            })
            ->when(request()->status != '', function ($q){
                $q->whereStatus(request()->status);
            })
            ->orderBy(request()->sort_by ?? 'id', request()->order_by ?? 'desc')->paginate(request()->limit_by ?? 10);

        return view('backend.payment_methods.index', compact('payment_methods'));
    }

    public function create()
    {
        return view('backend.payment_methods.create');
    }

    public function store(PaymentMethodRequest $request)
    {
        PaymentMethod::create($request->validated());

        return redirect()->route('admin.payment_methods.index')->with([
            'message'    => 'Created successfully',
            'alert-type' => 'success'
        ]);

    }

    public function show(PaymentMethod $payment_method)
    {
        return view('backend.payment_methods.show', compact('payment_method'));
    }

    public function edit(PaymentMethod $payment_method)
    {
        return view('backend.payment_methods.edit', compact('payment_method'));
    }

    public function update(PaymentMethodRequest $request, PaymentMethod $payment_method)
    {
        $payment_method->update($request->validated());

        return redirect()->route('admin.payment_methods.index')->with([
            'message'    => 'Updated successfully',
            'alert-type' => 'success'
        ]);
    }

    public function destroy(PaymentMethod $payment_method)
    {
        $payment_method->delete();

        return redirect()->route('admin.payment_methods.index')->with([
            'message'    => 'Deleted successfully',
            'alert-type' => 'success'
        ]);
    }
}
