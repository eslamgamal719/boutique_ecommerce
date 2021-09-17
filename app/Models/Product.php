<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = [];

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
        return $this->status ? "Active" : "Inactive";
    }

    public function feature()
    {
        return $this->featured ? "Yes" : "No";
    }



    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id');
    }


}
 