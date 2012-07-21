/**
 * This script contains all the clientside-logic and is also the "entry point" for execution.
 * Execution starts at the "$(function(){...}" from jQuery, as identified by the $-sign.
 *
 * AJAX-functions used are:
 * $.get and $.getJSON. (see http://docs.jquery.com/Main_Page).
 *
 * <p>
 * How tabs work:
 * By clicking on a tab, the script on the server-side with the same name as the HTML-id of the tab-div in "index.php"
 * is called. (Example: Click on <div id="overview"></div> calls "overview.php")
 * <br>
 * Adding a tab containing static HTML then simply means to add a div with id:"newtab" in index.php
 * and a corresponding server-script "newtab.php" in the ajax-folder.
 * Dynamic content needs special handling, see commented code below.
 * </p>
 */

/**
 * Handles clicks on the graphing-submit-button. CSV output is offered in the browsers download dialog,
 * Graphs open in a new browser tab.
 * Safari will default to a new window, but this is a setting that the user should choose in his browser preferences.
 */
function handleGraphingSubmit(graphingForm, earliestStartDate, latestEndDate) {
	// The parameters passed to create_graph.php:
	var params = {
		trials : selectedLocation.trials,
		outputtype : graphingForm.find('input[name=outputtype]:checked').val(),
		sensors : [],
		// Break cache of browser through a varying parameter -> request image anew each time, as server state may have changed.
		cacheBreak : (new Date()).getTime()
	};

	// Basic validation and params for corresponding selection:
	var interval = $('input[name=interval]:checked');
	var intervalType = interval.val();
	if(intervalType === 'fixed') {
		var startDateString = $('#startdate').val();
		var endDateString = $('#enddate').val();
		var valid = checkDates(startDateString, endDateString, earliestStartDate, latestEndDate);
		if(!valid) {
			return false;
		}

		params.startdate = startDateString;
		params.enddate = endDateString;
	} else { // custom, defaults and "everything":
		var time_span;

		if(intervalType === 'custom') {
			var customValue = $('#custom_text').val();
			if(!isNumber(customValue) || customValue <= 0) {
				alert('In "Last x hours/days", x must be a number greater than 0.');
				return false;
			}
			time_span = $('#custom_type option:selected').val() + customValue;
		} else {
			// also "Everything" with value: "all"
			time_span = interval.val();
		}
		params.time_span = time_span;
	}

	graphingForm.find('select[name=sensors] option:selected').each(function() {
		params.sensors.push(this.getAttribute('value'));
	});
	if(params.sensors.length === 0) {
		alert('Please select at least one sensor.');
		return false;
	}

	var creationURL = 'ajax/create_graph.php?' + $.param(params);
	if(params.outputtype === 'graph') {
		// null: open a new window every time, do not reuse old ones.
		window.open(creationURL, null);
	} else { // csv
		// Open download dialog.
		window.location.href = creationURL;
	}
	// Avoid submitting the form to the server:
	return false;
}

/**
 * Handles clicks on the heat-map submit-button. Checks input and forwards it to the server to get back sensor information to draw the map with.
 */
