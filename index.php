<?php
/**
 * This is the main website where all the querying and information display takes place.
 * The content is generated through AJAX calls to the server which take as input the selected trial(s) and possibly the necessary form data.
 * They then output<br>
 * 1) chunks of HTML directly containing all the information that was asked for, or<br>
 * 2) JSON containing sensor information that is then further processed on the client side to display maps etc.<br>
 * Which type of data is returned is documented in each AJAX-file in the ajax-folder.
 *
 * jQuery is used for the AJAX-calls to the server and simple DOM-manipulation.
 * Calls to jQuery are indentified through the "$"-sign.
 *
 * The jQueryUI-framework is used to display the tabbed area and also for the datepicker-popups in the "graphs" and "heat map" forms.
 *
 * The clientside-scripts (javascript) can be found in the "scripts" folder.
 * 
 * @package main
 */
require 'settings.php';
require 'localization.php';
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="script/jqueryui/jquery-ui-1.8.21.custom.css">
		<link rel="stylesheet" href="simplestyle.css">
		<script src="script/jquery-1.7.2.min.js"></script>
		<script src="script/jqueryui/jquery-ui-1.8.21.custom.min.js"></script>
		<script src="localization_client.php"></script>
		<script src="//maps.google.com/maps/api/js?sensor=false"></script>
		<script src="script/googlemapscripts.js"></script>
		<script src="script/openlayers/OpenLayers.js"></script>
		<script src="script/openstreetmapscripts.js"></script>
		<script src="script/util.js"></script>
		<script src="script/change_locale.js"></script>
		<script src="script/main.js"></script>
		<title><?php echo $messages['index.title'] ?></title>
	</head>
	<body>
		<!-- Page header -->
		<?php
		require 'banner.php';
		?>
		<!-- Contents of page concerned with networks -->
		<div id="network_container">
			<!-- Menu to select trials in -->
			<?php
			require 'menu.php';
			?> <!-- Tabbed area used for diverse network information display -->
			<div id="network_info">
				<ul>
					<li>
						<a href="#overview"><?php echo $messages['index.tabs.overview'] ?></a>
					</li>
					<li>
						<a href="#event_history"><?php echo $messages['index.tabs.event.history'] ?></a>
					</li>
					<li>
						<a href="#phenomena"><?php echo $messages['index.tabs.phenomena'] ?></a>
					</li>
					<li>
						<a href="#sensors"><?php echo $messages['index.tabs.sensors'] ?></a>
					</li>
					<li>
						<a href="#graphs"><?php echo $messages['index.tabs.graphs'] ?></a>
					</li>
					<li>
						<a href="#sensor_health"><?php echo $messages['index.tabs.sensor.health'] ?></a>
					</li>
					<li>
						<a href="#heat_map"><?php echo $messages['index.tabs.heat.map'] ?></a>
					</li>
				</ul>
				<div id="overview"></div>
				<div id="event_history"></div>
				<div id="phenomena"></div>
				<div id="sensors"></div>
				<div id="graphs"></div>
				<div id="sensor_health"></div>
				<div id="heat_map"></div>
			</div>
		</div>
	</body>
</html>