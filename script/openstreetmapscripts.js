/**
 * This script contains all the functions used to draw basic openstreetmaps and heatmaps.
 * It relies on the Openlayers.js file to do so.
 *
 */

/**
 * Constants used to transfer the "heat" of each sensor into a RGB range of blue to red.
 * See createHeatToWaveLengthFunction.
 */
var minWaveLength = 440;
var maxWaveLength = 700;

/**
 * Creates a function that converts heat in the range of minHeat..maxHeat to a subrange of the
 * range of the visible light. This produces a value between blue and red.
 * Inspired by:
 * http://stackoverflow.com/questions/2374959/algorithm-to-convert-any-positive-integer-to-an-rgb-value
 */
function createHeatToWaveLengthFunction(minHeat, maxHeat) {
	// Avoid division by 0:
	var heatSpan = ( maxHeat - minHeat) || 1;
	var factor = ( maxWaveLength - minWaveLength) / heatSpan;
	var adjustment = minWaveLength - minHeat * factor;
	return function(heat) {
		return heat * factor + adjustment;
	};
}

/**
 * Taken from:
 * http://www.efg2.com/Lab/ScienceAndEngineering/Spectra.htm
 */
function adjust(color) {
	// Don't want 0^x = 1 for x <> 0
	if(color === 0) {
		return 0;
	}
	// 255 = max intensity, 0.8 = gamma
	return Math.floor(255 * Math.pow(color, 0.8));
}

/**
 * Turns wavelength into a css RGB-string.
 * Taken from:
 * http://www.efg2.com/Lab/ScienceAndEngineering/Spectra.htm
 */
function wavelengthToRGB(wavelength) {
	var truncWavelength = Math.floor(wavelength);
	if(truncWavelength < minWaveLength || truncWavelength > maxWaveLength) {
		// white:
		return '#ffffff';
	}

	var blue, green, red;

	if(truncWavelength >= minWaveLength && truncWavelength <= 489) {
		red = 0.0;
		green = ( wavelength - 440) / (490 - 440);
		blue = 1.0;
	} else if(truncWavelength >= 490 && truncWavelength <= 509) {
		red = 0.0;
		green = 1.0;
		blue = -( wavelength - 510) / (510 - 490);
	} else if(truncWavelength >= 510 && truncWavelength <= 579) {
		red = ( wavelength - 510) / (580 - 510);
		green = 1.0;
		blue = 0.0;
	} else if(truncWavelength >= 580 && truncWavelength <= 644) {
		red = 1.0;
		green = -( wavelength - 645) / (645 - 580);
		blue = 0.0;
	} else {
		red = 1.0;
		green = 0.0;
		blue = 0.0;
	}

	var redHex = adjust(red).toString(16);
	var greenHex = adjust(green).toString(16);
	var blueHex = adjust(blue).toString(16);
	// RGB string is of format: #rrggbb.
	// Pad with 0 if necessary:
	redHex = redHex.length == 2 ? redHex : '0' + redHex;
	greenHex = greenHex.length == 2 ? greenHex : '0' + greenHex;
	blueHex = blueHex.length == 2 ? blueHex : '0' + blueHex;

	return '#' + redHex + greenHex + blueHex;
}

/**
 * Creates a function with a shared popup that handles clicks on a feature (known as "this" in the function.)
 * map: The map the popup is displayed on.
 */
function createShowPopupFunction(map) {
	var sharedPopup;
	return function(evt) {
		if(sharedPopup && sharedPopup.visible()) {
			sharedPopup.hide();
		}
		if(this.popup == null) {
			this.popup = this.createPopup(this.closeBox);
			map.addPopup(this.popup);
			this.popup.show();
		} else {
			this.popup.toggle();
		}
		sharedPopup = this.popup;
		OpenLayers.Event.stop(evt);
	};
}

// Settings for each opoup:
var popupClass = OpenLayers.Class(OpenLayers.Popup.FramedCloud, {
	'autoSize' : true,
	'minSize' : new OpenLayers.Size(300, 50),
	'maxSize' : new OpenLayers.Size(500, 300),
	'keepInMap' : true
});
// Options for the created maps:
var options = {
	units : 'm'
};
// The projection of the latitude and logitude values.
var srcProjection = new OpenLayers.Projection('EPSG:4326');

// For internal use.
// Creates a plain OSM.
function createOpenStreetMap(mapCanvas, nodes, heatRadiusMeters, minHeat, maxHeat) {
	var map = new OpenLayers.Map(mapCanvas, options);
	var osmLayer = new OpenLayers.Layer.OSM();
	map.addLayer(osmLayer);
	return map;
}

/**
 * Draws an OpenStreetMap onto the mapCanvas. value property of each node is treated as its popup-text.
 */
