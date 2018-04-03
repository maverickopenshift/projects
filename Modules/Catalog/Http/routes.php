<?php

Route::group(['middleware' => ['web','auth'], 'prefix' => 'catalog', 'namespace' => 'Modules\Catalog\Http\Controllers'], function()
{
    Route::get('/category', ['middleware' => ['permission:catalog-category'],'uses' => 'CategoryController@index'])->name('catalog.category');
    Route::post('/category/datatables', ['middleware' => ['permission:lihat-catalog'],'uses' => 'CategoryController@datatables'])->name('catalog.category.datatables');
    Route::post('/category/proses', ['middleware' => ['permission:catalog-category'],'uses' => 'CategoryController@proses'])->name('catalog.category.proses');
    Route::get('/category/get_category', ['middleware' => ['permission:lihat-catalog'],'uses' => 'CategoryController@get_category'])->name('catalog.category.get_category');

    Route::get('/category/get_category_induk/', ['middleware' => ['permission:lihat-catalog'],'uses' => 'CategoryController@get_category_induk'])->name('catalog.category.get_category_induk');
    Route::get('/category/get_category_all/{parent_id}', ['middleware' => ['permission:lihat-catalog'],'uses' => 'CategoryController@get_category_all'])->name('catalog.category.get_category_all');

    Route::delete('/category/delete', ['middleware' => ['permission:hapus-catalog-category'],'uses' => 'CategoryController@delete'])->name('catalog.category.delete');

    //////////////
    //Route::get('/product', ['middleware' => ['permission:catalog-product'],'uses' => 'ProductController@index'])->name('catalog.product');
    Route::get('/product_master', 
        ['middleware' => ['permission:catalog-product'],'uses' => 'ProductMasterController@index'])
    ->name('catalog.product.master');

    Route::get('/product_master/get_product_induk', 
        ['middleware' => ['permission:catalog-product'],'uses' => 'ProductMasterController@get_product_induk'])
    ->name('catalog.product_master.get_product_induk');

    Route::post('/product-master-upload', 
        ['middleware' => ['permission:catalog-product'],'uses' => 'ProductMasterController@upload'])
    ->name('catalog.product_master.upload');

    Route::post('/product_master/add_ajax', 
        ['middleware' => ['permission:catalog-product'],'uses' => 'ProductMasterController@add_ajax'])
    ->name('catalog.product_master.add_ajax');

    Route::post('/product_master/edit', 
        ['middleware' => ['permission:catalog-product'],'uses' => 'ProductMasterController@edit'])
    ->name('catalog.product_master.edit');    

    Route::delete('/product_master/delete', 
        ['middleware' => ['permission:hapus-catalog-product'],'uses' => 'ProductMasterController@delete'])
    ->name('catalog.product_master.delete');

    Route::get('/product_logistic', 
        ['middleware' => ['permission:catalog-product'],'uses' => 'ProductLogisticController@index'])
    ->name('catalog.product.logistic');

    Route::post('/product-logistic-upload', 
        ['middleware' => ['permission:catalog-product'],'uses' => 'ProductLogisticController@upload'])
    ->name('catalog.product_logistic.upload');

    Route::post('/product_logistic/add_ajax', 
        ['middleware' => ['permission:catalog-product'],'uses' => 'ProductLogisticController@add_ajax'])
    ->name('catalog.product_logistic.add_ajax');

    Route::post('/product_logistic/edit', 
        ['middleware' => ['permission:catalog-product'],'uses' => 'ProductLogisticController@edit'])
    ->name('catalog.product_logistic.edit');

    Route::get('/product_logistic/get_kode', 
        ['middleware' => ['permission:catalog-product'],'uses' => 'ProductLogisticController@get_kode_product_master'])
    ->name('catalog.product_logistic.get_kode_product_master');

    Route::get('/product_logistic/get_kontrak', 
        ['middleware' => ['permission:catalog-product'],'uses' => 'ProductLogisticController@get_kontrak'])
    ->name('catalog.product_logistic.get_kontrak');

    Route::get('/product_logistic/get_kode_normal', 
        ['middleware' => ['permission:catalog-product'],'uses' => 'ProductLogisticController@get_kode_product_master_normal'])
    ->name('catalog.product_logistic.get_kode_product_master_normal');

    Route::get('/product_logistic/get_kontrak_normal', 
        ['middleware' => ['permission:catalog-product'],'uses' => 'ProductLogisticController@get_kontrak_normal'])
    ->name('catalog.product_logistic.get_kontrak_normal');

    Route::delete('/product_logistic/delete', 
        ['middleware' => ['permission:hapus-catalog-product'],'uses' => 'ProductLogisticController@delete'])
    ->name('catalog.product_logistic.delete');
    ////////////
    /*
    Route::post('/product/datatables', ['middleware' => ['permission:lihat-catalog'],'uses' => 'ProductController@datatables'])->name('catalog.product.datatables');
    Route::get('/product/get_product_induk', ['middleware' => ['permission:catalog-product'],'uses' => 'ProductController@get_product_induk'])->name('catalog.product.get_product_induk');


    Route::get('/product/get_product_supplier', ['middleware' => ['permission:catalog-product'],'uses' => 'ProductController@get_product_supplier'])->name('catalog.product.get_product_supplier');
    //////*/
    //Route::post('/product/add', ['middleware' => ['permission:catalog-product'],'uses' => 'ProductController@add'])->name('catalog.product.add');
    /*
    Route::post('/product/add_ajax', ['middleware' => ['permission:catalog-product'],'uses' => 'ProductController@add_ajax'])->name('catalog.product.add_ajax');
    //////
    Route::post('/product/edit', ['middleware' => ['permission:catalog-product'],'uses' => 'ProductController@edit'])->name('catalog.product.edit');
    Route::delete('/product/delete', ['middleware' => ['permission:hapus-catalog-product'],'uses' => 'ProductController@delete'])->name('catalog.product.delete');

    Route::get('/product/boq', ['middleware' => ['permission:catalog-product'],'uses' => 'ProductController@boq'])->name('catalog.boq');
    Route::get('/product/supplier', ['middleware' => ['permission:catalog-product'],'uses' => 'ProductController@get_no_supplier'])->name('catalog.supplier');
    */

    //Route::get('/list', ['middleware' => ['permission:lihat-catalog'],'uses' => 'CatalogController@index'])->name('catalog.list');

    Route::get('/list_product_master', ['middleware' => ['permission:lihat-catalog'],'uses' => 'CatalogController@index_product_master'])->name('catalog.list.product_master');
    Route::post('/list_product_master/datatables', ['middleware' => ['permission:lihat-catalog'],'uses' => 'CatalogController@index_product_master_datatables'])->name('catalog.list.product_master.datatables');

    Route::get('/list_product_logistic', ['middleware' => ['permission:lihat-catalog'],'uses' => 'CatalogController@index_product_logistic'])->name('catalog.list.product_logistic');
    Route::post('/list_product_logistic/datatables', ['middleware' => ['permission:lihat-catalog'],'uses' => 'CatalogController@index_product_logistic_datatables'])->name('catalog.list.product_logistic.datatables');
    /*
    Route::get('/no_kontrak', ['middleware' => ['permission:lihat-catalog'],'uses' => 'CatalogController@get_no_kontrak'])->name('catalog.no_kontrak');
    Route::get('/cari_no_kontrak', ['middleware' => ['permission:lihat-catalog'],'uses' => 'CatalogController@cari_no_kontrak'])->name('catalog.cari_no_kontrak');
    */
});
