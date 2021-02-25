<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/','YoutubeController@index');
Route::get('/youtube','YoutubeController@searchList')->name('search');
Route::get('/youtube/{channel}/titles/{order}/{page_token?}','YoutubeController@getListByChannelIdAndToken')->name('list');
// Route::get('/youtube/{channel}/titles','YoutubeController@getOrderType');

Route::get('/youtube/{channel}/titles/order','YoutubeController@getOrderType')->name('listOrderBy');
// Route::post('/youtube/{channel}/titles/order','YoutubeController@getListByChannelIdOrderBy')->name('listOrderBy');

// Route::get('/youtube/{channel}/titles/{page_token?}/order','YoutubeController@getListByChannelIdOrderBy');