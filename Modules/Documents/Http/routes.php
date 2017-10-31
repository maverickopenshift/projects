<?php

Route::group(['middleware' => ['web','auth'], 'prefix' => 'documents', 'namespace' => 'Modules\Documents\Http\Controllers'], function()
{
    Route::get('/', 'DocumentsController@index')->name('doc');
    Route::get('/create/{type}', 'EntryDocumentController@index')->name('doc.create');
    Route::get('/get-po', 'DocumentsController@getPo')->name('doc.get-po');
    
    Route::get('/doc-template', ['middleware' => ['permission:lihat-template-pasal-pasal'],'uses' => 'DocTemplateController@index'])->name('doc.template');
    Route::get('/doc-template/data', ['middleware' => ['permission:lihat-template-pasal-pasal'],'uses' => 'DocTemplateController@data'])->name('doc.template.data');
    Route::get('/doc-template/create', ['middleware' => ['permission:tambah-template-pasal-pasal'],'uses' => 'DocTemplateController@create'])->name('doc.template.create');
    Route::post('/doc-template/store', ['middleware' => ['permission:tambah-template-pasal-pasal'],'uses' => 'DocTemplateController@store'])->name('doc.template.store');
    Route::get('/doc-template/{id}/edit', ['middleware' => ['permission:ubah-template-pasal-pasal'],'uses' => 'DocTemplateController@edit'])->name('doc.template.edit');
});
