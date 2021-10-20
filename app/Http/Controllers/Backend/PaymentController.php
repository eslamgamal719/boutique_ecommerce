<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\PaymentRequest;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
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
        $payment_methods = Payment::query()

            ->when(request()->keyword != '', function ($q){
                $q->search(request()->keyword);
            })
            ->when(request()->status != '', function ($q){
                $q->whereStatus(request()->status);
            })
            ->orderBy(request()->sort_by ?? 'id', request()->order_by ?? 'desc')->paginate(request()->limit_by ?? 10);

        return view('backend.payments.index', compact('payment_methods'));
    }

    public function create()
    {
        return view('backend.payments.create');
    }

    public function store(PaymentRequest $request)
    {
        Payment::create($request->validated());

        return redirect()->route('admin.payments.index')->with([
            'message'    => 'Created successfully',
            'alert-type' => 'success'
        ]);

    }

    public function show(Payment $payment_method)
    {
        return view('backend.payments.show', compact('payment_method'));
    }

    public function edit(Payment $payment)
    {
        return view('backend.payments.edit', compact('payment'));
    }

    public function update(PaymentRequest $request, Payment $payment)
    {
        $payment->update($request->validated());

        return redirect()->route('admin.payments.index')->with([
            'message'    => 'Updated successfully',
            'alert-type' => 'success'
        ]);
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('admin.payments.index')->with([
            'message'    => 'Deleted successfully',
            'alert-type' => 'success'
        ]);
    }
}
