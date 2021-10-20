<?php

use Gloudemans\Shoppingcart\Facades\Cart;


function active_menu($link)
{
    if(preg_match('/' . $link . '/i', \Request::segment(2))) {
        return ['', 'true', 'show'];
    }else {
        return ['collapsed', 'false', ''];
    }
}

function getNumbers()
{
    $subTotal = Cart::instance('default')->subTotal();

    $discount = session()->has('coupon') ? session()->get('coupon')['discount'] : 0.00;

    $subTotal_after_discount = $subTotal - $discount;

    $tax = config('cart.tax') / 100;
    $taxText = config('cart.tax') . '%';
    $productTaxes = round($subTotal_after_discount * $tax, 2);

    $subTotal_after_tax = $subTotal_after_discount + $productTaxes; 

    $shipping = session()->has('shipping') ? session()->get('shipping')['cost'] : 0.00;

    $total = $subTotal_after_tax + $shipping > 0 ? round($subTotal_after_tax + $shipping, 2) : 0.00;

    return collect([
        'subtotal'                => $subTotal,
        'discount'                => (float)$discount,
        'subotal_after_discount'  => (float)$subTotal_after_discount,
        'tax'                     => $tax,
        'tax_text'                => $taxText,
        'product_taxes'           => (float)$productTaxes,
        'subtotal_after_tax'      => (float)$subTotal_after_tax,
        'shipping'                => (float)$shipping,
        'total'                   => (float)$total,
    ]);
}