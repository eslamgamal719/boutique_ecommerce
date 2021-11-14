<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Gloudemans\Shoppingcart\Facades\Cart;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ShopProductsTagComponent extends Component
{
    use LivewireAlert;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';  //var in WithPagination trait
    public $paginationLimit = 12;              //normal variable
    public $sortingBy = 'default';
    public $slug;


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
        switch($this->sortingBy) {
            case 'popularity':
                $sort_field = 'id';
                $sort_type = 'asc';
                break;
            case 'low-high':
                $sort_field = 'price';
                $sort_type = 'asc';
                break;
            case 'high-low':
                $sort_field = 'price';
                $sort_type = 'desc';
                break;
            default: 
            $sort_field = 'id';
            $sort_type = 'asc';
        }

        $products = Product::with('firstMedia');

        $products = $products->with('tags')->whereHas('tags', function($query) {
            $query->where([
                'slug' => $this->slug,
                'status' => true
            ]);
        });

        $products = $products->active()->hasQuantity()->orderBy($sort_field, $sort_type)->paginate($this->paginationLimit);

        return view('livewire.frontend.shop-products-tag-component', [
            'products' => $products
        ]);
    }


}
