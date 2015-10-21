<?php

namespace HotelBooking\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use HotelBooking\Http\Requests\Frontend\SearchRequest;
use HotelBooking\Http\City;
use HotelBooking\HotelRoomType;
use HotelBooking\RoomType;
use HotelBooking\Hotel;
use HotelBooking\Order;
use DB;

/**
 * Controller for user.
 */
class UserController extends FrontendBaseController
{
    /**
     * The number of result per page to display.
     */
    const NUMBER_OF_RESULT = 5;

    /**
     * Get the search form.
     *
     * @return [view]
     */
    public function getSearch()
    {
        $cities = DB::table('cities')->lists('name', 'id');
        $roomTypes = DB::table('room_types')->lists('name', 'id');

        return view('frontend.search', compact('cities', 'roomTypes'));
    }

    /**
     * Getting the search data.
     *
     * @param SearchRequest $request
     *
     * @return [view]
     */
    public function search(SearchRequest $request)
    {
        // Get data from request
        $city = $request->input('city');
        $roomType = $request->input('roomtype');
        $comingDate = date('Y-m-d', strtotime($request->input('coming_date')));
        $leaveDate = date('Y-m-d', strtotime($request->input('leave_date')));
        $page = $request->input('page');

        // Retrieve search result
        $results = $this->getResult($city, $roomType);

        // Get the id list from the result for checking orders.
        $hotelRoomTypeids = [];
        foreach ($results as $key => $result) {
            $hotelRoomTypeids[$key] = $result->id;
        }

        // Get the orders of the hotels that in the result list
         $orders = $this->getOrdersOfHotels($hotelRoomTypeids, $comingDate, $leaveDate);

        // Set avaiable quantity of room type of each hotel for showing.
        $this->setAvaiableQuantity($results, $orders);

        // Paginating the search result
        $paginateResult = $this->paginate($results, $page);

        $totalPages = $results->count() / self::NUMBER_OF_RESULT;

        // return view
        $cities = DB::table('cities')->lists('name', 'id');
        $roomTypes = DB::table('room_types')->lists('name', 'id');

        return view('frontend.search', compact('cities', 'roomTypes', 'paginateResult', 'totalPages'));
    }

    /**
     * Get orders of hotels.
     *
     * @param [array]  $hotelRoomTypeids [array of hotel room type id]
     * @param [string] $comingDate       [the coming date]
     * @param [string] $leaveDate        [the leaving date]
     *
     * @return [array] [the array content orders that conflick the given time]
     */
    public function getOrdersOfHotels($hotelRoomTypeids, $comingDate, $leaveDate)
    {
        $orders = Order::select('hotel_room_type_id', 'quantity')
            ->where('status', '<', 3)
            ->whereIn('hotel_room_type_id', $hotelRoomTypeids)
            ->where(function ($query) use ($comingDate, $leaveDate) {
                $query->whereBetween('leave_date', [$comingDate, $leaveDate])
                    ->OrWhereBetween('coming_date', [$comingDate, $leaveDate])
                    ->OrWhere(function ($query) use ($comingDate, $leaveDate) {
                        $query->where('coming_date', '<=', $comingDate)
                            ->where('leave_date', '>=', $leaveDate);
                    });
            })->get();

        return $orders;
    }

    /**
     * Retrieve search result base on city and roomtype.
     *
     * @param [int] $city     [city id]
     * @param [int] $roomType [roomtype id]
     *
     * @return [collection] [description]
     */
    public function getResult($city, $roomType)
    {
        // Get the id list of hotels that locate in the city which the user is searching
        $hotelsId = Hotel::where('city_id', $city)
            ->lists('id');

        // Get the hotel room type result that the user is looking for.

        $with['hotel'] = function ($query) {
            $hotelColunms = ['id', 'name', 'quality', 'address', 'email', 'phone', 'image'];
            $query->select($hotelColunms);
        };
        $roomTypeColumns = ['id', 'name', 'hotel_id', 'quality', 'quantity', 'price', 'image', 'description'];
        $results = HotelRoomType::with($with)
            ->select($roomTypeColumns)
            ->where('room_type_id', $roomType)
            ->whereIn('hotel_id', $hotelsId)
            ->get();

        return $results;
    }

    /**
     * Paginate the results for displaying.
     *
     * @param [collection] $results
     * @param [int]        $page    [the current result page]
     *
     * @return [array] [the array of results have been paginated]
     */
    public function paginate($results, $page)
    {
        $startIndex = $page * self::NUMBER_OF_RESULT;
        $paginateResult = [];
        foreach ($results as $key => $result) {
            if ($startIndex <= $key && $key < ($startIndex + self::NUMBER_OF_RESULT)) {
                array_push($paginateResult, $result);
            }
        }

        return $paginateResult;
    }

    /**
     * Set the real avaiable quantity of hotel roomtype.
     * @param [collection] $results
     * @param [array] $orders
     */
    public function setAvaiableQuantity($results, $orders)
    {
        foreach ($results as $result) {
            $result->avaiable_quantity = $result->quantity;
            foreach ($orders as $order) {
                if ($result->id == $order->hotel_room_type_id) {
                    $result->avaiable_quantity -= $order->quantity;
                }
            }
        }
    }
}
