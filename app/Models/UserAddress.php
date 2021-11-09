<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class UserAddress extends Model
{
    use HasFactory, SearchableTrait;

    protected $guarded = [];

    protected $searchable = [
        'columns' => [
            'user_addresses.address_title' => 10,
            'user_addresses.first_name'    => 10,
            'user_addresses.last_name'     => 10,
            'user_addresses.email'         => 10,
            'user_addresses.mobile'        => 10,
            'user_addresses.address'       => 10,
            'user_addresses.address2'      => 10,
            'user_addresses.zip_code'      => 10,
            'user_addresses.po_box'        => 10,
            'countries.name'               => 10,
            'states.name'                  => 10,
            'cities.name'                  => 10,
            'users.first_name'             => 10,
            'users.last_name'              => 10,
            'users.username'               => 10,
            'users.email'                  => 10,
            'users.mobile'                 => 10,
        ],
        'joins' => [
            'users'     => ['users.id', 'user_addresses.user_id'],
            'countries' => ['countries.id', 'user_addresses.country_id'],
            'states'    => ['states.id', 'user_addresses.state_id'],
            'cities'    => ['cities.id', 'user_addresses.city_id'],
        ]
    ];

    public function defaultAddress()
    {
        return $this->default_address ? 'Default Address' : '';
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
