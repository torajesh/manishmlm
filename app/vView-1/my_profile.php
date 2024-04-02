 <?php
 /*
[0] => Array
        (
            [id] => 10
            [MemberCode] => S0002
            [member_type] => 1
            [Email] => testuserx@yahoo.com
            [password] => 123456
            [Name] => Sudharshan Sharma
            [gst_no] => 
            [Address] => A-59, National Highway, Near Gurdwara 
            [State] => 6
            [City] => 134
            [landmark] => New Mother Dairy
            [PMobile] => 6521425632
            [AMobile] => 5236521452
            [RCompany] => 
            [RName] => 
            [RGst] => 
            [RAddress] => 
            [RState] => 0
            [RCity] => 0
            [RPMobile] => 
            [RAMobile] => 
            [Status] => Active
            [Add_time] => 25/03/2024 11:18:16
            [pincode] => 123654
            [credit_days] => 7
            [VisitingCard] => 
            [payment_mode] => Cheque
            [senior_id] => 8
            [member_level] => 
            [mem_photo] => 1711330743_photo.jpg
            [Aadhar_no] => 523612364569
            [Aadhar_backside] => 1711388897_AadhaarB.jpg
            [Aadhar_frontside] => 1711388897_AadhaarF.jpg
            [Pan_no] => PAN452SSJ
            [Pan_img] => 1711330743_PAN.jpg
            [Voter_id] => 654123DLS
            [Voter_id_img] => 1711330743_Voter.jpg
            [account_no] => 52363333
            [ifsc_code] => ICIC0002
            [branch_name] => Vikaspuri
            [bank_name] => ICICI Bank
            [fee_paid] => UnPaid
            [register_date] => 25/03/2024
        )
 */
 ?>
