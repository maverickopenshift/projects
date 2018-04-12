<?php
Route::group(['middleware' => ['web','auth'], 'prefix' => 'supplier', 'namespace' => 'Modules\Supplier\Http\Controllers'], function()
{

    Route::get('/klasifikasiusaha', ['middleware' => ['permission:lihat-klasifikasi-usaha'],'uses' => 'KlasifikasiUsahaController@index'])->name('supplier.klasifikasi');
    Route::get('/klasifikasiusaha/getselect', 'KlasifikasiUsahaController@getSelect')->name('supplier.klasifikasi.getselect');
    Route::post('/klasifikasiusaha/data', ['middleware' => ['permission:lihat-klasifikasi-usaha'],'uses' => 'KlasifikasiUsahaController@data'])->name('supplier.klasifikasi.data');
    Route::post('/klasifikasiusaha/update', ['middleware' => ['permission:ubah-klasifikasi-usaha'],'uses' => 'KlasifikasiUsahaController@update'])->name('supplier.klasifikasi.update');
    Route::post('/klasifikasiusaha/add', ['middleware' => ['permission:tambah-klasifikasi-usaha'],'uses' => 'KlasifikasiUsahaController@add'])->name('supplier.klasifikasi.add');
    Route::delete('/klasifikasiusaha/delete', ['middleware' => ['permission:hapus-klasifikasi-usaha'],'uses' => 'KlasifikasiUsahaController@delete'])->name('supplier.klasifikasi.delete');
    Route::get('/get-klasifikasi', 'KlasifikasiUsahaController@getSelect')->name('supplier.get-klasifikasi');

    Route::get('/badanusaha', ['middleware' => ['permission:lihat-badan-usaha'],'uses' => 'BadanUsahaController@index'])->name('supplier.badanusaha');
    Route::post('/badanusaha/data', ['middleware' => ['permission:lihat-badan-usaha'],'uses' => 'BadanUsahaController@data'])->name('supplier.badanusaha.data');
    Route::post('/badanusaha/update', ['middleware' => ['permission:lihat-badan-usaha'],'uses' => 'BadanUsahaController@update'])->name('supplier.badanusaha.update');
    Route::post('/badanusaha/add', ['middleware' => ['permission:lihat-badan-usaha'],'uses' => 'BadanUsahaController@add'])->name('supplier.badanusaha.add');
    Route::delete('/badanusaha/delete', ['middleware' => ['permission:lihat-badan-usaha'],'uses' => 'BadanUsahaController@delete'])->name('supplier.badanusaha.delete');

    Route::get('/status/{status}', ['middleware' => ['permission:lihat-supplier'],'uses' => 'SupplierController@index'])->name('supplier');
    Route::get('/data/{status}', ['middleware' => ['permission:lihat-supplier'],'uses' => 'SupplierController@data'])->name('supplier.data');
    //////
    Route::post('/store', ['middleware' => ['permission:tambah-supplier'],'uses' => 'SupplierAddController@store'])->name('supplier.store');
    Route::post('/store_ajax', ['middleware' => ['permission:tambah-supplier'],'uses' => 'SupplierAddController@store_ajax'])->name('supplier.store_ajax');
    //////

    Route::get('/create', ['middleware' => ['permission:tambah-supplier'],'uses' => 'SupplierAddController@index'])->name('supplier.create');
    // Route::get('/{id}/{status}', ['middleware' => ['permission:ubah-supplier'],'uses' => 'SupplierEditController@index'])->name('supplier.edit');
    Route::get('/{id}/{status}', ['middleware' => ['permission:ubah-supplier'],'uses' => 'SupplierEditController@index'])->name('supplier.lihat');
    Route::post('/editstatus', ['middleware' => ['permission:ubah-supplier'],'uses' => 'SupplierEditController@editstatus'])->name('supplier.editstatus');
    Route::post('/return', ['middleware' => ['permission:ubah-supplier'],'uses' => 'SupplierEditController@return'])->name('supplier.return');
    //////
    Route::post('/update', ['middleware' => ['permission:ubah-supplier'],'uses' => 'SupplierEditController@update'])->name('supplier.update');
    Route::post('/update_ajax', ['middleware' => ['permission:ubah-supplier'],'uses' => 'SupplierEditController@update_ajax'])->name('supplier.update_ajax');
    //////
    Route::get('/get-select', 'SupplierController@getSelect')->name('supplier.get-select');
    Route::get('/cari-supplier', ['middleware' => ['permission:lihat-supplier'],'uses' => 'SupplierController@filtersupplier'])->name('supplier.filter');
    Route::post('/smile-upload', ['middleware' => ['permission:tambah-supplier'],'uses' => 'UploadSapController@uploadsmile'])->name('supplier.upload.smile');

    Route::get('/sap', ['middleware' => ['permission:lihat-supplier'],'uses' => 'SupplierSapController@index'])->name('suppliersap');
    Route::post('/sap-data', ['middleware' => ['permission:lihat-supplier'],'uses' => 'SupplierSapController@data'])->name('supplier.sap.data');
    Route::get('/sap-lihat-{id}', ['middleware' => ['permission:ubah-supplier'],'uses' => 'SupplierSapController@lihat'])->name('supplier.sap.lihat');
    Route::post('/sap-upload', ['middleware' => ['permission:tambah-supplier'],'uses' => 'UploadSapController@store'])->name('supplier.upload.sap');
    Route::get('/sap-mapping-{id}', ['middleware' => ['permission:ubah-supplier'],'uses' => 'MappingSapController@index'])->name('supplier.mapping.sap');
    Route::post('/mapping-simpan', ['middleware' => ['permission:ubah-supplier'],'uses' => 'MappingSapController@simpan'])->name('supplier.mapping.simpan');
    Route::post('/mapping-hapus', ['middleware' => ['permission:ubah-supplier'],'uses' => 'MappingSapController@hapus'])->name('supplier.hapus.mapping');

    Route::get('/comments', ['middleware' => ['permission:ubah-supplier'],'uses' => 'SupplierCommentController@comments'])->name('sup.comments');
    Route::get('/dmt-{id}', ['middleware' => ['permission:cetak-dmt'],'uses' => 'CetakDmtController@pdf'])->name('supplier.cetak.dmt');
    Route::get('/reprint-dmt-{id}', ['middleware' => ['permission:cetak-dmt'],'uses' => 'CetakDmtController@pdfUlang'])->name('supplier.cetak.ulang.dmt');

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

    Route::get('/template-{filename}', function ($filename){
        $path = public_path('template/template_' . $filename.'.csv');

        if (!File::exists($path)) {
            abort(404);
        }

        $type = File::mimeType($path);
        $headers = array(
             'Content-Type: '.$type,
           );
        $name = $filename.'_'.time().'.csv';
        return response()->download($path, $name, $headers);
    })->name('sap.template.download');
});
