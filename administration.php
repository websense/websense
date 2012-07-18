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
		<script src="script/jquery-1.6.2.min.js"></script>
		<script src="script/jqueryui-1.8.16.min.js"></script>
		<link rel="stylesheet" href="jquery-ui.css">
		<link rel="stylesheet" href="simplestyle.css">
		<script src="script/change_locale.js"></script>
		<title><?php echo $messages['banner.navigation.administration'] ?></title>
	</head>
	<body>
		<!-- Page header -->
		<?php
		require 'banner.php';
		?>

		<form method="post" action="addNode.php">
			<fieldset>
				<legend>
					Add Nodes
				</legend>
				<input type="submit" />
			</fieldset>
		</form>
		<form method="post">
			<fieldset>
				<legend>
					Remove Nodes
				</legend>
				<?php
				// TODO list all nodes here
				?>
				<input type="submit" />
			</fieldset>
		</form>
	</body>
</html>