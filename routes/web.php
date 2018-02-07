<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', 'HomeController@index')->name('home');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/pgs', 'HomeController@pgs')->name('pgs');
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

Route::post('/login-ajax', 'Auth\LoginController@loginAjax')->name('login.ajax');
Route::post('/pgs-change', 'HomeController@pgsChange')->name('home.pgschange');

Route::get('/userprofile', 'Profiluser@index')->name('home.profile');
Route::post('/userprofile/update', 'Profiluser@update')->name('home.profile.update');
