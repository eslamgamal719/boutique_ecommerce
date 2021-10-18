<?php

namespace App\Http\Livewire\Frontend;

use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class CartTotalComponent extends Component
{
    public $cart_subTotal;
    public $cart_total;
    public $cart_tax;

    protected $listeners = [
        'updateCart' => 'mount'
    ];

    public function mount()
    {
        $this->cart_subTotal = Cart::instance('default')->subTotal();
        $this->cart_total = Cart::instance('default')->total();
        $this->cart_tax = Cart::instance('default')->tax();
    }


    public function render()
    {
        return view('livewire.frontend.cart-total-component');
    }
}
