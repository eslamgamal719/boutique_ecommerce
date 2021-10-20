<div class="row">
    <div class="col-lg-8">

        <h2 class="h5 text-uppercase mb-4">Shipping addresses</h2>
        <div class="row">
            @forelse ($addresses as $address)
                <div class="col-6 form-group">
                    <div class="custom-control custom-radio">
                        <input 
                            type="radio"
                            class="custom-control-input"
                            id="address-{{ $address->id }}"
                            wire:model="customer_address_id"
                            wire:click="updateShippingCompanies()"
                            {{ intval($customer_address_id) == $address->id ? "checked" : '' }}
                            value="{{ $address->id }}">

                        <label for="address-{{ $address->id }}" class="custom-control-label text-small">
                            <b>{{ $address->address_title }}</b>
                            <small>
                                {{ $address->address }}<br/>
                                {{ $address->country->name }} - {{ $address->state->name }} - {{ $address->city->name }}
                            </small>
                        </label>    
                    </div>
                </div>
            @empty
                <p>No addresses found</p>
                <a href="#">Add an address</a>
            @endforelse
        </div>

        @if ($customer_address_id != 0)
        <h2 class="h5 text-uppercase mb-4">Shipping companies</h2>
        <div class="row">
            @forelse ($shipping_companies as $shipping_company)
                <div class="col-6 form-group">
                    <div class="custom-control custom-radio">
                        <input 
                            type="radio"
                            class="custom-control-input"
                            id="shipping_company-{{ $shipping_company->id }}"
                            wire:model="shipping_company_id"
                            wire:click="updateShippingCost()"
                            {{ intval($shipping_company_id) == $shipping_company->id ? "checked" : '' }}
                            value="{{ $shipping_company->id }}">

                        <label for="shipping_company-{{ $shipping_company->id }}" class="custom-control-label text-small">
                            <b>{{ $shipping_company->name }}</b>
                            <small>
                                {{ $shipping_company->description }} - (${{ $shipping_company->cost }})
                            </small>
                        </label>    
                    </div>
                </div>
            @empty
                <p>No shipping companies found</p>
                <a href="#">Add an company</a>
            @endforelse
        </div>
        @endif
    </div>
    
    <!-- ORDER SUMMARY-->
    <div class="col-lg-4">
        <div class="card border-0 rounded-0 p-lg-4 bg-light">
        <div class="card-body">
            <h5 class="text-uppercase mb-4">Your order</h5>
            <ul class="list-unstyled mb-0">
                <li class="d-flex align-items-center justify-content-between">
                    <strong class="small font-weight-bold">Subtotal</strong>
                    <span class="text-muted small">${{ $cart_subTotal }}</span>
                </li>

                @if(session()->has('coupon'))
                <li class="border-bottom my-2"></li>
                <li class="d-flex align-items-center justify-content-between">
                    <strong class="small font-weight-bold">Discount <small>({{ session()->get('coupon')['code'] }})</small></strong>
                    <span class="text-muted small">- ${{ $cart_discount }}</span>
                </li>
                @endif

                <li class="border-bottom my-2"></li>
                <li class="d-flex align-items-center justify-content-between">
                    <strong class="small font-weight-bold">Tax</strong>
                    <span class="text-muted small">${{ $cart_tax }}</span>
                </li>
                <li class="border-bottom my-2"></li>
                <li class="d-flex align-items-center justify-content-between">
                    <strong class="text-uppercase small font-weight-bold">Total</strong>
                    <span>${{ $cart_total }}</span>
                </li>

                <li class="border-bottom my-2"></li>
                <li>
                    <form wire:submit.prevent="applyDiscount()">
                        
                        @if(!session()->has('coupon'))
                        <input type="text" wire:model="coupon_code" class="form-control" placeholder="Enter your coupon">
                        @endif
                        
                        @if (session()->has('coupon'))
                        <button type="button" wire:click.prevent="removeCoupon()" class="btn btn-danger btn-sm btn-block">
                            <i class="fas fa-gift mr-2"></i> Remove Coupon
                        </button>
                        @else
                        <button type="submit" class="btn btn-dark btn-sm btn-block">
                            <i class="fas fa-gift mr-2"></i> Apply Coupon
                        </button>
                        @endif

                    </form>
                </li>

            </ul>
        </div>
        </div>
    </div>
</div>
