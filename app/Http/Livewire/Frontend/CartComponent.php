<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CartComponent extends Component
{
    use LivewireAlert;

    public $cartCount;
    public $wishlistCount;

    protected $listeners = [
        'updateCart' => 'update_cart',
        'removeFromCart' => 'remove_from_cart',
        'removeFromWishlist' => 'remove_from_wishlist',
        'moveToCart' => 'move_to_cart'
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

    public function remove_from_cart($rowId)
    {
        Cart::instance('default')->remove($rowId);
        $this->emit('updateCart');
        $this->alert('success', 'Item removed from your cart');
        if(Cart::instance('default')->count() == 0) {
            return redirect()->route('frontend.cart');
        }
    }

    public function remove_from_wishlist($rowId)
    {
        Cart::instance('wishlist')->remove($rowId);
        $this->emit('updateCart');
        $this->alert('success', 'Item removed from your wishlist');
        if(Cart::instance('wishlist')->count() == 0) {
            return redirect()->route('frontend.wishlist');
        }
    }

    public function move_to_cart($rowId)
    {
        $item = Cart::instance('wishlist')->get($rowId);
        $duplicates = Cart::instance('default')->search(function($cartItem, $rId) use ($item) {
            return $rId == $item->rowId;
        });

        if($duplicates->isNotEmpty()) { 
            Cart::instance('wishlist')->remove($rowId);
            $this->alert('error', 'This item is already exist in your cart');
        }else {
            Cart::instance('default')->add($item->id, $item->name, 1, $item->price)->associate(Product::class);
            Cart::instance('wishlist')->remove($rowId);
            $this->alert('success', 'Item moved to your cart');
        }
        $this->emit('updateCart');

        if(Cart::instance('wishlist')->count() == 0) {
            return redirect()->route('frontend.wishlist');
        }
    }  

    public function render()
    {
        return view('livewire.frontend.cart-component');
    }
}
