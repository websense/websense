<?php 
/**
 * Outputs the client localization strings from localization.php into a javascript-object.
 * Should be included before all javascripts using localization.
 *
 * @package main
 */
require 'localization.php';
require_once 'util.php';

// This file must not be cached, else the cached localization would be used.
disableClientCaching();
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
