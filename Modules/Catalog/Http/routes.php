<?php

Route::group(['middleware' => ['web','auth'], 'prefix' => 'catalog', 'namespace' => 'Modules\Catalog\Http\Controllers'], function()
{
    Route::get('/category',                             ['middleware' => ['permission:katalog-kategori'],'uses' => 'CategoryController@index'])->name('catalog.category');
    Route::get('/category/bulk',                        ['middleware' => ['permission:katalog-kategori'],'uses' => 'CategoryController@bulk'])->name('catalog.category.bulk');
    Route::post('/category/bulk_add',                    ['middleware' => ['permission:katalog-kategori'],'uses' => 'CategoryController@bulk_add'])->name('catalog.category.bulk_add');
    Route::post('/category/bulk_upload',                 ['middleware' => ['permission:katalog-kategori'],'uses' => 'CategoryController@bulk_upload'])->name('catalog.category.bulk_upload');
    Route::post('/category/datatables',                 ['middleware' => ['permission:katalog-kategori'],'uses' => 'CategoryController@datatables'])->name('catalog.category.datatables');    
    Route::get('/category/get_category',                ['middleware' => ['permission:katalog-kategori'],'uses' => 'CategoryController@get_category'])->name('catalog.category.get_category');
    Route::get('/category/get_category_induk/',         ['middleware' => ['permission:katalog-kategori'],'uses' => 'CategoryController@get_category_induk'])->name('catalog.category.get_category_induk');
    Route::get('/category/get_category_all/{parent_id}',['middleware' => ['permission:katalog-kategori'],'uses' => 'CategoryController@get_category_all'])->name('catalog.category.get_category_all');
    
    Route::post('/category/proses',                     ['middleware' => ['permission:katalog-kategori-proses'],'uses' => 'CategoryController@proses'])->name('catalog.category.proses');
    Route::delete('/category/delete',                   ['middleware' => ['permission:katalog-kategori-proses'],'uses' => 'CategoryController@delete'])->name('catalog.category.delete');

    /////////

    Route::get('/satuan',             ['middleware' => ['permission:katalog-satuan'],'uses' => 'SatuanController@index'])->name('catalog.satuan');
    Route::post('/satuan/datatables', ['middleware' => ['permission:katalog-satuan'],'uses' => 'SatuanController@index_satuan_datatables'])->name('catalog.list.satuan.datatables');
    Route::post('/satuan/add',        ['middleware' => ['permission:katalog-satuan'],'uses' => 'SatuanController@add'])->name('catalog.satuan.add');
    Route::post('/satuan/edit',       ['middleware' => ['permission:katalog-satuan'],'uses' => 'SatuanController@edit'])->name('catalog.satuan.edit');    
    Route::delete('/satuan/delete',   ['middleware' => ['permission:katalog-satuan'],'uses' => 'SatuanController@delete'])->name('catalog.satuan.delete');

    //////////////

    Route::get('/coverage',                     ['middleware' => ['permission:katalog-coverage'],'uses' => 'CoverageController@index'])->name('catalog.coverage');
    Route::get('/coverage/get_coverage',        ['middleware' => ['permission:katalog-coverage'],'uses' => 'CoverageController@get_coverage'])->name('catalog.coverage.get_coverage');
    Route::get('/coverage/get_group_coverage',  ['middleware' => ['permission:katalog-coverage'],'uses' => 'CoverageController@get_group_coverage'])->name('catalog.coverage.get_group_coverage');
    Route::post('/coverage/datatables',         ['middleware' => ['permission:katalog-coverage'],'uses' => 'CoverageController@index_coverage_datatables'])->name('catalog.list.coverage.datatables');
    Route::post('/coverage/add',                ['middleware' => ['permission:katalog-coverage'],'uses' => 'CoverageController@add'])->name('catalog.coverage.add');
    Route::post('/coverage/edit',               ['middleware' => ['permission:katalog-coverage'],'uses' => 'CoverageController@edit'])->name('catalog.coverage.edit');    
    Route::delete('/coverage/delete',           ['middleware' => ['permission:katalog-coverage'],'uses' => 'CoverageController@delete'])->name('catalog.coverage.delete');

    //////////////

    Route::get('/group_coverage',             ['middleware' => ['permission:katalog-coverage'],'uses' => 'GroupCoverageController@index'])->name('catalog.group_coverage');
    Route::post('/group_coverage/datatables', ['middleware' => ['permission:katalog-coverage'],'uses' => 'GroupCoverageController@index_group_coverage_datatables'])->name('catalog.list.group_coverage.datatables');
    Route::post('/group_coverage/add',        ['middleware' => ['permission:katalog-coverage'],'uses' => 'GroupCoverageController@add'])->name('catalog.group_coverage.add');
    Route::post('/group_coverage/edit',       ['middleware' => ['permission:katalog-coverage'],'uses' => 'GroupCoverageController@edit'])->name('catalog.group_coverage.edit');    
    Route::delete('/group_coverage/delete',   ['middleware' => ['permission:katalog-coverage'],'uses' => 'GroupCoverageController@delete'])->name('catalog.group_coverage.delete');

    //////////////

    Route::get('/product_master',                       ['middleware' => ['permission:katalog-master-item'],'uses' => 'ProductMasterController@index'])->name('catalog.product.master');
    Route::get('/product_master/bulk',                  ['middleware' => ['permission:katalog-master-item'],'uses' => 'ProductMasterController@bulk'])->name('catalog.product_master.bulk');
    Route::post('/product_master/bulk_add',              ['middleware' => ['permission:katalog-master-item'],'uses' => 'ProductMasterController@bulk_add'])->name('catalog.product_master.bulk_add');
    Route::get('/product_master/get_product_induk',     ['middleware' => ['permission:katalog-master-item'],'uses' => 'ProductMasterController@get_product_induk'])->name('catalog.product_master.get_product_induk');
    Route::get('/product_master/get_satuan',            ['middleware' => ['permission:katalog-master-item'],'uses' => 'ProductMasterController@get_satuan'])->name('catalog.product_master.get_satuan');
    Route::get('/product_master/get_select_category',   ['middleware' => ['permission:katalog-master-item'],'uses' => 'ProductMasterController@get_select_category'])->name('catalog.product_master.get_category');
    Route::post('/product-master-upload',               ['middleware' => ['permission:katalog-master-item-proses'],'uses' => 'ProductMasterController@upload'])->name('catalog.product_master.upload');
    Route::post('/product-master-upload_bulk',          ['middleware' => ['permission:katalog-master-item-proses'],'uses' => 'ProductMasterController@upload_bulk'])->name('catalog.product_master.upload_bulk');
    Route::post('/product_master/add_ajax',             ['middleware' => ['permission:katalog-master-item-proses'],'uses' => 'ProductMasterController@add_ajax'])->name('catalog.product_master.add_ajax');
    Route::post('/product_master/edit',                 ['middleware' => ['permission:katalog-master-item-proses'],'uses' => 'ProductMasterController@edit'])->name('catalog.product_master.edit');    
    Route::delete('/product_master/delete',             ['middleware' => ['permission:katalog-master-item-proses'],'uses' => 'ProductMasterController@delete'])->name('catalog.product_master.delete');

    Route::get('product_master/image/{filename}', function ($filename)
    {
        $path = storage_path('app/master_item/' . $filename);
        /*
        if (!File::exists($path)) {
            abort(404);
        }
        */

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    });

    /////////////////////

    Route::get('/product_logistic',                     ['middleware' => ['permission:katalog-item-price'],'uses' => 'ProductLogisticController@index'])->name('catalog.product.logistic');
    Route::get('/product_logistic/get_kode',            ['middleware' => ['permission:katalog-item-price'],'uses' => 'ProductLogisticController@get_kode_product_master'])->name('catalog.product_logistic.get_kode_product_master');
    Route::get('/product_logistic/get_kontrak_cari',    ['middleware' => ['permission:katalog-item-price'],'uses' => 'ProductLogisticController@get_kontrak_cari'])->name('catalog.product_logistic.get_kontrak_cari');
    Route::get('/product_logistic/get_kode_normal',     ['middleware' => ['permission:katalog-item-price'],'uses' => 'ProductLogisticController@get_kode_product_master_normal'])->name('catalog.product_logistic.get_kode_product_master_normal');
    Route::post('/product_logistic/upload',             ['middleware' => ['permission:katalog-item-price-proses'],'uses' => 'ProductLogisticController@upload'])->name('catalog.product_logistic.upload');
    Route::post('/product_logistic/add_ajax',           ['middleware' => ['permission:katalog-item-price-proses'],'uses' => 'ProductLogisticController@add_ajax'])->name('catalog.product_logistic.add_ajax');
    Route::post('/product_logistic/edit',               ['middleware' => ['permission:katalog-item-price-proses'],'uses' => 'ProductLogisticController@edit'])->name('catalog.product_logistic.edit');
    Route::delete('/product_logistic/delete',           ['middleware' => ['permission:katalog-item-price-proses'],'uses' => 'ProductLogisticController@delete'])->name('catalog.product_logistic.delete');

    /////////////////////////
    Route::get('/product_kontrak',                     ['middleware' => ['permission:katalog-item-price'],'uses' => 'ProductKontrakController@index'])->name('catalog.product.kontrak');
    //Route::get('/product_kontrak/get_kode',            ['middleware' => ['permission:katalog-item-price'],'uses' => 'ProductKontrakController@get_kode_product_master'])->name('catalog.product_kontrak.get_kode_product_master');
    //Route::get('/product_kontrak/get_kontrak_cari',    ['middleware' => ['permission:katalog-item-price'],'uses' => 'ProductKontrakController@get_kontrak_cari'])->name('catalog.product_kontrak.get_kontrak_cari');
    //Route::get('/product_kontrak/get_kode_normal',     ['middleware' => ['permission:katalog-item-price'],'uses' => 'ProductKontrakController@get_kode_product_master_normal'])->name('catalog.product_kontrak.get_kode_product_master_normal');
    Route::post('/product_kontrak/upload',             ['middleware' => ['permission:katalog-item-price-proses'],'uses' => 'ProductKontrakController@upload'])->name('catalog.product_kontrak.upload');
    Route::post('/product_kontrak/add_ajax',           ['middleware' => ['permission:katalog-item-price-proses'],'uses' => 'ProductKontrakController@add_ajax'])->name('catalog.product_kontrak.add_ajax');
    //Route::post('/product_kontrak/edit',               ['middleware' => ['permission:katalog-item-price-proses'],'uses' => 'ProductKontrakController@edit'])->name('catalog.product_kontrak.edit');
    //Route::delete('/product_kontrak/delete',           ['middleware' => ['permission:katalog-item-price-proses'],'uses' => 'ProductKontrakController@delete'])->name('catalog.product_kontrak.delete');
    ////////////

    Route::get('/list_product_master',                  ['middleware' => ['permission:katalog-master-item'],'uses' => 'CatalogController@index_product_master'])->name('catalog.list.product_master');
    Route::post('/list_product_master/datatables',      ['middleware' => ['permission:katalog-master-item'],'uses' => 'CatalogController@index_product_master_datatables'])->name('catalog.list.product_master.datatables');

    Route::get('/list_product_logistic',                ['middleware' => ['permission:katalog-item-price'],'uses' => 'CatalogController@index_product_logistic'])->name('catalog.list.product_logistic');
    Route::post('/list_product_logistic/datatables',    ['middleware' => ['permission:katalog-item-price'],'uses' => 'CatalogController@index_product_logistic_datatables'])->name('catalog.list.product_logistic.datatables');

    Route::get('/list_product_logistic_view',            ['middleware' => ['permission:katalog-item-price'],'uses' => 'CatalogController@index_product_logistic_view'])->name('catalog.list.product_logistic_view');
    Route::post('/list_product_logistic_view/datatables',['middleware' => ['permission:katalog-item-price'],'uses' => 'CatalogController@index_product_logistic_view_datatables'])->name('catalog.list.product_logistic_view.datatables');

    Route::post('/list_kontrak/datatables',             ['middleware' => ['permission:katalog-item-price'],'uses' => 'CatalogController@index_kontrak_datatables'])->name('catalog.list.kontrak.datatables');

    Route::get('/list_product_kontrak',                 ['middleware' => ['permission:katalog-item-price'],'uses' => 'CatalogController@index_product_kontrak'])->name('catalog.list.product_kontrak');
    Route::post('/list_product_kontrak/datatables',     ['middleware' => ['permission:katalog-item-price'],'uses' => 'CatalogController@index_product_kontrak_datatables'])->name('catalog.list.product_kontrak.datatables');
    Route::post('/list_product_kontrak_logistic/datatables',     ['middleware' => ['permission:katalog-item-price'],'uses' => 'CatalogController@index_product_kontrak_logistic_datatables'])->name('catalog.list.product_kontrak_logistic.datatables');
});
