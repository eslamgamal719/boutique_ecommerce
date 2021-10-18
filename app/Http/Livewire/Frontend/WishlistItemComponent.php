<?php

namespace App\Http\Livewire\Frontend;

use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class WishlistItemComponent extends Component
{
    public $rowId;



    public function moveToCart($rowId)
    {
        $this->emit('moveToCart', $rowId);
    }

    public function removeFromWishlist($rowId)
    {
        $this->emit('removeFromWishlist', $rowId);
    }

    public function render()
    {
        return view('livewire.frontend.wishlist-item-component', [
            'item' => Cart::instance('wishlist')->get($this->rowId)
        ]);
    }
}
