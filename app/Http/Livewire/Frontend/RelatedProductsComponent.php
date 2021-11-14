<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Product;
use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class RelatedProductsComponent extends Component
{
    use LivewireAlert;

    public $related_products;


    public function mount($related_products)
    {
        $this->related_products = $related_products;
    }

    public function addToCart($id) 
    {
        $product = Product::findOrFail($id);
        $duplicates = Cart::instance('default')->search(function($cartItem, $rowId) use($product) {
            return $cartItem->id === $product->id;
        });

        if($duplicates->isNotEmpty()) {
            $this->alert('warning', "This product is already exists in your cart");
        }else {
            Cart::instance('default')->add($product->id, $product->name, 1, $product->price)->associate(Product::class);;
            $this->emit('updateCart');
            $this->alert('success', "Product added to your cart successfully");
        }
    }

    public function addToWishlist($id) 
    {
        $product = Product::findOrFail($id);
        $duplicates = Cart::instance('wishlist')->search(function($cartItem, $rowId) use($product) {
            return $cartItem->id === $product->id;
        });

        if($duplicates->isNotEmpty()) {
            $this->alert('warning', "This product is already exists in your wishlist");
        }else {
            Cart::instance('wishlist')->add($product->id, $product->name, 1, $product->price)->associate(Product::class);;
            $this->emit('updateCart');
            $this->alert('success', "Product added to your wishlist successfully");
        }
    }

    
    public function render()
    {
        return view('livewire.frontend.related-products-component');
    }
}
