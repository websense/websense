<div id="menu">
	<?php
	/**
	 * This script generates the left hand checkbox-menu for selection of one or more trials.
	 * The information is taken from the database, so the output of this script is dynamic.
	 * 
	 * @package main
	 */
	require 'opendb.php';

	$standort_result = pg_query('SELECT country, id, description FROM standort ORDER BY country, description;');
	$trial = pg_fetch_assoc($standort_result);
	// If there are no trials, there is nothing to do:
	if(!$trial) {
		exit('<form id="observed_locations">'.$messages['menu.no.trials'].'</form>');
	}

	// Select first trial in first country by default:
	$last_country = $trial['country'];
	$menu = '
	<form id="observed_locations">
		<div class="info-box">
			<p>'.$messages['menu.info.paragraph.1'].'</p>
			<p>'.$messages['menu.info.paragraph.2'].'</p>
		</div>
		<fieldset>
			<ul>
				<li class="country_group">
					<h5 class="country_heading">' . $last_country . '</h5>
					<ul class="trialgroup">
						<li>
							<label>
								<input type="checkbox" name="trials[]" value="' . $trial['id'] . '" checked>
								' . $trial['description'] . '
							</label>
						</li>';
						
	while($trial = pg_fetch_assoc($standort_result)) {
		// Add new trial-list whenever country changes:
		$current_country = $trial['country'];
		if($last_country !== $current_country) {
			// Close last trialgroup/country and start new one:
			$menu .= '
					</ul>
				</li>
				<li class="country_group">
					<h5 class="country_heading">' . $current_country . '</h5>
					<ul class="trialgroup">';
			$last_country = $current_country;
		}
		// Add single trial to trialgroup/country:
		$menu .= '
						<li>
							<label>
								<input type="checkbox" name="trials[]" value="' . $trial['id'] . '">
								' . $trial['description'] . '
							</label>
						</li>';
	}
	// Close last country and rest of the form:
	$menu .= '
					</ul>
				</li>
			</ul>
		</fieldset>
		<input type="submit" value="'.$messages['menu.buttons.submit'].'">
	</form>';

	// Return constructed menu to client:
	echo $menu;
	?>
</div>