function handleHeatMapSubmit(heatForm, earliestStartDate, latestEndDate) {
	// Validate input:
	var heatDate = $('#heat_date').val();
	var heatHour = $('#heat_hour').val();
	var heatPlusMinutes = $('#heat_plus_minutes').val();
	var valid = checkDates(heatDate, latestEndDate, earliestStartDate, latestEndDate);
	if(!valid) {
		return false;
	}
	if(!isNumber(heatHour) || heatHour > 23 || heatHour < 0) {
		alert('Hour of Day must be a number between 0 and 23 inclusive.');
		return false;
	}
	if(!isNumber(heatPlusMinutes) || heatPlusMinutes < 0) {
		alert('Time interval should be a positive number.');
		return false;
	}

	// End pending heat map request if there is one:
	selectedLocation.unfinishedHeatMapRequest = abortIfExists(selectedLocation.unfinishedHeatMapRequest);

	// Parameters to be sent to create_heat_map.php
	var params = {
		trials : selectedLocation.trials,
		date : heatDate,
		hour : heatHour,
		plus_minutes : heatPlusMinutes,
		phenomenon : heatForm.find('select[name=phenomena] option:selected').attr('value'),
		depth : heatForm.find('select[name=depths] option:selected').attr('value')
	};
	// Get jQuery-Elements once:
	var heatmapCanvas = $('#heatmap_canvas');
	var spectrum = $('#spectrum');
	var scaleMin = $('#spectrum_min'), scaleMax = $('#spectrum_max');
	var scaleCheckBox = spectrum.find('input:checkbox[name=relative_scale]');

	heatmapCanvas.text('Loading heatmap...');
	// Spectrum is hidden until a heat map is drawn successfully:
	spectrum.css('visibility', 'hidden');
	selectedLocation.unfinishedHeatMapRequest = $.getJSON('ajax/create_heat_map.php', params, function(heatInfo) {
		// AJAX finished.
		selectedLocation.unfinishedHeatMapRequest = null;
		// Clear everything first:
		heatmapCanvas.empty();
		scaleMin.text('');
		scaleMax.text('');
		scaleCheckBox.unbind();
		scaleCheckBox.attr('checked', false);

		// No sensors?
		if(!heatInfo.sensors) {
			heatmapCanvas.text('No sensor collected data for these parameters.');
			return;
		}
		var unit = ' ' + heatInfo.bounds.unit;

		// Use static scale by default:
		var heatLayer = initializeOSMHeat('heatmap_canvas', heatInfo.sensors, unit);
		refillHeatLayer(heatLayer, heatInfo.sensors, 10, heatInfo.bounds.static_lower, heatInfo.bounds.static_upper);
		scaleMin.text(heatInfo.bounds.static_lower + unit);
		scaleMax.text(heatInfo.bounds.static_upper + unit);

		spectrum.css('visibility', 'visible');

		// Register for change of scale. Change it accordingly:
		scaleCheckBox.change(function() {
			var relativeScale = scaleCheckBox.is(':checked');
			var scaleLower, scaleUpper;
			if(relativeScale) {
				scaleLower = heatInfo.bounds.relative_lower;
				scaleUpper = heatInfo.bounds.relative_upper;
			} else {
				scaleLower = heatInfo.bounds.static_lower;
				scaleUpper = heatInfo.bounds.static_upper;
			}
			// Change the heat-layer of the heatmap accordingly to the change in scale
			// (Basically redraw all the circles):
			refillHeatLayer(heatLayer, heatInfo.sensors, 10, scaleLower, scaleUpper);
			scaleMin.text(scaleLower + unit);
			scaleMax.text(scaleUpper + unit);
		});
	});
	return false;
}

// Global variable used only by the functions in this file.
// Info about (loading) state of the selected location(s).
// Used for aborting old requests that are no longer needed because the location was switched during execution.
var selectedLocation = {
	trials : [],
	loadedContent : [],
	unfinishedAJAXRequests : [],
	unfinishedHeatMapRequest : null
};

