<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Alaouy\Youtube\Youtube;
use Illuminate\Support\Facades\DB;
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
	
	public function getLocalVideos(){
		$OAUTH2_CLIENT_ID = '990134486198-ojek7fk9eis03vi0evq5c3m7fh9maski.apps.googleusercontent.com';
		$OAUTH2_CLIENT_SECRET = 'pnOhVWsIou5KtdLIRDNd1oyO';
		$client = new \Google_Client();
		$client->setAuthConfig(storage_path('client_secret_990134486198-ojek7fk9eis03vi0evq5c3m7fh9maski.apps.googleusercontent.com.json'));
		$client->setAccessType("offline");        // offline access
		$client->setIncludeGrantedScopes(true);   // incremental auth
		$client->addScope(\Google_Service_Drive::DRIVE_METADATA_READONLY);
		$client->setScopes('https://www.googleapis.com/auth/youtube');
		$client->setRedirectUri('http://youtool.vn/youtool/public/upload_video');
		$auth_url = $client->createAuthUrl();
		if(session()->has('access_token') && session()->get('access_token')!= null){
			$client->setAccessToken(session()->get('access_token')['access_token']);
		}
		if($client->getAccessToken()){
			$allVideos = DB::table('videos_downloaded')->get();
			if(request()->ajax()){
				$youtube = new \Google_Service_YouTube($client);
				$needToUploadVideo = DB::table('videos_downloaded')->where('link_to_file',request()->get('link_to_file'))->first();
				$videoPath = $needToUploadVideo->link_to_file;
				$snipper = new \Google_Service_YouTube_VideoSnippet();
				$snipper->setTitle($needToUploadVideo->tittle);
				$snipper->setDescription($needToUploadVideo->tittle);
				$snipper->setTags(['tag1','tag2']);
				$snipper->setCategoryId('22');
				$status = new \Google_Service_YouTube_VideoStatus();
				$status->privacyStatus = "unlisted";
				$video = new \Google_Service_YouTube_video();
				$video->setSnippet($snipper);
				$video->setStatus($status);
				$chunkSizeBytes = 1*1024*1024;
				$client->setDefer(true);
				$insertReq = $youtube->videos->insert("status,snippet",$video);
				$media = new \Google_Http_MediaFileUpload(
					$client,
					$insertReq,
					"video/*",
					null,true,$chunkSizeBytes
				);
				$media->setFileSize(filesize($videoPath));
				$status = false;
				$handle = fopen($videoPath,'rb');
				while (!$status && !feof($handle)) {
					$chunk = fread($handle, $chunkSizeBytes);
					$status = $media->nextChunk($chunk);
				}
				fclose($handle);
				$client->setDefer(false);
				DB::table('videos_downloaded')->where('link_to_file',request()->get('link_to_file'))
					->update([
						'upload_status'=>1
					]);

			}
			return view('upload_video',compact('allVideos'));
			
		}
		if(request()->has('code')){
			$client->authenticate(request()->get('code'));
			$access_token = $client->getAccessToken();
			session()->put('access_token',$access_token);
		}else{
			return redirect(filter_var($auth_url, FILTER_SANITIZE_URL));
		}
	}
	
	public function youtube_dl()
	{
		$videoId = request()->get('videoId');
		if(!$videoId){
			echo 'failed';die;
		}
		$dl = new YoutubeDl([
			'continue' => true, // force resume of partially downloaded files. By default, youtube-dl will resume downloads if possible.
			'format' => 'best'
		]);
		// For more options go to https://github.com/rg3/youtube-dl#user-content-options
		$dl->setBinPath(storage_path('/youtube-dl.exe'));
		$dl->setDownloadPath(storage_path("videos"));
		try {
			$video = $dl->download('https://www.youtube.com/watch?v='.$videoId);
			$tittle =  $video->getTitle(); // Will return Phonebloks
			$a = DB::table('videos_downloaded')->insert(
				[
					'tittle'=>$tittle,
					'link_to_file'=>storage_path("videos/".$video->getFilename()),
				]
			);
			if($a){
				return response()->json(['mes'=>'success']);
			}
			// $video->getFile(); // \SplFileInfo instance of downloaded file
		} catch (NotFoundException $e) {
			// Video not found
			echo 'video not found';
			dd($e);
		} catch (PrivateVideoException $e) {
			// Video is private
			echo 'video not private';
			
			dd($e);
		} catch (CopyrightException $e) {
			echo 'video copyright';
			
			// The YouTube account associated with this video has been terminated due to multiple third-party notifications of copyright infringement
			dd($e);
		} catch (\Exception $e) {
			// Failed to download
			dd($e);
		}
	}
}
