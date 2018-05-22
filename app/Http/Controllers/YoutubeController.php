<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Alaouy\Youtube\Youtube;
use YoutubeDl\YoutubeDl;
use YoutubeDl\Exception\CopyrightException;
use YoutubeDl\Exception\NotFoundException;
use YoutubeDl\Exception\PrivateVideoException;

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
		$playlist = ($playlist['results']);
		return view('search_tool',compact('playlist'));
	}

	public function login(){
	    return view('login');
    }
    
    public function getAllVIdeos($channelId){
		$videos = $this->youtube->searchChannelVideos('',$channelId,50,'viewCount');
		dd($videos);
	}
	
	public function youtube_dl($videoId)
	{
		$dl = new YoutubeDl([
			'continue' => true, // force resume of partially downloaded files. By default, youtube-dl will resume downloads if possible.
			'format' => 'bestvideo',
		]);
		
		// For more options go to https://github.com/rg3/youtube-dl#user-content-options
		
		$dl->setDownloadPath(storage_path("/videos"));
		// Enable debugging
		/*$dl->debug(function ($type, $buffer) {
			if (\Symfony\Component\Process\Process::ERR === $type) {
				echo 'ERR > ' . $buffer;
			} else {
				echo 'OUT > ' . $buffer;
			}
		});*/
		try {
			$video = $dl->download('https://www.youtube.com/watch?v='.$videoId);
			echo $video->getTitle(); // Will return Phonebloks
			// $video->getFile(); // \SplFileInfo instance of downloaded file
		} catch (NotFoundException $e) {
			// Video not found
		} catch (PrivateVideoException $e) {
			// Video is private
		} catch (CopyrightException $e) {
			// The YouTube account associated with this video has been terminated due to multiple third-party notifications of copyright infringement
		} catch (\Exception $e) {
			// Failed to download
		}
	}
}
