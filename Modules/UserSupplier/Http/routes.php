<?php

Route::group(['middleware' => 'web', 'prefix' => 'usersupplier', 'namespace' => 'Modules\UserSupplier\Http\Controllers'], function()
{
    Route::get('/', 'UserSupplierController@index')->name('usersupplier');
    Route::get('/register', 'RegisterController@index')->name('usersupplier.register');
    Route::post('/register/add', 'RegisterController@add')->name('usersupplier.add');

    Route::get('/profileVendor', 'ProfileController@index')->name('profile');
});
