<?php
/**
 * Routes for admin pages
 */
Route::GET('admin/login',['as'=>'admin.login','uses'=>'Admin\AdminAuthController@getLoginAdmin']);
Route::POST('admin/login',['as'=>'admin.login','uses'=>'Admin\AdminAuthController@postLoginAdmin']);

Route::group(['middleware' => ['auth.admin']], function () {
    Route::GET('admin',['as'=>'admin.index','uses'=>'Admin\AdminBaseController@index']);
    Route::GET('admin/logout',['as'=>'admin.logout','uses'=>'Admin\AdminAuthController@getAdminLogout']);
    Route::GET('admin/edit-profile',['as'=>'admin.edit.profile','uses'=>'Admin\AdminUserController@getEditProfile']);
    Route::PUT('admin/edit-profile',['as'=>'admin.edit.profile','uses'=>'Admin\AdminUserController@putEditProfile']);
});
