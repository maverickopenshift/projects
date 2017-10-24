<?php
Route::group(['middleware' => ['web','auth'], 'prefix' => 'supplier', 'namespace' => 'Modules\Supplier\Http\Controllers'], function()
{
    
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


    Route::get('/', 'SupplierController@index')->name('supplier');
    Route::get('/data', 'SupplierController@data')->name('supplier.data');
    Route::post('/store', 'SupplierController@store')->name('supplier.store');
    Route::get('/create', 'SupplierController@create')->name('supplier.create');
    Route::get('/{id}/edit', 'SupplierController@edit')->name('supplier.edit');
    Route::post('/update', 'SupplierController@update')->name('supplier.update');
    Route::get('/legal-dokumen/{filename}', function ($filename){
        $path = storage_path('app/supplier/legal_dokumen/' . $filename);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    })->name('supplier.legaldokumen.file');
    Route::get('/sertifikat/{filename}', function ($filename){
        $path = storage_path('app/supplier/sertifikat_dokumen/' . $filename);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    })->name('supplier.sertifikat.file');
});
