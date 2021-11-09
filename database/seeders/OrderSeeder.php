<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderTransaction;
use App\Models\Product;
use App\Models\User;
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
    }
}
