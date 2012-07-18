<?php
/**
 * This file contains the static "Downloads" page of the websense website.
 *
 * It provides links to the software used to create the Websense project
 * and further documentation.
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
		<script src="script/change_locale.js"></script>
		<title><?php echo $messages['downloads.title'] ?></title>
	</head>
	<body>
		<?php
		require 'banner.php';
		?>

		<h4 class="rounded-corners"><?php echo $messages['downloads.used.software'] ?></h4>
		<ul>
			<li>
				<a href="http://httpd.apache.org/"><?php echo $messages['downloads.apache.web.server'] ?></a>
			</li>
			<li>
				<a href="http://www.postgresql.org/"><?php echo $messages['downloads.postgresql'] ?></a>
			</li>
			<li>
				<a href="http://jquery.com/"><?php echo $messages['downloads.jquery'] ?></a>
			</li>
			<li>
				<a href="http://jqueryui.com/"><?php echo $messages['downloads.jqueryui'] ?></a>
			</li>
			<li>
				<a href="http://jpgraph.net/"><?php echo $messages['downloads.jpgraph'] ?></a>
			</li>
		</ul>
		<h4 class="rounded-corners"><?php echo $messages['downloads.installation'] ?></h4>
		<p>
			<a href="websense-installation-instructions.html"><?php echo $messages['downloads.link'] ?></a>
		</p>
		<h4 class="rounded-corners"><?php echo $messages['downloads.database.skeleton'] ?></h4>
		<p>
			<?php echo $messages['downloads.tba'] ?>
		</p>
		<h4 class="rounded-corners"><?php echo $messages['downloads.webapp.code'] ?></h4>
		<p>
			<?php echo $messages['downloads.tba'] ?>
		</p>
	</body>
</html>