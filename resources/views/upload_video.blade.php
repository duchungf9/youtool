<?php
$OAUTH2_CLIENT_ID = '990134486198-ojek7fk9eis03vi0evq5c3m7fh9maski.apps.googleusercontent.com';
$OAUTH2_CLIENT_SECRET = 'pnOhVWsIou5KtdLIRDNd1oyO';

$client = new Google_Client();
$client->setClientId($OAUTH2_CLIENT_ID);
$client->setClientSecret($OAUTH2_CLIENT_SECRET);
$client->setScopes('https://www.googleapis.com/auth/youtube');
a$client->setRedirectUri($redirect);
echo $client->createAuthUrl();
//redirect to google server to get the token
return redirect()->to($client->createAuthUrl());
