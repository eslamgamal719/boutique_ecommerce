<?php

namespace App\Http\Livewire\Frontend;

use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class CartComponent extends Component
{
    public $cartCount;
    public $wishlistCount;

    protected $listeners = [
        'updateCart' => 'update_cart'
    ];

    public function mount()
    {
        $this->cartCount = Cart::instance('default')->count();
        $this->wishlistCount = Cart::instance('wishlist')->count();
    }

    public function update_cart()
    {
        $this->cartCount = Cart::instance('default')->count();
        $this->wishlistCount = Cart::instance('wishlist')->count();
    }

    public function render()
    {
        return view('livewire.frontend.cart-component');
    }
}
