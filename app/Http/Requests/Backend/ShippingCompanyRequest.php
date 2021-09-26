<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class ShippingCompanyRequest extends FormRequest
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
            'name'          => 'required|max:255',
            'code'          => 'required|unique:shipping_companies,code,' . $this->id,
            'description'   => 'required',
            'fast'          => 'required',
            'cost'          => 'required|numeric',
            'status'        => 'required',
            'countries'     => 'required',
        ];
    }
}
