<?php

/*
 * Routes for frontend pages
 */


 /**
  * Route group for user login and logout
  */
Route::group(['prefix' => 'user'], function () {
    Route::post('login', [
        'as' => 'user.login',
        'uses' => 'Frontend\AuthController@postLogin'
    ]);

    Route::get('logout', [
        'as' => 'user.logout',
        'uses' => 'Frontend\AuthController@getLogout'
    ]);
});

/**
 * Temp route for testing homepage. Need replace later
 */
Route::get('/', [
    'as' => 'user.index',
    'uses' => function () {
        return view('layouts.frontend');
    }
]);
