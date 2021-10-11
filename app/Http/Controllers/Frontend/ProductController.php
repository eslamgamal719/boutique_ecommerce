<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    
    public function product($slug)
    {
        $product = Product::with('media', 'tags', 'category', 'reviews')
        ->withAvg('reviews', 'rating')
        ->whereSlug($slug)->active()
        ->hasQuantity()
        ->activeCategory()->firstOrFail();
        
        $related_products = Product::with('firstMedia')->whereHas('category', function($query) use ($product) {
            $query->whereId($product->category_id);
            $query->whereStatus(true);
        })->inRandomOrder()
        ->active()
        ->hasQuantity()
        ->take(4)->get();

        return view('frontend.product', compact('product', 'related_products'));
    }
}
