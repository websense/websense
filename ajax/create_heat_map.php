<?php
/**
 * This script provides JSON data that contains the locations of all sensors and the "heat" (intensity) at each such location for the given phenomenon.
 *
 * The returned JSON-array is structured as follows:
 * <p>
 * [{lat:1, lon: 2, value: 20.3}, ...]
 * </p>
 * The "value" contains the measured value of that sensor, for example temperature. It's always a single number.
 *
 * <p>
 * Also the static and relative upper and lower bounds of the measured values will be returned along with the unit of the measurements.
 * </p>
 *
 * @package ajax
 */

require '../settings.php';
require '../localization.php';
require 'get_params.php';
require '../opendb.php';

// Tell the client that the answer is in JSON.
header('Content-type: application/json');

$date = $_GET['date'];
$hour = $_GET['hour'];
$plus_minutes = $_GET['plus_minutes'];
$phenomenon_id = $_GET['phenomenon'];
$depth = $_GET['depth'];

$heat_info = array();

// Note: The parameters in the initial main not-subquery-part COULD be left out. But they enhance the performance.
// JOIN ON 1=1 seems to be a good way to include variables into a query.
$sensor_heat_query = '
		SELECT sensor.lat, sensor.lon, messwert.wert AS value
		FROM funkstation as funk
		JOIN sensor ON (funk.standort_id = ANY($1) AND sensor.tiefe = $2 AND sensor.station_id = funk.id)
		JOIN messreihe ON (messreihe.messgroesse_id = $3 AND messreihe.sensor_id = sensor.id)
		JOIN messwert ON (messwert.messreihe_id = messreihe.id)
		JOIN
			(SELECT messwert.messreihe_id, MIN(messwert.measurementtime) AS nearest_date
			 FROM
				(SELECT to_timestamp($4, \'YYYY-MM-DD-HH24\') AS heat_date,
						to_timestamp($4, \'YYYY-MM-DD-HH24\') + CAST($5 || \' minutes\' AS INTERVAL) AS upper) AS bounds
			 JOIN funkstation as funk ON 1=1
			 JOIN sensor ON (funk.standort_id = ANY($1) AND sensor.tiefe = $2 AND sensor.station_id = funk.id)
			 JOIN messreihe ON (messreihe.messgroesse_id = $3 AND messreihe.sensor_id = sensor.id)
			 JOIN messwert ON (messwert.messreihe_id = messreihe.id AND
							   messwert.measurementtime >= bounds.heat_date AND
							   messwert.measurementtime <= bounds.upper)
			GROUP BY messwert.messreihe_id) AS sub
		ON(messwert.messreihe_id = sub.messreihe_id AND messwert.measurementtime = sub.nearest_date)
		ORDER BY messwert.wert;';
		
$sensor_heat_result = pg_query_params($sensor_heat_query, array_merge($trials, array($depth, $phenomenon_id, $date . '-' . $hour, $plus_minutes))) or die($messages['create.heat.map.error.query.main']);

$heat_info['sensors'] = pg_fetch_all($sensor_heat_result);

// No sensors found? Then we're finished here:
if(!$heat_info['sensors']) {
	exit(json_encode($heat_info));
}

// Get static and relative scale-bounds of the measured values.

// Static:
$phenomenon_bounds_query = 'SELECT minimum AS static_lower, maximum AS static_upper, unit FROM messgroesse WHERE id = $1;';
$phenomenon_bounds_result = pg_query_params($phenomenon_bounds_query, array($phenomenon_id)) or die($messages['create.heat.map.error.query.phenomenon']);

$heat_info['bounds'] = pg_fetch_assoc($phenomenon_bounds_result);

// Relative. Sensors in result are ordered in ascending order => first = min, last = max.
$heat_info['bounds']['relative_lower'] = $heat_info['sensors'][0]['value'];
$lastSensor = end($heat_info['sensors']);
$heat_info['bounds']['relative_upper'] = $lastSensor['value'];

// Return sensors + bounds to caller in JSON format:
echo json_encode($heat_info);
?>