<?php
/**
 * Routes for admin pages
 */

//Route call page display list admin hotel
Route::get('admin-hotel/index',['as'=>'adminhotel.index','uses'=>'Admin\AdminHotelController@index']);
//Route call detele a admin hotel with id
Route::delete('delete/{id}',['as'=>'adminhotel.destroy','uses'=>'Admin\AdminHotelController@destroy']);
