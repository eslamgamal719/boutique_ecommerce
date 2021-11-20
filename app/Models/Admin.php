<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasFactory, HasRoles, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'mobile',
        'user_image',
        'status',
        'role_name',
        'password',
    ];

    protected $appends = [
        'full_name'
    ];


    public function receivesBroadcastNotificationsOn()
    {
        return 'App.Models.Admin.'.$this->id;
    }


    public function getFullNameAttribute()
    {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }

    public function status()
    {
        return $this->status ? 'Active' : 'Inactive';
    }

}
