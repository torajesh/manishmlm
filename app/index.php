<?php
require_once("config-path.php");
require_once("config-connect.php");
require_once(SITEDIR."/vClasses/tools.class.php");
 
$toolObj = new commonTools();

$page = $_REQUEST['page'];
$breadcrumb = "Dashboard";

switch($page) {

	case 'cuisine':
	$loadpage = SITEDIR."/htmlViews/cuisine.php";
	$loadscript = SITEDIR."/assets/js/cuisine.js";
	break; 

 
	case 'my_profile':
	include_once(SITEDIR."/vMod-1/my_profile.php");
	$LOAD_PAGE = SITEDIR."/vView-1/my_profile.php";
	$breadcrumb = "My Profile";
	break;

	case 'my_members':
	include_once(SITEDIR."/vMod-1/my_members.php");
	$LOAD_PAGE = SITEDIR."/vView-1/my_members.php";
	$breadcrumb = "My Referrals";
	break;

	case 'add_members':
	include_once(SITEDIR."/vMod-1/add_members.php");
	$LOAD_PAGE = SITEDIR."/vView-1/add_members.php";
	$breadcrumb = "Add Referral";
	break;
	
	case 'logout':
	$toolObj->logout(SITEURL."/");
	break;
 

	//---------------START HERE------------------//
	case 'ajaxglobal':
	include $SITEDIR."/vMod-1/ajax-global-calling.php";				
	break;
	
	default:
	$loadpage = SITEDIR."/htmlViews/home.php";
}

if(isset($_SESSION['user_00']['id']) && $_SESSION['user_00']['id'] > 0 ) {

	include_once(SITEDIR."/Includes/main-frame.php");
}
else {
	include_once(SITEDIR."/Includes/nologin-frame.php");
}
?>