<?php

namespace App\Http\Livewire\Frontend;

use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class CartItemComponent extends Component
{
    public $rowId;
    public $item_quantity;
    

    public function mount()
    {
        $this->item_quantity = Cart::instance('default')->get($this->rowId)->qty ?? 1;
    }

    public function increaseQuantity($rowId) 
    {
        if($this->item_quantity > 0) {
            $this->item_quantity = $this->item_quantity + 1;
            Cart::instance('default')->update($rowId, $this->item_quantity);
            $this->emit("updateCart");
        }
    }

    public function decreaseQuantity($rowId) 
    {
        if($this->item_quantity > 1) {
            $this->item_quantity = $this->item_quantity - 1;
            Cart::instance('default')->update($rowId, $this->item_quantity);
            $this->emit("updateCart");
        }
    }


    public function render()
    {
        return view('livewire.frontend.cart-item-component', [
            'item' => Cart::instance('default')->get($this->rowId)
        ]);
    }
}
