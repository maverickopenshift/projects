<?php

Route::group(['middleware' => 'web', 'prefix' => 'usersupplier', 'namespace' => 'Modules\UserSupplier\Http\Controllers'], function()
{
  Route::get('/', 'UserSupplierController@index')->name('usersupplier');
  Route::get('/register', 'RegisterController@index')->name('usersupplier.register');

  Route::get('/register/add', 'RegisterController@add')  ->name('usersupplier.add');
  Route::get('/NotifEmail', ['middleware' => ['role:vendor'],'uses' => 'RegisterController@NotifEmail'])
  ->name('usersupplier.notifemail');



  Route::get('/profileVendor', ['middleware' => ['role:vendor'],'uses' => 'ProfileController@index'])
  ->name('profile');
  Route::post('/update', ['middleware' => ['role:vendor'],'uses' => 'ProfileController@update'])
  ->name('profile.update');

  Route::get('/dataSupplier', ['middleware' => ['role:vendor'],'uses' => 'DataSupplierController@index'])
  ->name('supplier.list');
  
  Route::get('/dataSupplier/data', ['middleware' => ['role:vendor'],'uses' => 'DataSupplierController@data'])
  ->name('supplier.isi');
  Route::get('/kelengkapanData', ['middleware' => ['role:vendor'],'uses' => 'DataSupplierController@tambah'])
  ->name('supplier.tambah');
  Route::post('/tambah', ['middleware' => ['role:vendor'],'uses' => 'DataSupplierController@add'])
  ->name('supplier.insert');

  Route::post('/updatedata', ['middleware' => ['role:vendor'],'uses' => 'DataSupplierController@update'])
  ->name('usersupplier.update');
});
