<?php

/*
 * Routes for frontend pages
 */



/**
* Route for user login
*/
Route::post('login', [
    'as' => 'user.login',
    'uses' => 'Frontend\AuthController@postLogin'
]);

/**
 * Route for user logout
 */
Route::get('logout', [
    'as' => 'user.logout',
    'uses' => 'Frontend\AuthController@getLogout'
]);


/**
 * Temp route for testing homepage. Need replace later
 */
Route::get('/', [
    'as' => 'user.index',
    'uses' => function () {
        return view('layouts.frontend');
    }
]);

/**
 * Route group for order pages.
 */
Route::group(['prefix' => 'order'], function () {
    Route::get('', [
        'as' => 'order.index',
        'uses' => 'Frontend\OrderController@index',
    ]);
    Route::get('{hotelRoomTypeId}', [
        'as' => 'order.load',
        'uses' => 'Frontend\OrderController@load',
    ]);
    Route::post('store', [
        'as' => 'order.store',
        'uses' => 'Frontend\OrderController@store',
    ]);
});

/**
 * Route for getting register form
 */
Route::get('/register', [
    'as' => 'user.register',
    'uses' => 'Frontend\AuthController@getRegister'
]);

/**
 * Route for posting register form data
 */
Route::post('/register', [
    'as' => 'user.register',
    'uses' => 'Frontend\AuthController@postRegister'
]);
/**
 * Route for profile user
 */
Route::get('profile', [
    'as' => 'user.profile',
    'uses' => 'Frontend\ProfileController@getProfile'
]);
Route::put('profile', [
    'as' => 'user.profile',
    'uses' => 'Frontend\ProfileController@putProfile'
]);
