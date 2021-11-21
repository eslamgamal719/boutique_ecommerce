<?php

namespace App\Http\Livewire\Backend\Dashboard;

use App\Models\Order;
use Livewire\Component;

class StatisticsComponent extends Component
{

    public $currentMonthEarning = 0;
    public $currentYearEarning = 0;
    public $currentMonthNewOrder = 0;
    public $currentMonthFinishOrder = 0;

    public function mount()
    {
        $this->currentMonthEarning = Order::whereOrderStatus(Order::FINISHED)->whereMonth('created_at', date('m'))->sum('total');
        $this->currentYearEarning = Order::whereOrderStatus(Order::FINISHED)->whereYear('created_at', date('Y'))->sum('total');
        $this->currentMonthNewOrder = Order::whereOrderStatus(Order::NEW_ORDER)->whereMonth('created_at', date('m'))->count();
        $this->currentMonthFinishOrder = Order::whereOrderStatus(Order::FINISHED)->whereMonth('created_at', date('m'))->count();
    }

    public function render()
    {
        return view('livewire.backend.dashboard.statistics-component');
    }
}
