<?php
define('DB_NAME', 'avmgodrej_mlm_db');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');

 

define('DB_HOST', 'localhost');
define("SESSION", session_id());
date_default_timezone_set("Asia/Kolkata");


try {
	$dbo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD);

} catch (PDOException $e) {
	print "Error!: " . $e->getMessage() . "<br/>";
	die();
}
?>