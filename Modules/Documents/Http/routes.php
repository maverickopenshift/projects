<?php

Route::group(['middleware' => ['web','auth'], 'prefix' => 'documents', 'namespace' => 'Modules\Documents\Http\Controllers'], function()
{
    Route::get('/status/{status}', ['middleware' => ['permission:lihat-kontrak'],'uses' => 'DocumentsController@index'])->name('doc');
    Route::get('/child', ['middleware' => ['permission:lihat-kontrak'],'uses' => 'DocumentsController@index'])->name('doc.child');
    Route::get('/create/{type}', ['middleware' => ['permission:tambah-kontrak'],'uses' => 'EntryDocumentController@index'])->name('doc.create');
    Route::post('/store/{type}',['middleware' => ['permission:tambah-kontrak'],'uses' => 'EntryDocumentController@store'])->name('doc.store');
    Route::get('/view/{type}/{id}/', ['middleware' => ['permission:lihat-kontrak'],'uses' => 'DocumentsController@view'])->name('doc.view');
    Route::post('/approve', ['middleware' => ['permission:approve-kontrak'],'uses' => 'DocumentsController@approve'])->name('doc.approve');
    Route::post('/reject', ['middleware' => ['permission:approve-kontrak'],'uses' => 'DocumentsController@reject'])->name('doc.reject');
    Route::get('/get-select-kontrak', 'DocumentsController@getSelectKontrak')->name('doc.get-select-kontrak');
    Route::get('/get-select-sp', 'DocumentsController@getSelectSp')->name('doc.get-select-sp');
    Route::get('/get-po', 'DocumentsController@getPo')->name('doc.get-po');
    Route::get('/get-pic', 'DocumentsController@getPic')->name('doc.get-pic');
    Route::get('/get-posisi', 'DocumentsController@getPosisi')->name('doc.get-posisi');

    Route::get('/doc-template', ['middleware' => ['permission:lihat-template-pasal-pasal'],'uses' => 'DocTemplateController@index'])->name('doc.template');
    Route::get('/doc-template/data', ['middleware' => ['permission:lihat-template-pasal-pasal'],'uses' => 'DocTemplateController@data'])->name('doc.template.data');
    Route::get('/doc-template/create', ['middleware' => ['permission:tambah-template-pasal-pasal'],'uses' => 'DocTemplateController@create'])->name('doc.template.create');
    Route::post('/doc-template/store', ['middleware' => ['permission:tambah-template-pasal-pasal'],'uses' => 'DocTemplateController@store'])->name('doc.template.store');
    Route::get('/doc-template/storeEdit', ['middleware' => ['permission:tambah-template-pasal-pasal'],'uses' => 'DocTemplateController@storeEdit'])->name('doc.template.storeEdit');
    Route::get('/doc-template/{id}/edit', ['middleware' => ['permission:ubah-template-pasal-pasal'],'uses' => 'DocTemplateController@edit'])->name('doc.template.edit');

    Route::get('/template/{filename}', function ($filename){
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
    })->name('doc.template.download');

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

    Route::get('/file_lt/{type}/{filename}', function ($filename,$type){
        $path = storage_path('app/documents/'.$type.'_latar_belakang/' . $filename);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    })->name('doc.file.latarbelakang');

});
