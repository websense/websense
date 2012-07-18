<?php
/**
 * This script adds an array with the correct locale for the current call to the global namespace,
 * determined by the session. Defaults to English.
 *
 * @package main
 */

$all_messages =
array(
	'english' => 
	array(
	
		// banner.php
		
		'banner.logo.hsma.alt' => 'Logo of the Hochschule Mannheim',
		'banner.logo.hsma.title' => 'Visit the Hochschule Mannheim',
		'banner.logo.uwa.alt' => 'Logo of the University of Western Australia',
		'banner.logo.uwa.title' => 'Visit the University of Western Australia',
		'banner.title' => 'WebSense: Sensor Network Viewer',
		'banner.navigation.home' => 'Home',
		'banner.navigation.administration' => 'Administration',
		'banner.navigation.publications' => 'Publications',
		'banner.navigation.downloads' => 'Downloads',
		'banner.navigation.contact' => 'Contact',
	
		// contact.php
		
		'contact.title' => 'Websense3 - Contact',
		'contact.paragraph.1' => 'This application is based on
			a Java-based WebSense application developed at the
			Hochschule Mannheim, Germany.',
		'contact.paragraph.2' => 'The following people have contributed
			to versions of
			this system and its database.',
		'contact.feedback.paragraph.1' => 'Please send us a',
		'contact.feedback.mail' => 'feedback email',
		'contact.feedback.paragraph.2' => 'if you have any comments, notice
			a bug or would like a copy of this software.',
		
		// downloads.php
		
		'downloads.title' => 'Websense3 - Downloads and Documentation',
		'downloads.used.software' => 'Used 3rd Party Software',
		'downloads.apache.web.server' => 'Apache Web Server',
		'downloads.postgresql' => 'PostgreSQL Database',
		'downloads.jquery' => 'jQuery',
		'downloads.jqueryui' => 'jQuery UI',
		'downloads.jpgraph' => 'JpGraph',
		'downloads.installation' => 'Installation Instructions',
		'downloads.link' => 'Link',
		'downloads.database.skeleton' => 'Database Skeleton',
		'downloads.webapp.code' => 'Web Application Code',
		'downloads.tba' => 'TBA',
		
		// index.php
		'index.title' => 'Websense3',
		'index.tabs.overview' => 'Overview',
		'index.tabs.event.history' => 'Event History',
		'index.tabs.phenomena' => 'Phenomena',
		'index.tabs.sensors' => 'Sensors',
		'index.tabs.graphs' => 'Graphs',
		'index.tabs.sensor.health' => 'Sensor Health',
		'index.tabs.heat.map' => 'Heat Map',
		
		// menu.php
		'menu.no.trials' => 'There are no trials (yet) to select.',
		'menu.info.paragraph.1' => 'Select one or more trials of the list below and click "Change Location".',
		'menu.info.paragraph.2' => 'These trials can then be queried through the tabs.',
		'menu.buttons.checkall' => 'Check all',
		'menu.buttons.uncheckall' => 'Uncheck all',
		'menu.buttons.submit' => 'Change Location',
		
		// opendb.php
		'opendb.error' => 'Cannot connect to test database. Try editing opendb.php to set the real database.',
		
		// publications.php
		'publications.title' => 'Websense3 - Publications',
		'publications.overview' => 'Websense Overview',
		'publications.deployments' => 'Sensor Network Deployments',
		
		// create_graph.php
		'create.graph.error.generic' => 'Please select one or more Sensor Nodes to display and select output format.',
		'create.graph.error.query.enddate' => 'Error performing enddate query.',
		'create.graph.error.query.startdate' => 'Error performing startdate query.',
		'create.graph.error.date.interval.missing' => 'Please specify date interval.',
		'create.graph.error.query.num.days' => 'Error performing num days query.',
		'create.graph.error.query.name' => 'Error performing name query.',
		'create.graph.error.query.csv' => 'Error performing csv query.',
		'create.graph.graph.title' => 'Sensor data for {trialname} from {startdate} to {enddate}',
		'create.graph.error.query.time.wert' => 'Error performing time,wert graph query',
		
		// create_heat_map.php
		'create.heat.map.error.query.main' => 'Error performing heat map query.',
		'create.heat.map.error.query.phenomenon' => 'Error performing phenomenon bounds query.',
		
		// event_history.php
		'event.history.multiple.trials.selected' => 'View individual networks for further information.',
		'event.history.error.query.blog' => 'Error performing blog query.',
		'event.history.no.events' => 'There are no events recorded for this trial.',
		
		// get_params.php
		'get.params.missing.params' => 'Invalid GET request. "trials" or "trials[]" must be set.',
		
		// graphs.php
		'graphs.error.query.dates' => 'Error performing dates query.',
		'graphs.no.measurements' => 'No measurements are recorded yet.',
		'graphs.form.time.interval' => 'Select Time Interval',
		'graphs.form.last.24h' => 'Last 24 Hours',
		'graphs.form.last.7d' => 'Last 7 Days',
		'graphs.form.last' => 'Last',
		'graphs.form.hours' => 'Hours',
		'graphs.form.days' => 'Days',
		'graphs.form.all' => 'Everything',
		'graphs.form.fixed.interval' => 'Fixed Date Interval...',
		'graphs.form.date.start' => 'Start Date:',
		'graphs.form.date.end' => 'End Date:',
		'graphs.form.by.type' => 'Select Sensor Time Series by Type',
		'graphs.form.output' => 'Choose output format',
		'graphs.form.output.graph' => 'Graph (Opens in new window)',
		'graphs.form.output.csv' => 'Download CSV file',
		'graphs.form.submit' => 'Submit Query',
		'graphs.form.reset' => 'Reset Form',
		
		// heat_map.php
		'heat.map.error.query.date' => 'Error performing dates query.',
		'heat.map.error.query.no.measurements' => 'No measurements are recorded yet.',
		'heat.map.error.query.phenomena' => 'Error performing phenomena query.',
		'heat.map.error.query.depth' => 'Error performing depth query.',
		'heat.map.form.time.of.measurement' => 'Select Time of Measurement',
		'heat.map.form.date' => 'Date',
		'heat.map.form.hour.of.day' => 'Hour of Day (0-23, format: "HH"):',
		'heat.map.form.include.minutes' => 'Include following Minutes:',
		'heat.map.form.select.phenomenon' => 'Select Phenomenon',
		'heat.map.form.depth.in.centimeters' => 'Select Depth in Centimeters',
		'heat.map.form.submit' => 'Submit Query',
		'heat.map.form.reset' => 'Reset Form',
		'heat.map.scale.toggle.popup' => 'Toggle relative scale (sensor values relative to each other) on/off',
		'heat.map.spectrum.alt' => 'Color range of the heat map from minimum to maximum.',
		
		// overview.php
		'overview.error.query.node' => 'Error performing node id query.',
		'overview.error.query.count' => 'Error performing number of nodes query.',
		'overview.error.query.trial.info' => 'Error performing trial info query.',
		'overview.num.nodes' => 'Number of nodes',
		'overview.total.measurements' => 'Total measurements',
		'overview.observation.first' => 'First observation',
		'overview.observation.last' => 'Last observation',
		'overview.contact.address' => 'Contact address',
		
		// phenomena.php
		'phenomena.error.query.phenomena' => 'Error performing phenomena query.',
		'phenomena.no.phenomena' => 'No phenomena are observed at this trial yet.',
		'phenomena.table.phenomenon' => 'Phenomenon',
		'phenomena.table.unit' => 'Unit',
		'phenomena.table.calibration' => 'Calibration',
		
		// sensor_health.php
		'sensor.health.error.query.main' => 'Error performing sensor health query.',
		'sensor.health.no.data' => 'None of the sensors collected data yet.',
		'sensor.health.table.sensor' => 'Sensor',
		'sensor.health.table.measurement' => 'Measurement',
		'sensor.health.table.value' => 'Value',
		'sensor.health.table.unit' => 'Unit',
		'sensor.health.table.measurement.last' => 'Last Measurement',
		'sensor.health.table.popup.last.h' => 'Last hour',
		'sensor.health.table.popup.last.24h' => 'Last 24 hours',
		
		// sensors.php
		'sensors.error.query.sensordevice' => 'Error performing sensordevice query.',
		'sensors.error.no.sensor.types' => 'No known type of sensor is used at this trial.',
		'sensors.table.description' => 'Description',
		'sensors.table.calibration' => 'Calibration',
		'sensors.table.measurement.method' => 'Measurement Method',
		'sensors.table.datasheet' => 'Datasheet',
		
		// testgraph.php
		'testgraph.title' => 'Graph to test that jpgraph library and links are working correctly',
		'testgraph.pressure' => 'Pressure '		
	),
	
	// Dein Job, Lisa. Viel Spaß. :)
	
	'german' => 
	array(
	
		// banner.php
		
		'banner.logo.hsma.alt' => 'Logo of the Hochschule Mannheim',
		'banner.logo.hsma.title' => 'Visit the Hochschule Mannheim',
		'banner.logo.uwa.alt' => 'Logo of the University of Western Australia',
		'banner.logo.uwa.title' => 'Visit the University of Western Australia',
		'banner.title' => 'WebSense: Sensor Network Viewer, auf deutsch. Hurra.',
		'banner.navigation.home' => 'Home',
		'banner.navigation.administration' => 'Administration',
		'banner.navigation.publications' => 'Publications',
		'banner.navigation.downloads' => 'Downloads',
		'banner.navigation.contact' => 'Contact',
	
		// contact.php
		
		'contact.title' => 'Websense3 - Contact',
		'contact.paragraph.1' => 'This application is based on
			a Java-based WebSense application developed at the
			Hochschule Mannheim, Germany.',
		'contact.paragraph.2' => 'The following people have contributed
			to versions of
			this system and its database.',
		'contact.feedback.paragraph.1' => 'Please send us a',
		'contact.feedback.mail' => 'feedback email',
		'contact.feedback.paragraph.2' => 'if you have any comments, notice
			a bug or would like a copy of this software.',
		
		// downloads.php
		
		'downloads.title' => 'Websense3 - Downloads and Documentation',
		'downloads.used.software' => 'Used 3rd Party Software',
		'downloads.apache.web.server' => 'Apache Web Server',
		'downloads.postgresql' => 'PostgreSQL Database',
		'downloads.jquery' => 'jQuery',
		'downloads.jqueryui' => 'jQuery UI',
		'downloads.jpgraph' => 'JpGraph',
		'downloads.installation' => 'Installation Instructions',
		'downloads.link' => 'Link',
		'downloads.database.skeleton' => 'Database Skeleton',
		'downloads.webapp.code' => 'Web Application Code',
		'downloads.tba' => 'TBA',
		
		// index.php
		'index.title' => 'Websense3',
		'index.tabs.overview' => 'Overview',
		'index.tabs.event.history' => 'Event History',
		'index.tabs.phenomena' => 'Phenomena',
		'index.tabs.sensors' => 'Sensors',
		'index.tabs.graphs' => 'Graphs',
		'index.tabs.sensor.health' => 'Sensor Health',
		'index.tabs.heat.map' => 'Heat Map',
		
		// menu.php
		'menu.no.trials' => 'There are no trials (yet) to select.',
		'menu.info.paragraph.1' => 'Select one or more trials of the list below and click "Change Location".',
		'menu.info.paragraph.2' => 'These trials can then be queried through the tabs.',
		'menu.buttons.checkall' => 'Check all',
		'menu.buttons.uncheckall' => 'Uncheck all',
		'menu.buttons.submit' => 'Change Location',
		
		// opendb.php
		'opendb.error' => 'Cannot connect to test database. Try editing opendb.php to set the real database.',
		
		// publications.php
		'publications.title' => 'Websense3 - Publications',
		'publications.overview' => 'Websense Overview',
		'publications.deployments' => 'Sensor Network Deployments',
		
		// create_graph.php
		'create.graph.error.generic' => 'Please select one or more Sensor Nodes to display and select output format.',
		'create.graph.error.query.enddate' => 'Error performing enddate query.',
		'create.graph.error.query.startdate' => 'Error performing startdate query.',
		'create.graph.error.date.interval.missing' => 'Please specify date interval.',
		'create.graph.error.query.num.days' => 'Error performing num days query.',
		'create.graph.error.query.name' => 'Error performing name query.',
		'create.graph.error.query.csv' => 'Error performing csv query.',
		'create.graph.graph.title' => 'Sensor data for {trialname} from {startdate} to {enddate}',
		'create.graph.error.query.time.wert' => 'Error performing time,wert graph query',
		
		// create_heat_map.php
		'create.heat.map.error.query.main' => 'Error performing heat map query.',
		'create.heat.map.error.query.phenomenon' => 'Error performing phenomenon bounds query.',
		
		// event_history.php
		'event.history.multiple.trials.selected' => 'View individual networks for further information.',
		'event.history.error.query.blog' => 'Error performing blog query.',
		'event.history.no.events' => 'There are no events recorded for this trial.',
		
		// get_params.php
		'get.params.missing.params' => 'Invalid GET request. "trials" or "trials[]" must be set.',
		
		// graphs.php
		'graphs.error.query.dates' => 'Error performing dates query.',
		'graphs.no.measurements' => 'No measurements are recorded yet.',
		'graphs.form.time.interval' => 'Select Time Interval',
		'graphs.form.last.24h' => 'Last 24 Hours',
		'graphs.form.last.7d' => 'Last 7 Days',
		'graphs.form.last' => 'Last',
		'graphs.form.hours' => 'Hours',
		'graphs.form.days' => 'Days',
		'graphs.form.all' => 'Everything',
		'graphs.form.fixed.interval' => 'Fixed Date Interval...',
		'graphs.form.date.start' => 'Start Date:',
		'graphs.form.date.end' => 'End Date:',
		'graphs.form.by.type' => 'Select Sensor Time Series by Type',
		'graphs.form.output' => 'Choose output format',
		'graphs.form.output.graph' => 'Graph (Opens in new window)',
		'graphs.form.output.csv' => 'Download CSV file',
		'graphs.form.submit' => 'Submit Query',
		'graphs.form.reset' => 'Reset Form',
		
		// heat_map.php
		'heat.map.error.query.date' => 'Error performing dates query.',
		'heat.map.error.query.no.measurements' => 'No measurements are recorded yet.',
		'heat.map.error.query.phenomena' => 'Error performing phenomena query.',
		'heat.map.error.query.depth' => 'Error performing depth query.',
		'heat.map.form.time.of.measurement' => 'Select Time of Measurement',
		'heat.map.form.date' => 'Date',
		'heat.map.form.hour.of.day' => 'Hour of Day (0-23, format: "HH"):',
		'heat.map.form.include.minutes' => 'Include following Minutes:',
		'heat.map.form.select.phenomenon' => 'Select Phenomenon',
		'heat.map.form.depth.in.centimeters' => 'Select Depth in Centimeters',
		'heat.map.form.submit' => 'Submit Query',
		'heat.map.form.reset' => 'Reset Form',
		'heat.map.scale.toggle.popup' => 'Toggle relative scale (sensor values relative to each other) on/off',
		'heat.map.spectrum.alt' => 'Color range of the heat map from minimum to maximum.',
		
		// overview.php
		'overview.error.query.node' => 'Error performing node id query.',
		'overview.error.query.count' => 'Error performing number of nodes query.',
		'overview.error.query.trial.info' => 'Error performing trial info query.',
		'overview.num.nodes' => 'Number of nodes',
		'overview.total.measurements' => 'Total measurements',
		'overview.observation.first' => 'First observation',
		'overview.observation.last' => 'Last observation',
		'overview.contact.address' => 'Contact address',
		
		// phenomena.php
		'phenomena.error.query.phenomena' => 'Error performing phenomena query.',
		'phenomena.no.phenomena' => 'No phenomena are observed at this trial yet.',
		'phenomena.table.phenomenon' => 'Phenomenon',
		'phenomena.table.unit' => 'Unit',
		'phenomena.table.calibration' => 'Calibration',
		
		// sensor_health.php
		'sensor.health.error.query.main' => 'Error performing sensor health query.',
		'sensor.health.no.data' => 'None of the sensors collected data yet.',
		'sensor.health.table.sensor' => 'Sensor',
		'sensor.health.table.measurement' => 'Measurement',
		'sensor.health.table.value' => 'Value',
		'sensor.health.table.unit' => 'Unit',
		'sensor.health.table.measurement.last' => 'Last Measurement',
		'sensor.health.table.popup.last.h' => 'Last hour',
		'sensor.health.table.popup.last.24h' => 'Last 24 hours',
		
		// sensors.php
		'sensors.error.query.sensordevice' => 'Error performing sensordevice query.',
		'sensors.error.no.sensor.types' => 'No known type of sensor is used at this trial.',
		'sensors.table.description' => 'Description',
		'sensors.table.calibration' => 'Calibration',
		'sensors.table.measurement.method' => 'Measurement Method',
		'sensors.table.datasheet' => 'Datasheet',
		
		// testgraph.php
		'testgraph.title' => 'Graph to test that jpgraph library and links are working correctly',
		'testgraph.pressure' => 'Pressure '		
	)
);

session_start();

if(array_key_exists('locale', $_SESSION) && array_key_exists($_SESSION['locale'], $all_messages)) {
	$messages = $all_messages[$_SESSION['locale']];
} else {
	// Default to English.
	$messages = $all_messages['english'];
}
?>