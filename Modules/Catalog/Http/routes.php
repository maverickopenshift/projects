<?php

Route::group(['middleware' => 'web', 'prefix' => 'catalog', 'namespace' => 'Modules\Catalog\Http\Controllers'], function()
{
    Route::get('/category', ['middleware' => ['permission:catalog-category'],'uses' => 'CategoryController@index'])->name('catalog.category');
    Route::post('/category/datatables', ['middleware' => ['permission:catalog-category'],'uses' => 'CategoryController@datatables'])->name('catalog.category.datatables');
    Route::post('/category/proses', ['middleware' => ['permission:catalog-category'],'uses' => 'CategoryController@proses'])->name('catalog.category.proses');
    Route::get('/category/get_category', ['middleware' => ['permission:lihat-catalog'],'uses' => 'CategoryController@get_category'])->name('catalog.category.get_category');
    Route::get('/category/get_category_induk', ['middleware' => ['permission:lihat-catalog'],'uses' => 'CategoryController@get_category_induk'])->name('catalog.category.get_category_induk');
    Route::get('/category/get_category_all/{parent_id}', ['middleware' => ['permission:lihat-catalog'],'uses' => 'CategoryController@get_category_all'])->name('catalog.category.get_category_all');
    Route::delete('/category/delete', ['middleware' => ['permission:hapus-catalog-category'],'uses' => 'CategoryController@delete'])->name('catalog.category.delete');

    Route::get('/product', ['middleware' => ['permission:catalog-product'],'uses' => 'ProductController@index'])->name('catalog.product');
    Route::post('/product/datatables', ['middleware' => ['permission:catalog-product'],'uses' => 'ProductController@datatables'])->name('catalog.product.datatables');
    Route::get('/product/get_product_induk', ['middleware' => ['permission:catalog-product'],'uses' => 'ProductController@get_product_induk'])->name('catalog.product.get_product_induk');
    Route::post('/product/add', ['middleware' => ['permission:catalog-product'],'uses' => 'ProductController@add'])->name('catalog.product.add');
    Route::post('/product/edit', ['middleware' => ['permission:catalog-product'],'uses' => 'ProductController@edit'])->name('catalog.product.edit');
    Route::delete('/product/delete', ['middleware' => ['permission:hapus-catalog-product'],'uses' => 'ProductController@delete'])->name('catalog.product.delete');

    Route::get('/product/boq', ['middleware' => ['permission:catalog-product'],'uses' => 'ProductController@boq'])->name('catalog.boq');

    Route::get('/list', ['middleware' => ['permission:lihat-catalog'],'uses' => 'CatalogController@index'])->name('catalog.list');
    Route::get('/no_kontrak', ['middleware' => ['permission:lihat-catalog'],'uses' => 'CatalogController@get_no_kontrak'])->name('catalog.no_kontrak');
    Route::get('/cari_no_kontrak', ['middleware' => ['permission:lihat-catalog'],'uses' => 'CatalogController@cari_no_kontrak'])->name('catalog.cari_no_kontrak');
});
