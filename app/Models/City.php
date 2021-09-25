<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class City extends Model
{
    use HasFactory, SearchableTrait;

    protected $fillable = [
        'name',
        'status',
        'state_id'
    ];

    protected $searchable = [
        'columns' => [
            'cities.name' => 10
        ]
    ]; 

    public $timestamps = false;



    public function status()
    {
        return $this->status ? 'Active' : 'Inactive';
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function addresses()
    {
        return $this->hasMany(UserAddress::class, 'city_id');
    }
}
