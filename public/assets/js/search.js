// After the API loads, call a function to enable the search box.
function handleAPILoaded() {
  $('#search-button').attr('disabled', false);
}

// Search for a specified string.
$("#search_btn").click(function(){
    search();
});
var videosData = [];
function search() {
    videosData = [];    //reset videos
  var q = $('#search_key').val();
  var params = {
      q: q,
      part: 'snippet',
      maxResults:50,
      order:'viewCount',
      type:'video',
      videoDuration:'short'
  };
  var request = gapi.client.youtube.search.list(params);

  request.execute(function(response) {
    $html = "";
    $.each(response.items,function(key,value){
        videosData.push(value);
        if(value.id.videoId != 'undefined'){
            $html += "<tr>";
            $html+= "<td>"+value.snippet.title+"</td>";
            $html+= "<td>"+value.id.videoId+"</td>";
            $html+= "<td><a href='https://youtube.com/watch?v="+value.id.videoId+"'>https://youtube.com?v="+value.id.videoId+"</a></td>";
            $html+= "</tr>";
        }

    });

    $('#search_resuilts').empty().html($html);
      if(response.nextPageToken != null){
          // searchPage(response.nextPageToken,params);
          //tạm thời chỉ lưu 50 video trên cùng
      }
  });
}

function searchPage(pagetoken,params){
    params.pageToken = pagetoken;
    var request = gapi.client.youtube.search.list(params);
    request.execute(function(response) {
        if(response.nextPageToken != null && response.items.length > 0){
            searchPage(response.nextPageToken,params);
            console.log(response.nextPageToken);
        }
        $html = "";
        $.each(response.items,function(key,value){
            videosData.push(value);
            if(value.id.videoId != 'undefined') {
                $html += "<tr>";
                $html += "<td>" + value.snippet.title + "</td>";
                $html += "<td>" + value.id.videoId + "</td>";
                $html += "<td><a href='https://youtube.com/watch?v=" + value.id.videoId + "'>https://youtube.com?v=" + value.id.videoId + "</a></td>";
                $html += "</tr>";
            }
        });
        $('#search_resuilts').append($html);

    });
}
