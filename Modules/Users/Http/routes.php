<?php

Route::group(['middleware' => 'web', 'prefix' => 'users', 'namespace' => 'Modules\Users\Http\Controllers'], function()
{
    Route::get('/', 'UsersController@index')->name('users');
    Route::get('/data', 'UsersController@data')->name('users.data');
    Route::post('/update', 'UsersController@update')->name('users.update');
    Route::post('/add', 'UsersController@add')->name('users.add');
    Route::delete('/delete', 'UsersController@delete')->name('users.delete');
    
    
    Route::get('/permissions', 'PermissionsController@index')->name('users.permissions');
    Route::get('/permissions/data', 'PermissionsController@data')->name('users.permissions.data');
    Route::post('/permissions/update', 'PermissionsController@update')->name('users.permissions.update');
    Route::post('/permissions/add', 'PermissionsController@add')->name('users.permissions.add');
    Route::delete('/permissions/delete', 'PermissionsController@delete')->name('users.permissions.delete');
    
    
    Route::get('/roles', 'RolesController@index')->name('users.roles');
    Route::get('/roles/data', 'RolesController@data')->name('users.roles.data');
    Route::post('/roles/update', 'RolesController@update')->name('users.roles.update');
    Route::post('/roles/add', 'RolesController@add')->name('users.roles.add');
    Route::delete('/roles/delete', 'RolesController@delete')->name('users.roles.delete');
});
