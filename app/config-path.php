<?php
session_start();
error_reporting(0);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('session.gc_maxlifetime', 36000);
error_reporting(E_ALL & ~E_NOTICE);

define('ROOTDIR', 'C:/UwAmp/www/mlm'); 
define('SITEDIR', 'C:/UwAmp/www/mlm/app');
define('ROOTURL', 'http://localhost/mlm');
define('SITEURL', 'http://localhost/mlm/app');
define('STATICURL', SITEURL);
 
define('EMAIL_CHECK_EXP', '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/');
define('RECORD_PER_PAGE', '10');
?>