<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Product;
use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ShowProductComponent extends Component
{
    use LivewireAlert;

    public $product;
    public $quantity = 1;

    public function mount($product)
    {
        $this->product = $product;
    }

    public function increaseQuantity()
    {
        if($this->product->quantity > $this->quantity) {
            $this->quantity++;
        }else {
            $this->alert('warning', "This is maximum quantity you can add!");
        }
    }

    public function decreaseQuantity()
    {
        if($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function addToCart()
    {
        $duplicates = Cart::instance('default')->search(function($cartItem, $rowId) {
            return $cartItem->id === $this->product->id;
        });

        if($duplicates->isNotEmpty()) {
            $this->alert('warning', "This product is already exists in cart");
        }else {
            Cart::instance('default')->add($this->product->id, $this->product->name, $this->quantity, $this->product->price)->associate(Product::class);
            $this->quantity = 1;
            $this->emit('updateCart');
            $this->alert('success', "Product added to your cart successfully");
        }
    }

    public function addToWishlist()
    {
        $duplicates = Cart::instance('wishlist')->search(function($cartItem, $rowId) {
            return $cartItem->id === $this->product->id;
        });

        if($duplicates->isNotEmpty()) {
            $this->alert('warning', 'This product is already exists in wishlist');
        }else {
            Cart::instance('wishlist')->add($this->product->id, $this->product->name, 1, $this->product->price)->associate(Product::class);
            $this->emit('updateCart');
            $this->alert('success', "Product added to your wishlist successfully");
        }
    }

    public function render()
    {
        return view('livewire.frontend.show-product-component');
    }
}
