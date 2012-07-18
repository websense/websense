<?php
session_start();

if(array_key_exists('locale', $_POST)) {
	$_SESSION['locale'] = $_POST['locale'];
}

?>