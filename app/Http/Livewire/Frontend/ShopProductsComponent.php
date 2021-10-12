<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Gloudemans\Shoppingcart\Facades\Cart;

class ShopProductsComponent extends Component
{
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
            Cart::instance('default')->add($product->id, $product->name, 1, $product->price);
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
            Cart::instance('wishlist')->add($product->id, $product->name, 1, $product->price);
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

        if($this->slug != '') {

            $category = Category::whereSlug($this->slug)->whereStatus(true)->first();

            if(is_null($category->parent_id)) {

                $categoriesIds = Category::whereParentId($category->id)->whereStatus(true)->pluck('id')->toArray();

                $products = $products->whereHas('category', function($query) use ($categoriesIds) {
                    $query->whereIn('id', $categoriesIds);
                });

            }else {

                $products = $products->with('category')->whereHas('category', function($q) {
                    $q->whereSlug($this->slug);
                    $q->whereStatus(true);
                });
            }

        }else {

            $products = $products->activeCategory();

        }

        $products = $products->active()->hasQuantity()->orderBy($sort_field, $sort_type)->paginate($this->paginationLimit);

        return view('livewire.frontend.shop-products-component', [
            'products' => $products
        ]);
    }
}
