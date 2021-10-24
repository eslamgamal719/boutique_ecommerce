<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    
    public function checkout_now()
    {
        return 'check out now';
    }

    public function cancelled($order_id)
    {

    }

    public function completed($order_id)
    {

    }

    public function webhook($order, $env)
    {

    }




}
