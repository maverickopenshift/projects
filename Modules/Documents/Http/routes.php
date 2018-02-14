<?php

Route::group(['middleware' => ['web','auth'], 'prefix' => 'documents', 'namespace' => 'Modules\Documents\Http\Controllers'], function()
{
    Route::get('/status/{status}', ['middleware' => ['permission:lihat-kontrak'],'uses' => 'DocumentsController@index'])->name('doc');
    Route::get('/child', ['middleware' => ['permission:lihat-kontrak'],'uses' => 'DocumentsController@index'])->name('doc.child');
    Route::get('/create/{type}', ['middleware' => ['permission:tambah-kontrak'],'uses' => 'EntryDocumentController@index'])->name('doc.create');
    Route::post('/store/{type}',['middleware' => ['permission:tambah-kontrak'],'uses' => 'EntryDocumentController@store'])->name('doc.store');
    // test edit ajax
    Route::post('/store_ajax/{type}',['middleware' => ['permission:tambah-kontrak'],'uses' => 'EntryDocumentController@store_ajax'])->name('doc.store_ajax');
    Route::post('/doc/upload/sow_boq', ['middleware' => ['permission:tambah-kontrak'],'uses' => 'DocumentsController@upload_boq'])->name('doc.upload_sow_boq');
    Route::post('/doc/upload/sow_boq_hargasatuan', ['middleware' => ['permission:tambah-kontrak'],'uses' => 'DocumentsController@upload_boq_harga_satuan'])->name('doc.upload_sow_boq_harga_satuan');
    // test edit ajax
    Route::get('/view/{type}/{id}/', ['middleware' => ['permission:lihat-kontrak'],'uses' => 'DocumentsController@view'])->name('doc.view');
    Route::get('/edit/{type}/{id}/', ['middleware' => ['permission:ubah-kontrak'],'uses' => 'EditController@index'])->name('doc.edit');
    Route::post('/storeedit/{type}/{id}/', ['middleware' => ['permission:ubah-kontrak'],'uses' => 'EditController@store'])->name('doc.storeedit');
    // test edit ajax
    Route::post('/storeedit_ajax/{type}/{id}/', ['middleware' => ['permission:ubah-kontrak'],'uses' => 'EditController@store_ajax'])->name('doc.storeedit_ajax');
    // test edit ajax
    Route::post('/approve', ['middleware' => ['permission:approve-kontrak'],'uses' => 'DocumentsController@approve'])->name('doc.approve');
    Route::post('/reject', ['middleware' => ['permission:approve-kontrak'],'uses' => 'DocumentsController@reject'])->name('doc.reject');
    Route::post('/hapus', ['middleware' => ['permission:hapus-kontrak'],'uses' => 'DocumentsController@hapus'])->name('doc.hapus');
    Route::post('/hs-upload', ['middleware' => ['permission:tambah-kontrak'],'uses' => 'EntryDocumentController@upload'])->name('doc.upload.hs');

    Route::get('/getKontrak', ['middleware' => ['permission:approve-kontrak'],'uses' => 'DocumentsController@getKontrak'])->name('doc.getKontrak');
    Route::get('/get-select-kontrak', 'DocumentsController@getSelectKontrak')->name('doc.get-select-kontrak');
    Route::get('/get-select-kontrak-sp', 'DocumentsController@getSelectKontrakSP')->name('doc.get-select-kontrak-sp');
    Route::get('/get-select-sp', 'DocumentsController@getSelectSp')->name('doc.get-select-sp');
    Route::get('/get-po', 'DocumentsController@getPo')->name('doc.get-po');
    Route::get('/get-pic', 'DocumentsController@getPic')->name('doc.get-pic');
    Route::get('/get-posisi', 'DocumentsController@getPosisi')->name('doc.get-posisi');
    Route::get('/get-unit', 'DocumentsController@getUnit')->name('doc.get-unit');

    /////////////

    Route::get('/closing/{type}/{id}/', ['middleware' => ['permission:tutup-kontrak'],'uses' => 'DocumentsClosingController@index'])->name('doc.closing');
    Route::post('/closing/store/{id}',['middleware' => ['permission:tutup-kontrak'],'uses' => 'DocumentsClosingController@create'])->name('doc.closing.store');

    ////////
    
    Route::get('/log-activity', ['middleware' => ['permission:lihat-kontrak|ubah-kontrak|'],'uses' => 'DocLogController@logActivity'])->name('doc.activity');

    Route::get('/comments', ['middleware' => ['permission:lihat-kontrak|ubah-kontrak|'],'uses' => 'DocCommentController@comments'])->name('doc.comments');
    Route::post('/comments/{id}/add', ['middleware' => ['permission:lihat-kontrak|ubah-kontrak|'],'uses' => 'DocCommentController@add'])->name('doc.comment.add');
    Route::post('/comments/{id}/edit', ['middleware' => ['permission:lihat-kontrak|ubah-kontrak|'],'uses' => 'DocCommentController@edit'])->name('doc.comment.edit');
    Route::delete('/comments/delete', ['middleware' => ['permission:lihat-kontrak|ubah-kontrak|'],'uses' => 'DocCommentController@delete'])->name('doc.comment.delete');

    Route::get('/doc-template', ['middleware' => ['permission:lihat-template-pasal-pasal'],'uses' => 'DocTemplateController@index'])->name('doc.template');
    Route::post('/doc-template/data', ['middleware' => ['permission:lihat-template-pasal-pasal'],'uses' => 'DocTemplateController@data'])->name('doc.template.data');
    Route::get('/doc-template/create', ['middleware' => ['permission:tambah-template-pasal-pasal'],'uses' => 'DocTemplateController@create'])->name('doc.template.create');
    Route::post('/doc-template/store', ['middleware' => ['permission:tambah-template-pasal-pasal'],'uses' => 'DocTemplateController@store'])->name('doc.template.store');
    Route::get('/doc-template/storeEdit', ['middleware' => ['permission:tambah-template-pasal-pasal'],'uses' => 'DocTemplateController@storeEdit'])->name('doc.template.storeEdit');
    Route::get('/doc-template/{id}/edit', ['middleware' => ['permission:ubah-template-pasal-pasal'],'uses' => 'DocTemplateController@edit'])->name('doc.template.edit');

    Route::get('/tmp/{filename}', function ($filename){
      $path = public_path('template/template_' . $filename.'.xlsx');

      if (!File::exists($path)) {
          abort(404);
      }

      $type = File::mimeType($path);
      $headers = array(
           'Content-Type: '.$type,
         );
      $name = $filename.'_'.time().'.xlsx';
      return response()->download($path, $name, $headers);
    })->name('doc.tmp.download');

    Route::get('/file/{type}/{filename}', function ($type,$filename){
        $path = storage_path('app/document/'.$type.'/' . $filename);
        //dd($path);
        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    })->name('doc.file');

    Route::get('/file_lt/{type}/{filename}', function ($type,$filename){
        $path = storage_path('app/document/'.$type.'_latar_belakang/' . $filename);
        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    })->name('doc.file.latarbelakang');
    Route::get('/file_lampiran/{type}/{filename}', function ($type,$filename){
        $path = storage_path('app/document/'.$type.'_lampiran_ttd/' . $filename);
        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    })->name('doc.file.lampiran');
    Route::get('/file_asuransi/{type}/{filename}', function ($type,$filename){
        $path = storage_path('app/document/'.$type.'_asuransi/' . $filename);
        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    })->name('doc.file.asuransi');

    Route::get('/file_scope/{type}/{filename}', function ($type,$filename){
        $path = storage_path('app/document/'.$type.'_scope_perubahan/' . $filename);
        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    })->name('doc.file.scope');

    Route::get('/download/pdf/{type}/{filename}', ['middleware' => ['permission:lihat-kontrak'],'uses' => 'PdfDocController@index'])
    ->name('doc.download');

});
