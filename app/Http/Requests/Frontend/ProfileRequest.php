<?php

namespace HotelBooking\Http\Requests\Frontend;

use HotelBooking\Http\Requests\Request;

class ProfileRequest extends Request
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
            'name' => 'required|min:6|max:30|regex:/^[A-Z][a-zA-Z\. ]*$/',
            'phone' => 'required|regex:/^0[0-9]*$/|min:10|max:15',
            'image' => 'image'
        ];
    }
}
