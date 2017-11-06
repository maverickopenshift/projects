<?php
Route::group(['middleware' => ['web','auth'], 'prefix' => 'supplier', 'namespace' => 'Modules\Supplier\Http\Controllers'], function()
{

    Route::get('/klasifikasiusaha', ['middleware' => ['permission:lihat-klasifikasi-usaha'],'uses' => 'KlasifikasiUsahaController@index'])->name('supplier.klasifikasi');
    Route::get('/klasifikasiusaha/getselect', 'KlasifikasiUsahaController@getSelect')->name('supplier.klasifikasi.getselect');
    Route::get('/klasifikasiusaha/data', ['middleware' => ['permission:lihat-klasifikasi-usaha'],'uses' => 'KlasifikasiUsahaController@data'])->name('supplier.klasifikasi.data');
    Route::post('/klasifikasiusaha/update', ['middleware' => ['permission:ubah-klasifikasi-usaha'],'uses' => 'KlasifikasiUsahaController@update'])->name('supplier.klasifikasi.update');
    Route::post('/klasifikasiusaha/add', ['middleware' => ['permission:tambah-klasifikasi-usaha'],'uses' => 'KlasifikasiUsahaController@add'])->name('supplier.klasifikasi.add');
    Route::delete('/klasifikasiusaha/delete', ['middleware' => ['permission:hapus-klasifikasi-usaha'],'uses' => 'KlasifikasiUsahaController@delete'])->name('supplier.klasifikasi.delete');


    Route::get('/badanusaha', ['middleware' => ['permission:lihat-badan-usaha'],'uses' => 'BadanUsahaController@index'])->name('supplier.badanusaha');
    Route::get('/badanusaha/data', ['middleware' => ['permission:lihat-badan-usaha'],'uses' => 'BadanUsahaController@data'])->name('supplier.badanusaha.data');
    Route::post('/badanusaha/update', ['middleware' => ['permission:lihat-badan-usaha'],'uses' => 'BadanUsahaController@update'])->name('supplier.badanusaha.update');
    Route::post('/badanusaha/add', ['middleware' => ['permission:lihat-badan-usaha'],'uses' => 'BadanUsahaController@add'])->name('supplier.badanusaha.add');
    Route::delete('/badanusaha/delete', ['middleware' => ['permission:lihat-badan-usaha'],'uses' => 'BadanUsahaController@delete'])->name('supplier.badanusaha.delete');


    Route::get('/', ['middleware' => ['permission:lihat-supplier'],'uses' => 'SupplierController@index'])->name('supplier');
    Route::get('/data', ['middleware' => ['permission:lihat-supplier'],'uses' => 'SupplierController@data'])->name('supplier.data');
    Route::post('/store', ['middleware' => ['permission:tambah-supplier'],'uses' => 'SupplierAddController@store'])->name('supplier.store');
    Route::get('/create', ['middleware' => ['permission:tambah-supplier'],'uses' => 'SupplierAddController@index'])->name('supplier.create');
    Route::get('/{id}/edit', ['middleware' => ['permission:ubah-supplier'],'uses' => 'SupplierEditController@index'])->name('supplier.edit');
    Route::post('/editstatus', ['middleware' => ['permission:ubah-supplier'],'uses' => 'SupplierEditController@editstatus'])->name('supplier.editstatus');
    Route::post('/update', ['middleware' => ['permission:ubah-supplier'],'uses' => 'SupplierEditController@update'])->name('supplier.update');
    Route::get('/get-select', 'SupplierController@getSelect')->name('supplier.get-select');

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
