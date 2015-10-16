<?php

namespace HotelBooking\Http\Requests\Admin;

use HotelBooking\Http\Requests\Request;

class UserUpdateFormRequest extends Request
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
            'name' => 'required|min:6',
            'phone' => 'required|min:10|max:12|regex:/^0[0-9]*$/',
            'address' => 'required|min:6',
            'image' => 'image',
        ];
    }
}
