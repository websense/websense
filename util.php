<?php

/**
 * Returns a PostreSQL array-string as single element inside a php array for convenience.
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
?>