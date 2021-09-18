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
        'city_id'
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
        return $this->belongsTo(State::class, 'city_id');
    }
}
