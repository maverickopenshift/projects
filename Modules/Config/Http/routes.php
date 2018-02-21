<?php

Route::group(['middleware' => ['web','auth'], 'prefix' => 'config', 'namespace' => 'Modules\Config\Http\Controllers'], function()
{
    Route::get('/', ['middleware' => ['permission:lihat-config'],'uses' => 'ConfigController@index'])->name('config');
    Route::get('/data', ['middleware' => ['permission:lihat-config'],'uses' => 'ConfigController@data'])->name('config.data');
    Route::post('/update', ['middleware' => ['permission:ubah-config'],'uses' => 'ConfigController@update'])->name('config.update');
    Route::post('/editstore', ['middleware' => ['permission:ubah-config'],'uses' => 'ConfigController@editstore'])->name('config.editstore');
    Route::post('/add', ['middleware' => ['permission:tambah-config'],'uses' => 'ConfigController@add'])->name('config.add');
    Route::delete('/delete', ['middleware' => ['permission:hapus-config'],'uses' => 'ConfigController@delete'])->name('config.delete');

    Route::get('/set-dmt', ['middleware' => ['permission:lihat-config'],'uses' => 'ConfigController@indexSetDmt'])->name('set.dmt');
    Route::post('/set-dmt-store', ['middleware' => ['permission:ubah-config'],'uses' => 'ConfigController@editstoreDmt'])->name('config.dmt.store');
});
