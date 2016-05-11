var map;
var davis = {lat: 38.5449, lng: -121.7405};

var countries;

function initMap() {
	map = new google.maps.Map($("#map").get(0), {
		center: davis,
		zoom: 6,
		disableDefaultUI: true
	});

	map.setOptions({styles: [ { featureType: "road", stylers: [ { visibility: "off" } ] },{ } ]});

	/*
	var testMarker = new google.maps.Marker({
		position: davis,
		map: map,
		title: 'Test marker'
	});

	testMarker.addListener('click', function() {
		$("#container").animate({
			'width': '507px',
			'padding': '10px'
		}, 300, function() {
			$("#site_title").html("<center><h3>SPEED Business Case: Adaptive Street and Area Lighting</h3></center>");
			$("#site_img").html('<center><img src="img/328.jpg" width="400px"></center>');
			$("#site_description").html("This business case explores various lighting control options for LED retrofits of street and area lighting, along with funding and financing sources. It provides a general economic analysis of the costs and benefits associated with street/area retrofits and new-construction installations of post-top luminaires. The scenarios presented in this business case analysis have the potential to reduce lighting energy use and carbon emissions 72–93%, in areas with an average occupancy rate of 20%. In June 2012, UC Davis completed a campus-wide exterior lighting retrofit using fixture-level occupancy sensors by WattStopper and an RF mesh network lighting control system by Lumewave. Over 1500 new dimmable LED fixtures by Philips were installed as part of the project. Parking lot and roadway lighting, wall packs, and post-top fixtures are now incorporated into a single smart lighting system that senses occupants’ direction and rate of travel and adjusts light levels for the route ahead while lights in vacant areas operate at lower power levels.");
		});

		$("#bg").animate({
			'width': '507px',
			'padding': '10px',
			'padding-top': '0px',
			'padding-bottom': '0px'
		}, 300);
	});
	*/

	$.ajax({
        type: "POST",
        url: "php/load_projects.php",
        data: {},
        data_type: "json",
        success: function(data) {
        	var projects = JSON.parse(data);
        	projects.forEach(function(project) {
        		var marker = new google.maps.Marker({
					position: {lat: project.lat, lng: project.lng},
					map: map,
					title: project.title
				});

				marker.addListener('click', function() {
					$.ajax({
				        type: "POST",
				        url: "php/load_project_details.php",
				        data: {pid: project.pid},
				        data_type: "json",
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

	countries = new Bloodhound({
	    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
	    queryTokenizer: Bloodhound.tokenizers.whitespace,
	    prefetch: {
	        url: 'search.json',
	        filter: function (countries) {
	            return $.map(countries, function (country) {
	                return {
	                    name: country
	                };
	            });
	        }
	    }
	});

	// Initialize the Bloodhound suggestion engine
	countries.initialize();

	// Instantiate the Typeahead UI
	$('#searchbar').typeahead(null, {
	    displayKey: 'name',
	    source: countries.ttAdapter()
	});
}