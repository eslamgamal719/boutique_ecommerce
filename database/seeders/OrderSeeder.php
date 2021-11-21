<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderTransaction;
use App\Models\Product;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $eslamUser = User::find(1);
        $products = Product::active()->hasQuantity()->activeCategory()->inRandomOrder()->take(3)->get();
        $subTotalValue = $products->sum('price');
        $discountValue = $subTotalValue * 0.5;
        $shippingValue = 15.00;
        $taxValue = ($subTotalValue - $discountValue) * 0.15;
        $totalValue = $subTotalValue + $taxValue + $shippingValue - $discountValue;

        //create order
        $order = $eslamUser->orders()->create([
            'ref_id'                => Str::random(15), //15 random char and num.
            'user_address_id'       => 1,
            'shipping_company_id'   => 1,
            'payment_method_id'     => 1,
            'subtotal'              => $subTotalValue,
            'discount_code'         => 'ESLAM300',
            'discount'              => $discountValue,
            'shipping'              => $shippingValue,
            'tax'                   => $taxValue,
            'total'                 => $totalValue,
            'currency'              => 'USD',
            'order_status'          => Order::PAYMENT_COMPLETED,
        ]);

        //create products order
        $order->products()->attach($products->pluck('id')->toArray());

        //create transactions
        $order->transactions()->createMany([
            [
                'transaction' => OrderTransaction::NEW_ORDER,
                'transaction_number' => null,
                'payment_result' => null,
            ],
            [
                'transaction' => OrderTransaction::PAYMENT_COMPLETED,
                'transaction_number' => Str::random(15),
                'payment_result' => 'success',
            ],
        ]);

        /**
         * Create fake order for each user
         */
        User::where('id', '>', '1')->each(function($user) use ($faker) {
            foreach(range(3, 6) as $index) {
                $products = Product::active()->hasQuantity()->activeCategory()->inRandomOrder()->take(3)->get();
                $subTotalValue = $products->sum('price');
                $discountValue = $subTotalValue * 0.5;
                $shippingValue = 15.00;
                $taxValue = ($subTotalValue - $discountValue) * 0.15;
                $totalValue = $subTotalValue + $taxValue + $shippingValue - $discountValue;
                $order_status = rand(0, 8);
                //create order
                $order = $user->orders()->create([
                    'ref_id'                => Str::random(15), //15 random char and num.
                    'user_address_id'       => $user->addresses()->first()->id,
                    'shipping_company_id'   => 1,
                    'payment_method_id'     => 1,
                    'subtotal'              => $subTotalValue,
                    'discount_code'         => 'ESLAM300',
                    'discount'              => $discountValue,
                    'shipping'              => $shippingValue,
                    'tax'                   => $taxValue,
                    'total'                 => $totalValue,
                    'currency'              => 'USD',
                    'order_status'          => $order_status,
                    'created_at'            => $faker->dateTimeBetween('-11 months', 'now'),
                    'updated_at'            => $faker->dateTimeBetween('-11 months', 'now'),
                ]);

                //create products order
                $order->products()->attach($products->pluck('id')->toArray());

                //create transactions
                $order->transactions()->createMany([
                    [
                        'transaction' => OrderTransaction::NEW_ORDER,
                        'transaction_number' => null,
                        'payment_result' => null,
                    ],
                    [
                        'transaction' => $order_status,
                        'transaction_number' => '9NW10162ME419262L',
                        'payment_result' => 'success',
                    ],
                ]);
            }
        });
    }
}
