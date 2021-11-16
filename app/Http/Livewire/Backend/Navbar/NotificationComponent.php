<?php

namespace App\Http\Livewire\Backend\Navbar;

use Livewire\Component;

class NotificationComponent extends Component
{

    public $unreadNotificationCount = '';
    public $unreadNotifications;


    public function getListeners(): array
    {
        $adminId = auth('admin')->id();
        return [
            "echo-notification:App.Models.Admin.{$adminId},notification" => 'mount'
        ];
    }

    public function markAsRead($id)
    {
        $notification = auth('admin')->user()->unreadNotifications()->whereId($id)->first();
        $notification->markAsRead();
        return redirect()->to($notification->data['order_url']);
    }

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
