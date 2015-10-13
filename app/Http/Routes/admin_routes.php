<?php

/**
 * Routes for admin pages.
 */
Route::get('admin', [
    'as' => 'admin.index',
    'uses' => 'Admin\AdminBaseController@index',
    ]);

/*
 * Routes for hotels manager pages
 */
Route::resource('admin/hotel', 'Admin\HotelController');

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

Route::resource('admin-hotel', 'Admin\AdminHotelController');

Route::resource('admin/room-type', 'Admin\RoomTypeController');
