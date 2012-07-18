<?php
/**
 * This script generates the complete HTML of the graphing form.
 *
 * <p>
 * It sets useful default values/options to select based on the data in the database.
 * Actual graphs are then created with the information entered through the create_graph.php script.
 *</p>
 *
 * @package ajax
 */
require '../settings.php';
require '../localization.php';
require 'get_params.php';
require '../opendb.php';

$dates_query = 'SELECT to_char(MIN(measurementtime), \'YYYY-MM-DD\') AS min,
				   to_char(MAX(measurementtime), \'YYYY-MM-DD\') AS max
				FROM funkstation AS funk
				JOIN sensor ON (sensor.station_id=funk.id)
				JOIN messreihe ON (messreihe.sensor_id=sensor.id)
				JOIN messwert ON (messwert.messreihe_id=messreihe.id)
				WHERE funk.standort_id = ANY($1);';

$dates_result = pg_query_params($dates_query, $trials) or die($messages['graphs.error.query.dates']);

list($firstdate, $lastdate) = pg_fetch_row($dates_result);
// No measurements yet.
if($firstdate == NULL) {
	exit($messages['graphs.no.measurements']);
}

$html = '
<div id="graphs_container">
	<form id="graphing_form">
		<input type="hidden" name="earliest_startdate" value="' . $firstdate . '">
		<input type="hidden" name="latest_enddate" value="' . $lastdate . '">
		<fieldset>
			<legend>'.$messages['graphs.form.time.interval'].'</legend>
			<label>
				<input type="radio" name="interval" value="h24" checked>
				'.$messages['graphs.form.last.24h'].'
			</label>
			<label>
				<input type="radio" name="interval" value="d7">
				'.$messages['graphs.form.last.7d'].'
			</label>
			<input type="radio" name="interval" value="custom" id="custom_rbtn">
			<span>
				<label for="custom_rbtn" class="inline-label">'.$messages['graphs.form.last'].'</label> <input type="text" size="3" maxlength="3" value="48" id="custom_text" disabled>
				<select size="1" id="custom_type" disabled>
					<option value="h" selected>'.$messages['graphs.form.hours'].'</option>
					<option value="d">'.$messages['graphs.form.days'].'</option>
				</select>
			</span>
			<label>
				<input type="radio" name="interval" value="all">
				'.$messages['graphs.form.all'].'
			</label>
			<input type="radio" name="interval" id="fixed_interval_rbtn" value="fixed">
			<div id="fixed_interval_section">
				<label for="fixed_interval_rbtn" class="inline-label">'.$messages['graphs.form.fixed.interval'].'</label>
				<table id="date_interval_table">
					<tr>
						<td><label for="startdate">'.$messages['graphs.form.date.start'].'</label></td>
						<td><input id="startdate" type="text" class="calendar" size="10" maxlength="10" value="' . $firstdate . '"></td>
					</tr>
					<tr>
						<td><label for="enddate">'.$messages['graphs.form.date.end'].'</label></td>
						<td><input id="enddate" type="text" class="calendar" size="10" maxlength="10" value="' . $lastdate . '"></td>
					</tr>
				</table>
			</div>
		</fieldset>
		<fieldset>
			<legend>'.$messages['graphs.form.by.type'].'</legend>';

$stypesresult = pg_query('SELECT id, description, unit FROM messgroesse;');
while($strow = pg_fetch_assoc($stypesresult)) {

	//now get nodes of this type
	$nodesquery = 'SELECT messreihe.id, sensor.description
				   FROM funkstation AS funk
				   JOIN sensor ON (sensor.station_id = funk.id)
				   JOIN messreihe ON (messreihe.sensor_id = sensor.id)
				   WHERE funk.standort_id = ANY($1)
				   AND messreihe.messgroesse_id = $2;';

	$nodesresult = pg_query_params($nodesquery, array_merge($trials, array($strow['id'])));
	$numrows = pg_numrows($nodesresult);
	if($numrows > 0) {
		$html .= '<p>' . $strow['description'] . ' (' . $strow['unit'] . ')<br>';
		$html .= '<select multiple="multiple" name="sensors" size="' . ($numrows > 5 ? 5 : $numrows) . '">';
		while($nrow = pg_fetch_assoc($nodesresult)) {
			$html .= '<option value="' . $nrow['id'] . '">' . $nrow['description'] . '</option>';
		}
		$html .= '</select></p>';
	} //end if >0 vals
} //end for each type

$html .= '
		</fieldset>
		<fieldset>
			<legend>'.$messages['graphs.form.output'].'</legend>
			<label>
				<input type="radio" name="outputtype" value="graph" checked="checked">
				'.$messages['graphs.form.output.graph'].'<br>
			</label>
			<label>
				<input type="radio" name="outputtype" value="csvtext">
				'.$messages['graphs.form.output.csv'].'
			</label>
		</fieldset>
		<fieldset>
			<input type="submit" value="'.$messages['graphs.form.submit'].'">
			<input type="reset" value="'.$messages['graphs.form.reset'].'">
		</fieldset>
	</form>
</div>';

echo $html;
?>