<?php
Route::group(['middleware' => ['web','auth'], 'prefix' => 'supplier', 'namespace' => 'Modules\Supplier\Http\Controllers'], function()
{
    Route::resource('/','SupplierController', [
        'names' => [
            'index' => 'supplier',
            'store' => 'supplier.store',
            'create' => 'supplier.create',
            'data' => 'supplier.data',
            'show' => 'supplier.show',
            'edit' => 'supplier.edit',
            'update' => 'supplier.update',
            'destroy' => 'supplier.destroy',
            // etc...
        ]
    ]);

    Route::get('/klasifikasiusaha', 'KlasifikasiUsahaController@index')->name('supplier.klasifikasi');
    Route::get('/klasifikasiusaha/getselect', 'KlasifikasiUsahaController@getSelect')->name('supplier.klasifikasi.getselect');
    Route::get('/klasifikasiusaha/data', 'KlasifikasiUsahaController@data')->name('supplier.klasifikasi.data');
    Route::post('/klasifikasiusaha/update', 'KlasifikasiUsahaController@update')->name('supplier.klasifikasi.update');
    Route::post('/klasifikasiusaha/add', 'KlasifikasiUsahaController@add')->name('supplier.klasifikasi.add');
    Route::delete('/klasifikasiusaha/delete', 'KlasifikasiUsahaController@delete')->name('supplier.klasifikasi.delete');


    Route::get('/badanusaha', 'BadanUsahaController@index')->name('supplier.badanusaha');
    Route::get('/badanusaha/data', 'BadanUsahaController@data')->name('supplier.badanusaha.data');
    Route::post('/badanusaha/update', 'BadanUsahaController@update')->name('supplier.badanusaha.update');
    Route::post('/badanusaha/add', 'BadanUsahaController@add')->name('supplier.badanusaha.add');
    Route::delete('/badanusaha/delete', 'BadanUsahaController@delete')->name('supplier.badanusaha.delete');


    // Route::get('/', 'SupplierController@index')->name('supplier');
    Route::get('/data', 'SupplierController@data')->name('supplier.data');
    // Route::get('/create', 'RegisterController@data')->name('supplier.create');
    //Route::resource('register','RegisterController',['as'=>'supplier']);
});
