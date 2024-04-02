<?php
//getDetail($tableName, $where_str, $join_cond='', $cols='') 
$userData = $toolObj->getDetail("members_details"," and id= '".$_SESSION['user_00']['id']."' ","",'*');

if(isset($_SESSION['user_00']['mem_photo']) and !empty($_SESSION['user_00']['mem_photo'])) {

	$Photos = ROOTURL."/UploadDocument/".$_SESSION['user_00']['id']."/".$_SESSION['user_00']['mem_photo'];
}
else {
	$Photos = ROOTURL.'/images/noimg.png';
}

// echo "<pre>";
// print_r($userData);
// echo "</pre>";
?>