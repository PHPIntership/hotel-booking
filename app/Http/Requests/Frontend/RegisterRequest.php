<?php

namespace HotelBooking\Http\Requests\Frontend;

use HotelBooking\Http\Requests\Frontend\FrontendRequest;

/**
 * Request class for user register form
 */
class RegisterRequest extends FrontendRequest
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
            'username' => 'required|regex:/^[a-z0-9,.\'-_]+$/i|min:6|max:20|unique:users',
            'password' => 'required|alpha_num|min:6|max:20',
            'retype_password' => 'required|same:password',
            'name' => 'required|regex:/^[a-z ,.\'-]+$/i',
            'email' => 'required|email|unique:users',
            'phone' => 'required|regex:/^0[0-9]*$/|min:10|max:15',
            'image' => 'image'
        ];
    }
}
