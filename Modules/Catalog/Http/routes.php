<?php

Route::group(['middleware' => 'web', 'prefix' => 'catalog', 'namespace' => 'Modules\Catalog\Http\Controllers'], function()
{
	/*
    Route::get('/category', 'CategoryController@index')->name('catalog.category');
    Route::post('/category/proses', 'CategoryController@proses')->name('catalog.category.proses');
    Route::get('/category/delete', 'CategoryController@delete')->name('catalog.category.delete');

    Route::get('/product', 'ProductController@index')->name('catalog.product');
    Route::post('/product/add', 'ProductController@add')->name('catalog.product.add');
    Route::get('/product/edit', 'ProductController@edit')->name('catalog.product.edit');
    Route::post('/product/edit_proses', 'ProductController@edit_proses')->name('catalog.product.edit_proses');
    Route::get('/product/delete', 'ProductController@delete')->name('catalog.product.delete');

    Route::get('/product/boq', 'ProductController@boq')->name('catalog.boq');
    */

    Route::get('/category', ['middleware' => ['permission:catalog-category'],'uses' => 'CategoryController@index'])->name('catalog.category');
    Route::post('/category/proses', ['middleware' => ['permission:catalog-category'],'uses' => 'CategoryController@proses'])->name('catalog.category.proses');
    Route::get('/category/delete', ['middleware' => ['permission:hapus-catalog-category'],'uses' => 'CategoryController@delete'])->name('catalog.category.delete');

    Route::get('/product', ['middleware' => ['permission:catalog-product'],'uses' => 'ProductController@index'])->name('catalog.product');
    Route::post('/product/add', ['middleware' => ['permission:catalog-product'],'uses' => 'ProductController@add'])->name('catalog.product.add');
    Route::get('/product/edit', ['middleware' => ['permission:catalog-product'],'uses' => 'ProductController@edit'])->name('catalog.product.edit');
    Route::post('/product/edit_proses', ['middleware' => ['permission:catalog-product'],'uses' => 'ProductController@edit_proses'])->name('catalog.product.edit_proses');
    Route::get('/product/delete', ['middleware' => ['permission:hapus-catalog-product'],'uses' => 'ProductController@delete'])->name('catalog.product.delete');

    Route::get('/product/boq', ['middleware' => ['permission:catalog-product'],'uses' => 'ProductController@boq'])->name('catalog.boq');
});
