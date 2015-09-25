<?php

namespace HotelBooking\Http\Requests\Admin;

use HotelBooking\Http\Requests\Request;

class AdminHotelCreateFormRequest extends Request
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
            'username'  =>  'required|regex:/^[a-z 0-9,.\'-_]+$/i|min:6|max:20|unique:admin_hotels',
            'password'  =>  'required|alpha_num',
            'name'      =>  'required|regex:/^[a-z ,.\'-]+$/i',
            'email'     =>  'required|email|unique:admin_hotels',
            'phone'     =>  'required|regex:/^0[0-9]*$/|min:10|max:15'

        ];
    }
}
