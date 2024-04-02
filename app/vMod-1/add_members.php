<?php
//getDetail($tableName, $where_str, $join_cond='', $cols='') 
$membership_level = $toolObj->getDetail("membership_level"," ","",'*');

$state_details = $toolObj->getDetail("state_details","   ","",'*');

$city_details = $toolObj->getDetail("city_details","  ","",'*');
 

echo "<pre>";
print_r($membership_level);
print_r($state_details);
print_r($city_details);
echo "</pre>";
?>