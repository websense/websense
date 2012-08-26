<?php
/**
 * This file contains the static "Contacts" page of the websense website.
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
		<link rel="stylesheet" href="css/simplestyle.css" type="text/css" media="screen">
		<script src="script/jquery-1.7.2.min.js"></script>
		<script src="script/jqueryui/jquery-ui-1.8.21.custom.min.js"></script>
		<script src="localization_client.php"></script>
		<script src="script/change_locale.js"></script>
		<title><?php echo $messages['contact.title'] ?></title>
	</head>
	<body>
		<?php
		require 'banner.php';
		?>
		<p>
			<?php echo $messages['contact.paragraph.1'] ?>
		</p>
		<p>
			<?php echo $messages['contact.paragraph.2'] ?>
		</p>
		<ul>
			<li>
				Moritz Lenz, Hochschule Mannheim
			</li>
			<li>
				Miriam Föller-Nord, Hochschule Mannheim
			</li>
			<li>
				Kai Trotter, Hochschule Mannheim
			</li>
			<li>
				Rachel Cardell-Oliver, University of Western Australia
			</li>
			<li>
				Thomas Zimmermann, Hochschule Mannheim and UWA
			</li>
		</ul>
		<p>
			<?php echo $messages['contact.feedback.paragraph.1'] ?>
			<a href="mailto:rachel.cardell-oliver@uwa.edu.au?subject=Websense3%20feedback"><?php echo $messages['contact.feedback.mail'] ?></a>
			<?php echo $messages['contact.feedback.paragraph.2'] ?>
		</p>
	</body>
</html>