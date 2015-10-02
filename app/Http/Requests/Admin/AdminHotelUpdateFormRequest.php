<?php

namespace HotelBooking\Http\Requests\Admin;

use HotelBooking\Http\Requests\Request;

/**
 * A Request class for validating the requests from edit hotel admin forms.
 */
class AdminHotelUpdateFormRequest extends Request
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
            'name'      =>  'required|regex:/^[a-z \']+$/i',
            'phone'     =>  'required|regex:/^0[0-9]*$/|min:10|max:15'
        ];
    }
    public function messages()
    {
        return [
            'phone.regex' =>  'Phone number must be start as 0'

        ];
    }
}
