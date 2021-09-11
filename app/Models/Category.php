<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, Sluggable, SearchableTrait;

    protected $fillable = [
        'name',
        'slug',
        'cover',
        'status',
        'parent_id',
    ];

    protected $searchable = [
        'columns' => [
            'categories.name' => 10,
        ],
    ];

    public function sluggable(): array
    {
        return [
                'slug' => [
                    'source' => 'name',
                ]
            ];
    }


    public function status()
    {
        return $this->status == true ? "Active" : "Inactive";
    }


    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}



