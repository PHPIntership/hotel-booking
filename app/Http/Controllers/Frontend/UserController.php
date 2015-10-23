<?php

namespace HotelBooking\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use HotelBooking\Http\Requests\Frontend\SearchRequest;
use HotelBooking\Http\City;
use HotelBooking\HotelRoomType;
use HotelBooking\RoomType;
use HotelBooking\Hotel;
use DB;
use Session;

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

        $keys = [
            'city' => $city,
            'room_type' => $roomType,
            'coming_date' => $comingDate,
            'leave_date' => $leaveDate,
            'offset' => 0,
        ];

        $results = $this->getResult($keys);

        Session::put('coming_date', $comingDate);
        Session::put('leave_date', $leaveDate);
        Session::put('number_of_result', self::NUMBER_OF_RESULT);

        // return view
        $cities = DB::table('cities')->lists('name', 'id');
        $roomTypes = DB::table('room_types')->lists('name', 'id');

        return view('frontend.search', compact('cities', 'roomTypes', 'results'));
    }

    /**
     * Get the search result
     * @param  [array] $keys [search keys]
     * @return [array]
     */
    public function getResult($keys)
    {
        $city = $keys['city'];
        $roomType = $keys['room_type'];
        $comingDate = $keys['coming_date'];
        $leaveDate = $keys['leave_date'];
        $offset = $keys['offset'];

        // SQL query the number of rooms belong to hotel room type that were ordered
        $ordered = DB::table('orders')
        ->select(DB::raw('sum(orders.quantity)'))
        ->whereRaw('orders.hotel_room_type_id = hotel_room_types.id')
        ->where(function ($query) use ($comingDate, $leaveDate) {
            $query->whereRaw("orders.leave_date between '".$comingDate."' and '".$leaveDate."'")
                ->OrWhereRaw("orders.coming_date between '".$comingDate."' and '".$leaveDate."'")
                ->OrWhere(function ($query) use ($comingDate, $leaveDate) {
                    $query->whereRaw("orders.coming_date <= '".$comingDate."'")
                        ->whereRaw("orders.leave_date >= '".$leaveDate."'");
                });
        })->toSql();

        $hotelsId = Hotel::where('city_id', $city)
            ->lists('id');

        // Get the hotel room type result that the user is looking for.
        $with['hotel'] = function ($query) {
            $hotelColunms = ['id', 'name', 'quality', 'address', 'email', 'phone', 'image'];
            $query->select($hotelColunms);
        };
        $roomTypeColumns = ['id', 'hotel_id', 'quality', 'quantity', 'price', 'image', 'description'];
        $roomTypeColumnsRaw = implode(',', $roomTypeColumns);
        $results = HotelRoomType::with($with)
            ->select(DB::raw($roomTypeColumnsRaw.', ('.$ordered.') AS ordered'))
            ->where('room_type_id', $roomType)
            ->whereIn('hotel_id', $hotelsId)
            ->havingRaw('quantity > COALESCE(ordered, 0 )')
            ->skip($offset)
            ->take(self::NUMBER_OF_RESULT)
            ->get();

        return $results;
    }

    /**
     * Load more result
     * @param  SearchRequest $request
     * @return [view]
     */
    public function loadMore(SearchRequest $request)
    {
        $keys = [];
        $keys['city'] = $request->input('city');
        $keys['room_type'] = $request->input('roomtype');
        $keys['coming_date'] = date('Y-m-d', strtotime($request->input('coming_date')));
        $keys['leave_date'] = date('Y-m-d', strtotime($request->input('leave_date')));
        $keys['offset'] = $request->input('offset');
        $results = $this->getResult($keys);

        if ($results->count() > 0) {
            return view('layouts.frontend.partials.search_result', compact('results'));
        } else {
            return '';
        }
    }
}
