<?php

namespace app\Services;

use Omnipay\Omnipay;

class OmnipayService 
{
    protected $gateway = '';

    public function __construct($payment_method = "PayPal_Express")
    {
        if(is_null($payment_method) || $payment_method == 'PayPal_Express') {
            $this->gateway = Omnipay::create('PayPal_Express');
            $this->gateway->setUsername = config('services.paypal.username');
            $this->gateway->setPassword = config('services.paypal.password');
            $this->gateway->setSignature = config('services.paypal.signture');
            $this->gateway->setTestMode = config('services.paypal.sandbox');
        }
        return $this->gateway;
    }

    public function purchase(array $parameter)
    {
        $response = $this->gateway->purchase($parameter)->send();
        return $response;
    }

    public function refund(array $parameter)
    {
        $response = $this->gateway->refund($parameter)->send();
        return $response;
    }

    public function complete(array $parameter)
    {
        $response = $this->gateway->completePurchase($parameter)->send();
        return $response;
    }

    public function getCancelUrl($orderId)
    {
        return route('frontend.checkout.cancel', $orderId);
    }

    public function getReturnUrl($orderId)
    {
        return route('frontend.checkout.complete', $orderId);
    }

    public function getNotifyUrl($orderId)
    {
        $env = config('services.paypal.sandbox') == true ? 'sandbox' : 'live';
        return route('frontend.checkout.webhook.ipn', [$orderId, $env]);
    }
}