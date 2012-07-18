<?php
 require_once ('jpgraph-3.5.0b1/src/jpgraph.php');
 require_once ('jpgraph-3.5.0b1/src/jpg-config.inc.php');
 require_once ('jpgraph-3.5.0b1/src/jpgraph_date.php');
 require_once ('jpgraph-3.5.0b1/src/jpgraph_line.php');
 require_once ('jpgraph-3.5.0b1/src/jpgraph_bar.php');
 require_once ('jpgraph-3.5.0b1/src/jpgraph_error.php');
 require_once ('jpgraph-3.5.0b1/src/jpgraph_utils.inc.php');
 require_once ('jpgraph-3.5.0b1/src/jpgraph_ttf.inc.php');


include "opendb.php";
$trialid = $_POST['trialid'];
$trialname = $_POST['trialname'];

//output graph or csv text
$outputtype = $_POST['outputtype']; 


//TODO checkdate() in trial range if user changes defaults
$startdate = $_POST['startdate'];
$enddate = $_POST['enddate'];
$ndays = (strtotime($enddate)-strtotime($startdate))/(1440*60); //time in secs, so find days

//echo 'ndays = '.$ndays.'and int='.$ndays/20  .'<br>';

//get the names of each measurement type for labelling axes
$stypesresult = pg_query("SELECT * FROM messgroesse");
$ntypes=pg_numrows($stypesresult);
$sensortype = array($ntypes);
for ($j=0; $j < $ntypes; $j++) {
    $strow = pg_fetch_array($stypesresult);
    $sensortype[$j] = $strow['id'];
//echo "sensortype[". $j ."]=".$strow['id']." (".$strow['name'].")<br>";
}

$sensormessreiheid = $_POST['sensorname'];
$nsensors = count($sensormessreiheid);

//debug
//echo "<br>num of sensor types = ".$ntypes; 
//echo "<br>num of sensor names = ".$nsensors.":<br>"; 
//for ($i=0; $i < $nsensors; $i++) { echo $sensormessreiheid[$i]."<br>"; }

if (empty($sensormessreiheid) || empty($outputtype)) {
  echo "<p>Please select one or more Sensor Nodes to display and select output format</p>";
} 

if ($outputtype==graph) {
    $graph = new Graph(1600,800);
    $graph->SetScale('datlin'); 
    $graph->img->SetMargin(60,180,60,40);	
    $graph->title->SetFont(FF_ARIAL, FS_NORMAL, 16);
    $graph->title->Set("Sensor data for ".$trialname." from ". $startdate." to ". $enddate);
    $graph->xaxis->SetPos( 'min' ); #x labels at bottom of graph
    $graph->xaxis->scale->SetTimeAlign( DAYADJ_1 );
    $graph->xaxis->SetLabelAngle(45);
    if ($ndays>20) { //don't let the x axis get too crowded
       $graph->xaxis->scale->ticks->Set(($ndays/20)*1440*60);
       $graph->xaxis->SetLabelFormatString('d M',true);
    } else {
      $graph->xaxis->scale->ticks->Set(12*60*60); //12 hour
      $graph->xaxis->SetLabelFormatString('d M H:00',true);
    }
    $graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,10); 
    $graph->SetYDeltaDist(60); //default 50 between axes is too close 
}

if ($outputtype==csvtext) {
   //output sensor name, reading type, time, value
   echo "SENSOR_NAME , SENSOR_TYPE , TIME ,  VALUE <br>";
}
       
