<?php

Route::group(['middleware' => 'web', 'prefix' => 'users', 'namespace' => 'Modules\Users\Http\Controllers'], function()
{
    Route::get('/', 'UsersController@index');
    Route::get('/permissions', 'PermissionsController@index')->name('users.permissions');
    Route::get('/permissions/data', 'PermissionsController@data')->name('users.permissions.data');
    Route::post('/permissions/update', 'PermissionsController@update')->name('users.permissions.update');
    Route::post('/permissions/add', 'PermissionsController@add')->name('users.permissions.add');
    Route::delete('/permissions/delete', 'PermissionsController@delete')->name('users.permissions.delete');
});
