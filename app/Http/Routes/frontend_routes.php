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
 *
 * Route group for order pages.
 */
Route::group(['prefix' => 'order'], function () {
    Route::get('history', [
        'as' => 'order.history',
        'uses' => 'Frontend\OrderController@history',
    ]);
    Route::get('', [
        'as' => 'order.create',
        'uses' => 'Frontend\OrderController@create',
    ]);
    Route::post('store', [
        'as' => 'order.store',
        'uses' => 'Frontend\OrderController@store',
    ]);
});

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
