<?php

Route::group(['middleware' => 'web', 'prefix' => 'usersupplier', 'namespace' => 'Modules\UserSupplier\Http\Controllers'], function()
{
  Route::get('/', 'UserSupplierController@index')->name('usersupplier');
  Route::get('/register', 'RegisterController@index')->name('usersupplier.register');
  Route::post('/register/add', 'RegisterController@add')  ->name('usersupplier.add');
  Route::get('/NotifEmail', ['middleware' => ['role:vendor'],'uses' => 'RegisterController@NotifEmail'])
  ->name('usersupplier.notifemail');
  Route::get('/forget-password', 'RegisterController@forgetpwd')->name('usersupplier.forgetpwd');
  Route::post('/check-email', 'RegisterController@checking')  ->name('usersupplier.forgetpwd.check');





  Route::get('/profileVendor', ['middleware' => ['role:vendor'],'uses' => 'ProfileController@index'])
  ->name('profile');
  Route::post('/update', ['middleware' => ['role:vendor'],'uses' => 'ProfileController@update'])
  ->name('profile.update');

  Route::get('/dataSupplier', ['middleware' => ['role:vendor'],'uses' => 'DataSupplierController@index'])
  ->name('supplier.list');

  Route::get('/dataSupplier/data', ['middleware' => ['role:vendor'],'uses' => 'DataSupplierController@data'])
  ->name('supplier.isi');
  Route::get('/kelengkapanData', ['middleware' => ['role:vendor'],'uses' => 'DataSupplierController@tambah'])
  ->name('supplier.tambah');
  Route::post('/tambah', ['middleware' => ['role:vendor'],'uses' => 'DataSupplierController@add'])
  ->name('supplier.insert');

  Route::post('/updatedata', ['middleware' => ['role:vendor'],'uses' => 'DataSupplierController@update'])
  ->name('usersupplier.update');

  Route::get('/comments', ['middleware' => ['role:vendor'],'uses' => 'UserSupplierCommentController@comments'])->name('usr.comments');

  Route::get('/legal-dokumen/{filename}', function ($filename){
      $path = storage_path('app/supplier/legal_dokumen/' . $filename);

      if (!File::exists($path)) {
          abort(404);
      }

      $file = File::get($path);
      $type = File::mimeType($path);

      $response = Response::make($file, 200);
      $response->header("Content-Type", $type);

      return $response;
  })->name('usersupplier.legaldokumen.file');
  Route::get('/sertifikat/{filename}', function ($filename){
      $path = storage_path('app/supplier/sertifikat_dokumen/' . $filename);

      if (!File::exists($path)) {
          abort(404);
      }

      $file = File::get($path);
      $type = File::mimeType($path);

      $response = Response::make($file, 200);
      $response->header("Content-Type", $type);

      return $response;
  })->name('usersupplier.sertifikat.file');

});
