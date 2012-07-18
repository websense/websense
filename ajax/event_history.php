<?php
/**
 * This script retrieves all the events (measurement adjustments, sensors added...) to the given trial.
 * If multiple trials were selected, a descriptive message stating so is returned to the client instead.
 *
 * @package ajax
 */
require '../settings.php';
require '../localization.php';
require 'get_params.php';

if($num_trials > 1) {
	exit($messages['event.history.multiple.trials.selected']);
}

require '../opendb.php';

$blogquery = 'SELECT to_char(event_date, \'YYYY-MM-DD: \') || event_description AS entry
			  FROM trialeventblog
			  WHERE (trial_id = ANY($1))
			  ORDER BY event_date DESC;';
						 
$blogresult = pg_query_params($blogquery, $trials) or die($messages['event.history.error.query.blog']);
$row = pg_fetch_assoc($blogresult);

if(!$row) {
	exit($messages['event.history.no.events']);
}

$event_blog = '<ol id="event_blog">';
do {
	$event_blog .= '<li>' . $row['entry'] . '</li>';
} while($row = pg_fetch_assoc($blogresult));
$event_blog .= '</ol>';

echo $event_blog;
?>