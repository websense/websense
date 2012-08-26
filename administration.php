<?php
/**
 * This page allows to add sensors, locations etc. to the database.
 *
 * @package main
 */
require 'settings.php';
require 'localization.php';
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<link rel="stylesheet"
	href="script/jqueryui/jquery-ui-1.8.21.custom.css">
<link rel="stylesheet" href="css/simplestyle.css">
<link rel="stylesheet" href="css/administration.css">
<script src="script/jquery-1.7.2.min.js"></script>
<script src="script/jqueryui/jquery-ui-1.8.21.custom.min.js"></script>
<script src="localization_client.php"></script>
<script src="script/change_locale.js"></script>
<script src="script/administration.js"></script>
<title><?php echo $messages['banner.navigation.administration'] ?></title>
</head>
<body>
	<!-- Page header -->
	<?php
	require 'banner.php';
	?>
	<div id="admin-wrapper">

		<div id="admin-trial-block">
			<h4>
				<?php echo $messages['administration.form.trials.title'] ?>
			</h4>
			<img class="image-button"
				alt="<?php echo $messages['administration.form.trials.add.title'] ?>"
				title="<?php echo $messages['administration.form.trials.add.title'] ?>"
				src="images/Add.png"> <img class="image-button"
				alt="<?php echo $messages['administration.form.trials.edit.title'] ?>"
				title="<?php echo $messages['administration.form.trials.edit.title'] ?>"
				src="images/Edit.png"> <img class="image-button"
				alt="<?php echo $messages['administration.form.trials.remove.title'] ?>"
				title="<?php echo $messages['administration.form.trials.remove.title'] ?>"
				src="images/Remove.png">
			<ul>
			</ul>
		</div>

		<div id="admin-node-block">
			<h4>
				<?php echo $messages['administration.form.nodes.title'] ?>
			</h4>
			<img class="image-button"
				alt="<?php echo $messages['administration.form.nodes.add.title'] ?>"
				title="<?php echo $messages['administration.form.nodes.add.title'] ?>"
				src="images/Add.png"> <img class="image-button"
				alt="<?php echo $messages['administration.form.nodes.edit.title'] ?>"
				title="<?php echo $messages['administration.form.nodes.edit.title'] ?>"
				src="images/Edit.png"> <img class="image-button"
				alt="<?php echo $messages['administration.form.nodes.remove.title'] ?>"
				title="<?php echo $messages['administration.form.nodes.remove.title'] ?>"
				src="images/Remove.png">
			<ul>
			</ul>
		</div>

		<div id="admin-sensor-block">
			<h4>
				<?php echo $messages['administration.form.sensors.title'] ?>
			</h4>
			<img class="image-button"
				alt="<?php echo $messages['administration.form.sensors.add.title'] ?>"
				title="<?php echo $messages['administration.form.sensors.add.title'] ?>"
				src="images/Add.png"> <img class="image-button"
				alt="<?php echo $messages['administration.form.sensors.edit.title'] ?>"
				title="<?php echo $messages['administration.form.sensors.edit.title'] ?>"
				src="images/Edit.png"> <img class="image-button"
				alt="<?php echo $messages['administration.form.sensors.remove.title'] ?>"
				title="<?php echo $messages['administration.form.sensors.remove.title'] ?>"
				src="images/Remove.png">
			<ul>
			</ul>
		</div>

	</div>
</body>
</html>
