<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(PermissionSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(TagSeeder::class);
        $this->call(ProductsImagesSeeder::class);
        $this->call(ProductsTagsSeeder::class);
        $this->call(CouponSeeder::class);
        $this->call(ReviewSeeder::class);
        $this->call(WorldSeeder::class);
        $this->call(WorldStatusSeeder::class);
        $this->call(UserAddressSeeder::class);
        $this->call(ShippingCompanySeeder::class);
        $this->call(PaymentMethodSeeder::class);
    }
}
