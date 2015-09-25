<?php
/**
 * Routes for admin pages
 */
Route::GET('admin/login',['as'=>'admin.login','uses'=>'Admin\AuthController@getLoginAdmin']);
Route::POST('admin/login',['as'=>'admin.login','uses'=>'Admin\AuthController@postLoginAdmin']);

Route::group(['middleware' => ['auth.admin']], function () {
    Route::GET('admin',['as'=>'admin.index','uses'=>'Admin\AdminBaseController@index']);
    Route::GET('admin/logout',['as'=>'admin.logout','uses'=>'Admin\AuthController@getAdminLogout']);
    Route::GET('admin/edit-profile',['as'=>'admin.edit.profile','uses'=>'Admin\UserController@getEditProfile']);
    Route::PUT('admin/edit-profile',['as'=>'admin.edit.profile','uses'=>'Admin\UserController@putEditProfile']);
});
