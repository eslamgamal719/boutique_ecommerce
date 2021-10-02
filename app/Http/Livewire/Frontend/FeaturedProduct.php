<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Product;
use Livewire\Component;

class FeaturedProduct extends Component
{
    public function render()
    {
        return view('livewire.frontend.featured-product', [
            'featuredProducts' => Product::with('firstMedia')
            ->inRandomOrder()->active()->featured()->hasQuantity()->activeCategory()
            ->take(8)->get()
        ]);
    }
}
