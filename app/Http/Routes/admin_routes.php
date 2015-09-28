<?php
/**
 * Routes for admin pages
 */
Route::get('admin', ['as'=>'admin.index','uses'=>'Admin\AdminBaseController@index']);
Route::resource('admin/hotels', 'Admin\AdminHotelsController');
