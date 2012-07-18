<?php
/**
 * This script opens the connection to the PostgreSQL database that is used throughout the program.
 * 
 * Multiple requires of this file do no harm, as the pg_connect function is "clever" enough to reuse the connection,
 * but should be avoided for clarity.
 * When transferring this file to a different server, the port of the DBMS may have to be adjusted.
 * 
 * @package main
 */

 require_once 'localization.php';
 
  //open test-database
  $db_handle = pg_connect("host=localhost port=5432 dbname=websense user=webreader password=webreader") or die('<p>'.$messages['opendb.error'].'</p>');
  //open postgres database for websense application
  //$db_handle = pg_connect("host=localhost port=5000 dbname=test user=webreader password=webreader") or die("<p>Cannot connect to Australian DB");
  //do this externally
  //$db_handle = pg_connect("host='141.19.78.216' port=5003 dbname=sensordb user=postgres password=testuser");
  //if (!$db_handle) { echo '<p>Error connecting to German DB'; } else { echo '<p>German DB OK'; }
?>
