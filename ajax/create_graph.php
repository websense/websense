<?php
/**
 * This script generates a graph from the provided data, or csv text if so specified.
 *
 * The graph is sent back to the client as an image file.
 * The csv-file is sent back with a header signalising an attachmet,
 * so client browsers (hopefully) will open their file download dialog for it.
 *
 * The graph style is from the new WebSense theme
 * NOTE: Creating a graph does heavily depend on the default time zone set in "settings.php".
 * If no default time zone is set, php will emit warnings that will corrupt the image-stream to the client.
 * This behaviour holds as long as error-reporting is enabled in "settings.php".
 *
 * @package ajax
 */

require '../settings.php';
require '../localization.php';

require_once '../jpgraph-3.5.0b1/src/jpgraph.php';
require_once '../jpgraph-3.5.0b1/src/jpg-config.inc.php';
require_once '../jpgraph-3.5.0b1/src/jpgraph_date.php';
require_once '../jpgraph-3.5.0b1/src/jpgraph_line.php';
require_once '../jpgraph-3.5.0b1/src/jpgraph_bar.php';
require_once '../jpgraph-3.5.0b1/src/jpgraph_error.php';
require_once '../jpgraph-3.5.0b1/src/jpgraph_utils.inc.php';
require_once '../jpgraph-3.5.0b1/src/jpgraph_ttf.inc.php';

require 'get_params.php';

require_once '../util.php';

if(!containsKeys($_GET, array('outputtype', 'sensors'))) {
	die($messages['create.graph.error.generic']);
}

//output graph or csv text
$outputtype = $_GET['outputtype'];
$sensormessreiheid = $_GET['sensors'];

$subsensors = phpArrayToSQLArray($sensormessreiheid);

require '../opendb.php';

