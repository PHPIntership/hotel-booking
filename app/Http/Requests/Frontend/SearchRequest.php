<?php

namespace HotelBooking\Http\Requests\Frontend;

use HotelBooking\Http\Requests\Frontend\FrontendRequest;

class SearchRequest extends FrontendRequest
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
        $yesterday = date('Y-m-d', strtotime('-1 days'));
        $now = date('Y-m-d', strtotime('now'));
        return [
            'city' => 'required',
            'roomtype' => 'required',
            'coming_date' => 'required|after:'.$yesterday,
            'leave_date' => 'required|after:'.$now
        ];
    }
}
