 
<div class="col-sm-12">
<form method="post" action="" enctype="multipart/form-data" autocomplete="off">
      <div class="row form-row px-3">
      <div class="  col-md-12">
      
      <div class="form-group row">
      <div class="col-sm-12 pl-0">  
      <fieldset style="min-height:50px;">
      <legend><b> Basic Details </b> </legend>
      </fieldset>
      </div>

       
      
      <label for="inputPassword" class="col-sm-2 col-form-label pl-0">Member Type:</label>                  
      <div class="col-sm-4">
      <select class="form-control member_type" name="member_type" id="member_type" required>
      <option value="">Select One</option> 
      <?php
      foreach ($membership_level as $mkey => $mvalue) {
        ?>
        <option value="<?php echo $mvalue['id'];?>"><?php echo $mvalue['level_name'];?></option>
        <?php
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
      <input type="text" class="form-control" name="PMobile" onkeypress="return /[0-9]/i.test(event.key)" placeholder="Mobile No." maxlength="10" pattern="[0-9 ]+" value="<?php echo $_POST['PMobile'];?>">
      </div>

      <label for="inputPassword" class="col-sm-2 col-form-label pl-0">Alternate Mobile No. </label>
      <div class="col-sm-4">
      <input type="text" class="form-control" name="AMobile" onkeypress="return /[0-9]/i.test(event.key)" placeholder="Mobile No." maxlength="10" pattern="[0-9 ]+" value="<?php echo $_POST['AMobile'];?>">
      </div>      
      </div>

      <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label pl-0">E-mail-id <span class="text-danger">*</span></label>
      <div class="col-sm-4">
      <input type="text" class="form-control" name="Email" placeholder="E-mail-id" id="Email" value="<?php echo $_POST['Email'];?>">
      </div>

      <label for="inputPassword" class="col-sm-2 col-form-label pl-0">Password <span class="text-danger">*</span></label>
      <div class="col-sm-3">
      <input type="text" class="form-control" name="password" placeholder="Password" required="" id="password" value="<?php echo $_POST['password'];?>">
      </div> 
      </div>
  
    
      <div class="form-group row">      
      <label for="inputPassword" class="col-sm-2 col-form-label pl-0">State <span class="text-danger">*</span></label>
      <div class="col-sm-4">
      <select class="form-control select2" id="state" name="State" required="">
      <option value="">Select State</option>
      <?php
      foreach ($state_details as $skey => $svalue) {
        ?>
        <option value="<?php echo $mvalue['id'];?>"><?php echo $svalue['state_name'];?></option>
        <?php
      }
      ?>  
      </div> 

      <label for="inputPassword" class="col-sm-2 col-form-label pl-0">City<span class="text-danger">*</span></label>
      <div class="col-sm-4 d-flex align-items-center"> 
      <select class="custom-select  select2" name="City" id="city">
      <option value="">Select City</option>
      </select>
      <!-- <a class="ml-1" data-toggle="modal" href="#AddNewCity"><i class="fa fa-plus-circle text-success" aria-hidden="true"></i></a>   -->
      </div>
      </div>

      <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label pl-0">Address <span class="text-danger">*</span></label>
      <div class="col-sm-10">
      <textarea type="text" class="form-control address" name="Address" placeholder="Address" id="Address" ><?php echo $_POST['Address'];?></textarea>
      </div> 
      </div>

      <div class="form-group row">              
      <label for="inputPassword" class="col-sm-2 col-form-label pl-0">Landmark</label>
      <div class="col-sm-4">
      <input type="text" class="form-control landmark" name="landmark" placeholder="Landmark" id="landmark" onkeypress="return /[0-9]/i.test(event.key)" value="<?php echo $_POST['landmark'];?>">
      </div>

      <label for="inputPassword" class="col-sm-2 col-form-label pl-0">Pincode <span class="text-danger">*</span></label>
      <div class="col-sm-4">
      <input type="text" class="form-control pincode" name="pincode" placeholder="Pincode" id="Pincode" onkeypress="return /[0-9]/i.test(event.key)" maxlength="6" value="<?php echo $_POST['pincode'];?>">
      </div>     
      </div>

      <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label pl-0">Voter ID<span class="text-danger">*</span></label>
      <div class="col-sm-4">
      <input type="text" class="form-control Voter_id" name="Voter_id" placeholder="Voter ID" id="Voter_id" value="<?php echo $_POST['Voter_id'];?>">  
      </div>      

      <label for="inputPassword" class="col-sm-3 col-form-label pl-0">Upload Voter Card</label>
      <div class="col-sm-3 text-left">
      <input type="file" class="form-control" name="VoterUpload">
      </div> 
      </div>

      <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label pl-0">PAN No.<span class="text-danger">*</span></label>
      <div class="col-sm-4">
      <input type="text" class="form-control pan_no" name="Pan_no" placeholder="Pan No" id="panno"  value="<?php echo $_POST['Pan_no'];?>">  
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

      <label for="inputPassword" class="col-sm-2 col-form-label pl-0">Account No. <span class="text-danger">*</span></label>
      <div class="col-sm-4">
      <input type="text" class="form-control" name="account_no" placeholder="Account No." value="<?php echo $_POST['account_no'];?>">
      </div>
      <label for="inputPassword" class="col-sm-2 col-form-label pl-0">IFSC Code <span class="text-danger">*</span></label>
      <div class="col-sm-4">
      <input type="text" class="form-control" name="ifsc_code" placeholder="IFSC Code" value="<?php echo $_POST['ifsc_code'];?>">
      </div>
      </div>
      <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label pl-0">Branch Name <span class="text-danger">*</span></label>
      <div class="col-sm-4">
      <input type="text" class="form-control" name="branch_name" placeholder="Branch Name" value="<?php echo $_POST['branch_name'];?>">
      </div>
      <label for="inputPassword" class="col-sm-2 col-form-label pl-0">Bank Name <span class="text-danger">*</span></label>
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
         