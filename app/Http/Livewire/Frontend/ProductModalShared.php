<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Product;
use Livewire\Component;

class ProductModalShared extends Component
{
    public $productModalStatus = false;
    public $productModal = [];
    public $quantity = 1;

    protected $listeners = ['showProductModalAction'];


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
