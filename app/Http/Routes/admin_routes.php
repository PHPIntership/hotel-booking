<?php

/**
 * Routes for admin pages
 */
Route::get('admin', ['as'=>'admin.index','uses'=>'Admin\AdminBaseController@index']);

/**
 * Routes for hotels manager pages
 */
Route::resource('admin/hotel', 'Admin\HotelController');

Route::post('admin/login', [
    'as' => 'admin.login',
    'uses' => 'Admin\AuthController@postLogin',
    ]);
Route::get('admin/login', [
    'as' => 'admin.login',
    'uses' => 'Admin\AuthController@getLogin',
]);
Route::get('admin/logout', [
    'as' => 'admin.logout',
    'uses' => 'Admin\AuthController@getLogout',
]);
Route::group(['middleware' => ['auth.admin']], function () {
    Route::get('admin', [
        'as' => 'admin.index',
        'uses' => 'Admin\AdminBaseController@index',
        ]);
    Route::get('admin/profile/edit', [
        'as' => 'admin.profile.edit',
        'uses' => 'Admin\UserController@getEditProfile', ]);
    Route::put('admin/profile/edit', [
        'as' => 'admin.profile.edit',
        'uses' => 'Admin\UserController@putEditProfile',
        ]);
});

Route::resource('admin-hotel', 'Admin\AdminHotelController');
