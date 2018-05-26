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
Route::get('search_tool','YoutubeController@search');
Route::any('upload_video','YoutubeController@getLocalVideos')->name('upload_file');
Route::get('login','YoutubeController@login');
Route::any('downloadYt','YoutubeController@youtube_dl');
Route::get('all-videos-channel/{channelId?}','YoutubeController@getAllVIdeos');
Route::get('clear_token_v1',function(){
	session()->remove('access_token');
})->name('clear_token');
