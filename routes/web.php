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

//semua route API yang membutuhkan authentication sekarang didaftarkan dalam grup middleware sesuai dengan nama yang sudah dibuat di kernel
Route::group(['middleware' => 'check-token'], function(){
    Route::get('post', 'PostController@index');
    Route::get('post/{id}', 'PostController@detail');
    //kalau nanti ada endpoint yang butuh authentication tinggal dimasukkan di grup ini saja
});