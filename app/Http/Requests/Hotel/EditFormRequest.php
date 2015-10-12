<?php

namespace HotelBooking\Http\Requests\Hotel;

use HotelBooking\Http\Requests\Request;
use Auth;

/**
 * Edit hotel form request class
 */
class EditFormRequest extends Request
{
    /**
     * Determine if the hotel admin is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::hotel()->get();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone' => 'required|min:10|max:12|regex:/^0[0-9]*$/',
            'description' => 'required|min:10|max:200|regex:/^[a-zA-Z0-9\-\.\, ]*$/',
            'image' => 'image',
            'website' => 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/'
        ];
    }
}
