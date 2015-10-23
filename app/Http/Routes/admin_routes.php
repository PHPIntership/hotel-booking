<?php

/**
 * Routes for admin pages.
 */
Route::get('admin', [
    'as' => 'admin.index',
    'uses' => 'Admin\AdminBaseController@index',
    ]);

Route::group(['prefix' => 'admin'], function () {
    Route::get('login', [
        'as' => 'admin.login',
        'uses' => 'Admin\AuthController@getLogin',
     ]);
    Route::post('login', [
        'as' => 'admin.login',
        'uses' => 'Admin\AuthController@postLogin',
    ]);
    Route::get('logout', [
        'as' => 'admin.logout',
        'uses' => 'Admin\AuthController@getLogout',
    ]);
});

Route::group(['middleware' => ['auth.admin']], function () {
    Route::get('admin', [
        'as' => 'admin.index',
        'uses' => 'Admin\AdminBaseController@index',
        ]);
        Route::group(['prefix' => 'admin'], function () {
            Route::get('profile', [
                'as' => 'admin.profile.edit',
                'uses' => 'Admin\AdminUserController@getEditProfile',
            ]);
            Route::put('profile', [
                'as' => 'admin.profile.edit',
                'uses' => 'Admin\AdminUserController@putEditProfile',
            ]);
        });
});

/**
 * Route group for adding auththenticate middleware
 */
Route::group(['middleware' => ['auth.admin']], function () {
    /*
     * Routes for hotels manager pages
     */
    Route::resource('admin/hotel', 'Admin\HotelController');

    /**
     * Route resource for manage hotel admins
     */
    Route::resource('admin-hotel', 'Admin\AdminHotelController');

    /**
     * Route resource for manage room type
     */
    Route::resource('admin/room-type', 'Admin\RoomTypeController');

    /**
     * Route resource for manage users
     */
    Route::resource('admin/user', 'Admin\UserController');
});
