<?php
/**
 * This script retrieves and processes the mandatory GET parameter "trials[]" or "trials".
 *
 * <p>
 * If present, the variable "trials" is declared in the global namespace, containing all the trials that information should be gathered for.
 * It's formatted as an array containing a single string suitable for insertion in a database query.
 * (For example: "... = ANY($trials)")
 * Also, the number of trials "num_trials" is declared.
 * All the scripts in the "ajax" folder/package rely on the trials-parameter to do their queries.
 *</p>
 * <p>
 * If the "trials"-GET-parameter is not present, the script fails with a descriptive error message.
 * </p>
 *
 * @package ajax
 */

require_once '../util.php';

if(!array_key_exists('trials', $_GET)) {
	die($messages['get.params.missing.params']);
}

$trials = phpArrayToSQLArray($_GET['trials']);
$num_trials = count($_GET['trials']);
?>