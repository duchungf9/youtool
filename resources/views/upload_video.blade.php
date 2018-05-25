<?php
$OAUTH2_CLIENT_ID = '990134486198-ojek7fk9eis03vi0evq5c3m7fh9maski.apps.googleusercontent.com';
$OAUTH2_CLIENT_SECRET = 'pnOhVWsIou5KtdLIRDNd1oyO';

$client = new Google_Client();
$client->setAuthConfig(storage_path('client_secret_990134486198-ojek7fk9eis03vi0evq5c3m7fh9maski.apps.googleusercontent.com.json'));
$client->setAccessType("offline");        // offline access
$client->setIncludeGrantedScopes(true);   // incremental auth
$client->addScope(Google_Service_Drive::DRIVE_METADATA_READONLY);
$client->setRedirectUri('http://youtool.vn/youtool/public/upload_video');
$auth_url = $client->createAuthUrl();
if(request()->has('code')){
	$client->authenticate($_GET['code']);
	$access_token = $client->getAccessToken();
	dd($access_token);
}
header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));

