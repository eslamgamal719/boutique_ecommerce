<div x-data="{ showOrder: @entangle('showOrder') }">
    <div class="d-flex">
        <h2 class="h5 text-uppercase mb-4">Orders</h2>
    </div>

    <div class="my-4">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Order Ref.</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th class="col-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>{{ $order->ref_id }}</td>
                            <td>{{ $order->currency . ' ' . $order->total }}</td>
                            <td>{!! $order->statusWithLabel() !!}</td>
                            <td>{{ $order->created_at->format('d-m-Y') }}</td>
                            <td class="text-right">
                                <button type="button"
                                 x-on:click="showOrder = true"
                                 wire:click.prevent="displayOrder('{{ $order->id }}')"
                                     class="btn btn-success btn-sm rounded">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <p class="text-center">No orders found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div x-show="showOrder" x-on:click.away="showOrder = false" class="border rounded shadow p-4">
            <div class="table-responsive mb-4">
                <table class="table">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0" scope="col"><strong class="text-small text-uppercase">Product</strong></th>
                            <th class="border-0" scope="col"><strong class="text-small text-uppercase">Price</strong></th>
                            <th class="border-0" scope="col"><strong class="text-small text-uppercase">Quantity</strong></th>
                            <th class="border-0" scope="col"><strong class="text-small text-uppercase">Total</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $order->currency . ' ' . number_format($product->price, 2) }}</td>
                                <td>{{ $product->pivot->quantity }}</td>
                                <td>{{ $order->currency . ' ' . number_format($product->price * $product->pivot->quantity, 2) }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="3" class="text-right"><strong>Subtotal</strong></td>
                            <td>{{ $order->currency . ' ' . number_format($order->subtotal, 2) }}</td>
                        </tr>
                        @if(!is_null($order->discount_code))
                            <tr>
                                <td colspan="3" class="text-right"><strong>Discount (<small>{{ $order->discount_code }}</small>)</strong></td>
                                <td>{{ $order->currency . ' ' . number_format($order->discount, 2) }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td colspan="3" class="text-right"><strong>Tax</strong></td>
                            <td>{{ $order->currency . ' ' . number_format($order->tax, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-right"><strong>Shipping</strong></td>
                            <td>{{ $order->currency . ' ' . number_format($order->shipping, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-right"><strong>Total</strong></td>
                            <td>{{ $order->currency . ' ' . number_format($order->total, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <h2 class="h5 text-uppercase">Transactions</h2>
            <div class="table-responsive mb-4">
                <table class="table">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0" scope="col"><strong class="text-small text-uppercase">Transaction</strong></th>
                            <th class="border-0" scope="col"><strong class="text-small text-uppercase">Date</strong></th>
                             <!-- <th class="border-0" scope="col"><strong class="text-small text-uppercase">Days</strong></th>  -->
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->status() }}</td>
                                <td>{{ $transaction->created_at->format('Y-m-d') }}</td>
                                 <!-- <td>{{ $transaction->created_at->addDays(5)->diffInDays() }}</td>  -->
                                <td>
                                    @if (
                                        $loop->last &&
                                        $transaction->transaction == \App\Models\OrderTransaction::FINISHED &&
                                        $transaction->created_at->addDays(5)->diffInDays() != 0
                                    )
                                        <button type="button" wire:click.prevent="requestReturnOrder('{{ $order->id }}')" class="btn btn-link text-right">
                                            You can return order in ({{ $transaction->created_at->addDays(5)->diffInDays() }}) days
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
