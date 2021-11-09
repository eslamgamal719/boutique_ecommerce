<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderTransaction;
use App\Services\OmnipayService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show_orders', ['only' => ['index']]);
        $this->middleware('permission:update_order', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_order', ['only' => ['destroy']]);
        $this->middleware('permission:display_order', ['only' => ['show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with(['user', 'payment_method'])

        ->when(request()->keyword != null, function($q) {
            $q->search(request()->keyword);
        })
        ->when(request()->status != null, function($q) {
            $q->whereOrderStatus(request()->status);
        })
        ->orderBy(request()->sort_by ?? 'id', request()->order_by ?? 'desc')

        ->paginate(request()->limit_by ?? 10);

        return view('backend.orders.index', compact('orders'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $order_status_array = [
            '0' => 'New order',
            '1' => 'Paid',
            '2' => 'Under process',
            '3' => 'Finished',
            '4' => 'Rejected',
            '5' => 'Cancelled',
            '6' => 'Refund request',
            '7' => 'Returned order',
            '8' => 'Refunded',
        ];

        $key = array_search($order->order_status, array_keys($order_status_array));

        foreach($order_status_array as $k => $value) {
            if($k <= $key) {
                 unset($order_status_array[$k]);
            }
        }

        return view('backend.orders.show', compact('order', 'order_status_array'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        if ($request->order_status == Order::REFUNDED) {
            
            $omniPay = new OmnipayService('PayPal_Express');
            $response = $omniPay->refund([
                'amount' => $order->total,
                'transactionReference' => $order->transactions()->where('transaction', OrderTransaction::PAYMENT_COMPLETED)->first()->transaction_number,
                'cancelUrl' => $omniPay->getCancelUrl($order->id),
                'returnUrl' => $omniPay->getReturnUrl($order->id),
                'notifyUrl' => $omniPay->getNotifyUrl($order->id),
            ]);

            if ($response->isSuccessful()) {
                $order->update(['order_status' => Order::REFUNDED]);
                $order->transactions()->create([
                    'transaction' => OrderTransaction::REFUNDED,
                    'transaction_number' => $response->getTransactionReference(),
                    'payment_result' => 'success'
                ]);
    
                return redirect()->back()->with([
                    'message' => 'Order refunded successfully',
                    'alert-type' => 'success'
                ]);
            }

        }else {
            $order->update(['order_status' => $request->order_status]);

            $order->transactions()->create([
                'transaction' => $request->order_status
            ]);

            return redirect()->back()->with([
                'message' => 'Updated successfully',
                'alert-type' => 'success'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('admin.orders.index')->with([
            'message' => 'Deleted successfully',
            'alert-type' => 'success'
        ]);
    }
}