$ynum=0;  //number of y axes used so far
$ydrawn=0; //axis not drawn for this $t yet
for ($t=0; $t < $ntypes; $t++) { //for each sensor type make new y axis
  //get y get descriptions
  $nameresult = pg_query("SELECT * FROM messgroesse 
        WHERE id=".$sensortype[$t]);
  $namerow = pg_fetch_assoc($nameresult);
  $tname=$namerow['description'];
  $tunit=$namerow['unit'];
  $ytitle=$namerow['description'].' ('.$tunit.' )';
  if ($ydrawn==1) { $ynum++; }
  $ydrawn=0; //axis not drawn for this $t yet

for ($i=0; $i < $nsensors; $i++) {
  
  $result = pg_query("SELECT sensor.description from sensor,messreihe 
       WHERE sensor.id=messreihe.sensor_id AND 
             messreihe.id=".$sensormessreiheid[$i]) or 
              die ('Error performing sensorname graph query');
  $srow = pg_fetch_array($result);
  $sname = $srow['description'].' ('.$tunit.')';

    $graphquery = "SELECT measurementtime, wert 
    FROM messwert,messreihe
    WHERE messreihe.id=messwert.messreihe_id AND
          messreihe.messgroesse_id=".$sensortype[$t]." AND
          messwert.messreihe_id =". $sensormessreiheid[$i] ." AND
          messwert.measurementtime >= '". $startdate."' AND
          messwert.measurementtime < '". $enddate ."'
     ORDER BY measurementtime";

    $result = pg_query($graphquery) or 
              die ('Error performing time,wert graph query');
    $nrows=pg_numrows($result);

//echo "nrows for i=".$i." and sname=".$sname." type=". $tname;
//echo " messreiheid=". $sensormessreiheid[$i]." is ".$nrows."<br>";

    if ($nrows > 0) { //then plot result, else try next sensor/type 
      if ($outputtype==csvtext) { echo "<br>nrows=".$nrows."<br>"; }
      //TODO if nrows too large then change j increment so only select vals are shown say if ($nrows > 5000) {
//if ($nrows > 5000) { //&& ($outputtype==graph)) { 
//	$step = (int) ($nrows/5000);
//  $step = step+1;
//	$npoints = (int) ($nrows/$step);
//	$act="(compressed by step=".$step.")";
	//  } else {
		 $step = 1;
         $npoints = $nrows;
	 // $act="(no compression)";
	 // }
	 //if ($outputtype==csvtext) {
	 // echo "<p>step=".$step." and npoints=".$npoints." and act = ".$act."</p>";
	 // }
      $datax1 = array($npoints);
      $datay1 = array($npoints);
      
      for ($j=0; $j < $npoints; $j++) {
	//for ($k=0; $k < $step; $k++) { //plot every $step-th val only
	      $row = pg_fetch_array($result);
	      //}
	      $datax1[$j] = strtotime($row['measurementtime']); 
	      $datay1[$j] = $row['wert']; 
            }
        if ($outputtype==csvtext) {
           //output sensor name, reading type, time, value
	  echo $sname." , ".$tname." , ".$row['measurementtime']." , ".$row['wert']."<br>";
        }
      } //end get measurement point for each j
      //add a line and legend if data exists
        if ($outputtype==graph) {
          if ($sensortype[$t]==14) { //rainfall (only) drawn as bar graph
	    $p1 = new BarPlot($datay1,$datax1);
	    $p1->SetWidth(3.0);
          } else {
	    $p1 = new LinePlot($datay1,$datax1); //datlin has y then x
	    //TODO find why weight has no effect here 
            //$p1->SetWeight ( 10 ); 
	   }
          $p1->SetLegend($sname); //.$act); 
        }

    if ($ynum==0) { //first type so add to left hand yaxis
        if ($outputtype==graph) {
            if ($ydrawn==0) {
                $graph->yaxis->title->SetFont(FF_ARIAL,FS_NORMAL,12); 
                $graph->yaxis->title->Set($ytitle); 
                $graph->yaxis->SetTitleMargin(40);
                $graph->yaxis->SetFont(FF_ARIAL,FS_NORMAL,10); 
                $ydrawn=1;
            }
          $graph->Add($p1);
        }
        
	} else { //ynum > 0 so need new y axes
      if ($outputtype==graph) {
        if ($ydrawn==0) {
            $graph->SetYScale($ynum-1,'lin');
            $graph->ynaxis[$ynum-1]->title->SetFont(FF_ARIAL,FS_NORMAL,12);
            $graph->ynaxis[$ynum-1]->title->Set($ytitle);
            $graph->ynaxis[$ynum-1]->SetTitleMargin(40);
            $graph->ynaxis[$ynum-1]->SetFont(FF_ARIAL,FS_NORMAL,10);

            $ydrawn=1; //to ensure only 1 y axis of each type is drawn
	    } 
	   $graph->AddY($ynum-1,$p1);
      }
	} //end else ynum>0

     // see old versions for bar plots
   } //end if anything to plot

 } //end for each sensor
 //end for each type

if ($outputtype==graph) {
    $graph->legend->SetFont(FF_ARIAL,FS_NORMAL,12);
    $graph->legend->SetPos(0.5,0.95,'center','bottom');
    $graph->Stroke(); //send image to the client
}
?>    