<div class="  col-md-12">
			
	<div class="form-group row">
	<div class="col-sm-12 pl-0">  
	<fieldset style="min-height:50px;">
	<legend><b> Basic Details </b> </legend>
	</fieldset>
	</div>

	 
	
	 
	</div>

	<div class="form-group row">      
		<label for="inputPassword" class="col-sm-2 col-form-label pl-0">Member Name </label>
		<div class="col-sm-4"><?php echo $userData[0]['Name'];?></div> 

		<label for="inputPassword" class="col-sm-2 col-form-label pl-0">Photo</label>
		<div class="col-sm-3"><img src="<?php echo $Photos; ?>" alt="User Image" class="avatar-img rounded-circle"></div>      
	</div>

	<div class="form-group row">      
	<label for="inputPassword" class="col-sm-2 col-form-label pl-0">Mobile No. </label>
	<div class="col-sm-4">
	<?php echo $userData[0]['PMobile'];?>
	</div>

	<label for="inputPassword" class="col-sm-2 col-form-label pl-0">Alternate Mobile No. </label>
	<div class="col-sm-4">
	<?php echo $userData[0]['AMobile'];?>
	</div>      
	</div>

	<div class="form-group row">
	<label for="inputPassword" class="col-sm-2 col-form-label pl-0">E-mail-id </label>
	<div class="col-sm-4">
 	<?php echo $userData[0]['Email'];?>
	</div>

	<label for="inputPassword" class="col-sm-2 col-form-label pl-0">Password  </label>
	<div class="col-sm-3">
	<?php echo $userData[0]['password'];?>
	</div> 
	</div>

	<div class="form-group row">      
	<label for="inputPassword" class="col-sm-2 col-form-label pl-0">State  </label>
	<div class="col-sm-4">
	<?php echo $userData[0]['State'];?>
	</div> 

	<label for="inputPassword" class="col-sm-2 col-form-label pl-0">City </label>
	<div class="col-sm-4 d-flex align-items-center"> 
 	<?php echo $userData[0]['City'];?>
	</div>
	</div>

	<div class="form-group row">
	<label for="inputPassword" class="col-sm-2 col-form-label pl-0">Address </label>
	<div class="col-sm-10">
 	<?php echo $userData[0]['Address'];?>
	</div> 
	</div>


	<div class="form-group row">              
	<label for="inputPassword" class="col-sm-2 col-form-label pl-0">Landmark</label>
	<div class="col-sm-4">
 	<?php echo $userData[0]['landmark'];?>
	</div>

	<label for="inputPassword" class="col-sm-2 col-form-label pl-0">Pincode </label>
	<div class="col-sm-4">
 	<?php echo $userData[0]['pincode'];?>
	</div>     
	</div>Voter_id


	<div class="form-group row">
	<label for="inputPassword" class="col-sm-2 col-form-label pl-0">Voter ID</label>
	<div class="col-sm-4">
	<?php echo $userData[0]['Voter_id'];?>
	</div>      

	<label for="inputPassword" class="col-sm-3 col-form-label pl-0">Upload Voter Card</label>
	<div class="col-sm-3 text-left">
 	<?php echo $userData[0]['Voter_id_img'];?>
	</div> 
	</div>

	<div class="form-group row">
	<label for="inputPassword" class="col-sm-2 col-form-label pl-0">PAN No.</label>
	<div class="col-sm-4">
	<?php echo $userData[0]['Pan_no'];?>
	</div>      

	<label for="inputPassword" class="col-sm-3 col-form-label pl-0">Upload PAN Card</label>
	<div class="col-sm-3">
	<?php echo $userData[0]['Pan_img'];?>
	</div> 
	</div>
 





 
	<div class="form-group row">
	<label for="inputPassword" class="col-sm-2 col-form-label pl-0">Aadhaar No.</label>
	<div class="col-sm-4">
	<?php echo $userData[0]['Aadhar_no'];?>
	</div>
	</div>      
	

	<div class="form-group row">
	<label for="inputPassword" class="col-sm-2 col-form-label pl-0">Aadhaar Card Frontside</label>
	<div class="col-sm-4">
	<?php echo $userData[0]['Aadhar_frontside'];?>
	</div> 

	<label for="inputPassword" class="col-sm-3 col-form-label pl-0">Aadhaar Card Backside</label>
	<div class="col-sm-3">
	<?php echo $userData[0]['Aadhar_backside'];?>
	</div> 
	</div>   
				
	<div class="form-group row">
	<div class="col-sm-12 pl-0">  
	<fieldset style="min-height:50px;">
	<legend><b> Bank Account Details </b> </legend>
	</fieldset>
	</div>

	<label for="inputPassword" class="col-sm-2 col-form-label pl-0">Account No. </label>
	<div class="col-sm-4">
	<?php echo $userData[0]['account_no'];?>
	</div>
	<label for="inputPassword" class="col-sm-2 col-form-label pl-0">IFSC Code </label>
	<div class="col-sm-4">
	<?php echo $userData[0]['ifsc_code'];?>
	</div>
	</div>
	<div class="form-group row">
	<label for="inputPassword" class="col-sm-2 col-form-label pl-0">Branch Name </label>
	<div class="col-sm-4">
	<?php echo $userData[0]['branch_name'];?>
	</div>
	<label for="inputPassword" class="col-sm-2 col-form-label pl-0">Bank Name </label>
	<div class="col-sm-4">
	<?php echo $userData[0]['bank_name'];?>
	</div>       
	</div> 

	<div class="form-group row">
	<div class="col-sm-12 pl-0">  
	<fieldset style="min-height:50px;">
	<legend><b> Pay Details </b> </legend>
	</fieldset>
	</div>
 
	<label for="inputPassword" class="col-sm-2 col-form-label pl-0">Payment Pay (in Days)</label>
	<div class="col-sm-3"><?php echo $userData[0]['Name'];?>
	</div>

	<label for="inputPassword" class="col-sm-3 col-form-label pl-0">Payment Mode </label>
	<div class="col-sm-3">
	<?php echo $userData[0]['Name'];?>
	
	</div> 
	</div>
	

	<div class="form-group row">
	<div class="col-sm-12 pl-0">  
	<fieldset style="min-height:50px;">
	<legend><b>Senior Details </b> </legend>
	</fieldset>
	</div>

	<label for="inputPassword" class="col-sm-2 col-form-label pl-0">Senior Name </label>
	<div class="col-sm-4">
	<?php echo $userData[0]['Name'];?>
	</div>      
	</div>

	<div class="form-group row">
	<div class="col-sm-12 pl-0">  
	<fieldset style="min-height:50px;">
	<legend><b> Admin Details </b> </legend>
	</fieldset>
	</div>   

	<label for="inputPassword" class="col-sm-2 col-form-label pl-0">Pay Registration Fee</label>
	<div class="col-sm-3">
	<?php echo $userData[0]['Name'];?>
	</div>   

	

	<label for="inputPassword" class="col-sm-2 col-form-label pl-0">Registration Date</label>
	<div class="col-sm-3"><?php echo $userData[0]['Name'];?></div>
	</div>

	<div class="form-group row">
		<label for="inputPassword" class="col-sm-2 col-form-label pl-0">Status </label>
		<div class="col-sm-3">
		<?php echo $userData[0]['Name'];?>
		</div>
	</div>       
	
</div>
 