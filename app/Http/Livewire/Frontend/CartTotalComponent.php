<?php

namespace App\Http\Livewire\Frontend;

use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class CartTotalComponent extends Component
{
    public $cart_subTotal;
    public $cart_total;
    public $cart_tax;
    public $cart_discount;
    public $cart_shipping;
    
    protected $listeners = [
        'updateCart' => 'mount'
    ];

    public function mount()
    {
        $this->cart_subTotal = getNumbers()->get('subtotal');
        $this->cart_total = getNumbers()->get('total');
        $this->cart_tax = getNumbers()->get('product_taxes');
        $this->cart_discount = getNumbers()->get('discount');
        $this->cart_shipping = getNumbers()->get('shipping');
    }


    public function render()
    {
        return view('livewire.frontend.cart-total-component');
    }
}
