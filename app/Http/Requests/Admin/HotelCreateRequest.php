<?php

namespace HotelBooking\Http\Requests\Admin;

use HotelBooking\Http\Requests\Request;

class HotelCreateRequest extends Request
{

  public function authorize()
  {
    return true;
  }

  public function rules()
  {

    return [
      'city_id' => 'required|integer',
      'name' => 'required|min:6|max:30|regex:/^[A-Z][a-zA-Z ]*$/',
      'quality' => 'required|integer|min:0|max:10',
      'address' => 'required|min:6|max:50|regex:/^[a-zA-Z0-9\-\.\, ]*$/',
      'email' => 'required|unique:hotels,email|min:10|max:30|email',
      'phone' => 'required|min:10|max:12|regex:/^0[0-9]*$/',
      'description' => 'required|min:10|max:200|regex:/^[a-zA-Z0-9\-\.\, ]*$/'
    ];
  }
}
