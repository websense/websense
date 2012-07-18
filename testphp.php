<h1>Test that Apache Server is Running</h1>
<p>
	You should see a table of php information below.
</p>
<p>
	If not, then check that the Apache server is running
	and that the websense directory is placed in the Apache htdocs directory.
</p>
<?php
/**
 * This script just outputs phpinfo() to see if the apache server is running.
 * 
 * @package main
 */
phpinfo();
?>

