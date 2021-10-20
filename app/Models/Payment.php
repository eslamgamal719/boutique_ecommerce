<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;


class Payment extends Model
{
    use HasFactory, SearchableTrait;

    protected $guarded = [];

    protected $searchable = [
        'columns' => [
            'payments.name' => 10,
            'payments.code' => 10,
            'payments.merchant_email' => 10,
        ]
    ];

    
    public function status()
    {
        return $this->status ? "Active" : "Inactive";
    }

    public function sandbox()
    {
        return $this->sandbox ? "Sandbox" : "Live";
    }
}
