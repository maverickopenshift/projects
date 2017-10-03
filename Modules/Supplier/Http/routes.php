<?php

Route::group(['middleware' => 'web', 'prefix' => 'supplier', 'namespace' => 'Modules\Supplier\Http\Controllers'], function()
{
    Route::get('/', 'SupplierController@index');
});
