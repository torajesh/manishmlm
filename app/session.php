<?php
session_start();


echo "<pre>";
echo "==================SESSION====================<br>";
print_r($_SESSION);
echo "==================SESSION====================<br>";
echo "<br><br>";
echo "==================REQUEST====================<br>";
print_r($_REQUEST);
echo "==================REQUEST====================<br>";

echo "<br><br>";
echo "==================_COOKIE====================<br>";
print_r($_COOKIE);
echo "==================_COOKIE====================<br>";
echo "<br><br>";

echo "</pre>";

$_SESSION['select_q'] = array();
$_SESSION['update_q'] = array();
$_SESSION['insert_q'] = array();
$_SESSION['delete_q'] = array();
//session_destroy();

phpinfo();
 
?>