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
Route::get('upload_video','YoutubeController@getLocalVideos');
Route::get('login','YoutubeController@login');
Route::any('downloadYt','YoutubeController@youtube_dl');
Route::get('/redr_demo',function(){
	if (isset($_GET['code'])) {
		$OAUTH2_CLIENT_ID = '990134486198-ojek7fk9eis03vi0evq5c3m7fh9maski.apps.googleusercontent.com';
		$OAUTH2_CLIENT_SECRET = 'pnOhVWsIou5KtdLIRDNd1oyO';
		$client = new Google_Client();
		$client->setClientId($OAUTH2_CLIENT_ID);
		$client->setClientSecret($OAUTH2_CLIENT_SECRET);
		// Define an object that will be used to make all API requests.
		$youtube = new Google_Service_YouTube($client);
		//authenticate using the parameter $_GET['code'] you got from google server
		$client->authenticate(request()->get('code'));
		//get the access token
		$tokens = $client->fetchAccessTokenWithAuthCode(request()->get('code'));
		dd($tokens);
		
	}
});
Route::get('all-videos-channel/{channelId?}','YoutubeController@getAllVIdeos');
