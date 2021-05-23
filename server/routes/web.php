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
Route::get('/youtube/export','YoutubeController@csvExport')->name('csvExport');
Route::get('/youtube/{channel}/titles/show','YoutubeController@getShowRequest');
Route::get('/youtube/{channel}/titles/{page_token?}','YoutubeController@getListByChannelIdAndToken')->name('list');