// Start of jquerys document-ready function.
// This gets executed as soon as the DOM is ready on loading the page.
$(function() {
	// Find the trial-menu once for faster retrieval of selected trials.
	var trialMenu = $('#observed_locations');

	// Default values for all datepickers (jQueryUI):
	$.datepicker.setDefaults({
		dateFormat : 'yy-mm-dd',
		showOn : 'button',
		// Preload calendar-image, avoids flickering on initial load:
		buttonImage : (new Image()).src = 'images/office-calendar.png',
		buttonImageOnly : true,
		buttonText : 'Show Calendar'
	});
	// Establish tabs (jQueryUI):
	var $tabs = $( '#network_info' ).tabs({
		select : function(event, ui) {
			// If the content of the tab is already loaded, we have nothing left to do:
			var selectedTab = ui.panel.id;
			if($.inArray(selectedTab, selectedLocation.loadedContent) != -1) {
				return;
			}
			var selectedTabElement = $('#' + selectedTab);
			// That no trial is selected should not be possible, maybe through back-button in browsers.
			if(!selectedLocation.trials.length) {
				selectedTabElement.text('No trial selected. Please select one or more on the left side.');
				return;
			}
			selectedTabElement.text('Loading...');

			// Every tab has a corresponding server side php script with the same name to ease case-handling.
			selectedLocation.unfinishedAJAXRequests.push($.get('ajax/' + selectedTab + '.php', {
				trials : selectedLocation.trials
			}, function(data, status, request) {
				// AJAX finished.
				selectedLocation.loadedContent.push(selectedTab);
				selectedLocation.unfinishedAJAXRequests.remove(request);

				// overview needs special handling, because it retrieves its data in JSON format, not HTML.
				if(selectedTab === 'overview') {
					selectedTabElement.html(data.html);
					switch(data.displaypref) {
						case 'GoogleMaps':
							initializeGoogleMap(document.getElementById('map_canvas'), data.nodes);
							break;
						case 'OpenStreetMaps' :
							initializeOSMOverview('map_canvas', data.nodes);
							break;
						case 'LocalImage' :
							$('#map_canvas').html('<img id="local_image" src="images/' + data.image + '" alt="Image of the selected trial" title="Right click to open image in new window">');
							break;
					}
				} else {
					// All other tabs get simple html:
					selectedTabElement.html(data);
				}
				// Only graphs and heat_map need special handling for their forms:
				if(selectedTab !== 'graphs' && selectedTab !== 'heat_map') {
					return;
				}
				// Activate datepickers in the created content with the correct date interval:
				var earliestStartDate = selectedTabElement.find('input:hidden[name=earliest_startdate]').val();
				var latestEndDate = selectedTabElement.find('input:hidden[name=latest_enddate]').val();
				var dateBounds = {
					minDate : new Date(earliestStartDate),
					maxDate : new Date(latestEndDate)
				};
				selectedTabElement.find('.calendar').datepicker(dateBounds);

				if(selectedTab === 'graphs') {
					// Add handlers to the interval-radiobuttons to toggle editable content on/off based on selection:
					var customRbtn = $('#custom_rbtn'), customType = $('#custom_type'), customText = $('#custom_text');
					var fixedRbtn = $('#fixed_interval_rbtn'), fixedTable = $('#date_interval_table');
					var btnGroup = $('input[name=interval]');
					btnGroup.change(function() {
						var disableCustom = !customRbtn.attr('checked');
						customType.prop('disabled', disableCustom);
						customText.prop('disabled', disableCustom);
						var hideFixed = fixedRbtn.prop('checked') ? 'visible' : 'collapse';
						fixedTable.css('visibility', hideFixed);
					});
					// Catch the submit-button-click for creating graphs/csv-text:
					var graphingForm = $('#graphing_form');
					graphingForm.submit(function() {
						return handleGraphingSubmit(graphingForm, earliestStartDate, latestEndDate);
					});
					// Resetting doesn't hide the custom and fixed input fields. Do it manually here:
					graphingForm.find('[type="reset"]').click(function() {
						customType.prop('disabled', true);
						customText.prop('disabled', true);
						fixedTable.css('visibility', 'collapse');
					});
				} else { // heat map
					// Catch the submit-button-click for creating heat maps:
					var heatForm = $('#heat_form');
					heatForm.submit(function() {
						return handleHeatMapSubmit(heatForm, earliestStartDate, latestEndDate);
					});
				}

			}));
		}
	});

	/**
	 * Clears the old content in the tabs and cancels any pending AJAX-requests to the server.
	 * Changes the selectedLocation- global variable to contain the new set of selected trials.
	 *
	 * Also colors the selected trials in the menu on the left side of the page.
	 */
	function changeLocation() {
		// Get all the selected trials:
		var trials = selectedLocation.trials;
		trials.length = 0;
		var selectedTrials = trialMenu.find("input:checkbox[name='trials[]']:checked");
		// Don't change location when nothing is selected.
		if(selectedTrials.length == 0) {
			return false;
		}
		trialMenu.find("input:checkbox[name='trials[]']").each(function() {
			var trial = $(this);
			if(trial.is(':checked')) {
				trials.push(trial.val());
				// Mark containing <li> as selected:
				trial.parent().parent().addClass('selected-trial');
			} else {
				// Remove if present:
				trial.parent().parent().removeClass('selected-trial');
			}
		});
		// If there are any pending requests, cancel them:
		for(var i = selectedLocation.unfinishedAJAXRequests.length - 1; i >= 0; i--) {
			selectedLocation.unfinishedAJAXRequests[i].abort();
		}
		selectedLocation.unfinishedAJAXRequests.length = 0;
		selectedLocation.unfinishedHeatMapRequest = abortIfExists(selectedLocation.unfinishedHeatMapRequest);

		// Remove old content:
		$('ul li','#network_info').each(function() {
			$(this.getAttribute('href')).empty();
		});
		// Update every loaded data on selection:
		selectedLocation.loadedContent.length = 0;

		// Change selected tab to first one (overview):
		$('.ui-tabs-selected','#network_info').removeClass('ui-state-active').removeClass('ui-tabs-selected');
		$tabs.tabs('select', 0);
		return false;
	}

	//NOTE: This code is run on loading the page:

	// If somehow no trial is selected, select the first one by default:
	if(!trialMenu.find("input:checkbox[name='trials[]']:checked").length) {
		trialMenu.find("input:checkbox[name='trials[]']:first").attr('checked', true);
	}

	// Register clicks on check/uncheck all button:
	trialMenu.find(".country_group").each(function(){
		var countryGroup = $(this);
		var heading = countryGroup.find(".country_heading");
		
		heading.click(function(){
			var allTrialBoxes = countryGroup.find("input:checkbox[name='trials[]']");
			var checkedTrialBoxes = countryGroup.find("input:checkbox[name='trials[]']:checked");
			
			if(allTrialBoxes.length == checkedTrialBoxes.length){
				// All checked -> uncheck all.
				allTrialBoxes.attr('checked', false);
			} else{
				// Some checked -> check all.
				allTrialBoxes.attr('checked', true);
			}
		});
	});

	// Register change in location/site via submit-button-click:
	trialMenu.submit(changeLocation);
	// Load initial network information for default selected trial:
	changeLocation();
});