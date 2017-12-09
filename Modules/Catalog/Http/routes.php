<?php

Route::group(['middleware' => 'web', 'prefix' => 'catalog', 'namespace' => 'Modules\Catalog\Http\Controllers'], function()
{
    Route::get('/category', 'CategoryController@index')->name('catalog.category');
    Route::post('/category/proses', 'CategoryController@proses')->name('catalog.category.proses');
    Route::get('/category/delete', 'CategoryController@delete')->name('catalog.category.delete');

    Route::get('/product', 'ProductController@index')->name('catalog.product');
    Route::post('/product/add', 'ProductController@add')->name('catalog.product.add');
    Route::get('/product/edit', 'ProductController@edit')->name('catalog.product.edit');
    Route::post('/product/edit_proses', 'ProductController@edit_proses')->name('catalog.product.edit_proses');
    Route::get('/product/delete', 'ProductController@delete')->name('catalog.product.delete');
});
