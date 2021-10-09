<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Product;
use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;

class ProductModalShared extends Component
{
    public $productModalStatus = false;
    public $productModal = [];
    public $quantity = 1;

    protected $listeners = ['showProductModalAction'];

    public function decreaseQuantity()
    {
        if($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function increaseQuantity()
    {
        if($this->productModal->quantity > $this->quantity) {
            $this->quantity++;
        }else {
            $this->alert('warning', "This is maximum quantity you can add!");
        }
    }   

    public function addToCart()
    {
        $duplicates = Cart::instance('default')->search(function($cartItem, $rowId) {
            return $cartItem->id === $this->productModal->id;
        });

        if($duplicates->isNotEmpty()) {
            $this->alert('warning', "This product is already exists in cart");
        }else {
            Cart::instance('default')->add($this->productModal->id, $this->productModal->name, $this->quantity, $this->productModal->price)->associate(Product::class);
            $this->quantity = 1;
            $this->alert('success', "Product added to your cart successfully");
        }
    }

    public function addToWishlist()
    {
        $duplicates = Cart::instance('wishlist')->search(function($cartItem, $rowId) {
            return $cartItem->id === $this->productModal->id;
        });

        if($duplicates->isNotEmpty()) {
            $this->alert('warning', 'This product is already exists in wishlist');
        }else {
            Cart::instance('wishlist')->add($this->productModal->id, $this->productModal->name, 1, $this->productModal->price)->associate(Product::class);
            $this->alert('success', "Product added to your wishlist successfully");
        }
    }

    public function showProductModalAction($slug)
    {
        $this->productModalStatus = true;
        $this->productModal = [];
        $this->productModal = Product::withAvg('reviews', 'rating')->whereSlug($slug)->Active()->HasQuantity()->ActiveCategory()->firstOrFail();
        //dd($this->productModal);
    }

    public function render()
    {
        return view('livewire.frontend.product-modal-shared');
    }
}
