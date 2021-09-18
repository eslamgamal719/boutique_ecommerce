<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class State extends Model
{
    use HasFactory, SearchableTrait;

    protected $fillable = [
        'name',
        'status',
        'country_id',
    ];

    protected $searchable = [
        'columns' => [
            'states.name' => 10
        ]
    ];

    public $timestamps = false;

    

    public function status()
    {
        return $this->status ? 'Active' : 'Inactive';
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function cities()
    {
        return $this->hasMany(City::class, 'city_id');
    }
}
