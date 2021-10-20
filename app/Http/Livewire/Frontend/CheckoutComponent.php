<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Coupon;
use App\Models\ShippingCompany;
use App\Models\UserAddress;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class CheckoutComponent extends Component
{
    public $cart_subTotal;
    public $cart_total;
    public $cart_tax;
    public $coupon_code;
    public $cart_discount;
    public $addresses;
    public $customer_address_id;
    public $shipping_companies;
    public $shipping_company_id;
    public $cart_shipping;

    protected $listeners = [
        'updateCart' => 'mount'
    ];


    public function mount()
    {
        $this->addresses = auth()->user()->addresses;

        $this->cart_subTotal = getNumbers()->get('subtotal');
        $this->cart_total = getNumbers()->get('total');
        $this->cart_tax = getNumbers()->get('product_taxes');
        $this->cart_discount = getNumbers()->get('discount');
        $this->cart_shipping = getNumbers()->get('shipping');
        if($this->customer_address_id == '') {
            $this->shipping_companies = collect([]);
        }else {
            $this->updateShippingCompanies();
        }
    }

    public function applyDiscount()
    {
        if($this->cart_subTotal > 0) {
            $coupon = Coupon::whereCode($this->coupon_code)->whereStatus(true)->first();
            if(!$coupon) {
                $this->coupon_code = '';
                $this->alert('error', 'Coupon is invalid');
            }else {
                $discountValue = $coupon->discount($this->cart_subTotal);
                if($discountValue > 0) {
                    session()->put('coupon', [
                        'code'      => $coupon->code,
                        'value'     => $coupon->value,
                        'discount'  => $discountValue,
                    ]);

                    $this->coupon_code = session()->get('coupon')['code'];
                    $this->emit('updateCart');
                    $this->alert('success', 'Coupon is applied successfully');

                }else {
                    $this->alert('error', 'Coupon is invalid');
                }
            }

        }else {
            $this->coupon_code = '';
            $this->alert('error', 'No products in your cart');
        }
    }

    public function removeCoupon()
    {
        session()->remove('coupon');
        $this->coupon_code = '';
        $this->emit('updateCart');
        $this->alert('success', 'Coupon is removed successfully');
    }

    public function updateShippingCompanies()
    {
        $address = UserAddress::whereId($this->customer_address_id)->first();
        $this->shipping_companies = ShippingCompany::whereHas('countries', function($query) use($address) {
            $query->where('country_id', $address->country_id);
        })->get();
    }

    public function updatingCustomerAddressId()  //doing before $customer_address_id updated
    {
        session()->forget('saved_customer_address_id');
        session()->forget('saved_shipping_company_id');
        session()->put('saved_customer_address_id', $this->customer_address_id);

        $this->customer_address_id = session()->has('saved_customer_address_id') ? session()->get('saved_customer_address_id') : '';
        $this->shipping_company_id = session()->has('saved_shipping_company_id') ? session()->get('saved_shipping_company_id') : '';
        $this->emit('updateCart');
    }

    public function updatedCustomerAddressId()  //doing after $customer_address_id updated
    {
        session()->forget('saved_customer_address_id');
        session()->forget('saved_shipping_company_id');
        session()->put('saved_customer_address_id', $this->customer_address_id);

        $this->customer_address_id = session()->has('saved_customer_address_id') ? session()->get('saved_customer_address_id') : '';
        $this->shipping_company_id = session()->has('saved_shipping_company_id') ? session()->get('saved_shipping_company_id') : '';
        $this->emit('updateCart');
    }

    public function updateShippingCost()
    {
        $selectedShippingCompany = ShippingCompany::whereId($this->shipping_company_id)->first();
        session()->put('shipping', [
            'code' => $selectedShippingCompany->code,
            'cost' => $selectedShippingCompany->cost,
        ]);
        $this->emit('updateCart');
        $this->alert('success', 'Shipping cost is applied successfully');
    }

    public function updatingShippingCompanyId()  //doing before $shipping_company_id updated
    {
        session()->forget('saved_shipping_company_id');
        session()->put('saved_shipping_company_id', $this->shipping_company_id);

        $this->customer_address_id = session()->has('saved_customer_address_id') ? session()->get('saved_customer_address_id') : '';
        $this->shipping_company_id = session()->has('saved_shipping_company_id') ? session()->get('saved_shipping_company_id') : '';
        $this->emit('updateCart');
    }

    public function updatedShippingCompanyId()  //doing after $shipping_company_id updated
    {
        session()->forget('saved_shipping_company_id');
        session()->put('saved_shipping_company_id', $this->shipping_company_id);

        $this->customer_address_id = session()->has('saved_customer_address_id') ? session()->get('saved_customer_address_id') : '';
        $this->shipping_company_id = session()->has('saved_shipping_company_id') ? session()->get('saved_shipping_company_id') : '';
        $this->emit('updateCart');
    }

    public function render()
    {
        return view('livewire.frontend.checkout-component');
    }
}
