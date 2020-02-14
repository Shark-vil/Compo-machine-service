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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/stores', 'StoreController@index');
Route::get('/stores/create', 'StoreController@create');
Route::post('/stores/create', 'StoreController@create');
Route::get('/stores/remove/{id}', 'StoreController@remove');
Route::get('/stores/view/{id}', 'StoreController@view');
Route::get('/stores/change/{id}', 'StoreController@change');
Route::post('/stores/change/{id}', 'StoreController@change');

// Not protected api
Route::post('/api/stores/store', 'StoreController@store');
Route::get('/api/stores/show/{id}', 'StoreController@show');
Route::delete('/api/stores/destroy/{id}', 'StoreController@destroy');
Route::put('/api/stores/update/{id}', 'StoreController@update');
Route::patch('/api/stores/edit/{id}', 'StoreController@edit');