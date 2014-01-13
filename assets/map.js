$(window).load(function() {
   // Initialize the map
     $("#next").hide();
     $("#back").hide();
    var obj;
    var map;
$.get("http://yourshore.corp.gq1.yahoo.com:4080/Testing-0.0.2-SNAPSHOT/v1/flicker/hi", function(data, status) {
    getImage(data);
    $("#submit").click(function(){
      marker(data);
      $("#submit").hide();
      $("#next").show();
    });

})
.done(function(data, status) {})
.fail(function(data, status) {
  alert("error" + data.responseText + " " + status);
})
.always(function(data) { });
    var markers = [];
    var markerSet = false;

    buildMap();
    function getImage(data) {
        var imageId = $('#flickr').attr("src", data.url);
        $('#image-link').attr("href",data.flickerUrl);
    }

    function buildMap() {
        var map_canvas = document.getElementById('map_canvas');
        var map_options = {
          center: new google.maps.LatLng(44.5403, -78.5463),
          zoom: 4,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        map = new google.maps.Map(map_canvas, map_options);
	console.log(map);
        google.maps.event.addListener(map, 'click', function(event){
          if(markerSet){
            for (var i = 0; i < markers.length; i++) {
              markers[i].setMap(null);
            }
            markers = [];
            markerSet = false;
          }
          var marker = new google.maps.Marker({
              position: event.latLng,
              map: map,
	      icon: new google.maps.MarkerImage("http://maps.google.com/mapfiles/ms/icons/red.png")
            });
            console.log(event.latLng);
            markers.push(marker);
            markerSet = true;
	    $("#submit").removeAttr("disabled");
        });
    }
      function	marker(data){
          var img_latlng = new google.maps.LatLng(data.LAT,data.LONG);
          var img_marker = new google.maps.Marker({
            position: img_latlng,
            map: map,
            icon: new google.maps.MarkerImage("http://maps.google.com/mapfiles/ms/icons/blue.png")
          });
        markers.push(img_marker);
      
	var dist = google.maps.geometry.spherical.computeDistanceBetween(img_latlng,markers[0].position);
	resize_map();
	var score = Math.round(dist / 1000);
	$('#points').text(score);
    }

    function resize_map() {
   	 var bound = new google.maps.LatLngBounds();
    	for(var i = 0; i < markers.length; i++) {
        bound.extend(markers[i].position);
    	}
      	map.fitBounds(bound);
     }

    $("#next").click(function() {
        location.reload;
    });

    $("#rank").click(function(e) {
        e.preventDefault();
        $("#rank").hide();
        $("#back").show();
        $("#rank-board").attr("style",  "position: absolute; left:0px");
        $("#game").attr("style", "position: relative; left:250px");
    });
    $("#back").click(function(e) {
        e.preventDefault();
        $("#back").hide();
        $("#rank").show();
        $("#rank-board").removeAttr("style");
        $("#game").removeAttr("style");
    });

    var score = dist / 1000;
});
