<?php
/**
 * Routes for admin pages
 */
Route::get('admin-hotel/create', [
	'as'   => 'admin-hotel.create',
	'uses' => 'Admin\AdminHotelController@create'
]);

Route::post('admin-hotel/create', [
	'as'   => 'admin-hotel.store',
	'uses' => 'Admin\AdminHotelController@store'
]);

Route::get('admin-hotel/{id}/edit', [
	'as'   =>  'admin-hotel.edit',
	'uses' =>  'Admin\AdminHotelController@edit'
	]);

Route::put('admin-hotel/{id}', [
	'as'   =>  'admin-hotel.update',
	'uses' =>  'Admin\AdminHotelController@update'
	]);
