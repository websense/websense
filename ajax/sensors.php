<?php
/**
 * This script returns a HTML-table containing all the sensor types used in the trial identified by the GET-parameters.
 * If no sensors are in use, a message explaining so is returned.
 * 
 * @package ajax
 */

require '../settings.php';
require '../localization.php';
require 'get_params.php';
require '../opendb.php';

$sdevice_query = 'SELECT DISTINCT ON(sdev.id) sdev.description, sdev.calibrationinfo, sdev.measurement_method, sdev.datasheetlink
				  FROM funkstation AS funk
				  JOIN sensor AS sens ON (funk.id = sens.station_id)
				  JOIN sensordevice AS sdev ON (sens.sensordevice_id = sdev.id)
				  WHERE funk.standort_id = ANY($1)
				  ORDER BY sdev.id;';

$sdevice_result = pg_query_params($sdevice_query, $trials) or die($messages['sensors.error.query.sensordevice']);

$sdevice = pg_fetch_assoc($sdevice_result);
// Not one sensordevice?
if(!$sdevice) {
	exit($messages['sensors.error.no.sensor.types']);
}

$html = '
<table>
	<thead>
		<tr>
			<th>'.$messages['sensors.table.description'].'</th><th>'.$messages['sensors.table.calibration'].'</th><th>'.$messages['sensors.table.measurement.method'].'</th><th>'.$messages['sensors.table.datasheet'].'</th>
		</tr>
	</thead>
	<tbody>';

do {
	$html .= '
		<tr>
			<td>' . $sdevice['description'] . '</td>
			<td>' . $sdevice['calibrationinfo'] . '</td>
			<td>' . $sdevice['measurement_method'] . '</td>
			<td>' . $sdevice['datasheetlink'] . '</td>
		</tr>';
} while($sdevice = pg_fetch_assoc($sdevice_result));

$html .= '
	</tbody>
</table>';

echo $html;
?>