<?php

Route::group(['middleware' => 'web', 'prefix' => 'documents', 'namespace' => 'Modules\Documents\Http\Controllers'], function()
{
    Route::get('/', 'DocumentsController@index');
});
