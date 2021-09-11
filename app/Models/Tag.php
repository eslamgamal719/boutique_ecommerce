<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory, Sluggable, SearchableTrait;

    protected $guarded = [];

    public function sluggable(): array
    {
        return [
                'slug' => [
                    'source' => 'name',
                ]
            ];
    }

    protected $searchable = [
        'columns' => [
            'tags.name' => 10,
        ],
    ];

    public function status()
    {
        return $this->status == true ? "Active" : "Inactive";
    }


    public function products()
    {
        return $this->morphedByMany(Product::class, 'taggable');
    }
}
