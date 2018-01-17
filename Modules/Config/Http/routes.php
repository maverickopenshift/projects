<?php

Route::group(['middleware' => ['web','auth'], 'prefix' => 'config', 'namespace' => 'Modules\Config\Http\Controllers'], function()
{
    Route::get('/', ['middleware' => ['permission:lihat-config'],'uses' => 'ConfigController@index'])->name('config');
    Route::get('/data', ['middleware' => ['permission:lihat-config'],'uses' => 'ConfigController@data'])->name('config.data');
    Route::post('/update', ['middleware' => ['permission:ubah-config'],'uses' => 'ConfigController@update'])->name('config.update');
    Route::post('/add', ['middleware' => ['permission:tambah-config'],'uses' => 'ConfigController@add'])->name('config.add');
    Route::delete('/delete', ['middleware' => ['permission:hapus-config'],'uses' => 'ConfigController@delete'])->name('config.delete');
});