<?php

/**
 * webSense Theme class RCO Sept 2011
 */
class WebSenseTheme extends Theme {
	private $font_color = 'black';
	//'#0044CC';
	private $background_color = '#DDFFFF';
	private $axis_color = 'gray';
	// '#0066CC';
	private $grid_color = 'lightgray';
	//'#3366CC';

	function GetColorList() { //from http://doc.async.com.br/jpgraph/html/2230colors.html
		return array('dodgerblue3', 'darkgoldenrod1', 'darkolivegreen3', 'red', 'bisque4', 'aquamarine3', 'chocolate2', 'cadetblue3', 'lightsteelblue', 'burlywood4', 'chartreuse4', 'firebrick', 'blue', 'palevioletred4', 'darkolivegreen2', 'goldenrod4', 'lightsalmon', 'darkorange', 'darkred', 'steelblue4');
	}

	function SetupGraph($graph) {

		// graph

		$graph -> SetFrame(false);
		$graph -> SetMarginColor('white');

		// legend
		$graph -> legend -> SetFrameWeight(0);
		$graph -> legend -> Pos(0.5, 0.94, 'center', 'bottom');
		$graph -> legend -> SetFont(FF_ARIAL, FS_NORMAL, 14);
		//new
		$graph -> legend -> SetColor($this -> font_color);
		$graph -> legend -> SetFillColor('white');
		$graph -> legend -> SetLayout(LEGEND_HOR);
		$graph -> legend -> SetColumns(6);
		//wide legend
		$graph -> legend -> SetShadow(false);
		$graph -> legend -> SetMarkAbsSize(12);

		// xaxis
		$graph -> xaxis -> title -> SetColor($this -> font_color);
		$graph -> xaxis -> SetFont(FF_ARIAL, FS_NORMAL, 12);
		$graph -> xaxis -> SetColor($this -> axis_color, $this -> font_color);
		//axis and labels
		$graph -> xaxis -> SetTickSide(SIDE_BOTTOM);
		$graph -> xaxis -> SetLabelMargin(10);

		// yaxis (copied to ynaxis)
		$graph -> yaxis -> title -> SetColor($this -> font_color);
		$graph -> yaxis -> title -> SetFont(FF_ARIAL, FS_NORMAL, 12);
		$graph -> yaxis -> SetColor($this -> axis_color, $this -> font_color);
		$graph -> yaxis -> SetFont(FF_ARIAL, FS_NORMAL, 12);
		$graph -> yaxis -> SetTickSide(SIDE_LEFT);
		$graph -> yaxis -> SetTitleMargin(40);

		// grid
		$graph -> ygrid -> SetColor($this -> grid_color);
		$graph -> ygrid -> SetLineStyle('dotted');

		//title font
		$graph -> title -> SetColor($this -> font_color);
		$graph -> title -> SetFont(FF_ARIAL, FS_NORMAL, 18);
		$graph -> subtitle -> SetColor($this -> font_color);
		$graph -> subsubtitle -> SetColor($this -> font_color);

		//$graph->img->SetAntiAliasing(); //don't use antialiasing because it is slow and stops line width settings
	}

	function SetupPieGraph($graph) {

		// graph
		$graph -> SetFrame(false);

		// legend
		$graph -> legend -> SetFillColor('white');

		$graph -> legend -> SetFrameWeight(0);
		$graph -> legend -> Pos(0.5, 0.95, 'center', 'top');
		$graph -> legend -> SetLayout(LEGEND_HOR);
		$graph -> legend -> SetColumns(4);

		$graph -> legend -> SetShadow(false);
		$graph -> legend -> SetMarkAbsSize(5);

		// title
		$graph -> title -> SetColor($this -> font_color);
		$graph -> subtitle -> SetColor($this -> font_color);
		$graph -> subsubtitle -> SetColor($this -> font_color);

		$graph -> SetAntiAliasing();
	}

	function PreStrokeApply($graph) {
		if($graph -> legend -> HasItems()) {
			$img = $graph -> img;
			$height = $img -> height;
			$graph -> SetMargin($img -> left_margin, $img -> right_margin, $img -> top_margin, $height * 0.25);
		}
	}

	function ApplyPlot($plot) {

		switch (get_class($plot)) {
			case 'GroupBarPlot' :

			case 'AccBarPlot' :
				foreach($plot->plots as $_plot) {
					$this -> ApplyPlot($_plot);
				}
				break;

			case 'BarPlot' :

			//always rain as lightblue bar
				$plot -> Clear();

				$color = 'cornflowerblue';
				//$this->GetNextColor();
				$plot -> SetColor($color);
				$plot -> SetFillColor($color);
				$plot -> SetWidth(3.0);
				//$plot->SetShadow('red', 3, 4, false);
				break;

			case 'LinePlot' :
				$plot -> Clear();
				$plot -> SetColor($this -> GetNextColor() . '@0.4');
				//40% transparency
				$plot -> SetWeight(3);
				//maybe too strong
				break;

			case 'PiePlot' :
				$plot -> SetCenter(0.5, 0.45);
				$plot -> ShowBorder(false);
				$plot -> SetSliceColors($this -> GetThemeColors());
				break;

			case 'PiePlot3D' :
				$plot -> SetSliceColors($this -> GetThemeColors());
				break;
		}
	}

}
?>
