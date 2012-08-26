<?php
/**
 * This file generates JSON containing all the data needed by the administration GUI.
 * This includes trials, their nodes and the sensors of these nodes.
 * Also returns all types of sensors in use (sensordevices).
 * 
 * 
 *@package ajax
 */

require '../settings.php';
require '../opendb.php';

$trials_query = 'SELECT id, description, sourcecontact, displaypreference,
				localimage, timezone, country
				FROM standort;';

$nodes_query = 'SELECT id, name, lat, lon, serialnumber, standort_id
				FROM funkstation;';

$sensors_query = 'SELECT id, serialnumber, description, tiefe, station_id, sensordevice_id
				 FROM sensor;';

$sensordevices_query = 'SELECT id, description, calibrationinfo, datasheetlink, measurement_method
						FROM sensordevice;';

$trials_result = pg_query($trials_query) or die('trials_query failed.');
$nodes_result = pg_query($nodes_query) or die('nodes_query failed.');
$sensors_result = pg_query($sensors_query) or die('sensors_query failed.');
$sensordevices_result = pg_query($sensordevices_query) or die('sensordevices_query failed.');

function toObject($query_result){
	$res = pg_fetch_all($query_result);
	if(!$res){
		$res = array();
	}
	return $res;
}

$result = array('trials' => toObject($trials_result),
				'nodes' => toObject($nodes_result),
				'sensors' => toObject($sensors_result),
				'sensordevices' => toObject($sensordevices_result)
				);

echo json_encode($result);
?>