<?php

Route::group(['middleware' => ['web','auth'], 'prefix' => 'documents', 'namespace' => 'Modules\Documents\Http\Controllers'], function()
{
    Route::get('/', 'DocumentsController@index')->name('doc');
    Route::get('/create/{type}', 'EntryDocumentController@index')->name('doc.create');
});
