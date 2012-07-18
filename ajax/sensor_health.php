<?php
/**
 * This script generates the complete HTML for the sensor health table.
 *
 * <p>
 * The newest measurement from each sensor of the selected trial(s) is displayed along with its date.
 * </p>
 *
 * @package ajax
 */

require '../settings.php';
require '../localization.php';
require 'get_params.php';
require '../opendb.php';

$sensor_health_query = '
						SELECT sensor.description AS sensor_desc, messgroesse.description AS unit_desc,
						wert AS value, messgroesse.unit AS unit, measurementtime,
						(EXTRACT(EPOCH FROM LOCALTIMESTAMP) - EXTRACT(EPOCH FROM measurementtime)) AS elapsed_seconds
						FROM funkstation
						JOIN sensor ON (sensor.station_id = funkstation.id)
						JOIN messreihe ON (messreihe.sensor_id = sensor.id)
						JOIN messgroesse ON (messgroesse.id = messreihe.messgroesse_id)
						JOIN
						(
							WITH RECURSIVE maxima AS (
								(
								SELECT mw_row
								FROM messwert mw_row
								ORDER BY messreihe_id DESC, measurementtime DESC
								LIMIT 1
								)
							UNION ALL
								SELECT (
									SELECT mw_row_smaller
									FROM messwert mw_row_smaller
									WHERE mw_row_smaller.messreihe_id < (m.mw_row).messreihe_id
									ORDER BY mw_row_smaller.messreihe_id DESC, mw_row_smaller.measurementtime DESC
									LIMIT 1
								)
								FROM  maxima m
								WHERE mw_row IS NOT NULL
							)
							SELECT (mw_row).messreihe_id, (mw_row).wert, (mw_row).measurementtime
							FROM maxima
							WHERE mw_row IS NOT NULL
						) AS messwert_maxima
						ON (messreihe.id = messwert_maxima.messreihe_id)
						WHERE funkstation.standort_id = ANY($1)
						ORDER BY sensor.id, messgroesse.id;';

$sensor_health_result = pg_query_params($sensor_health_query, $trials) or die($messages['sensor.health.error.query.main']);

// Fetch first one. If it doesn't exist, there is no need to check the rest. Avoids expensive counting.
$row = pg_fetch_assoc($sensor_health_result);
if(!$row) {
	exit($messages['sensor.health.no.data']);
}

// TODO
/*
<form>
	<fieldset>
		<legend>Change indicating colors</legend>
		
		<span>
		
			<label class="inline-label">
				Limit green
				<input type="text" size="3" value="48" id="green_limit">
			</label>
			<select size="1" id="green_limit_type">
				<option value="h" selected>Hours</option>
				<option value="d">Days</option>
			</select>
			</span>
		<input type="button" value=""
	</fieldset>
</form>
*/

$sensor_html = '
<table>
	<thead>
		<tr>
			<th>'.$messages['sensor.health.table.sensor'].'</th>
			<th>'.$messages['sensor.health.table.measurement'].'</th>
			<th>'.$messages['sensor.health.table.value'].'</th>
			<th>'.$messages['sensor.health.table.unit'].'</th>
			<th>'.$messages['sensor.health.table.measurement.last'].'</th>
		</tr>
	</thead>
	<tbody>';
// Construct table content:
$seconds_per_hour = 60 * 60;
$seconds_per_day = $seconds_per_hour * 24;
do {
	$sensor_html .= '
		<tr>
			<td>' . $row['sensor_desc'] . '</td>
			<td>' . $row['unit_desc'] . '</td>
			<td>' . $row['value'] . '</td>
			<td>' . $row['unit'] . '</td>';
	// Set measurementtime to something better readable:
	$elapsed_seconds = $row['elapsed_seconds'];
	if($elapsed_seconds < $seconds_per_hour) {
		$sensor_html .= '<td class="recent_mmt"><abbr title="' . $row['measurementtime'] . '">'.$messages['sensor.health.table.popup.last.h'].'</abbr></td>';
	} else if($elapsed_seconds < $seconds_per_day) {
		$sensor_html .= '<td class="old_mmt"><abbr title="' . $row['measurementtime'] . '">'.$messages['sensor.health.table.popup.last.24h'].'</abbr></td>';
	} else {
		$sensor_html .= '<td class="outdated_mmt">' . $row['measurementtime'] . '</td>';
	}
	$sensor_html .= '</tr>';
} while($row = pg_fetch_assoc($sensor_health_result));

$sensor_html .= '
	</tbody>
</table>';

// Return the table to the client:
echo $sensor_html;
?>