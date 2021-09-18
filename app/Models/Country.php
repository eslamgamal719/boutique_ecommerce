<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Country extends Model
{
    use HasFactory, SearchableTrait;
    

    protected $fillable = [
        'name',
        'status'
    ];

    protected $searchable = [
        'columns' => [
            'countries.name' => 10
        ]
    ];

    public $timestamps = false;


    
    public function status()
    {
        return $this->status ? 'Active' : 'Inactive';
    }

    public function states()
    {
        return $this->hasMany(State::class, 'country_id');
    }
}
