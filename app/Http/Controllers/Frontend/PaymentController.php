<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderTransaction;
use App\Models\Product;
use App\Services\OmnipayService;
use App\Services\OrderService;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function checkout() 
    {
        return view('frontend.checkout');
    }
    
    public function checkout_now(Request $request)
    {
        $order = (new OrderService)->createOrder($request->except(['_token', 'submit']));

        $omniPay = new OmnipayService('PayPal_Express');
        $response = $omniPay->purchase([
            'amount' => $order->total,
            'transactionId' => $order->id,
            'currency' => $order->currency,
            'cancelUrl' => $omniPay->getCancelUrl($order->id),
            'returnUrl' => $omniPay->getReturnUrl($order->id),
        ]);

        if ($response->isRedirect()) {
            $response->redirect();
        }

        toast($response->getMessage(), 'error');
        return redirect()->route('frontend.index');
    }


    public function cancelled($order_id)
    {
        $order = Order::find($order_id);
        $order->update([
            'order_status' => Order::CANCELED
        ]);
        $order->products()->each(function($order_product) {
            $product = Product::whereId($order_product->id)->first();
            $product->update([
                'quantity' => $product->quantity + $order_product->pivot->quantity
            ]);
        });

        toast('You have cancelled your order payment!', 'error');
        return redirect()->route('frontend.index');
    }


    public function completed($order_id)
    {
        $order = Order::find($order_id);

        $omniPay = new OmnipayService('PayPal_Express');
        $response = $omniPay->complete([
            'amount' => $order->total,
            'transactionId' => $order->id,
            'currency' => $order->currency,
            'cancelUrl' => $omniPay->getCancelUrl($order->id),
            'returnUrl' => $omniPay->getReturnUrl($order->id),
            'notifyUrl' => $omniPay->getNotifyUrl($order->id),
        ]);

        if($response->isSuccessful()) {

            $order->update(['order_status' => Order::PAYMENT_COMPLETED]);

            $order->transactions()->create([
                'transaction' => OrderTransaction::PAYMENT_COMPLETED,
                'transaction_number' => $response->getTransactionReference(),
                'payment_result' => 'success'
            ]);

            if(session()->has('coupon')) {
                $coupon = Coupon::whereCode(session()->get('coupon')['code'])->first();
                $coupon->increment('used_times');
            }

            Cart::instance('default')->destroy();

            session()->forget([
                'coupon',
                'saved_customer_address_id',
                'saved_shipping_company_id',
                'saved_payment_method_id',
                'shipping',
            ]);

            toast('Your recent payment is successful with reference code: ' . $response->getTransactionReference(), 'success');
            return redirect()->route('frontend.index');
        }else {
            toast($response->getMessage(), 'error');
            return redirect()->route('frontend.index');
        }
    }


    public function webhook($order, $env)
    {

    }




}
