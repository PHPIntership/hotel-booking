<?php
/**
 * Routes for admin pages
 */
Route::get('admin', ['as'=>'admin.index','uses'=>'Admin\AdminBaseController@index']);
