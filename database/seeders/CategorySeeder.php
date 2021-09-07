<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $clothes = Category::create(['name' => 'Clothes', 'cover' => 'clothes.jpg', 'status' => true, 'parent_id' => null]);
        Category::create(['name' => 'Women\'s T-Shirts', 'cover' => 'clothes.jpg', 'status' => true, 'parent_id' => $clothes->id]);
        Category::create(['name' => 'Men\'s T-Shirts', 'cover' => 'clothes.jpg', 'status' => true, 'parent_id' => $clothes->id]);
        Category::create(['name' => 'Dresses', 'cover' => 'clothes.jpg', 'status' => true, 'parent_id' => $clothes->id]);
        Category::create(['name' => 'Novelty socks', 'cover' => 'clothes.jpg', 'status' => true, 'parent_id' => $clothes->id]);
        Category::create(['name' => 'Women\'s sunglasses', 'cover' => 'clothes.jpg', 'status' => true, 'parent_id' => $clothes->id]);
        Category::create(['name' => 'Men\'s sunglasses', 'cover' => 'clothes.jpg', 'status' => true, 'parent_id' => $clothes->id]);

        $shoes = Category::create(['name' => 'Shoes', 'cover' => 'shoes.jpg', 'status' => true]);
        Category::create(['name' => 'Women\'s Shoes', 'cover' => 'shoes.jpg', 'status' => true, 'parent_id' => $shoes->id]);
        Category::create(['name' => 'Men\'s Shoes', 'cover' => 'shoes.jpg', 'status' => true, 'parent_id' => $shoes->id]);
        Category::create(['name' => 'Boy\'s Shoes', 'cover' => 'shoes.jpg', 'status' => true, 'parent_id' => $shoes->id]);
        Category::create(['name' => 'Girls\'s Shoes', 'cover' => 'shoes.jpg', 'status' => true, 'parent_id' => $shoes->id]);

        $watches = Category::create(['name' => 'Watches', 'cover' => 'watches.jpg', 'status' => true]);
        Category::create(['name' => 'Women\'s Watches', 'cover' => 'shoes.jpg', 'status' => true, 'parent_id' => $watches->id]);
        Category::create(['name' => 'Men\'s Watches', 'cover' => 'shoes.jpg', 'status' => true, 'parent_id' => $watches->id]);
        Category::create(['name' => 'Boy\'s Watches', 'cover' => 'shoes.jpg', 'status' => true, 'parent_id' => $watches->id]);
        Category::create(['name' => 'Girls\'s Watches', 'cover' => 'shoes.jpg', 'status' => true, 'parent_id' => $watches->id]);

        $electronics = Category::create(['name' => 'Electronics', 'cover' => 'electronics.jpg', 'status' => true]);
        Category::create(['name' => 'Electronics', 'cover' => 'electronics.jpg', 'status' => true, 'parent_id' => $electronics->id]);
        Category::create(['name' => 'USB Flash drives', 'cover' => 'electronics.jpg', 'status' => true, 'parent_id' => $electronics->id]);
        Category::create(['name' => 'Headphones', 'cover' => 'electronics.jpg', 'status' => true, 'parent_id' => $electronics->id]);
        Category::create(['name' => 'Portable speakers', 'cover' => 'electronics.jpg', 'status' => true, 'parent_id' => $electronics->id]);
        Category::create(['name' => 'Cell Phone bluetooth headsets', 'cover' => 'electronics.jpg', 'status' => true, 'parent_id' => $electronics->id]);
        Category::create(['name' => 'Keyboards', 'cover' => 'electronics.jpg', 'status' => true, 'parent_id' => $electronics->id]);
    }
}
