<?php
	$con = new PDO('mysql:host=localhost; dbname=electronitech', 'root', '');
	$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$con->exec('set names utf8');
	date_default_timezone_set('America/Bogota');
?>