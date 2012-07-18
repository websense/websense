<?php
/**
 * This script generates all the information of the "Overview" tab.
 *
 * <p>
 * It provides:
 * The type of map used for the given trialids.
 * The latitude and longitude of the "funkstation"'s on the map that may be used to display markers.
 * The sensors of every funkstation formatted as HTML suitable for display in a popup.
 * Additional information about the site itself as HTML.
 * </p>
 * <p>
 * Every information is transmitted via JSON. The HTML is embedded in it as a string.
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

// Get all the nodes and site info:
$site_info = array();

if($num_trials == 1) {
	// It's only one trial, but there's no need to deconstruct the "trials"-postgre-array.
	$trialquery = 'SELECT sourcecontact,displaypreference,localimage FROM standort WHERE id = ANY($1);';
	$trialresult = pg_query_params($trialquery, $trials);
	$myrow = pg_fetch_assoc($trialresult);
	$contact = $myrow['sourcecontact'];
	$site_info['displaypref'] = $myrow['displaypreference'];
	$site_info['image'] = $myrow['localimage'];
} else {
	$contact = 'See individual networks';
	$site_info['displaypref'] = 'GoogleMaps';
}
// MAX-aggregate returns the corresponding single value for each primary key funk.id.
// It doesn't incur a large overhead, since it only deals with one value.
$nodesquery = 'SELECT MAX(funk.lat) AS lat, MAX(funk.lon) AS lon,
			   \'<h5>Sensors for \' || MAX(funk.name) || \'</h5><ul>\' || COALESCE(string_agg(\'<li>\' || sensor.description || \'</li>\', \'\'), \'<li>none</li>\') || \'</ul>\' AS value
			   FROM (SELECT id, lat, lon, name FROM funkstation WHERE funkstation.standort_id = ANY($1)) AS funk
			   LEFT JOIN sensor ON (sensor.station_id = funk.id)
			   GROUP BY funk.id;';

$num_nodes_query = 'SELECT COUNT(*) AS num_nodes FROM funkstation WHERE standort_id = ANY($1);';

//TODO: COUNT(*) results in a sequential scan in postgres. This is unavoidable. Use guess from ANALYZE instead? Trigger on insert?
// The dates part is now sufficiently optimized, it makes heavy use of indices.
$info_query = '
			   WITH subsensors AS (
					SELECT messreihe.id
					FROM funkstation AS funk
					JOIN sensor ON (sensor.station_id = funk.id)
				 	JOIN messreihe ON (messreihe.sensor_id = sensor.id)
					WHERE funk.standort_id = ANY($1))
			   SELECT
			   		(WITH RECURSIVE minima AS (
						(SELECT mw_row
						FROM messwert mw_row
						ORDER BY messreihe_id ASC, measurementtime ASC
						LIMIT 1)
					UNION ALL
						SELECT (
							SELECT mw_row_bigger
							FROM messwert mw_row_bigger
							WHERE mw_row_bigger.messreihe_id > (m.mw_row).messreihe_id
							ORDER BY mw_row_bigger.messreihe_id ASC, mw_row_bigger.measurementtime ASC
							LIMIT 1
						)
						FROM  minima m
						WHERE mw_row IS NOT NULL
					)
					SELECT to_char(MIN((mw_row).measurementtime), \'YYYY-MM-DD\')
					FROM subsensors JOIN minima
					ON (mw_row IS NOT NULL AND (mw_row).messreihe_id = subsensors.id)) AS firstdate,
					
					(WITH RECURSIVE maxima AS (
						(SELECT mw_row
						FROM messwert mw_row
						ORDER BY messreihe_id DESC, measurementtime DESC
						LIMIT 1)
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
					SELECT to_char(MAX((mw_row).measurementtime), \'YYYY-MM-DD\')
					FROM subsensors JOIN maxima
					ON (mw_row IS NOT NULL AND (mw_row).messreihe_id = subsensors.id)) AS lastdate,
					
					(SELECT COUNT(*)
					FROM funkstation AS funk
					JOIN sensor ON (sensor.station_id = funk.id)
				 	JOIN messreihe ON (messreihe.sensor_id = sensor.id)
				 	JOIN messwert ON (messwert.messreihe_id = messreihe.id)
					WHERE funk.standort_id = ANY($1)) AS total_measurements;';

$nodesresult = pg_query_params($nodesquery, $trials) or die($messages['overview.error.query.node']);
$num_nodes_result = pg_query_params($num_nodes_query, $trials) or die($messages['overview.error.query.count']);
$info_result = pg_query_params($info_query, $trials) or die($messages['overview.error.query.trial.info']);

$site_info['nodes'] = pg_fetch_all($nodesresult);

$info = pg_fetch_object($info_result);

$html_content = '
<div id="map_canvas"></div>
<div id="info" class="info-box">
	<dl>
		<dt>'.$messages['overview.num.nodes'].'</dt>
		<dd>' . pg_fetch_object($num_nodes_result) -> num_nodes . '</dd>
	
		<dt>'.$messages['overview.total.measurements'].'</dt>
		<dd>' . $info -> total_measurements . '</dd>
	
		<dt>'.$messages['overview.observation.first'].'</dt>
		<dd>' . $info -> firstdate . '</dd>
	
		<dt>'.$messages['overview.observation.last'].'</dt>
		<dd>' . $info -> lastdate . '</dd>
	
		<dt>'.$messages['overview.contact.address'].'</dt>
		<dd>' . $contact . '</dd>
	</dl>
</div>';

$site_info['html'] = $html_content;

// Return the cumulated information to the caller.
echo json_encode($site_info);
?>