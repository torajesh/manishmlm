<?php
include("config.php");
unset($_SESSION['MANMID']);
unset($_SESSION['MANM_NAME']);
setcookie("MANM_NAME","",time()-36000);
setcookie("MANM_MOBILE","",time()-36000);
header("Location:index.php");
?>