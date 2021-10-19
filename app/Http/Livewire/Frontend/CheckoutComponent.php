<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Coupon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class CheckoutComponent extends Component
{
    public $cart_subTotal;
    public $cart_total;
    public $cart_tax;
    public $coupon_code;
    public $cart_discount;

    protected $listeners = [
        'updateCart' => 'mount'
    ];


    public function mount()
    {
        $this->cart_subTotal = getNumbers()->get('subtotal');
        $this->cart_total = getNumbers()->get('total');
        $this->cart_tax = getNumbers()->get('product_taxes');
        $this->cart_discount = getNumbers()->get('discount');
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

    public function render()
    {
        return view('livewire.frontend.checkout-component');
    }
}
