<h1>Test that Postgresql Server is Running</h1>
<p>
	You should see a table of trial names from the database below.
</p>
<p>
	If everything is working then clicking on a trial will take you to the websense application.
</p>
<?php //get trial ids
	/**
	 * This script merely tests the database connection and outputs some links if it is working.
	 *
	 * @package main
	 */
	include 'opendb.php';
	echo '<h4>List of Sensor Networks in the Database</h4>';

	$standort_result = pg_query('SELECT country, description FROM standort ORDER BY country, description;');

	echo '<ul>';
	if($trial = pg_fetch_assoc($standort_result)) {
		$last_country = $trial['country'];
		echo '<li><h5>' . $last_country . '</h5></li>';
		echo '<li><a href="index.php">' . $trial['description'] . '</a></li>';
		while($trial = pg_fetch_assoc($standort_result)) {
			// Add headline whenever country changes:
			$current_country = $trial['country'];
			if($last_country !== $current_country) {
				echo '<li><h5>' . $current_country . '</h5></li>';
				$last_country = $current_country;
			}
			echo '<li><a href="index.php">' . $trial['description'] . '</a></li>';
		}
	}
	echo '</ul>';
?>

