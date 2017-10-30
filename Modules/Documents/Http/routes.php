<?php

Route::group(['middleware' => ['web','auth'], 'prefix' => 'documents', 'namespace' => 'Modules\Documents\Http\Controllers'], function()
{
    Route::get('/', 'DocumentsController@index')->name('doc');
    Route::get('/create/{type}', 'EntryDocumentController@index')->name('doc.create');
    
    Route::get('/doc-template', 'DocTemplateController@index')->name('doc.template');
    Route::get('/doc-template/create', 'DocTemplateController@create')->name('doc.template.create');
    Route::post('/doc-template/store', 'DocTemplateController@store')->name('doc.template.store');
});
