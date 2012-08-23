<?php
/**
*
*Help.php file containing help documentation
*
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
		<title><?php echo $messages['help.title'] ?></title>
	</head>
	<body>
		<?php 
		require 'banner.php';
		?>
		<p>
			<?php echo $messages['help.intro'] ?>
		</p>
		<p> 
			<?php echo $messages['help.intro.2'] ?>
		</p>
		<h4 class="rounded-corners"><?php echo $messages['help.help.title'] ?></h4>
		<p>
			<?php echo $messages['help.list.german'] ?>
		</p>
			<ul>
			<li>
				<a href="javascript:void(window.open('Help_Documentation/German/index.html','example','width=auto, height=auto, location=no, 					menubar=no, status=no, toolbar=yes, scrollbars=yes, resizable=yes, left=600,top=50'))"><?php echo $messages['help.online.help.ger'] ?></a>
			</li> 
			<li>
				<a href="Help_Documentation/German/Benutzerhandbuch.pdf"><?php echo $messages['help.user.guide.ger'] ?></a>
			</li>
			</ul>
		<p>
			<?php echo $messages['help.list.english'] ?>
		</p> 
			<ul>
			<li>
				<a href="javascript:void(window.open('Help_Documentation/English/index.html','example','width=auto, height=auto, location=no, 					menubar=no, status=no, toolbar=yes, scrollbars=yes, resizable=yes, left=600,top=50'))"><?php echo $messages['help.online.help.en'] ?></a>
			</li>
			<li>
				<a href="Help_Documentation/English/UserGuide.pdf"><?php echo $messages['help.user.guide.en'] ?></a> 
			</li>
			</ul>
	</body>
</html>