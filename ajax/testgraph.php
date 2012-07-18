<?php
/**
 * This file tests that JPgraph is correctly installed and running.
 * 
 * @package main
 */ 

require '../localization.php';

require_once '../jpgraph-3.5.0b1/src/jpgraph.php';
require_once '../jpgraph-3.5.0b1/src/jpg-config.inc.php';
require_once '../jpgraph-3.5.0b1/src/jpgraph_date.php';
require_once '../jpgraph-3.5.0b1/src/jpgraph_line.php';
require_once '../jpgraph-3.5.0b1/src/jpgraph_bar.php';
require_once '../jpgraph-3.5.0b1/src/jpgraph_error.php';
require_once '../jpgraph-3.5.0b1/src/jpgraph_utils.inc.php';
require_once '../jpgraph-3.5.0b1/src/jpgraph_ttf.inc.php';
require_once '../jpgraph-3.5.0b1/src/themes/WebSenseTheme.class.php';


$month=array(
"Jan","Feb","Mar","Apr","Maj","Jun","Jul","Aug","Sep","Okt","Nov","Dec");

$steps=100;
for($i=0; $i<$steps; ++$i) {
	$databarx[]=sprintf("198%d %s",floor($i/12),$month[$i%12]);
	
	// Simulate an accumulated value for every 5:th data point
	if( $i % 6 == 0 ) {
		$databary[]=abs(25*sin($i)+5);
	}
	else {
		$databary[]=0;
	}
	
}

// New graph with a background image and drop shadow
$graph = new Graph(1600, 1000);

// Use an integer X-scale
$graph->SetScale("textlin");

// Set title and margin
	$graph -> img -> SetMargin(100, 150, 50, 50);
	$graph -> title -> Set($messages['testgraph.title']);


// Display every 10:th datalabel
$graph->xaxis->SetTextTickInterval(6);
$graph->xaxis->SetTextLabelInterval(2);
$graph->xaxis->SetTickLabels($databarx);
$graph->xaxis->SetLabelAngle(90);

// Create the bar plot
$b1 = new BarPlot($databary);
$b1->SetLegend("Temperature");
$graph->Add($b1);

// Create line plots
for($t = 0; $t < 20; $t++) {
// Create datapoints where every point
$steps=100;
for($i=0; $i<$steps; ++$i) {
	$datay[$i]=log(pow($i,$i/10)+1)*sin($i/15)+25+2*$t;	
}
$p1 = new LinePlot($datay);
$p1->SetLegend("Pressure ".$t);
$graph->Add($p1);
}


//placet the legend at the bottom
$graph->legend->SetFont(FF_ARIAL,FS_NORMAL,12);
$graph->legend->SetPos(0.5,.99,'center','bottom');

// Finally output the  image
$graph->Stroke();

?>
