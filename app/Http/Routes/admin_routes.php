<?php

/**
 * Routes for admin pages
 */
Route::get('admin', ['as'=>'admin.index','uses'=>'Admin\AdminBaseController@index']);

/**
 * Routes for hotels manager pages
 */
Route::resource('admin/hotels', 'Admin\HotelsController');

Route::resource('admin-hotel', 'Admin\AdminHotelController');
