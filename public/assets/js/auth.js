// The client ID is obtained from the {{ Google Cloud Console }}
// at {{ https://cloud.google.com/console }}.
// If you run this code from a server other than http://localhost,
// you need to register your own client ID.
var OAUTH2_CLIENT_ID = '990134486198-ojek7fk9eis03vi0evq5c3m7fh9maski.apps.googleusercontent.com';
var OAUTH2_SCOPES = [
  'https://www.googleapis.com/auth/youtube',
    "https://www.googleapis.com/auth/youtubepartner",
    "https://www.googleapis.com/auth/youtube.readonly",
    "https://www.googleapis.com/auth/youtube.upload",
    "https://www.googleapis.com/auth/youtubepartner-channel-audit",
    "https://www.googleapis.com/auth/youtube.force-ssl"
];
// Upon loading, the Google APIs JS client automatically invokes this callback.
googleApiClientReady = function() {
  gapi.auth.init(function() {
    window.setTimeout(checkAuth(), 1000);
    // getChannel();
  });
}

// Attempt the immediate OAuth 2.0 client flow as soon as the page loads.
// If the currently logged-in Google Account has previously authorized
// the client specified as the OAUTH2_CLIENT_ID, then the authorization
// succeeds with no user intervention. Otherwise, it fails and the
// user interface that prompts for authorization needs to display.
function checkAuth() {
    gapi.auth.authorize({
    client_id: OAUTH2_CLIENT_ID,
    scope: OAUTH2_SCOPES,
    immediate: true
  }, handleAuthResult);
}

// Handle the result of a gapi.auth.authorize() call.
function handleAuthResult(authResult) {
    console.log('callbacked');
    console.log(authResult);
    if (authResult && !authResult.error) {
        // Authorization was successful. Hide authorization prompts and show
    // content that should be visible after authorization succeeds.
    $('.pre-auth').hide();
    $('.post-auth').show();
    loadAPIClientInterfaces();
  } else {
    gapi.auth.authorize(
        {
            'client_id': OAUTH2_CLIENT_ID,
            'scope': OAUTH2_SCOPES,
        },
        function (authResult) {gapi.auth.signIn();
        alert('Bạn cần reload lại trang sau khi login!');}
    );
    // Make the #login-link clickable. Attempt a non-immediate OAuth 2.0
    // client flow. The current function is called when that flow completes.
    $('#login-link').click(function() {
      gapi.auth.authorize({
        client_id: OAUTH2_CLIENT_ID,
        scope: OAUTH2_SCOPES,
        immediate: true
        }, handleAuthResult);
    });
  }
}

// Load the client interfaces for the YouTube Analytics and Data APIs, which
// are required to use the Google APIs JS client. More info is available at
// https://developers.google.com/api-client-library/javascript/dev/dev_jscript#loading-the-client-library-and-the-api
function loadAPIClientInterfaces() {
  gapi.client.load('youtube', 'v3', function() {
    handleAPILoaded();
    getChannel();
  });
}

$("#logout-button").click(function(){
    gapi.auth.authorize(
        {
            'client_id': OAUTH2_CLIENT_ID,
            'scope': OAUTH2_SCOPES,
        },
        function (authResult) {gapi.auth.signOut();}
    );
});
function getChannel() {
    gapi.client.youtube.channels.list({
        'part': 'snippet,contentDetails,statistics',
        'mine': 'true'
    }).then(function(response) {
        var channel = response.result.items[0];
        var channelavt = $(".channelavt");
        var channeltitle = $(".channeltitle");
        channelavt.attr('src',channel.snippet.thumbnails.default.url);
        channeltitle.html(channel.snippet.title);
        console.log(response);
        console.log('This channel\'s ID is ' + channel.id + '. ' +
            'Its title is \'' + channel.snippet.title + ', ' +
            'and it has ' + channel.statistics.viewCount + ' views.');
    });
}

