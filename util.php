<?php

/**
 * Returns a PostgreSQL array-string as single element inside a php array for convenience.
 */
function phpArrayToSQLArray($arr) {
	return array('{' . implode(', ', $arr) . '}');
}

/**
 * Returns true if all the values in keysArray are present as keys in assocArray.
 */
function containsKeys($assocArray, $keysArray) {
	return count(array_diff($keysArray, array_keys($assocArray))) == 0;
}

/**
 * Sets headers to prevent clients form caching the current page.
 */
function disableClientCaching(){
	// This is how drupal does it.
	header("Expires: Sun, 19 Nov 1978 05:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: store, no-cache, must-revalidate, post-check=0, pre-check=0");
}

?>