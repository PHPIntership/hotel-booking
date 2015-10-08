<?php

namespace HotelBooking\Http\Requests\Admin;

class HotelEditRequest extends HotelCreateRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route()->getParameter('hotel');
        $rulesParent = parent::rules();
        $rules= [
          'email' => "required|unique:hotels,email,$id|min:10|max:30|email",
          'website' => 'regex:/^[0-9a-z]{5,20}(\.[a-z]{2,4}){1,2}$/',
          'image' => 'image'
        ];
        return array_merge($rulesParent, $rules);
    }
}
