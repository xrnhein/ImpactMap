var map;
var davis = {lat: 38.5449, lng: -121.7405};
var davis2 = {lat: 38.5759, lng: -121.7301};
var sacramento = {lat: 38.5816, lng: -121.4944};
var markers =[];
var testMarker, testMarker2, testMarker3;

function initMap() {
	map = new google.maps.Map($("#map").get(0), {
		center: davis,
		zoom: 8,
        mapTypeControl: true,
        mapTypeControlOptions: {
        style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
        position: google.maps.ControlPosition.RIGHT_BOTTOM
        },
        zoomControl: true,
        zoomControlOptions: {
        position: google.maps.ControlPosition.RIGHT_BOTTOM
        },
        scaleControl: true,
        streetViewControl: true,
        streetViewControlOptions: {
        position: google.maps.ControlPosition.RIGHT_BOTTOM
        },
        fullscreenControl: true
	});

	map.setOptions({styles: [ { featureType: "road", stylers: [ { visibility: "off" } ] },{ } ]});


    
    
    
	var testMarker = new google.maps.Marker({
		position: davis,
		map: map,
		title: 'Test marker',
        category: 'Davis'
	});
    
    
    var testMarker2 = new google.maps.Marker({
                                            position: davis2,
                                            map: map,
                                            title: 'Test marker2',
                                            category: 'Davis'
                                            });

    
    var testMarker3 = new google.maps.Marker({
                                            position: sacramento,
                                            map: map,
                                            title: 'Test marker3',
                                             category: 'Sacramento'
                                            });
    
    testMarker.addListener('click', function() {
                           $("#container").toggle(1000);
                           $("#container").animate({
                                                   'width': '507px',
                                                   'padding': '10px',
                                                   'padding-top': '104px'
                                                   }, 300, function() {
                                                   $("#site_title").html("<center><h2>Test Site</h2></center>");
                                                   $("#site_img").html('<center><img src="img/test.png"></center>');
                                                   $("#site_description").html("test 3 ");
                                                   });
                           });
    
    testMarker3.addListener('click', function() {
                           $("#container").toggle(1000);
                           $("#container").animate({
                                                   'width': '507px',
                                                   'padding': '10px',
                                                   'padding-top': '104px'
                                                   }, 300, function() {
                                                   $("#site_title").html("<center><h2>Test Site</h2></center>");
                                                   $("#site_img").html('<center><img src="img/test.png"></center>');
                                                   $("#site_description").html("test 3 ");
                                                   });
                           });
    
    
    testMarker.setIcon('http://maps.google.com/mapfiles/ms/icons/green-dot.png');
    testMarker2.setIcon('http://maps.google.com/mapfiles/ms/icons/blue-dot.png');
    markers = [testMarker, testMarker2, testMarker3];
    
// Create the search box and link it to the UI element.
  var input = document.getElementById('pac-input');
  var searchBox = new google.maps.places.SearchBox(input);
  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
        
  // Bias the SearchBox results towards current map's viewport.
  map.addListener('bounds_changed', function() {
  searchBox.setBounds(map.getBounds());
   });
        
  //var markers = [];
   // Listen for the event fired when the user selects a prediction and retrieve
   // more details for that place.
  searchBox.addListener('places_changed', function() {
  var places = searchBox.getPlaces();
                              
  if (places.length == 0) {
  return;
   }
                              
                        
                              
 // For each place, get the icon, name and location.
 var bounds = new google.maps.LatLngBounds();
 places.forEach(function(place) {
 var icon = {
 url: place.icon,
 size: new google.maps.Size(71, 71),
 origin: new google.maps.Point(0, 0),
 anchor: new google.maps.Point(17, 34),
 scaledSize: new google.maps.Size(25, 25)
};
                                             
 // Create a marker for each place.
  markers.push(new google.maps.Marker({
  map: map,
  icon: icon,
  title: place.name,
  position: place.geometry.location
  }));
                                             
  if (place.geometry.viewport) {
  // Only geocodes have viewport.
  bounds.union(place.geometry.viewport);
  } else {
  bounds.extend(place.geometry.location);
  }
 });
 map.fitBounds(bounds);
});
  
    var content = '<div id="iw-container">' +
        '<div class="iw-title">Something about the center</div>' +
        '<div class="iw-content">' +
        '<div class="iw-subTitle">Project Info</div>' +
        '<p>This project was started in 2008 and is still being worked on ....</p>' +
        '<div class="iw-bottom-gradient"></div>' +
        '</div>';
    var infowindow = new google.maps.InfoWindow({
                        content: content,
                                
                        maxWidth: 350
        });

        testMarker.addListener('click', function() {
                                                          infowindow.open(map, testMarker);
                                                        });
   
}

google.maps.event.addDomListener(window, 'load', initialize);

function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
}

function check(){
        markers[0].setMap(null);
        markers[1].setMap(null);
        markers[2].setMap(map);
}

function uncheck(){
        markers[2].setMap(null);
        markers[0].setMap(map);
        markers[1].setMap(map);
}
function check2(){
    markers[0].setMap(map);
    markers[1].setMap(map);
    markers[2].setMap(map);
}

