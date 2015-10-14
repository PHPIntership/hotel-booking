<?php

namespace HotelBooking\Http\Requests\Hotel;

use HotelBooking\Http\Requests\Request;

class RoomFormRequest extends Request
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
            'hotel_room_type_id' => 'required|integer',
            'name' => 'required|min:3|max:15|regex:/^[A-Z][a-zA-Z0-9 ]*$/',
            'status' => 'required|integer|min:0|max:2',
        ];
    }
}
