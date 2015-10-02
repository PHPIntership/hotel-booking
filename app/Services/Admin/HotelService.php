<?php

namespace HotelBooking\Services\Admin;

use HotelBooking\Hotel;

/**
 * HotelService
 */
class HotelService
{

    /**
     * Create new Hotel from request information and sotre into database
     *
     * @param Request $request
     * @return HotelBooking\Hotel
     */
    public static function store($request)
    {
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

    /**
     * Update Hotel from request information into database
     *
     * @param Request $request
     * @param int $id
     * @return HotelBooking\Hotel
     */
    public static function update($request, $id)
    {
        $hotel = Hotel::findOrFail($id);

        $hotel -> city_id = $request["city_id"];
        $hotel -> name = $request["name"];
        $hotel -> quality = $request["quality"];
        $hotel -> address = $request["address"];
        $hotel -> phone = $request["phone"];
        $hotel -> email = $request["email"];
        $hotel -> website = $request["website"];
        if (isset($request["image"])) {
            $hotel -> image = self::imageUpload($request["image"]);
        }
        $hotel -> description = $request["description"];

        $hotel -> save();

        return $hotel;
    }

    /**
     * Save upload image from request file into uploads folder
     *
     * @param file $file
     * @return string
     */
    private static function imageUpload($file)
    {
        $dir = "uploads/";
        $name = $file->getClientOriginalName();
        while (file_exists($dir.$name)) {
            $name = (rand(10, 99))."_".$name;
        }
        $file->move($dir, $name);
        return $name;
    }
}
