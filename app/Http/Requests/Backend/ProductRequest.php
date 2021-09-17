<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'description'   => 'required',
            'price'         => 'required|numeric',
            'quantity'      => 'required|numeric',
            'category_id'   => 'required',
            'tags.*'        => 'required',
            'featured'      => 'required',
            'status'        => 'required',
            'images'        => 'nullable',  //images field
            'images.*'      => 'mimes:jpg,jpeg,png,gif|max:3000' //for each image
        ];
    }
}
