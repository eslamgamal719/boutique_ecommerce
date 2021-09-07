<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
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


    public function products()
    {
        return $this->morphedByMany(Product::class, 'taggable');
    }
}
