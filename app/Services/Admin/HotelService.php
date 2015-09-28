<?php

namespace HotelBooking\Services\Admin;

use HotelBooking\Hotel;

class HotelService
{

  public static function save($request){
    $hotel = new Hotel;

    $hotel -> city_id = $request["city_id"];
    $hotel -> name = $request["name"];
    $hotel -> quality = $request["quality"];
    $hotel -> address = $request["address"];
    $hotel -> phone = $request["phone"];
    $hotel -> email = $request["email"];
    $hotel -> description = $request["description"];

    $hotel -> save();

    return $hotel;
  }

  public static function update($request, $id){
    $hotel = Hotel::findOrFail($id);

    $hotel -> city_id = $request["city_id"];
    $hotel -> name = $request["name"];
    $hotel -> quality = $request["quality"];
    $hotel -> address = $request["address"];
    $hotel -> phone = $request["phone"];
    $hotel -> email = $request["email"];
    $hotel -> website = $request["website"];
    $hotel -> description = $request["description"];

    $hotel -> save();

    return $hotel;
  }

  public static function cities(){
    $cities = array(
      'cities' => [
        1 => 'Danang',
        2 => 'Hanoi',
        3 => 'HCM city'
      ]
    );
    return $cities;
  }

}
