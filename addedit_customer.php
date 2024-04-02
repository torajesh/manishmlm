<?php
$Page="OurMembers";
$InnPage="membersList"; 
include('header.php'); 
include('sidebar.php');
$random=rand(0000000,9999999);
if(isset($_POST['part']) && $_SESSION['random_move']==$_POST['random_move']) {
  if(empty($_POST['slno'])) {
    $Check=Get_Count_Data($con,$_POST['Aadhar_no'],'Aadhar_no','members_details');
  }
  else {
    $querys = mysqli_query($con,"SELECT count(id) as countss FROM members_details where id!='".$_POST['slno']."' and Aadhar_no='".$_POST['Aadhar_no']."' ");
    $row=mysqli_fetch_array($query); 
    $Check = $row['countss']; 
  }
  if($Check==0){
      $errorMsg ='';
      $extension_allow = array('pdf','jpeg','jpg','png');

      if(!empty($_FILES['PhotoUpload']['name'])) {
        $ext = strtolower(pathinfo($_FILES['PhotoUpload']['name'],PATHINFO_EXTENSION));
        if(!in_array($ext, $extension_allow)) {
          $errorMsg .='<br>Only Upload PDF, JPEG, JPG, PNG Format in Photo<br>';
        }
      }

      if(!empty($_FILES['VoterUpload']['name'])) {
        $ext = strtolower(pathinfo($_FILES['VoterUpload']['name'],PATHINFO_EXTENSION));
        if(!in_array($ext, $extension_allow)) {
           $errorMsg .='Only Upload PDF, JPEG, JPG, PNG Format in Voter ID<br>';          
        }
      }

      if(!empty($_FILES['PanUpload']['name'])) {
        $ext = strtolower(pathinfo($_FILES['PanUpload']['name'],PATHINFO_EXTENSION));
        if(!in_array($ext, $extension_allow)) {
          $errorMsg .='Only Upload PDF, JPEG, JPG, PNG Format in Pan Card<br>';  
           
        }
      }   
    
      if(!empty($_FILES['AadhaarCardFront']['name'])) {
        $ext = strtolower(pathinfo($_FILES['AadhaarCardFront']['name'],PATHINFO_EXTENSION));
        if(!in_array($ext, $extension_allow)) {
          $errorMsg .='Only Upload PDF, JPEG, JPG, PNG Format in Aadhaar Frontside<br>';
        }
      }
           
      if(!empty($_FILES['AadhaarCardBack']['name'])) {
        $ext1 = strtolower(pathinfo($_FILES['AadhaarCardBack']['name'],PATHINFO_EXTENSION));
        if(!in_array($ext, $extension_allow)) {
          $errorMsg .='Only Upload PDF, JPEG, JPG, PNG Format in Aadhaar Backside<br>';
        }
      }      
         
    if(empty($errorMsg)) {

      if(!empty($_POST['slno'])) {
        $sqls="UPDATE members_details SET member_type='".$_POST['member_type']."', Email = '".mysqli_real_escape_string($con,$_POST['Email'])."', Name = '".mysqli_real_escape_string($con,$_POST['Name'])."', password = '".$_POST['password']."',  Address = '".mysqli_real_escape_string($con,$_POST['Address'])."', pincode = '".$_POST['pincode']."', State = '".$_POST['State']."', City = '".$_POST['City']."', landmark='".$_POST['landmark']."', PMobile='".$_POST['PMobile']."', AMobile='".$_POST['AMobile']."', credit_days='".$_POST['credit_days']."',  payment_mode='".mysqli_real_escape_string($con,$_POST['payment_mode'])."', senior_id='".mysqli_real_escape_string($con,$_POST['senior_id'])."', account_no='".$_POST['account_no']."', ifsc_code='".$_POST['ifsc_code']."', branch_name = '".mysqli_real_escape_string($con,$_POST['branch_name'])."', bank_name='".$_POST['bank_name']."', Add_time='".date("d/m/Y h:i:s")."', fee_paid='".$_POST['fee_paid']."', Status='".$_POST['Status']."', Pan_no='".$_POST['Pan_no']."',Aadhar_no='".$_POST['Aadhar_no']."', Voter_id='".$_POST['Voter_id']."', register_date='".$_POST['register_date']."' WHERE id='".$_POST['slno']."' ";        
        //echo $sqls."@@";
        $query=mysqli_query($con,$sqls);
        $memID = $_POST['slno'];
      }
      else {

        $sqls="INSERT INTO members_details SET MemberCode = '".$_POST['MemberCode']."', member_type='".$_POST['member_type']."', Email = '".mysqli_real_escape_string($con,$_POST['Email'])."', Name = '".mysqli_real_escape_string($con,$_POST['Name'])."', password = '".$_POST['password']."',  Address = '".mysqli_real_escape_string($con,$_POST['Address'])."', pincode = '".$_POST['pincode']."', State = '".$_POST['State']."', City = '".$_POST['City']."', landmark='".$_POST['landmark']."', PMobile='".$_POST['PMobile']."', AMobile='".$_POST['AMobile']."', credit_days='".$_POST['credit_days']."',  payment_mode='".mysqli_real_escape_string($con,$_POST['payment_mode'])."', senior_id='".mysqli_real_escape_string($con,$_POST['senior_id'])."', account_no='".$_POST['account_no']."', ifsc_code='".$_POST['ifsc_code']."', branch_name = '".mysqli_real_escape_string($con,$_POST['branch_name'])."', bank_name='".$_POST['bank_name']."', Add_time='".date("d/m/Y h:i:s")."', fee_paid='".$_POST['fee_paid']."', Status='".$_POST['Status']."', Pan_no='".$_POST['Pan_no']."',Aadhar_no='".$_POST['Aadhar_no']."', Voter_id='".$_POST['Voter_id']."', register_date='".$_POST['register_date']."' ";
        
        //echo $sqls."@@";
        $query=mysqli_query($con, $sqls);
        $memID = mysqli_insert_id($con);
      }

      if(!empty($_FILES)) {
        if (!file_exists(BASEDIR."/UploadDocument/".$memID)) {
          mkdir(BASEDIR."/UploadDocument/".$memID, 0777, true);
        }

        if(!empty($_FILES['PhotoUpload']['name'])) {
          $ext = pathinfo($_FILES['PhotoUpload']['name'],PATHINFO_EXTENSION); 
          $attachfile = round(microtime(true)).'_photo.'.$ext;            
          $image_upload_path = BASEDIR."/UploadDocument/".$memID."/".$attachfile;
          move_uploaded_file($_FILES['PhotoUpload']['tmp_name'], $image_upload_path);
          mysqli_query($con, "UPDATE members_details SET mem_photo='".$attachfile."' WHERE id='".$memID."'");
        }
        if(!empty($_FILES['VoterUpload']['name'])) {
          $ext = pathinfo($_FILES['VoterUpload']['name'],PATHINFO_EXTENSION); 
          $attachfile = round(microtime(true)).'_Voter.'.$ext;            
          $image_upload_path = BASEDIR."/UploadDocument/".$memID."/".$attachfile;
          move_uploaded_file($_FILES['VoterUpload']['tmp_name'], $image_upload_path);
          mysqli_query($con, "UPDATE members_details SET Voter_id_img='".$attachfile."' WHERE id='".$memID."'");
        }
        if(!empty($_FILES['PanUpload']['name'])) {
          $ext = pathinfo($_FILES['PanUpload']['name'],PATHINFO_EXTENSION); 
          $attachfile = round(microtime(true)).'_PAN.'.$ext;            
          $image_upload_path = BASEDIR."/UploadDocument/".$memID."/".$attachfile;
          move_uploaded_file($_FILES['PanUpload']['tmp_name'], $image_upload_path);
          mysqli_query($con, "UPDATE members_details SET Pan_img='".$attachfile."' WHERE id='".$memID."'");
        }

        if(!empty($_FILES['AadhaarCardFront']['name'])) {
          $ext = pathinfo($_FILES['AadhaarCardFront']['name'],PATHINFO_EXTENSION); 
          $attachfile = round(microtime(true)).'_AadhaarF.'.$ext;            
          $image_upload_path = BASEDIR."/UploadDocument/".$memID."/".$attachfile;
          move_uploaded_file($_FILES['AadhaarCardFront']['tmp_name'], $image_upload_path);
          mysqli_query($con, "UPDATE members_details SET Aadhar_frontside='".$attachfile."' WHERE id='".$memID."'");
        }
        if(!empty($_FILES['AadhaarCardBack']['name'])) {
          $ext = pathinfo($_FILES['AadhaarCardBack']['name'],PATHINFO_EXTENSION); 
          $attachfile = round(microtime(true)).'_AadhaarB.'.$ext;            
          $image_upload_path = BASEDIR."/UploadDocument/".$memID."/".$attachfile;
          move_uploaded_file($_FILES['AadhaarCardBack']['tmp_name'], $image_upload_path);
          mysqli_query($con, "UPDATE members_details SET Aadhar_backside='".$attachfile."' WHERE id='".$memID."'");
        }
      }
      $msss="<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
      <strong>Success!</strong>Member Detail has updated successfully</div>";

    } else {
      $msss="<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
      <strong>Error!</strong> Showing Error ".$errorMsg.".</div>"; 
    }
  }
  else {
    $msss="<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
    <strong>Error!</strong> Aadhaar Card Already Exist</div>"; 
  }
}
$_SESSION['random_move']=$random;

