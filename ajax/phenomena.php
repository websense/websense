<?php
/**
 * This script returns a table containing all the phenomena measured in the trial identified by the GET-parameters.
 * If no phenomena are observed, a message explaining so is returned.
 * 
 * @package ajax
 */

require '../settings.php';
require '../localization.php';
require 'get_params.php';
require '../opendb.php';

$phenomena_query = 'SELECT messg.description, messg.unit, messg.minimum, messg.maximum, messg.comments FROM
							(SELECT messr.messgroesse_id FROM funkstation AS funk
							 JOIN sensor AS sens ON (funk.standort_id = ANY($1) AND funk.id = sens.station_id)
							 JOIN messreihe AS messr ON (sens.id = messr.sensor_id)
							 GROUP BY messr.messgroesse_id) AS sub
						JOIN messgroesse AS messg ON (sub.messgroesse_id = messg.id)
						ORDER BY messg.description;';

$phenomena_result = pg_query_params($phenomena_query, $trials) or die($messages['phenomena.error.query.phenomena']);
$phenomenon = pg_fetch_assoc($phenomena_result);
if(!$phenomenon) {
	exit($messages['phenomena.no.phenomena']);
}

$html = '
<table>
	<thead>
		<tr>
			<th>'.$messages['phenomena.table.phenomenon'].'</th><th>'.$messages['phenomena.table.unit'].'</th><th>'.$messages['phenomena.table.minimum'].'</th><th>'.$messages['phenomena.table.maximum'].'</th><th>'.$messages['phenomena.table.calibration'].'</th>
		</tr>
	</thead>
	<tbody>';

do {
	$html .= '<tr><td>'.$phenomenon['description'].'</td><td>'.$phenomenon['unit'].'</td><td>'.$phenomenon['minimum'].'</td><td>'.$phenomenon['maximum'].'</td><td>'.$phenomenon['comments'].'</td></tr>';
} while($phenomenon = pg_fetch_assoc($phenomena_result));

$html .= '
	</tbody>
</table>';

echo $html;
?>