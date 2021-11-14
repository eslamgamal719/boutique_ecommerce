<?php

namespace App\Http\Livewire\Backend\Navbar;

use Livewire\Component;

class NotificationComponent extends Component
{

    public $unreadNotificationCount = '';
    public $unreadNotifications;


    public function mount()
    {
        $this->unreadNotificationCount = auth('admin')->user()->unreadNotifications()->count();
        $this->unreadNotifications = auth('admin')->user()->unreadNotifications;
    }

    public function render()
    {
        return view('livewire.backend.navbar.notification-component');
    }
}