function initializeOSMOverview(mapCanvas, nodes) {
	// Precached Marker for overview-maps:
	initializeOSMOverview.redIcon = initializeOSMOverview.redIcon || new OpenLayers.Icon('http://www.openlayers.org/dev/img/marker.png', new OpenLayers.Size(21, 25), new OpenLayers.Pixel(-(21 / 2), -25));

	var map = createOpenStreetMap(mapCanvas);
	// Overview maps just need markers:
	var markerLayer = createMarkerLayer(map, nodes, initializeOSMOverview.redIcon);
	// Zoom out till all markers fit:
	map.zoomToExtent(markerLayer.getDataExtent());
	// Add the markers at last:
	map.addLayer(markerLayer);
}

/**
 * Creates an OSM Heatmap on the mapCanvas.
 * It includes markers with popup of the value of each node + unit.
 * It will contain an empty heat-layer, which is returned by this function for further adding of heat-circles.
 */
function initializeOSMHeat(mapCanvas, nodes, unit) {
	// Precached Marker for heat-maps:
	initializeOSMHeat.blueIcon = initializeOSMHeat.blueIcon || new OpenLayers.Icon('http://www.openlayers.org/dev/img/marker-blue.png', new OpenLayers.Size(10.5, 12.5), new OpenLayers.Pixel(-(10.5 / 2), -12.5));

	var map = createOpenStreetMap(mapCanvas);

	// Add heat layer under the markers, to make the markers clickable:
	var heatLayer = new OpenLayers.Layer.Vector('Heat Layer');
	map.addLayer(heatLayer);
	// Make map accessible via the layer.map property:
	heatLayer.setMap(map);

	// Markers on top. Heat -> append unit to value.:
	var markerLayer = createMarkerLayer(map, nodes, initializeOSMHeat.blueIcon, unit);
	// Zoom out till all markers fit:
	map.zoomToExtent(markerLayer.getDataExtent());
	// Add the markers:
	map.addLayer(markerLayer);

	return heatLayer;
}

// For internal use.
// Creates a Layer with markers and popups.
// If unit is set, append it to the value of the node.
function createMarkerLayer(map, nodes, markerImage, unit) {
	unit = unit || '';
	var destProjection = map.getProjectionObject();
	var markerLayer = new OpenLayers.Layer.Markers('Markers');

	// Function for showing a popup with the information of the feature it is opened upon.
	var markerClick = createShowPopupFunction(map);

	for(var i = nodes.length - 1; i >= 0; i--) {
		var mark = nodes[i];
		// val is 1) heat (temperature, soil moisture...), if this is a heatmap or 2) a list of sensors of this node if not
		var val = mark.value;

		var pt = new OpenLayers.LonLat(mark.lon, mark.lat).transform(srcProjection, destProjection);
		var feature = new OpenLayers.Feature(markerLayer, pt);
		feature.closeBox = true;
		feature.popupClass = popupClass;
		feature.data.popupContentHTML = val + unit;
		feature.data.overflow = 'auto';
		var marker = new OpenLayers.Marker(pt, markerImage.clone());
		marker.events.register('mousedown', feature, markerClick);
		markerLayer.addMarker(marker);
	}
	return markerLayer;
}

/**
 * The value of each node is treated as the "heat" at this point
 * and it is displayed accordingly.
 * HeatRadiusMeters specifies the radius around the node where the heat is valid.
 * minHeat and maxHeat are the upper and lower bounds of the heat-scale.
 * They may be relative to the nodes, or static.
 */ 
function refillHeatLayer(heatLayer, nodes, heatRadiusMeters, minHeat, maxHeat) {
	// Remove old heat-circles if there were any:
	heatLayer.destroyFeatures();

	var destProjection = heatLayer.map.getProjectionObject();
	// Create function to transform heat into wavelength:
	var heatToWaveLength = createHeatToWaveLengthFunction(minHeat, maxHeat);

	for(var i = nodes.length - 1; i >= 0; i--) {
		var node = nodes[i];

		var pt = new OpenLayers.LonLat(node.lon, node.lat).transform(srcProjection, destProjection);
		var center = new OpenLayers.Geometry.Point(pt.lon, pt.lat);
		var heatCircle = new OpenLayers.Geometry.Polygon.createRegularPolygon(center, heatRadiusMeters, 360);
		var wavelength = heatToWaveLength(node.value);

		// The style the heat-circle is drawn with.
		var heatStyle = {
			fillColor : wavelengthToRGB(wavelength),
			fillOpacity : 0.7,
			stroke : false
		};

		var heatVector = new OpenLayers.Feature.Vector(heatCircle, null, heatStyle);
		heatLayer.addFeatures([heatVector]);
	}
}