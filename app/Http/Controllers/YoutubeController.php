<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Alaouy\Youtube\Youtube;
class YoutubeController extends Controller
{
    //
	private $youtube;
	function __construct(){
		$this->youtube = new Youtube("990134486198-ojek7fk9eis03vi0evq5c3m7fh9maski.apps.googleusercontent.com");
		$this->youtube->setApiKey("AIzaSyASShYIDdjFuNXS06EbI5jdXQ6MZjuKHBY");
	}
	
	public function search(){
		$playlist = $this->youtube->getPlaylistsByChannelId('UC9T9L69TlIT1vWMpaCWAxzw');
		dump($playlist);
		return view('search_tool');
	}

	public function login(){
	    return view('login');
    }
}
