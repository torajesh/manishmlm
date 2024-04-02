<?php
include('header.php'); 
$mArr = Get_Fetch_Data($con,$_REQUEST['slno'], 'All', 'members_details');
?>
<br><br>
<div class="text-center mt-5"><h4>Aadhaar No: <?php echo $mArr['Aadhar_no']?></h4></div>

<div class="text-center mt-5">
	<img src="UploadDocument/<?php echo $mArr['id']?>/<?php echo $mArr['Aadhar_frontside']?>">
</div>

<div class="text-center mt-5">
	<img src="UploadDocument/<?php echo $mArr['id']?>/<?php echo $mArr['Aadhar_backside']?>">
</div>
