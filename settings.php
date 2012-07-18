<?php
/**
 * This script sets temporary settings that are only in use as long as the php-interpreter runs the current request.
 * This avoids potential clashes with other programs running on the same server.
 * 
 * Setting the default timezone is important for JpGraph, else it will emit warnings.
 * Also, error-reporting may be disabled when the project has fully matured.
 * 
 * @package main
 */
// Activate all error reporting for the duration of the script:
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL | E_STRICT);

// Enable zipping of the generated output from .php-files sent to the browser.
// TODO: Use mod_deflate of the Apache-Server to also compress css/js files sent to the client. Disable zlib.output_compression afterwards.
ini_set('zlib.output_compression', 'On');

// Set the timezone all dates are to be displayed in. This setting is mainly used by jpgraph.
// If it isn't set, jpgraph will emit warnings and notifications that might(will definitively) interfere with the graph creation if
// strict error handling is set.
date_default_timezone_set('Australia/Perth');
?>