$memQry = mysqli_query($con,"SELECT * FROM members_details where id='".$_REQUEST['slno']."' ");
if(mysqli_num_rows($memQry)>0) {
  $result=mysqli_fetch_array($memQry);

  $_POST['Name'] = $result['Name']; $_POST['member_type'] = $result['member_type'];
  $_POST['Email'] = $result['Email']; $_POST['Address'] = $result['Address'];
  $_POST['State'] = $result['State']; $_POST['City'] = $result['City'];
  $_POST['password'] = $result['password'];
  $_POST['landmark'] = $result['landmark']; $_POST['PMobile'] = $result['PMobile'];
  $_POST['AMobile'] = $result['AMobile']; $_POST['Status'] = $result['Status'];
  $_POST['pincode'] = $result['pincode']; $_POST['senior_id'] = $result['senior_id'];

  $_POST['payment_mode'] = $result['payment_mode']; $_POST['Aadhar_no'] = $result['Aadhar_no'];
  $_POST['Pan_no'] = $result['Pan_no']; $_POST['Voter_id'] = $result['Voter_id'];
  $_POST['account_no'] = $result['account_no']; $_POST['ifsc_code'] = $result['ifsc_code'];
  $_POST['branch_name'] = $result['branch_name']; $_POST['bank_name'] = $result['bank_name'];
  $_POST['fee_paid'] = $result['fee_paid']; $_POST['credit_days'] = $result['credit_days']; 

  $_POST['register_date'] = ($result['register_date'])?($result['register_date']):(date('d/m/Y'));     
}
else {
  $_POST['register_date'] = date('d/m/Y');
}
?>
<!-- Page Wrapper -->
<style>
.Capitalize{ text-transform:uppercase; }
.first{ text-transform:uppercase;     font-size: 14px; } .create_time{ font-size:11px;    white-space: nowrap; } 
.nav-tabs .nav-link.active { background:#dee2e6;}
.nav-link {
    display: block;
    padding: .3rem 1rem;
}
.select2-container--default .select2-selection--single .select2-selection__rendered{line-height: 34px;}
.col-form-label{white-space:nowrap;}
.select2-container .select2-selection--single{height: 34px;}
.form-control{height: 34px;}
/* @media (min-width: 992px){
.modal-lg, .modal-xl {
    max-width: 1024px;
} */
fieldset {
    font-family: sans-serif;
    border-top: 1px solid #00489c;
    background: #fff;
    border-radius: 0;
    padding: 9px;
}

fieldset legend {
    background: #00499e;
    color: #fff;
    padding: 5px 10px;
    font-size: 16px;
    border-radius: 5px;
    box-shadow: 0 0 0 2px #ddd;
    margin-left: 20px;
    width: auto;
}
.table.table-center td:first-child {
    border-left: 2px solid #f3f3f3;
}
</style>
<div class="page-wrapper">
<div class="content container-fluid">     
<!-- Page Header -->
<div class="page-header" style="margin-bottom:0px;">
<div class="row">
<div class="col">
<h3 class="page-title">Add Member</h3>
<ul class="breadcrumb">
<li class="breadcrumb-item"><a href="Dashboard.php">Dashboard</a></li>
<li class="breadcrumb-item"><a href="MembersList.php">Member List</a></li>
<li class="breadcrumb-item active">Add New Member</li>
</ul>
<?php if(isset($msss)){ echo $msss; }?>
</div>
</div>
</div>
    <!-- /Page Header -->
      <div class=" ">
      <div class="col-sm-12">
      <div class="card">
      <div class="card-body">
      <form method="post" action="" enctype="multipart/form-data" autocomplete="off">
      <div class="row form-row px-3">
      <div class="  col-md-12">
      
      <div class="form-group row">
      <div class="col-sm-12 pl-0">  
      <fieldset style="min-height:50px;">
      <legend><b> Basic Details </b> </legend>
      </fieldset>
      </div>

      <label for="inputPassword" class="col-sm-2 col-form-label pl-0">Registration Code</label>
      <div class="col-sm-4">
      <input type="text" class="form-control" placeholder="Enter Member Code" name="MemberCode" value="<?php echo MemberCode($con);?>" readonly> 
      </div> 
      
      <label for="inputPassword" class="col-sm-2 col-form-label pl-0">Member Type:</label>                  
      <div class="col-sm-4">
      <select class="form-control member_type" name="member_type" id="member_type" required>
      <option value="">Select One</option>        
      <?php      
      $mquery=mysqli_query($con,"SELECT * FROM membership_level WHERE status='Active' ");
       while($mArr = mysqli_fetch_array($mquery)) {
        if($mArr['id']==$_POST['member_type']) {
        echo "<option value=".$mArr['id']." selected>$mArr[level_name]</option>";
        }
        else{
         echo "<option value=".$mArr['id'].">$mArr[level_name]</option>"; 
        }
      }
      ?>
      </select>
      </div>
      </div>

      <div class="form-group row">      
      <label for="inputPassword" class="col-sm-2 col-form-label pl-0">Member Name <span class="text-danger">*</span></label>
      <div class="col-sm-4">
      <input type="text" class="form-control" name="Name" placeholder="Name" required="" id="Name" value="<?php echo $_POST['Name'];?>" required>
      </div> 

      <label for="inputPassword" class="col-sm-2 col-form-label pl-0">Upload Photo</label>
      <div class="col-sm-3">
      <input type="file" class="form-control" name="PhotoUpload">
      </div>      
      </div>

      <div class="form-group row">      
      <label for="inputPassword" class="col-sm-2 col-form-label pl-0">Mobile No. <span class="text-danger">*</span></label>
      <div class="col-sm-4">
      <input type="text" class="form-control" name="PMobile" onkeypress="return /[0-9]/i.test(event.key)" placeholder="Mobile No." maxlength="10" pattern="[0-9 ]+" value="<?php echo $_POST['PMobile'];?>" required>
      </div>

      <label for="inputPassword" class="col-sm-2 col-form-label pl-0">Alternate Mobile No. </label>
      <div class="col-sm-4">
      <input type="text" class="form-control" name="AMobile" onkeypress="return /[0-9]/i.test(event.key)" placeholder="Mobile No." maxlength="10" pattern="[0-9 ]+" value="<?php echo $_POST['AMobile'];?>">
      </div>      
      </div>

      <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label pl-0">E-mail-id <span class="text-danger">*</span></label>
      <div class="col-sm-4">
      <input type="text" class="form-control" name="Email" placeholder="E-mail-id" id="Email" value="<?php echo $_POST['Email'];?>" required>
      </div>

      <label for="inputPassword" class="col-sm-2 col-form-label pl-0">Password <span class="text-danger">*</span></label>
      <div class="col-sm-3">
      <input type="text" class="form-control" name="password" placeholder="Password" required="" id="password" value="<?php echo $_POST['password'];?>" required>
      </div> 
      </div>
  
    
      <div class="form-group row">      
      <label for="inputPassword" class="col-sm-2 col-form-label pl-0">State <span class="text-danger">*</span></label>
      <div class="col-sm-4">
      <select class="form-control select2" id="state" name="State" required="">
      <option value="">Select State</option>
      <?php
      $Vsqls=mysqli_query($con,"select * from state_details where status='Y' order by state_name asc");
      while($Vrows=mysqli_fetch_array($Vsqls)){
         if($_POST['State']==$Vrows['id']){
      echo "<option value=".$Vrows['id']." selected>$Vrows[state_name]</option>";  
      }else{
        echo "<option value=".$Vrows['id'].">$Vrows[state_name]</option>"; 
      }
    }
       ?>
      </select>
      </div> 

      <label for="inputPassword" class="col-sm-2 col-form-label pl-0">City<span class="text-danger">*</span></label>
      <div class="col-sm-4 d-flex align-items-center"> 
      <select class="custom-select  select2" name="City" id="city" required>
      <option value="">Select City</option>
        <?php
        $Esqll=mysqli_query($con,"SELECT * from city_details where status='Y' ");
        while($Erow=mysqli_fetch_array($Esqll)){
          if($_POST['City']==$Erow['id']){
            echo "<option value=".$Erow['id']." selected>$Erow[city_name]</option>"; 
          }else{
           echo "<option value=".$Erow['id'].">$Erow[city_name]</option>";  
          }
        }                     
      ?>
      </select>
      <!-- <a class="ml-1" data-toggle="modal" href="#AddNewCity"><i class="fa fa-plus-circle text-success" aria-hidden="true"></i></a>   -->
      </div>
      </div>

      <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label pl-0">Address <span class="text-danger">*</span></label>
      <div class="col-sm-10">
      <textarea type="text" class="form-control address" name="Address" placeholder="Address" id="Address" required><?php echo $_POST['Address'];?></textarea>
      </div> 
      </div>

      <div class="form-group row">              
      <label for="inputPassword" class="col-sm-2 col-form-label pl-0">Landmark</label>
      <div class="col-sm-4">
      <input type="text" class="form-control landmark" name="landmark" placeholder="Landmark" id="landmark" value="<?php echo $_POST['landmark'];?>">
      </div>

      <label for="inputPassword" class="col-sm-2 col-form-label pl-0">Pincode <span class="text-danger">*</span></label>
      <div class="col-sm-4">
      <input type="text" class="form-control pincode" name="pincode" placeholder="Pincode" id="Pincode" onkeypress="return /[0-9]/i.test(event.key)" maxlength="6" value="<?php echo $_POST['pincode'];?>" required>
      </div>     
      </div>

      <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label pl-0">Voter ID / DL License</label>
      <div class="col-sm-4">
      <input type="text" class="form-control Voter_id" name="Voter_id" placeholder="Voter ID / DL License" id="Voter_id" value="<?php echo $_POST['Voter_id'];?>">  
      </div>      

      <label for="inputPassword" class="col-sm-3 col-form-label pl-0">Upload Voter ID / DL License</label>
      <div class="col-sm-3 text-left">
      <input type="file" class="form-control" name="VoterUpload">
      </div> 
      </div>

      <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label pl-0">PAN No.<span class="text-danger">*</span></label>
      <div class="col-sm-4">
      <input type="text" class="form-control pan_no" name="Pan_no" placeholder="Pan No" id="panno"  value="<?php echo $_POST['Pan_no'];?>" required>  
      </div>      

      <label for="inputPassword" class="col-sm-3 col-form-label pl-0">Upload PAN Card</label>
      <div class="col-sm-3">
      <input type="file" class="form-control" name="PanUpload">
      </div> 
      </div>
     
     
      <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label pl-0">Aadhaar No.<span class="text-danger">*</span></label>
      <div class="col-sm-4">
      <input type="text" class="form-control" name="Aadhar_no" id="Aadhar_no" placeholder="Aadhaar No." value="<?php echo $_POST['Aadhar_no'];?>" required>
      </div>
      </div>      
      

      <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label pl-0">Aadhaar Card Frontside</label>
      <div class="col-sm-4">
      <input type="file" class="form-control" name="AadhaarCardFront">
      </div> 

      <label for="inputPassword" class="col-sm-3 col-form-label pl-0">Aadhaar Card Backside</label>
      <div class="col-sm-3">
      <input type="file" class="form-control" name="AadhaarCardBack">
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
      <input type="text" class="form-control" name="account_no" placeholder="Account No." value="<?php echo $_POST['account_no'];?>">
      </div>
      <label for="inputPassword" class="col-sm-2 col-form-label pl-0">IFSC Code</label>
      <div class="col-sm-4">
      <input type="text" class="form-control" name="ifsc_code" placeholder="IFSC Code" value="<?php echo $_POST['ifsc_code'];?>">
      </div>
      </div>
      <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label pl-0">Branch Name </label>
      <div class="col-sm-4">
      <input type="text" class="form-control" name="branch_name" placeholder="Branch Name" value="<?php echo $_POST['branch_name'];?>">
      </div>
      <label for="inputPassword" class="col-sm-2 col-form-label pl-0">Bank Name </label>
      <div class="col-sm-4">
      <input type="text" class="form-control" name="bank_name" placeholder="Bank Name" value="<?php echo $_POST['bank_name'];?>">
      </div>       
      </div> 

      <div class="form-group row">
      <div class="col-sm-12 pl-0">  
      <fieldset style="min-height:50px;">
      <legend><b> Pay Details </b> </legend>
      </fieldset>
      </div>
     
      <label for="inputPassword" class="col-sm-2 col-form-label pl-0">Payment Pay (in Days)</label>
      <div class="col-sm-3"><input type="text" name="credit_days" id="credit_days" class="form-control numval" value="<?php echo $_POST['credit_days'];?>">
      </div>

      <label for="inputPassword" class="col-sm-3 col-form-label pl-0">Payment Mode <span class="text-danger">*</span></label>
      <div class="col-sm-3">
      <select class="form-control select2 payment_mode" name="payment_mode" id="payment_mode">
      <option value="">Select</option>     
      <option value="Online" <?php if($_POST['payment_mode']=="Online"){echo "selected";}?>>Online</option>
      <option value="Cheque" <?php if($_POST['payment_mode']=="Cheque"){echo "selected";}?>>Cheque</option>     
      </select>  
      
      </div> 
      </div>
      

      <div class="form-group row">
      <div class="col-sm-12 pl-0">  
      <fieldset style="min-height:50px;">
      <legend><b>Senior Details </b> </legend>
      </fieldset>
      </div>

      <label for="inputPassword" class="col-sm-2 col-form-label pl-0">Senior Name <span class="text-danger">*</span></label>
      <div class="col-sm-4">
      <select class="form-control select2" name="senior_id" id="senior_id">
      <option value="">Select Senior</option>
      <?php
      $SeniorQry=mysqli_query($con,"select * from members_details where 1=1 ");
      while($Erow=mysqli_fetch_array($SeniorQry)){
        if($_POST['senior_id']==$Erow['id']){
          echo "<option value=".$Erow['id']." selected>$Erow[Name]</option>"; 
        }else{
          echo "<option value=".$Erow['id'].">$Erow[Name]</option>"; 
        }
      }
      ?>  
      </select>
      </div>      
      </div>

      <div class="form-group row">
      <div class="col-sm-12 pl-0">  
      <fieldset style="min-height:50px;">
      <legend><b> Admin Details </b> </legend>
      </fieldset>
      </div>   

      <label for="inputPassword" class="col-sm-2 col-form-label pl-0">Pay Registration Fee<span class="text-danger">*</span></label>
      <div class="col-sm-3">
      <select class="form-control select2" name="fee_paid">
      <option value="">Select One</option>  
      <option value="Paid" <?php echo ($_POST['fee_paid']=='Paid')?('selected'):('')?>>Paid</option>
      <option value="UnPaid" <?php echo ($_POST['fee_paid']=='UnPaid')?('selected'):('')?>>UnPaid</option>
      </select>
      </div>   

      

      <label for="inputPassword" class="col-sm-2 col-form-label pl-0">Registration Date</label>
      <div class="col-sm-3"> <input type="text" class="form-control datepickerss" name="register_date" id="register_date" value="<?php echo $_POST['register_date'];?>" autocomplete="off" style="border: 0px;padding: 3px;"></div>
      </div>

      <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label pl-0">Status <span class="text-danger">*</span></label>
      <div class="col-sm-3">
      <select class="form-control select2" name="Status">      
      <option value="Active" <?php echo ($_POST['Status']=='Active')?('selected'):('')?>>Active</option>
      <option value="InActive" <?php echo ($_POST['Status']=='InActive')?('selected'):('')?>>InActive</option>
      </select>
      </div>
      </div>       

      <hr>
      <input type="hidden" name="random_move" value="<?php echo $_SESSION['random_move']; ?>">
      <input type="hidden" name="slno" value="<?php echo $_REQUEST['slno']; ?>">      
      <input type="hidden" name="part" value="AddEditMember">
      <button type="submit" class="btn btn-success" name="AddMem">SUBMIT MEMBER</button>
      </div>
      </div>
     
      </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /Page Wrapper -->

</div>
<!-- Filter Part --> 




<!-- delete Details Modal -->
<div class="modal fade" id="Modalss" aria-hidden="true" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document" >
    <div class="modal-content load_datas">
      
    </div>
  </div>
</div>
<!-- /delete Details Modal -->
<?php include('footer.php'); ?>
<link rel="stylesheet" type="text/css" href="datatable/css/jquery.dataTables.css">
<link href="djs/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
<script type="text/javascript" language="javascript" src="datatable/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="djs/js/bootstrap-datetimepicker.js" charset="UTF-8"></script> 
<script type="text/javascript" src="djs/js/locales/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script> 
<script>
$('.select2').select2();

$(document).ready(function() {
  // Function to allow only integer and decimal input
  $(".numval").on("input", function() {
    // Remove non-numeric characters and allow only one decimal point
    $(this).val(function(index, value) {
      return value
        .replace(/[^0-9.]/g, '')         // Remove non-numeric characters
        .replace(/(\..*)\./g, '$1');     // Allow only one decimal point
    });
  });
});


/*$(document).on("change", ".pincode", function(e) {
var pincode=$(this).val();
jQuery.ajax({
type:'POST',
url:'return.php',
data:'pincode='+pincode+'&part=Get_State_List',
dataType:'html',
beforeSend: function(){
$('.state').html('<option>Please Wait...</option>');
},
success : function (responseData, status, XMLHttpRequest) {
$('.state').html(responseData);
}
});
});*/

$(document).on("change", "#state", function(e) {
  var state=$(this).val();
  jQuery.ajax({
  type:'POST',
  url:'return_func.php',
  data:'state='+state+'&part=Get_City_List_State',
  dataType:'html',
  beforeSend: function(){
  $('#city').html('<option>Loading...</option>');
  },
  success : function (responseData, status, XMLHttpRequest) {
  $('#city').html(responseData);
  var cityId=$('#cityId').val();
  $('#city').val(cityId).change();
  }
  });
});

$(document).on("change", "#gsttno", function(e) {
  var GSTNo=$(this).val();
  jQuery.ajax({
  type:'POST',
  url:'return.php',
  data:'gstin='+GSTNo+'&checktype=Buyer&part=Check_Supplier_GST_Details',
  dataType:'html',
  beforeSend: function(){
  },
  success : function (responseData, status, XMLHttpRequest) {
    //console.log(responseData);
    //24|Active|395003|HI TECH CREST SHOP NO G-1 GROUND FLOOR FALSAVADI, NEAR GOLDEN POINT BEGUMPURA, SURAT||ABHIVADAN FASHION|||1||REGULAR|ABHIVADAN FASHION
    var Dats=responseData.split('|');
    if(Dats[12]==0) {
      $('#address').val(Dats[3]);
      // $('#state').val(Dats[0]).change();
      $('#state').val(parseInt(Dats[0])).change();
      $('#Pincode').val(Dats[2]);
      $('#cityId').val(Dats[9]);
      $('#company').val(Dats[11]);
      $('#Name').val(Dats[5]);
      if(Dats[8]==true){
      $('#GST_Status').html('<span class="text-success">Verified</span>');
      } else {
      $('#GST_Status').html('<span class="text-danger">Not Found</span>');
      } 
    }
    else {
      $('#GST_Status').html('<span class="text-danger">Already Exist GST No</span>');
    }
  }
  });  
});

$(document).on("change", "#Buyer_Tpe", function(e) {
  var gsttype=$(this).val();
  //alert(gsttype);
  if(gsttype=="Registered"){
    $(".gstno").show();
    $(".pan_no").hide();
    
  }else{
     $(".gstno").hide();
     $(".pan_no").show();      
  }
});
$(document).ready(function() {
  $("#caddress").click(function() {
    var inputValue = $("#address").val(); 
    $("#billty_address").text(inputValue);    
    $("#address").select();                 
    document.execCommand("copy");            
  });
});
// $(document).on("input", ".numval", function() {
//     this.value = this.value.replace(/\D/g,'');
// });
// $(document).on("input", ".numvals", function() {
//     this.value = this.value.replace(/\D/g,'');
// });

$('.datepickers').datetimepicker({
  weekStart: 1,
  todayBtn:  1,
  autoclose: 1,
  todayHighlight: 1,
  startView: 2,
  minView: 2,
  forceParse: 0,
  format: "dd/mm/yyyy"
});

$(document).on("click", ".datepickerss", function(e) {
$(this).datetimepicker({
   weekStart: 1,
   todayBtn:  1,
   autoclose: 1,
   todayHighlight: 1,
   startView: 2,
   minView: 2,
   forceParse: 0,
   format: "dd/mm/yyyy"
   }).focus();  
});
</script>
