<?php

namespace HotelBooking\Http\Requests\Hotel;

use HotelBooking\Http\Requests\Request;

/**
 * Request for room type form.
 */
class RoomTypeUpdateFormRequest extends Request
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
            'quantity' => 'required|integer|min:0|max:10',
            'quality' => 'required|min:10|max:50|regex:/^[a-zA-Z0-9 ]*$/',
            'price' => 'required|numeric|min:0',
            'description' => 'required|min:10|max:200|regex:/^[a-zA-Z0-9\-\.\, ]*$/',
            'image' => 'image',
        ];
    }
}
