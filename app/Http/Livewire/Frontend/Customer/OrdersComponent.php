<?php

namespace App\Http\Livewire\Frontend\Customer;

use App\Models\Order;
use Livewire\Component;

class OrdersComponent extends Component
{
    public $showOrder = false;
    public $order;


    public function displayOrder($id)
    {
        $this->order = Order::with('products')->find($id);
    }

    public function render()
    {
        return view('livewire.frontend.customer.orders-component', [
            'orders' => auth()->user()->orders
        ]);
    }
}
