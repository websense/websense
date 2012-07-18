/**
 * This file encapsulates all the google-maps logic used in the websense project.
 * Google maps is merely used to display the overview-map, heatmaps are drawn via openlayers.
 * 
 * This file relies on the google maps API v3.
 */

/**
 * Creates a map on the given mapCanvasElement.
 * It must have a fixed width and height for this function to succeed.
 *
 * "nodes" provides an array of objects structured like this:
 * [{lat: 1, lon: 2, value : "popup html/string"},{lat: 3, lon: 4, value : "popup"}].
 */
function initializeGoogleMap(mapCanvasElement, nodes) {
	var map = new google.maps.Map(mapCanvasElement, {
		mapTypeId : google.maps.MapTypeId.SATELLITE
	});
	// Bound to display all markers in:
	var bounds = new google.maps.LatLngBounds();
	// Offset the popup-root to be at the position of the marker, not above it:
	var infowindow = new google.maps.InfoWindow({
		pixelOffset : new google.maps.Size(0, 34)
	});

	// Add markers to the map:
	var marker, i;
	for( i = nodes.length - 1; i >= 0; i--) {
		var pos = new google.maps.LatLng(nodes[i].lat, nodes[i].lon);
		marker = new google.maps.Marker({
			position : pos,
			map : map
		});
		// Associate the popup-value with each marker on the map.
		// Closure magic taken from http://stackoverflow.com/questions/3059044/google-maps-js-api-v3-simple-multiple-marker-example
		google.maps.event.addListener(marker, 'click', (function(marker, i) {
			return function() {
				infowindow.setContent(nodes[i].value);
				infowindow.open(map, marker);
			}
		})(marker, i));

		// Extend bound until it can show all the markers:
		bounds.extend(pos);
	}
	// Fit the viewport such that every marker is visible:
	map.fitBounds(bounds);
}