// Set appropriate values for startdate and enddate:
if(array_key_exists('time_span', $_GET)) {
	// Get the last date any measurement was taken. It will always be included in the result of time spans, as they range only into the past.
	$enddate_query = '
					WITH RECURSIVE maxima AS (
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
					SELECT MAX((mw_row).measurementtime) AS enddate
					FROM maxima
					WHERE (mw_row IS NOT NULL AND (mw_row).messreihe_id = ANY($1));';
	$enddate_result = pg_query_params($enddate_query, $subsensors) or die($messages['create.graph.error.query.enddate']);
	$enddate =          pg_fetch_object($enddate_result) -> enddate;

	// Could be a timespan or "all":
	$time_span = $_GET['time_span'];

	if($time_span == 'all') {
		$startdate_query = '
					WITH RECURSIVE minima AS (
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
					SELECT MIN((mw_row).measurementtime) AS startdate
					FROM minima
					WHERE (mw_row IS NOT NULL AND (mw_row).messreihe_id = ANY($1));';
		$startdate_result = pg_query_params($startdate_query, $subsensors) or die($messages['create.graph.error.query.startdate']);
		$startdate =          pg_fetch_object($startdate_result) -> startdate;
	} else {
		// First position is type, rest is number:
		$type = substr($time_span, 0, 1);
		$interval = substr($time_span, 1);
		if($type == 'd') {
			$interval_type = 'days';
		} else if($type == 'h') {
			$interval_type = 'hours';
		} else {
			die('Unknown interval type: ' . $type);
		}
		$startdate_result = pg_query_params('SELECT (LOCALTIMESTAMP - CAST($1 || \' \' || $2 AS INTERVAL)) AS startdate;', array($interval, $interval_type));
		$startdate =        pg_fetch_object($startdate_result) -> startdate;
	}
} else {
	// Then there HAVE to be fixed dates:
	if(!containsKeys($_GET, array('startdate', 'enddate'))) {
		die($messages['create.graph.error.date.interval.missing']);
	}
	$startdate = $_GET['startdate'];
	$enddate = $_GET['enddate'];
}
if($outputtype == 'graph') {
	$num_days_result = pg_query_params('SELECT (CAST($1 AS DATE) - CAST($2 AS DATE)) AS num_days;', array($enddate, $startdate)) or die($messages['create.graph.error.query.num.days']);
	// Number of days for scale of x-Axis.
	$ndays =        pg_fetch_object($num_days_result) -> num_days;
}

// Replace all spaces in the trialnames with underscores and then stitch them together with -.
// Makes a useful .csv- file-name.
$name_query = 'SELECT string_agg(translate(description, \' \',\'_\' ), \'-\')
	  AS trialname FROM standort WHERE id = ANY($1);';

$name_result = pg_query_params($name_query, $trials) or die($messages['create.graph.error.query.name']);
$trialname =     pg_fetch_object($name_result) -> trialname;

// Handle the complete csv-case.
if($outputtype == 'csvtext') {
	// Set the appropriate headers. If its a graph, JpGraph will automatically do the right thing.
	header('Content-type: text/csv');
	header('Content-disposition: attachment;filename=' . $trialname . $startdate . 'to' . $enddate . '.csv');
	$csv_query = '
				SELECT sensor.description || \' (\' || messgroesse.unit ||\')\' AS SENSOR_NAME, messgroesse.description AS SENSOR_TYPE,
					   messwert.measurementtime AS TIME, messwert.wert AS VALUE
				FROM (SELECT CAST($1 AS INTEGER[]) AS ids) AS subsensor_ids
				JOIN funkstation AS funk ON 1=1
				JOIN sensor ON (sensor.station_id = funk.id)
				JOIN messreihe ON (messreihe.sensor_id = sensor.id)
				JOIN messgroesse ON (messreihe.messgroesse_id = messgroesse.id)
				JOIN messwert ON (messwert.messreihe_id = messreihe.id)
				WHERE
				funk.standort_id = ANY($2)
				AND messreihe.id = ANY(subsensor_ids.ids)
				AND messreihe_id = ANY(subsensor_ids.ids)
				AND messwert.measurementtime >= $3
				AND messwert.measurementtime <= $4;';
	$csv_result = pg_query_params($csv_query, array_merge($subsensors, $trials, array($startdate, $enddate))) or die($messages['create.graph.error.query.csv']);
	$csv_row = pg_fetch_assoc($csv_result);
	// Output to client:
	$out = fopen('php://output', 'w');
	if($csv_row) {
		// Output header row:
		fwrite($out, '"' . implode('","', str_replace('"', '""', array_keys($csv_row))) . '"' . "\r\n");
		// Start result form beginning:
		pg_result_seek($csv_result, 0);
	}
	while($csv_row = pg_fetch_assoc($csv_result)) {
		fwrite($out, '"' . implode('","', str_replace('"', '""', $csv_row)) . '"' . "\r\n");
	}
	fclose($out);
	// We are done with csv.
	exit ;
}
// Handle the graph output:
// most formatting done in WebSenseTheme - here just details for time series

$nsensors = count($sensormessreiheid);

//maximum points per time series to display, if n>$maxpoints recorded, then select each n/2500 steps
//stress tested on Schriesheim data set, 391K readings
$maxpoints = 2500;

//get the names of each measurement type for labelling axes
$stypesresult = pg_query('SELECT id FROM messgroesse;');
$sensortype = pg_fetch_all_columns($stypesresult);
$ntypesresult = pg_query('SELECT COUNT(*) AS ntypes FROM messgroesse;');
$ntypes = pg_fetch_object($ntypesresult) -> ntypes;

$graph = new Graph(1600, 1000);
$graph -> SetScale('datlin');
$graph -> img -> SetMargin(100, 150, 50, 50);
$graph -> title -> Set(str_replace(array('{trialname}', '{startdate}', '{enddate}'), array($trialname, $startdate, $enddate), $messages['create.graph.graph.title']));

$graph -> xaxis -> scale -> SetTimeAlign(DAYADJ_1);
$graph -> xaxis -> SetLabelAngle(45);
if($ndays > 20) { //don't let the x axis get too crowded
	$graph -> xaxis -> scale -> ticks -> Set(($ndays / 20) * 1440 * 60);
	$graph -> xaxis -> SetLabelFormatString('d M y', true);
} else {
	$graph -> xaxis -> scale -> ticks -> Set(12 * 60 * 60);
	//12 hour
	$graph -> xaxis -> SetLabelFormatString('d M H:00', true);
}
//$graph -> xaxis -> SetFont(FF_ARIAL, FS_NORMAL, 12);
$graph -> SetYDeltaDist(70);
//default 50 between axes is too close for multiple y axes

$ynum = 0;
//number of y axes used so far
$ydrawn = 0;






//axis not drawn for this $t yet
for($t = 0; $t < $ntypes; $t++) { //for each sensor type make new y axis
	//get y get descriptions
	$nameresult = pg_query_params('SELECT description || \' (\' || unit || \' )\' AS ytitle, unit FROM messgroesse 
        WHERE id=$1;', array_slice($sensortype, $t, 1));
	list($ytitle, $tunit) = pg_fetch_row($nameresult);
	if($ydrawn == 1) {
		$ynum++;
	}
	$ydrawn = 0;
	//axis not drawn for this $t yet

	for($i = 0; $i < $nsensors; $i++) {

		$result = pg_query_params('SELECT sensor.description FROM
								   sensor JOIN messreihe ON
								   (messreihe.id=$1 AND sensor.id=messreihe.sensor_id);', array_slice($sensormessreiheid, $i, 1)) or die('Error performing sensorname graph query.');
		$srow = pg_fetch_assoc($result);
		$sname = $srow['description'] . ' (' . $tunit . ')';

		$graphquery = 'SELECT measurementtime, EXTRACT(EPOCH FROM measurementtime) AS mmt_seconds, wert 
	FROM messwert JOIN messreihe
	ON (messwert.messreihe_id = messreihe.id)
	WHERE messreihe.messgroesse_id = $1 AND
		  messwert.messreihe_id = $2 AND
		  messwert.measurementtime >= $3 AND
		  messwert.measurementtime <= $4
	ORDER BY measurementtime;';

		$result = pg_query_params($graphquery, array($sensortype[$t], $sensormessreiheid[$i], $startdate, $enddate)) or die($messages['create.graph.error.query.time.wert']);
		$nrows = pg_numrows($result);

		if($nrows > 0) { //now plot result, else try next sensor/type
			//if nrows too many then change j increment so only select vals are shown say
			$steps = (int)(ceil($nrows / $maxpoints));
			//$steps>=1

			$datax1 = array();
			$datay1 = array();
			// TODO: some readings aren't plotted, so why retrieve them from the database?
			for($j = 0; $j < $nrows; $j++) {
				$row = pg_fetch_array($result);
				if(($j % $steps) == 0) { //only print every $step-th reading
					array_push($datax1, $row['mmt_seconds']);
					array_push($datay1, $row['wert']);
				}
			} //end get measurement point for each j
			//add a line and legend if data exists

			if($sensortype[$t] == 14) { //rainfall (only) drawn as bar graph
				$p1 = new BarPlot($datay1, $datax1);
				$p1 -> SetWidth(3.0);
			} else {
				$p1 = new LinePlot($datay1, $datax1);
			}
			$p1 -> SetLegend($sname);

			if($ynum == 0) { //first type so add to left hand yaxis

				if($ydrawn == 0) {
					$graph -> yaxis -> title -> Set($ytitle);
					$ydrawn = 1;
				}
				$graph -> Add($p1);
			} else { //ynum > 0 so need new y axes
				if($ydrawn == 0) {
					//most formatting done in WebSenseTheme - here just copy style for additional y axes
					$graph -> SetYScale($ynum - 1, 'lin');
					$graph -> ynaxis[$ynum - 1] -> SetColor('gray', 'black');
					$graph -> ynaxis[$ynum - 1] -> title -> SetFont(FF_ARIAL, FS_NORMAL, 12);
					$graph -> ynaxis[$ynum - 1] -> title -> Set($ytitle);
					$graph -> ynaxis[$ynum - 1] -> title -> SetColor('black');
					$graph -> ynaxis[$ynum - 1] -> SetTitleMargin(40);
					$graph -> ynaxis[$ynum - 1] -> SetFont(FF_ARIAL, FS_NORMAL, 12);
					//$graph -> ynaxis[$ynum - 1] -> SetColor('black');
					$ydrawn = 1;
					//to ensure only 1 y axis of each type is drawn
				}
				$graph -> AddY($ynum - 1, $p1);
			} //end else ynum>0
			// see old versions for bar plots
		} //end if anything to plot

	} //end for each sensor
} //end for each type

//send image to the client
$graph -> Stroke();

?>