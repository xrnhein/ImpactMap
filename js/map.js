/*
	All of the client-side code to control interactions with the map and to request data from the server.
	This is where pins are loaded and the logic behind the interface takes place
*/

// The reference to a google maps map
var map;
// GPS coordinates for Davis
var davis = {lat: 38.5449, lng: -121.7405};
// A reference to a Bloodhound search suggestion object
var projects;

/** 
* Called by the google maps api on load, initializes the map
*/
function initMap() {
	// Create a new google maps object
	map = new google.maps.Map($("#map").get(0), {
		center: davis,
		zoom: 6,
		disableDefaultUI: true
	});

	// Configure the style
	map.setOptions({styles: [ { featureType: "road", stylers: [ { visibility: "off" } ] },{ } ]});

	// Request all the projects that meet the filters
	$.ajax({
        type: "POST",
        url: "php/admin/projects/load_projects.php",
        data: {},
        data_type: "json",
        // On a successful request, populate the map with markers for each project and add user click interactions
        success: function(data) {
        	var projects = JSON.parse(data);
        	projects.forEach(function(project) {
        		var marker = new google.maps.Marker({
					position: {lat: project.lat, lng: project.lng},
					map: map,
					title: project.title
				});

        		// Add a click listener to each marker added to load details of the project when a user clicks on it
				marker.addListener('click', function() {
					$.ajax({
				        type: "POST",
				        url: "php/admin/projects/load_project_details.php",
				        data: {pid: project.pid},
				        data_type: "json",
				        // On click animate a dialog window expanding to show details about the project
				        success: function(data) {
				        	project = JSON.parse(data);

				        	$("#container").animate({
								'width': '507px',
								'padding': '10px'
							}, 300, function() {
								$("#site_title").html("<center><h3>" + project.title + "</h3></center>");
								$("#site_description").html(project.description);
							});

							$("#bg").animate({
								'width': '507px',
								'padding': '10px',
								'padding-top': '0px',
								'padding-bottom': '0px'
							}, 300);
				        	
				        },
				        complete: function() {

				        }
				    });
				});
        	});
        },
        complete: function() {

        }
    });
}

/** 
* Called when the web page is loaded. Initializes the search suggestion engine and readies the search bar for queries.
*/
$(document).ready(function () {
	// Create the Bloodhound suggestion engine object
	projects = new Bloodhound({
	    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
	    queryTokenizer: Bloodhound.tokenizers.whitespace,
	    prefetch: {
	        url: 'json/search.json',
	        filter: function (projects) {
	            return $.map(projects, function (project) {
	                return {
	                    name: project
	                };
	            });
	        }
	    }
	});

	// Clear the prefetch cache in case it's been updated (projects added/edited/deleted)
	projects.clearPrefetchCache();

	// Initialize the Bloodhound suggestion engine
	projects.initialize();

	// Instantiate the Typeahead UI
	$('#searchbar').typeahead(null, {
	    displayKey: 'name',
	    source: projects.ttAdapter()
	});

	// When the user presses enter in the search bar send a search request to the server
	$('#searchbar').keypress(function (event) {
		if (event.which == 13) {
			// Convert all of the words in the user's search query to their root form (i.e. running -> run)
		    var stemmer = new Snowball("english");
		    var searchWords = $("#searchbar").val().split(" ");
		    searchWords.forEach(function (word, i, words) {
		        stemmer.setCurrent(word);
		        stemmer.stem();
		        words[i] = stemmer.getCurrent();
		    });
		    console.log(searchWords.join(" "));

		    // Send the search terms to the server and print any matches
			$.ajax({
		        type: "POST",
		        url: "php/map/search.php",
		        data: {stemmedSearchText: searchWords.join(" ")},
		        data_type: "json",
		        success: function(data) {
		        	console.log(data);
		        }
		    });
		}
	});
});