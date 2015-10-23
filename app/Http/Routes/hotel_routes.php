<?php

Route::resource('hotel/room', 'Hotel\RoomController');

/*
 * Route for getting hotel admin log in form
 */
Route::get('hotel/login', [
    'as' => 'hotel.login',
    'uses' => 'Hotel\AuthController@getLogin',
]);

/*
 * Route for posting the hotel admin data when log in (Authenticate)
 */
Route::post('hotel/login', [
    'as' => 'hotel.login',
    'uses' => 'Hotel\AuthController@postLogin',
]);

/*
 * Route for hotel admin log out
 */
Route::get('hotel/logout', [
    'as' => 'hotel.logout',
    'uses' => 'Hotel\AuthController@getLogout',
]);

/*
 * Route group for hotel admin edit hotel information.
 */
Route::group(['prefix' => 'hotel'], function () {
    Route::get('profile', [
        'as' => 'hotel.profile',
        'uses' => 'Hotel\HotelController@edit',
    ]);

    Route::post('profile', [
        'as' => 'hotel.profile',
        'uses' => 'Hotel\HotelController@update',
    ]);

    Route::get('checkin/{id}', [
        'as' => 'hotel.checkin',
        'uses' =>'Hotel\CheckInController@checkIn'
    ]);
    Route::put('checkin/{id}', [
        'as' => 'hotel.checkin',
        'uses' =>'Hotel\CheckInController@updateCheckIn'
    ]);

    Route::get('checkout/{id}', [
        'as' => 'hotel.checkout',
        'uses' =>'Hotel\CheckInController@checkOut'
    ]);

    Route::put('checkout/{id}', [
        'as' => 'hotel.checkout',
        'uses' =>'Hotel\CheckInController@updateCheckOut'
    ]);
});

/*
 *Route for hotel room type
 */
Route::resource('hotel/room-type', 'Hotel\RoomTypeController');
