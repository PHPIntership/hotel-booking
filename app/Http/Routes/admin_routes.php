<?php
/**
 * Routes for admin pages
 */
Route::POST('admin/login', ['as'=>'admin.login', 'uses'=>'Admin\AuthController@postLogin']);
Route::GET('admin/login', ['as'=>'admin.login', 'uses'=>'Admin\AuthController@getLogin']);
Route::GET('admin/logout', ['as'=>'admin.logout', 'uses'=>'Admin\AuthController@getLogout']);
Route::group(['middleware' => ['auth.admin']], function () {
    Route::GET('admin', ['as'=>'admin.index', 'uses'=>'Admin\AdminBaseController@index']);
    Route::GET('admin/profile/edit', ['as'=>'admin.edit.profile', 'uses'=>'Admin\UserController@getEditProfile']);
    Route::PUT('admin/profile/edit', ['as'=>'admin.edit.profile', 'uses'=>'Admin\UserController@putEditProfile']);
});
