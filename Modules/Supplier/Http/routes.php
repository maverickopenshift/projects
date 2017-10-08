<?php
Route::group(['middleware' => 'web', 'prefix' => 'supplier-register', 'namespace' => 'Modules\Supplier\Http\Controllers'], function()
{
    Route::get('/', 'RegisterController@index')->name('supplier.register');
});
Route::group(['middleware' => 'web', 'prefix' => 'supplier', 'namespace' => 'Modules\Supplier\Http\Controllers'], function()
{
    Route::get('/', 'SupplierController@index');
});
