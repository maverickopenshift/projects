<?php

Route::group(['middleware' => 'web', 'prefix' => 'usersupplier', 'namespace' => 'Modules\UserSupplier\Http\Controllers'], function()
{
    Route::get('/', 'UserSupplierController@index')->name('usersupplier');
    Route::get('/register', 'RegisterController@index')->name('usersupplier.register');
    Route::post('/register/add', 'RegisterController@add')->name('usersupplier.add');
    Route::get('/NotifEmail', 'RegisterController@NotifEmail')->name('usersupplier.notifemail');

    Route::get('/profileVendor', 'ProfileController@index')->name('profile');
    Route::post('/update', 'ProfileController@update')->name('profile.update');

    Route::get('/dataSupplier', 'DataSupplierController@index')->name('supplier.list');
    Route::get('/dataSupplier/data', 'DataSupplierController@data')->name('supplier.isi');
    Route::get('/kelengkapanData', 'DataSupplierController@tambah')->name('supplier.tambah');
    Route::get('/tambah', 'DataSupplierController@add')->name('supplier.insert');
});
