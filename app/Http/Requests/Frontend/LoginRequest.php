<?php

namespace HotelBooking\Http\Requests\Frontend;

use HotelBooking\Http\Requests\Request;

/**
 * FormRequest for user login form
 */
class LoginRequest extends Request
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
            'username' => 'required|regex:/^[a-z0-9,.\'-_]+$/i|min:6|max:20|',
            'password' => 'required|alpha_num|min:6|max:20'
        ];
    }
}
