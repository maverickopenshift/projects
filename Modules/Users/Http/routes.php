<?php

Route::group(['middleware' => ['web','auth'], 'prefix' => 'users', 'namespace' => 'Modules\Users\Http\Controllers'], function()
{

    Route::get('/', ['middleware' => ['permission:lihat-user'],'uses' => 'UsersController@index'])->name('users');
    Route::post('/data', ['middleware' => ['permission:lihat-user'],'uses' => 'UsersController@data'])->name('users.data');
    Route::post('/update', ['middleware' => ['permission:ubah-user'],'uses' => 'UsersController@update'])->name('users.update');
    Route::get('/reset-user',  ['middleware' => ['permission:ubah-user'],'uses' => 'UsersController@reset'])->name('users.reset');
    Route::post('/add', ['middleware' => ['permission:tambah-user'],'uses' => 'UsersController@add'])->name('users.add');
    Route::delete('/delete', ['middleware' => ['permission:hapus-user'],'uses' => 'UsersController@delete'])->name('users.delete');
    Route::get('/get-select-user-telkom', 'UsersController@getSelectUserTelkom')->name('users.get-select-user-telkom');
    Route::get('/get-select-user-telkom-by-nik', 'UsersController@getSelectUserTelkomByNik')->name('users.get-select-user-telkom-by-nik');
    Route::get('/get-select-user-vendor', 'UsersController@getSelectUserVendor')->name('users.get-select-user-vendor');
    Route::get('/get-select-konseptor', 'UsersController@getSelectKonseptor')->name('users.get-select-konseptor');
    Route::get('/get-atasan-by-userid', 'UsersController@getAtasanByUserid')->name('users.get-atasan-by-userid');


    Route::get('/permissions', ['middleware' => ['permission:lihat-permission'],'uses' => 'PermissionsController@index'])
    ->name('users.permissions');
    Route::get('/permissions/data',['middleware' => ['permission:lihat-permission'],'uses' => 'PermissionsController@data'])
    ->name('users.permissions.data');
    Route::post('/permissions/update', ['middleware' => ['permission:ubah-permission'],'uses' => 'PermissionsController@update'])
    ->name('users.permissions.update');
    Route::post('/permissions/add', ['middleware' => ['permission:tambah-permission'],'uses' => 'PermissionsController@add'])
    ->name('users.permissions.add');
    Route::delete('/permissions/delete', ['middleware' => ['permission:hapus-permission'],'uses' => 'PermissionsController@delete'])
    ->name('users.permissions.delete');


    Route::get('/roles', ['middleware' => ['permission:lihat-role'],'uses' => 'RolesController@index'])->name('users.roles');
    Route::post('/roles/data',['middleware' => ['permission:lihat-role'],'uses' => 'RolesController@data'])->name('users.roles.data');
    Route::post('/roles/update',['middleware' => ['permission:ubah-role'],'uses' => 'RolesController@update'])->name('users.roles.update');
    Route::post('/roles/add', ['middleware' => ['permission:tambah-role'],'uses' => 'RolesController@add'])->name('users.roles.add');
    Route::delete('/roles/delete',['middleware' => ['permission:hapus-role'],'uses' => 'RolesController@delete'])->name('users.roles.delete');
});
