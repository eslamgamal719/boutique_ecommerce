<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name'  => 'required',
            'username'   => 'required|max:20|unique:users,username,' . auth()->id(),
            'email'      => 'required|email|max:255|unique:users,email,' . auth()->id(),
            'mobile'     => 'required|unique:users,mobile,' . auth()->id(),
            'password'   => 'nullable|min:8',
            'user_image' => 'nullable|mimes:jpg,png,jpeg,svg|max:20000',
        ];
    }
}
