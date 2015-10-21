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
 * Route for user search
 */
Route::get('/search', [
    'as' => 'user.search',
    'uses' => 'Frontend\UserController@getSearch'
]);

/**
 * Route for posting search data
 */
 Route::get('/search-result', [
     'as' => 'user.searchresult',
     'uses' => 'Frontend\UserController@search'
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
