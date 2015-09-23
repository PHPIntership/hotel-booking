<?php
/**
 * Routes for admin pages
 */

Route::GET('admin/login',['as'=>'admin.login','uses'=>'Admin\AdminAuthController@getLoginAdmin']);
Route::POST('admin/login',['as'=>'admin.login','uses'=>'Admin\AdminAuthController@postLoginAdmin']);

Route::group(['middleware' => ['auth.admin']], function () {
    Route::GET('admin',['as'=>'admin.index','uses'=>'Admin\AdminAuthController@index']);
    Route::GET('admin/logout',['as'=>'admin.logout','uses'=>'Admin\AdminAuthController@getAdminLogout']);
});
