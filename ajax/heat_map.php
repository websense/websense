<?php
/**
 * This file generates a HTML-form to specify parameters to the heatmap-generation.
 * The JSON data to create these heatmaps on the client side is then generated in the create_heat_map.php script.
 * 
 * <p>
 * Useful default values are filled in some form-fields to ease the process.
 * </p>
 * 
 *@package ajax
 */

require '../settings.php';
require '../localization.php';
require 'get_params.php';
require '../opendb.php';

$dates_query = 'SELECT to_char(MIN(measurementtime), \'YYYY-MM-DD\') AS min,
					   to_char(MAX(measurementtime), \'YYYY-MM-DD|HH24|MI|SS\') AS max
				FROM funkstation AS funk
				JOIN sensor ON (sensor.station_id=funk.id)
				JOIN messreihe ON (messreihe.sensor_id=sensor.id)
				JOIN messwert ON (messwert.messreihe_id=messreihe.id)
				WHERE funk.standort_id = ANY($1);';

$depth_query = 'SELECT tiefe as depth, COUNT(*) AS num_sensors
				FROM funkstation AS funk
				JOIN sensor ON (sensor.station_id=funk.id)
				WHERE funk.standort_id = ANY($1)
				GROUP BY tiefe
				ORDER BY tiefe ASC;';

$phenomena_query = 'SELECT messg.id, messg.description
					FROM
						(SELECT messr.messgroesse_id FROM funkstation AS funk
						 JOIN sensor AS sens ON (funk.id = sens.station_id)
						 JOIN messreihe AS messr ON (sens.id = messr.sensor_id)
						 WHERE funk.standort_id = ANY($1)
						 GROUP BY messr.messgroesse_id) AS sub
					JOIN messgroesse AS messg ON (sub.messgroesse_id = messg.id);';

$dates_result = pg_query_params($dates_query, $trials) or die($messages['heat.map.error.query.date']);
$row = pg_fetch_assoc($dates_result);
// No measurements taken if no earliest observation.
if($row['min'] == NULL) {
	exit($messages['heat.map.error.query.no.measurements']);
}
$phenomena_result = pg_query_params($phenomena_query, $trials) or die($messages['heat.map.error.query.phenomena']);
$depth_result = pg_query_params($depth_query, $trials) or die($messages['heat.map.error.query.depth']);
$firstdate = $row['min'];
list($lastdate, $last_hour, $last_minute, $last_second) = explode('|', $row['max']);
//TODO get reasonable values from database. This value makes sure, that the newest measurement is in the interval.
$interval_minutes = $last_minute + ($last_second == 0 ? 0 : 1);

$html = '
<div id="heat_map_container">
	<form id="heat_form">
		<input type="hidden" name="earliest_startdate" value="'. $firstdate .'">
		<input type="hidden" name="latest_enddate" value="'. $lastdate .'">
		<fieldset>
			<legend>'.$messages['heat.map.form.time.of.measurement'].'</legend>
			<label for="heat_date">'.$messages['heat.map.form.date'].' (<strong>' . $firstdate . '</strong> - <strong>' . $lastdate . '</strong>):</label>
			<input id="heat_date" type="text" class="calendar" size="12" value="' . $lastdate . '">
			<label for="heat_hour">'.$messages['heat.map.form.hour.of.day'].'</label>
			<input id="heat_hour" type="text" size="12" value="' . $last_hour . '">
			<label for="heat_plus_minutes">'.$messages['heat.map.form.include.minutes'].'</label>
			<input id="heat_plus_minutes" type="text" size="12" value="' . $interval_minutes . '">
		</fieldset>
		<fieldset>
			<legend>'.$messages['heat.map.form.select.phenomenon'].'</legend>
			<select name="phenomena">';

$phenomenon = pg_fetch_assoc($phenomena_result);
if($phenomenon) {
	// Select first one by default:
	$html .= '<option value="' . $phenomenon['id'] . '" selected="selected">' . $phenomenon['description'] . '</option>';
	while($phenomenon = pg_fetch_assoc($phenomena_result)) {
		$html .= '<option value="' . $phenomenon['id'] . '">' . $phenomenon['description'] . '</option>';
	}
}

$html .= '
			</select>
		</fieldset>
		<fieldset>
			<legend>'.$messages['heat.map.form.depth.in.centimeters'].'</legend>
			<select name="depths">';

$depth_row = pg_fetch_assoc($depth_result);
if($depth_row) {
	// Select first one by default:
	$depth = $depth_row['depth'];
	$html .= '<option value="' . $depth . '" selected="selected">' . $depth . ' (' . $depth_row['num_sensors'] . ' sensors)' . '</option>';
	while($depth_row = pg_fetch_assoc($depth_result)) {
		$depth = $depth_row['depth'];
		$html .= '<option value="' . $depth . '">' . $depth . ' (' . $depth_row['num_sensors'] . ' sensors)' . '</option>';
	}
}

$html .= '
			</select>
		</fieldset>
		<fieldset>
			<legend>'.$messages['heat.map.form.submit'].'</legend>
			<input type="submit" value="'.$messages['heat.map.form.submit'].'">
			<input type="reset" value="'.$messages['heat.map.form.reset'].'">
		</fieldset>
	</form>
	<div id="heat_result">
		<div id="heatmap_canvas"></div>
		<div id="spectrum">
			<label>
				<input type="checkbox" name="relative_scale">
				<abbr title="'.$messages['heat.map.scale.toggle.popup'].'">Relative</abbr>
			</label>
			<span id="spectrum_max"></span>
			<img src="images/spectrum.png" alt="'.$messages['heat.map.spectrum.alt'].'">
			<span id="spectrum_min"></span>
		</div>
	</div>
</div>';

echo $html;
?>