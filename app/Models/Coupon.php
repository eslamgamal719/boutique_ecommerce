<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory, SearchableTrait;

    protected $guarded = [];

    protected $searchable = [
        'columns' => [
            'coupons.code' => 10,
            'coupons.description' => 10,
        ],
    ];


    public function status()
    {
        return $this->status == 1 ? "Active" : 'Inactive';
    }


    protected $dates = [
        'start_date',
        'expire_date'
    ];

}
