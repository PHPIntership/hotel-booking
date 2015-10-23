<?php

namespace HotelBooking\Http\Requests\Frontend;

use HotelBooking\Http\Requests\Request;

/**
 * FormRequest for order form
 */
class OrderRequest extends Request
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
            'coming_date' => 'required|date|after:tomorrow',
            'leave_date' => 'required|date|after:coming_date',
            'quantity' => 'required|integer|min:1',
            'comment' => 'max:50|regex:/^[a-zA-Z0-9\-\.\, ]*$/'
        ];
    }
}
