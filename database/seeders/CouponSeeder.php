<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Coupon::create([
            'code'              => 'ESLAM100',
            'type'              => 'fixed',
            'value'             => 200,
            'description'       => 'Discount 200 SAR on your sales on website',
            'use_times'         => 20,
            'start_date'        => Carbon::now(),
            'expire_date'       => Carbon::now()->addMonth(),
            'greater_than'      => 600,  //use this discount if you buy products its value greater than 600
            'status'            => 1,
        ]);

        Coupon::create([
            'code'              => 'ESLAM300',
            'type'              => 'percentage',
            'value'             => 50,
            'description'       => 'Discount 50% on your sales on website',
            'use_times'         => 10,
            'start_date'        => Carbon::now(),
            'expire_date'       => Carbon::now()->addWeek(),
            'greater_than'      => null,  //use this discount for any products you buy
            'status'            => 1,
        ]);
    }
    
}
