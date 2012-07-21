<?php 
/**
 * Outputs the client localization strings from localization.php into a javascript-object.
 * Should be included before all javascripts using localization.
 *
 * @package main
 */
require 'localization.php';

// Disable browser caching. This is how drupal does it.
header("Expires: Sun, 19 Nov 1978 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: store, no-cache, must-revalidate, post-check=0, pre-check=0");
?>

var messages = <?php echo json_encode($client_messages); ?>;

<?php
// Translate the jqueryui datepicker.
// The translation file is in the jqueryui folder and should be included previous to this file.

if(array_key_exists('locale', $_SESSION) && $_SESSION['locale'] == 'german'){
	?>
	
	/* German initialisation for the jQuery UI date picker plugin. */
	/* Written by Milian Wolff (mail@milianw.de). */
	jQuery(function($){
		$.datepicker.regional['de'] = {
			closeText: 'schließen',
			prevText: '&#x3c;zurück',
			nextText: 'Vor&#x3e;',
			currentText: 'heute',
			monthNames: ['Januar','Februar','März','April','Mai','Juni',
			'Juli','August','September','Oktober','November','Dezember'],
			monthNamesShort: ['Jan','Feb','Mär','Apr','Mai','Jun',
			'Jul','Aug','Sep','Okt','Nov','Dez'],
			dayNames: ['Sonntag','Montag','Dienstag','Mittwoch','Donnerstag','Freitag','Samstag'],
			dayNamesShort: ['So','Mo','Di','Mi','Do','Fr','Sa'],
			dayNamesMin: ['So','Mo','Di','Mi','Do','Fr','Sa'],
			weekHeader: 'KW',
			dateFormat: 'yy-mm-dd',
			firstDay: 1,
			isRTL: false,
			showMonthAfterYear: false,
			yearSuffix: ''};
		$.datepicker.setDefaults($.datepicker.regional['de']);
	});
	
<?php 
}
?>
