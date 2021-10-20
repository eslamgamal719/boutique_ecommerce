<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'           => 'required|max:255',
            'code'           => 'required|max:255|unique:payments,code,' . $this->id,
            'driver_name'    => 'nullable',
            'merchant_email' => 'nullable|email',
            'username'       => 'nullable',
            'password'       => 'nullable',
            'secret'         => 'nullable',
            'sandbox_merchant_email' => 'nullable',
            'sandbox_username'       => 'nullable',
            'sandbox_password'       => 'nullable',
            'sandbox_secret'         => 'nullable',
            'sandbox'                => 'nullable',
            'status'                 => 'required',
        ];
    }
}
