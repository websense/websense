<?php
/**
 * This file creates the static "Publications" page of the websense website.
 * 
 * @package main
 */
require 'settings.php';
require 'localization.php';
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
		<link rel="stylesheet" href="simplestyle.css" type="text/css" media="screen">
		<script src="script/jquery-1.7.2.min.js"></script>
		<script src="script/jqueryui/jquery-ui-1.8.21.custom.min.js"></script>
		<script src="localization_client.php"></script>
		<script src="script/change_locale.js"></script>
		<title><?php echo $messages['publications.title'] ?></title>
	</head>
	<body>
		<?php
		require 'banner.php';
		?>
		<h4 class="rounded-corners"><?php echo $messages['publications.overview'] ?></h4>
		<ul>
			<li>
				<h5><a href="publications/websense-august2011.pdf">WebSense: A Lightweight and Configurable Application for Publishing Sensor Network Data</a></h5>
				Rachel Cardell-Oliver, Christof Hübner, Miriam Föller-Nord
			</li>
		</ul>
		<h4 class="rounded-corners"><?php echo $messages['publications.deployments'] ?></h4>
		<ul class="spaced-listing">
			<li>
				<h5>Empirical Investigation of Error Correction Strategies for Transmit-only 40 MHz Sensor Networks (in review)</h5>
				Rachel Cardell-Oliver, Andreas Willig, Christof Hübner, Thomas Buerhing, Alvaro Monsalve
			</li>
			<li>
				<h5>Long range wireless sensor networks with transmit-only nodes and software defined receivers</h5>
				Christof Hübner, Rachel Cardell-Oliver, Stefan Hanelt, Tino Wagenknecht, Alvaro Monsalve
				<br>
				<i>Journal of Wireless Communications and Mobile Computing</i> (To appear, accepted May 2011)
			</li>
			<li>
				<h5><a href="http://dl.acm.org/citation.cfm?id=1870052">Poster Abstract: Long range wireless sensor networks using transmit-only nodes</a></h5>
				Christof Hübner, Rachel Cardell-Oliver S Hanelt, T.Wagenknecht, A Monsalve
				<br>
				<i>Proceedings of the 8th international Conference on Embedded Networked Sensor Systems (Zurich, Switzerland, November 3-5, 2010). SenSys 2010</i>. ACM, New York, NY. doi>10.1145/1869983.1870052
			</li>
			<li>
				<h5>Wireless soil moisture sensing for vineyard irrigation</h5>
				K Jotter, C Hübner, K Spohrer, R Cardell-Oliver, R Becker, T Wagenknecht, M Lenz
				<br>
				<i>Proceedings of the 9th International Conference on Electromagnetic Wave Interaction with Water and Moist Substances</i>, ISEMA 2010, October, Weimar, Germany (refereed abstract)
			</li>
			<li>
				<h5><a href="http://radio.tkk.fi/isema2009">Wireless soil moisture sensor networks for environmental monitoring and vineyard irrigation</a></h5>
				C Hübner, R Cardell-Oliver, R Becker, K Spohrer, K Jotter, T Wagenknecht
				<br>
				<i>Proceedings of the 8th International Conference on Electromagnetic
				Wave Interaction with Water and Moist Substances</i>, ISEMA 2009, 1-5 June, Helsinki, Finland, <a href="http://radio.tkk.fi/isema2009">Homepage</a> (refereed abstract)
			</li>
			<li>
				<h5><a href="http://www.sciencedirect.com/science/article/pii/S0168192309001944">Harnessing wireless sensor technologies to advance forest ecology and agricultural research</a></h5>
				S. S. O. Burgess, M. L. Kranz,, N. E. Turner, R. Cardell-Oliver, T.E. Dawson
				<br>
				<i>Journal of Agricultural and Forest Meteorology</i>, Volume 150, Issue 1, 15, January 2010, pages 30-37, DOI 10.1016/j.agrformet.2009.08.002
			</li>
		</ul>
	</body>
</html>