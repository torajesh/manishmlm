<?php
include ("config.php");
date_default_timezone_set('Asia/Kolkata');
//$SelYears=Get_Fetch_Fields($con,"id","1","Year","Years");
$currnetyear=financialyears(date('m'));
$financialyear=calculateFiscalYearForDate(date('m'));
$explode=explode(":",$financialyear);
$ex=$explode[0];
$ex1=$explode[1];
$UserRow=Get_Fetch_Data($con,$_SESSION['MANMID'],'All','admin_login');
if ($_POST['part'] == 'Delete_Table_Data'){
  ?>
  <div class="modal-header bg-danger">
  <h5 class="modal-title">Are You Sure for Delete This Record</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
  </div>
  <div class="modal-body">
  <form method="post" action="">
  <input type="hidden" name="id" value="<?php echo $_POST['id']; ?>">
  <input type="hidden" name="random_move" value="<?php echo $_SESSION['random_move']; ?>">
  <div class="row form-row">
  <div class="col-6">
  <button class="btn btn-danger" name="remove_lead">Delete</button>
  </div>
  <div class="col-6">
  <button class="btn btn-info" data-dismiss="modal" aria-label="Close" style="float: right;">Cancel</button>
  </div>
  </div>
  </form>
  </div>
  <?php 
} 
 if ($_REQUEST['part'] == 'All_State_Data') {

      $requestData = $_REQUEST;

      $sqls = "SELECT * FROM state_details where id!='' $where";

      $sql = "SELECT * FROM state_details where id!='' $where";

      $querys = mysqli_query($con,$sqls);

      $totalData = mysqli_num_rows($querys);

      $totalFiltered = $totalData;

      if (!empty($requestData['search']['value']))

      { // if there is a search parameter, $requestData['search']['value'] contains search parameter

          $sql .= " AND ( state_name LIKE '%" . $requestData['search']['value'] . "%' ";

          $sql .= " OR status LIKE '%" . $requestData['search']['value'] . "%' )";

      }

      $sql .= "  ORDER BY state_name asc  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";

      //echo $sqls;

      $query = mysqli_query($con,$sql);

      //$totalFiltered = mysql_num_rows($query);

      $data = array();

      $i = 1;

      while ($row = mysqli_fetch_array($query)){ // preparing an array

        if($row[status]=='Y') {
          $status = "Active";
        }
        else {
          $status = "In-Active";
        }

          $action = "<input type='hidden' class='id' value=" . $row['id'] . ">

        <span style='white-space:nowrap;float: right;'>

        <a class='btn btn-sm bg-success-light mr-2 updateLinks' href='javascript:void'><i class='fe fe-pencil'></i></a>&nbsp;

        <a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></a></span>";

          if ($row[status] == 'Y')

          {
            $status = "Active";
              $class = 'bg-success';

          }

          else

          {
            $status = "In-Active";
              $class = 'bg-danger';

          }

          $nestedData = array();

          $nestedData[] = "<div class='first'>$i</div>";

          $nestedData[] = "<div class='first'>$row[state_name]</div>";

          $nestedData[] = "<div class='third $class'>$status</div>";

          $nestedData[] = "<div class='fourth'><i class='fe fe-clock text-warning mr-1'></i> $row[add_time]";

          $nestedData[] = "$action";

          $data[] = $nestedData;

          $i++;

      }

      $json_data = array(

          "draw" => intval($requestData['draw']) ,

          "recordsTotal" => intval($totalData) ,

          "recordsFiltered" => intval($totalFiltered) ,

          "data" => $data

      );

      echo json_encode($json_data);

  }

if ($_POST['part'] == 'State_data_Update'){

    $row = Get_Fetch_Data($con,$_POST['id'], 'All', 'state_details');

    ?>
    <div class="modal-header ">
    <h5 class="modal-title">Update State Detail</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
    </div>
    <div class="modal-body">
    <form action="" method="post" enctype="multipart/form-data">
    <div class="row form-row">
    <div class="col-6">
    <div class="form-group">
    <label> State Name<span class="text-danger">*</span></label>
    <input type="text" class="form-control" value="<?php echo $row['state_name']; ?>" name="state_name" required>
    </div>
    </div>
    <div class="col-6">
    <div class="form-group">
    <label>Status<span class="text-danger">*</span></label>
    <select class="form-control" name="status">
    <?php

    $arr = array(

    'Active',

    'Inactive'

    );

    foreach ($arr as $status)

    {

    if ($status == $row['status'])

    {

    echo "<option value=" . $status . " selected>$status</option>";

    }

    else

    {

    echo "<option value=" . $status . ">$status</option>";

    }

    }

    ?>
    </select>
    </div>
    </div>
    </div>
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    <input type="hidden" name="random_move" value="<?php echo $_SESSION['random_move']; ?>">
    <button class="btn btn-success" name="UpdateState">Update</button>
    </form>
    </div>
    <?php
  }

if ($_REQUEST['part'] == 'All_City_Data'){

    $requestData = $_REQUEST;

    if ($_REQUEST['state'] != '')

    {

        $where = " and state='" . $_REQUEST['state'] . "'";

    }

    if ($_REQUEST['status'] != '')

    {

        $where = " and status='" . $_REQUEST['status'] . "'";

    }

    $sqls = "SELECT * FROM city_details where id!='' $where";

    $sql = "SELECT * FROM city_details where id!='' $where";

    $querys = mysqli_query($con,$sqls);

    $totalData = mysqli_num_rows($querys);

    $totalFiltered = $totalData;

    if (!empty($requestData['search']['value']))

    { // if there is a search parameter, $requestData['search']['value'] contains search parameter

        $sql .= " AND ( city_name LIKE '%" . $requestData['search']['value'] . "%' ";

        $sql .= " OR status LIKE '%" . $requestData['search']['value'] . "%' )";

    }

    $sql .= "  ORDER BY city_name asc  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";

    //echo $sqls;

    $query = mysqli_query($con,$sql);

    //$totalFiltered = mysql_num_rows($query);

    $data = array();

    $i = 1;

    while ($row = mysqli_fetch_array($query))

    { // preparing an array

        $action = "<input type='hidden' class='id' value=" . $row['id'] . ">

    <span style='white-space:nowrap;float: right;'>

    <a class='btn btn-sm bg-success-light mr-2 updateLinks' href='javascript:void'><i class='fe fe-pencil'></i></a>&nbsp;

    <a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></a></span>";

         if ($row[status] == 'Y')

        {
          $status = "Active";
            $class = 'bg-success';

        }

        else

        {
          $status = "In-Active";
            $class = 'bg-danger';

        }

        $state = Get_Fetch_Data($con,$row['state'], 'All', 'state_details');

        $nestedData = array();

        $nestedData[] = "<div class='first'>$i</div>";

        $nestedData[] = "<div class='first'>$row[city_name]</div>";

        $nestedData[] = "<div class='first'>$state[state_name]</div>";

        $nestedData[] = "<div class='third'>$status</div>";

        $nestedData[] = "<div class='fourth'><i class='fe fe-clock text-warning mr-1'></i> $row[add_time]";

        $nestedData[] = "$action";

        $data[] = $nestedData;

        $i++;

    }

    $json_data = array(

        "draw" => intval($requestData['draw']) ,

        "recordsTotal" => intval($totalData) ,

        "recordsFiltered" => intval($totalFiltered) ,

        "data" => $data

    );

    echo json_encode($json_data);

}

if ($_POST['part'] == 'City_data_Update') {

  $row = Get_Fetch_Data($con,$_POST['id'], 'All', 'city_details');

  ?>
  <div class="modal-header ">
  <h5 class="modal-title">Update City Detail</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
  </div>
  <div class="modal-body">
  <form action="" method="post" enctype="multipart/form-data">
  <div class="row form-row">
  <div class="col-6">
  <div class="form-group">
  <label>State</label>
  <select class="form-control" name="state" required>
  <option value="">Select State</option>
  <?php

  $Bsqls = mysqli_query($con,"select * from state_details where status='Active'");

  while ($Brows = mysqli_fetch_array($Bsqls))

  {

  if ($Brows['id'] == $row['state'])

  {

  echo "<option value='" . $Brows['id'] . "' selected>$Brows[state_name]</option>";

  }

  else

  {

  echo "<option value='" . $Brows['id'] . "'>$Brows[state_name]</option>";

  }

  }

  ?>
  </select>
  </div>
  </div>
  <div class="col-6">
  <div class="form-group">
  <label> City Name<span class="text-danger">*</span></label>
  <input type="text" class="form-control" value="<?php echo $row['city_name']; ?>" name="city_name" required>
  </div>
  </div>
  <div class="col-6">
  <div class="form-group">
  <label>Status<span class="text-danger">*</span></label>
  <select class="form-control" name="status">
  <?php

  $arr = array(

  'Active',

  'Inactive'

  );

  foreach ($arr as $status)

  {

  if ($status == $row['status'])

  {

  echo "<option value=" . $status . " selected>$status</option>";

  }

  else

  {

  echo "<option value=" . $status . ">$status</option>";

  }

  }

  ?>
  </select>
  </div>
  </div>
  </div>
  <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
  <input type="hidden" name="random_move" value="<?php echo $_SESSION['random_move']; ?>">
  <button class="btn btn-success" name="UpdateCity">Update</button>
  </form>
  </div>
  <?php

}

if ($_REQUEST['part'] == 'All_HSN_Data'){

      $requestData = $_REQUEST; 
      if ($_REQUEST['status'] != ''){
          $where .= " and status='" . $_REQUEST['status'] . "'";
      }
      $sqls = "SELECT * FROM HsnList where id!='' $where";
      $sql = "SELECT * FROM HsnList where id!='' $where";
      $querys = mysqli_query($con,$sqls);
      $totalData = mysqli_num_rows($querys);
      $totalFiltered = $totalData;
      if (!empty($requestData['search']['value']))
      { // if there is a search parameter, $requestData['search']['value'] contains search parameter

          $sql .= " AND ( hsncode LIKE '%" . $requestData['search']['value'] . "%' ";

          $sql .= " OR status LIKE '%" . $requestData['search']['value'] . "%' )";

      }

      $sql .= "  ORDER BY id desc  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";

      //echo $sqls;

      $query = mysqli_query($con,$sql);

      //$totalFiltered = mysql_num_rows($query);

      $data = array();

      $i = 1;

      while ($row = mysqli_fetch_array($query))

      { // preparing an array

          
          $action = "<input type='hidden' class='id' value=" . $row['id'] . "> <span style='white-space:nowrap;float: right;'> <a class='btn btn-sm bg-success-light mr-2 updateLinks' href='javascript:void'><i class='fe fe-pencil'></i></a>&nbsp; <a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></a></span>";

          if ($row[status] == 'Active')

          {

              $class = 'bg-success';

          } else {

              $class = 'bg-danger';

          }

          if ($row['images'] != '')

          {

              $photo = "<a href='Product/" . $row['images'] . "' data-lightbox='photos'><img src='Product/" . $row['images'] . "' style='height: 70px; width: 70px;

              border-color: aliceblue !important; padding: 1px; border: 1px solid;  border-radius: 50%; box-shadow: 0px 0px 5px #ccc;'></a>";        

          } else {

              $photo = "<img src='Banner/no-icons.png'  style='height: 70px; width: 70px; border-color: aliceblue !important; padding: 1px; border: 1px solid;

              border-radius: 50%; box-shadow: 0px 0px 5px #ccc;'>";

          }

          $nestedData = array();
          $nestedData[] = "<div class='first'>$row[hsncode]</div>";
          $nestedData[] = "<div class='third'><span class='badge badge-pill $class inv-badge'>$row[status]</div>";
          $nestedData[] = "<div class='fourth'><i class='fe fe-clock text-warning mr-1'></i> $row[add_time]";

          $nestedData[] = "$action";

          $data[] = $nestedData;

          $i++;

      }

      $json_data = array(

          "draw" => intval($requestData['draw']) ,

          "recordsTotal" => intval($totalData) ,

          "recordsFiltered" => intval($totalFiltered) ,

          "data" => $data

      );

      echo json_encode($json_data);
}

if ($_POST['part'] == 'hsncode_data_Update') {

    $row = Get_Fetch_Data($con,$_POST['id'], 'All', 'HsnList'); ?>
    <div class="modal-header ">
    <h5 class="modal-title">Update HSN Detail</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
    </div>
    <div class="modal-body">
    <form action="" method="post" enctype="multipart/form-data">
    <div class="row form-row">
    <div class="col-6 col-sm-6">
    <div class="form-group">
    <label> HSN/SAC Code<span class="text-danger">*</span></label>
    <input type="number" class="form-control" value="<?php echo $row['hsncode']; ?>" name="hsncode"  required>
    </div>
    </div>
    <div class="col-6">
    <div class="form-group">
    <label>Status<span class="text-danger">*</span></label>
    <select class="form-control" name="status">
    <?php $arr = array('Active','Inactive');

    foreach ($arr as $status)

    {

    if ($status == $row['status'])

    {

    echo "<option value=" . $status . " selected>$status</option>";

    }

    else

    {

    echo "<option value=" . $status . ">$status</option>";

    }

    }

    ?>
    </select>
    </div>
    </div>


    </div>
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    <input type="hidden" name="random_move" value="<?php echo $_SESSION['random_move']; ?>">
    <button class="btn btn-success" name="UpdateSubCategory">Update</button>
    </form>
    </div>
    <?php
} 

if ($_REQUEST['part'] == 'All_membership_level_Data') {

  $requestData = $_REQUEST;
  $sqls = "SELECT * FROM membership_level where id!='' $where";
  $sql = "SELECT * FROM membership_level where id!='' $where";
  $querys = mysqli_query($con,$sqls);
  $totalData = mysqli_num_rows($querys);
  $totalFiltered = $totalData;
  if (!empty($requestData['search']['value']))
  { // if there is a search parameter, $requestData['search']['value'] contains search parameter
  $sql .= " AND ( level_name LIKE '%" . $requestData['search']['value'] . "%' ";
  $sql .= " OR status LIKE '%" . $requestData['search']['value'] . "%' )";
  }
  $sql .= " ORDER BY level_name asc LIMIT " . $requestData['start'] . " ," . $requestData['length'] . " ";
  //echo $sqls;
  $query = mysqli_query($con,$sql);
  //$totalFiltered = mysql_num_rows($query);
  $data = array();
  $i = 1;
  while ($row = mysqli_fetch_array($query))
  { // preparing an array
  $action = "<input type='hidden' class='id' value=" . $row['id'] . ">
  <span style='white-space:nowrap;float: right;'>
  <a class='btn btn-sm bg-success-light mr-2 updateLinks' href='javascript:void'><i class='fe fe-pencil'></i></a> 
  <a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></a></span>";
  if ($row[status] == 'Active')
  {
  $class = 'bg-success';
  }
  else
  {
  $class = 'bg-danger';
  }
  $nestedData = array();
  $nestedData[] = "<div class='first'>$i</div>";
  $nestedData[] = "<div class='first'>$row[level_name]</div>";
  $nestedData[] = "<div class='third'><span class='badge badge-pill $class inv-badge'>$row[status]</span>";
  $nestedData[] = "<div class='fourth'><i class='fe fe-clock text-warning mr-1'></i> $row[add_time]";
  $nestedData[] = "$action";
  $data[] = $nestedData;
  $i++;
  }
  $json_data = array(
  "draw" => intval($requestData['draw']) ,
  "recordsTotal" => intval($totalData) ,
  "recordsFiltered" => intval($totalFiltered) ,
  "data" => $data
  );
  echo json_encode($json_data);
}

if ($_POST['part'] == 'membership_level_data_Update'){

  $row = Get_Fetch_Data($con,$_POST['id'], 'All', 'membership_level');

  ?>
  <div class="modal-header ">
  <h5 class="modal-title">Update Area Detail</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
  </div>
  <div class="modal-body">
  <form action="" method="post" enctype="multipart/form-data">
  <div class="row form-row">
  <div class="col-6">
  <div class="form-group">
  <label> Level Name<span class="text-danger">*</span></label>
  <input type="text" class="form-control" value="<?php echo $row['level_name']; ?>" name="level_name" required>
  </div>
  </div>
  <div class="col-6">
  <div class="form-group">
  <label>Status<span class="text-danger">*</span></label>
  <select class="form-control" name="status">
  <?php
  $arr = array('Active','Inactive');
  foreach ($arr as $status) {
    if ($status == $row['status']) {
    echo "<option value=" . $status . " selected>$status</option>";
    }
    else
    {
    echo "<option value=" . $status . ">$status</option>";
    }
  }
  ?>
  </select>
  </div>
  </div>
  </div>
  <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
  <input type="hidden" name="random_move" value="<?php echo $_SESSION['random_move']; ?>">
  <button class="btn btn-success" name="UpdateArea">Update</button>
  </form>
  </div>
  <?php
}

if ($_REQUEST['part'] == 'All_Members_List') {
    $requestData = $_REQUEST;

    if ($_REQUEST['state'] != '') {
        $where = " and State='".$_REQUEST['state']."'";
    }
    if ($_REQUEST['city'] != '') {
        $where = " and City='".$_REQUEST['city']."'";
    }
    if ($_REQUEST['status'] != '') {
        $where = " and status='".$_REQUEST['status']."'";
    }
    if ($_REQUEST['fee_paid'] != '') {
        $where = " and fee_paid='".$_REQUEST['fee_paid']."'";
    }
    $sqls = "SELECT * FROM members_details where id!='' $where";
    $sql = "SELECT * FROM members_details where id!='' $where";

    $querys = mysqli_query($con,$sqls);
    $totalData = mysqli_num_rows($querys);
    $totalFiltered = $totalData;
    if (!empty($requestData['search']['value'])) { 
        $sql .= " AND (Name LIKE '%".$requestData['search']['value']."%'";
        $sql .= " AND (AMobile LIKE '%".$requestData['search']['value']."%'";
        $sql .= " OR PMobile LIKE '%".$requestData['search']['value']."%' )";
    }
    $sql .= " ORDER BY Name ASC LIMIT ".$requestData['start']." ,".$requestData['length']." ";
    //echo $sqls;
    $query = mysqli_query($con,$sql);
    //$totalFiltered = mysql_num_rows($query);
    $data = array();

    $i = 1;
    while ($row = mysqli_fetch_array($query)) { // preparing an array
      $action = "<input type='hidden' class='id' value=".$row['id'].">
      <span style='white-space:nowrap;float: right;'>
      <a class='btn btn-sm bg-success-light mr-2' href='addedit_customer.php?slno=$row[id]'><i class='fe fe-pencil'></i></a>&nbsp;
      <a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></a></span>";

      if ($row[Status] == 'Active') {$status = "Active"; $class = 'bg-success';}
      else {$status = "In-Active";  $class = 'bg-danger';}
      if ($row[fee_paid] == 'Paid') {
        $PaidS = '<i class="fa fa-circle text-success" aria-hidden="true"></i>';       
      }
      else {
        $PaidS = '<i class="fa fa-circle text-danger" aria-hidden="true"></i>';        
      }
      $state = Get_Fetch_Data($con,$row['State'], 'All', 'state_details');
      $city = Get_Fetch_Data($con,$row['City'], 'All', 'city_details');

      $seniorArr = Get_Fetch_Data($con,$row['senior_id'], 'All', 'members_details');

      $nestedData = array();
      $nestedData[] = "<div>$i</div>";
      $nestedData[] = "<div style='white-space:nowrap;'>$PaidS&nbsp;&nbsp;$status</div>";
      $nestedData[] = "<div class='first'><a href='javascript:void' class='ViewDataLinks'>$row[MemberCode]</a></div>";
      $nestedData[] = "<div style='white-space:nowrap;'>$row[Name]</div>";
      $nestedData[] = "<div>$row[member_type]</div>";
      $nestedData[] = "<div style='white-space:nowrap;'>Email: $row[Email]<br>MOB1: $row[PMobile]<br>MOB2: $row[AMobile]</div>";
      $nestedData[] = "<div style='white-space:nowrap;'>AD: <a href='view_aadhar.php?vid=viewAadhar&slno=$row[id]' target='_blank'>$row[Aadhar_no]</a><br>VD: <a href='UploadDocument/$row[id]/$row[Voter_id_img]' target='_blank'>$row[Voter_id]</a><br>PAN: <a href='UploadDocument/$row[id]/$row[Pan_img]' target='_blank'>$row[Pan_no]</a></div>";
      $nestedData[] = "<div style='white-space:nowrap;'>$seniorArr[Name]</div>";
      $nestedData[] = "<div style='white-space:nowrap;'>$row[Address], $city[city_name], $state[state_name]</div>";      
      $nestedData[] = "<div style='white-space:nowrap;'><i class='fe fe-clock text-warning mr-1'></i> $row[Add_time]<br><i class='fe fe-clock text-warning mr-1'></i> $row[register_date]";
      $nestedData[] = "$action";
      $data[] = $nestedData;
      $i++;
    }

    $json_data = array(
        "draw" => intval($requestData['draw']),
        "recordsTotal" => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data" => $data
    );
    echo json_encode($json_data);
}

if ($_POST['part'] == 'Member_Data_View') {

  $row = Get_Fetch_Data($con,$_POST['id'], 'All', 'members_details');
  $memLevel = Get_Fetch_Data($con,$row['member_type'], 'All', 'membership_level');

  $seniorArr = Get_Fetch_Data($con,$row['senior_id'], 'All', 'members_details');
  $srmemLevel = Get_Fetch_Data($con,$seniorArr['member_type'], 'All', 'membership_level');

  $state = Get_Fetch_Data($con,$row['State'], 'All', 'state_details');
  $city = Get_Fetch_Data($con,$row['City'], 'All', 'city_details');

  if ($row['photo'] != '') {
  $photo = "UploadDocument/$row[id]/$row[mem_photo]";
  }
  else {
  $photo = "Banner/noimages.jpg";
  }
  ?>
  <div class="modal-header">
  <h5 class="modal-title">Member Details</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
  </div>

  <div class="modal-body">
  <h5 style="color:#000000"><i class="fa fa-file-text" aria-hidden="true"></i> Basic Details</h5>

  <!-- <div style="width:100px;height:100px;position:absolute; right:10px;top:20px;"><img src="<?php echo $photo; ?>" style="width: 100px;    height: 100px;    border-radius: 50%;    box-shadow: 0px 3px 5px #ccc;    border: 2px solid #ccc;"></div> -->

  <div class="row form-row step_1">
    <div class="col-4">
      <div class="form-group">
        <label class="text-dark">Member Code</label>
        <p class="c-detail"><?php echo $row['MemberCode']; ?></p>
      </div>
    </div>

    <div class="col-4">
      <div class="form-group">
        <label class="text-dark">Member Type</label>
        <p class="c-detail"><?php echo $memLevel['level_name']; ?></p>
      </div>
    </div>


    <div class="col-4">
      <div class="form-group">
        <label class="text-dark">Name</label>
        <p class="c-detail"><?php echo $row['Name']; ?></p>
      </div>
    </div>

    <div class="col-4">
      <div class="form-group">
        <label class="text-dark">Mobile Phone</label>
        <p class="c-detail"><?php echo $row['PMobile']; ?></p>
      </div>
    </div>

    <div class="col-4">
      <div class="form-group">
        <label class="text-dark">Alternate Mobile No</label>
        <p class="c-detail"><?php echo $row['AMobile']; ?></p>
      </div>
    </div>
    
    <div class="col-6">
      <div class="form-group">
        <label class="text-dark">E-mail-id</label>
        <p class="c-detail"><?php echo $row['Email']; ?></p>
      </div>
    </div>

    <div class="col-6">
      <div class="form-group">
        <label class="text-dark">Password </label>
        <p class="c-detail"><?php echo $row['password']; ?></p>
      </div>
    </div>

    <div class="col-12">
      <div class="form-group">
        <label class="text-dark">Address </label>
        <p class="c-detail"><?php echo $row['Address']; ?></p>
      </div>
    </div>

    <div class="col-4">
      <div class="form-group">
        <label class="text-dark">State </label>
        <p class="c-detail"><?php echo $state['state_name']; ?></p>
      </div>
    </div>

    <div class="col-4">
      <div class="form-group">
        <label class="text-dark">City </label>
        <p class="c-detail"><?php echo $city['city_name']; ?></p>
      </div>
    </div>

    <div class="col-4">
      <div class="form-group">
        <label class="text-dark">Landmark </label>
        <p class="c-detail"><?php echo $row['landmark']; ?></p>
      </div>
    </div>

    <div class="col-4">
      <div class="form-group">
        <label class="text-dark">Pin Code</label>
        <p class="c-detail">
          <?php echo $row['pincode']; ?>
        </p>
      </div>
    </div>

    <div class="col-4">
      <div class="form-group">
        <label class="text-dark">Aadhar No</label>
        <p class="c-detail">
          <?php echo $row['Aadhar_no']; ?>
        </p>
      </div>
    </div>

    <div class="col-4">
      <div class="form-group">
        <label class="text-dark">PAN No</label>
        <p class="c-detail">
          <?php echo $row['Pan_no']; ?>
        </p>
      </div>
    </div>

    <div class="col-4">
      <div class="form-group">
        <label class="text-dark">Voter ID</label>
        <p class="c-detail">
          <?php echo $row['Voter_id']; ?>
        </p>
      </div>
    </div>
  </div>

  <h5 style="color:#000000"><i class="fa fa-file-text" aria-hidden="true"></i> Bank Account Details</h5>

  <div class="row form-row step_1">
    <div class="col-4">
      <div class="form-group">
        <label class="text-dark">Account No</label>
        <p class="c-detail"> <?php echo $row['account_no']; ?> </p>
      </div>
    </div>

    <div class="col-4">
      <div class="form-group">
        <label class="text-dark">IFSC Code</label>
        <p class="c-detail"> <?php echo $row['ifsc_code']; ?> </p>
      </div>
    </div>

    <div class="col-4">
      <div class="form-group">
        <label class="text-dark">Branch Name</label>
        <p class="c-detail"> <?php echo $row['branch_name']; ?> </p>
      </div>
    </div>

    <div class="col-4">
      <div class="form-group">
        <label class="text-dark">Bank Name </label>
        <p class="c-detail"> <?php echo $row['bank_name']; ?> </p>
      </div>
    </div>
  </div>

  <h5 style="color:#000000"><i class="fa fa-file-text" aria-hidden="true"></i> Pay Details</h5>
  <div class="row form-row step_1">
    <div class="col-6">
      <div class="form-group">
        <label class="text-dark">Payment Pay (in Days)</label>
        <p class="c-detail"><?php echo $row['credit_days']; ?></p>
      </div>
    </div>

    <div class="col-6">
      <div class="form-group">
        <label class="text-dark">Payment Mode </label>
        <p class="c-detail"><?php echo $row['payment_mode']; ?></p>
      </div>
    </div>   
  </div>

   <h5 style="color:#000000"><i class="fa fa-file-text" aria-hidden="true"></i> Senior Details</h5>
  <div class="row form-row step_1">
    <div class="col-4">
      <div class="form-group">
        <label class="text-dark">Senior Name</label>
        <p class="c-detail"><?php echo $seniorArr['Name']; ?></p>
      </div>
    </div>
    <div class="col-4">
      <div class="form-group">
        <label class="text-dark">Member Code</label>
        <p class="c-detail"><?php echo $seniorArr['MemberCode']; ?></p>
      </div>
    </div>   

    <div class="col-4">
      <div class="form-group">
        <label class="text-dark">Member Type</label>
        <p class="c-detail"><?php echo $srmemLevel['level_name']; ?></p>
      </div>
    </div>  
  </div>

  <h5 style="color:#000000"><i class="fa fa-file-text" aria-hidden="true"></i> Admin Details</h5>
  <div class="row form-row step_1">
    <div class="col-4">
      <div class="form-group">
        <label class="text-dark">Pay Registration Fee</label>
        <p class="c-detail"><?php echo $row['fee_paid']; ?></p>
      </div>
    </div>

    <div class="col-4">
      <div class="form-group">
        <label class="text-dark">Registration Date</label>
        <p class="c-detail"><?php echo $row['register_date']; ?></p>
      </div>
    </div>

    <div class="col-4">
      <div class="form-group">
        <label class="text-dark">Status</label>
        <p class="c-detail"><?php echo $row['Status']; ?></p>
      </div>
    </div>
  </div>

  </div>
  <?php
}

if ($_REQUEST['part'] == 'All_Category_List') {
    $requestData = $_REQUEST;
    $sqls = "SELECT * FROM category_details where id!='' $where";
    $sql = "SELECT * FROM category_details where id!='' $where";

    $querys = mysqli_query($con,$sqls);
    $totalData = mysqli_num_rows($querys);
    $totalFiltered = $totalData;
    if (!empty($requestData['search']['value'])) { 
        $sql .= " AND (catg_name LIKE '%".$requestData['search']['value']."%' )";        
        //$sql .= " OR PMobile LIKE '%".$requestData['search']['value']."%' )";
    }
    $sql .= " ORDER BY catg_name ASC LIMIT ".$requestData['start']." ,".$requestData['length']." ";
    //echo $sql;
    $query = mysqli_query($con,$sql);
    //$totalFiltered = mysql_num_rows($query);
    $data = array();

    $i = 1;
    while ($row = mysqli_fetch_array($query)) { // preparing an array

      $sql = " $where";

    $totalData = mysqli_num_rows(mysqli_query($con,"SELECT id FROM product_details where status='Active' and catg_slno='".$row['id']."' "));    

      $action = "<input type='hidden' class='id' value=".$row['id'].">
      <span style='white-space:nowrap;float: right;'>
      <a class='btn btn-sm bg-success-light mr-2 updateLinks' href='javascript:void'><i class='fe fe-pencil'></i></a>&nbsp;
      <a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></a></span>";

      if ($row[Status] == 'Active') {$status = "Active"; $class = 'bg-success';}
      else {$status = "In-Active";  $class = 'bg-danger';}

      $nestedData = array();
      $nestedData[] = "<div>$i</div>";     
      $nestedData[] = "<div style='white-space:nowrap;'>$row[catg_name]</div>";
      $nestedData[] = "<div>$totalData</div>";
      $nestedData[] = "<div style='white-space:nowrap;'>$row[status]</div>";           
      $nestedData[] = "<div style='white-space:nowrap;'><i class='fe fe-clock text-warning mr-1'></i> $row[add_time]</div>";
      $nestedData[] = "$action";
      $data[] = $nestedData;
      $i++;
    }

    $json_data = array(
        "draw" => intval($requestData['draw']),
        "recordsTotal" => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data" => $data
    );
    echo json_encode($json_data);
}

if ($_POST['part'] == 'Category_data_Update') {
  $row = Get_Fetch_Data($con,$_POST['id'], 'All', 'category_details');

  ?>
  <div class="modal-header ">
  <h5 class="modal-title">Update Category Detail</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
  </div>
  <div class="modal-body">
  <form action="" method="post" enctype="multipart/form-data">
  <div class="row form-row">
  <div class="col-6">
  <div class="form-group">
  <label>Category Name</label>
  <input type="text" class="form-control" value="<?php echo $row['catg_name']; ?>" name="catg_name" required>
  </div>
  </div>
  
  <div class="col-6">
  <div class="form-group">
  <label>Status<span class="text-danger">*</span></label>
  <select class="form-control" name="status">
  <?php
  $arr = array('Active','Inactive');
  foreach ($arr as $status) {
    if ($status == $row['status']) {
      echo "<option value=" . $status . " selected>$status</option>";
    }
    else {
    echo "<option value=" . $status . ">$status</option>";
    }
  }
  ?>
  </select>
  </div>
  </div>
  </div>
  <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
  <input type="hidden" name="random_move" value="<?php echo $_SESSION['random_move']; ?>">
  <button class="btn btn-success" name="UpdateCategory">Update</button>
  </form>
  </div>
  <?php
}

if ($_REQUEST['part'] == 'All_Product_List') {
    $requestData = $_REQUEST;
    $sqls = "SELECT * FROM product_details where id!='' $where";
    $sql = "SELECT * FROM product_details where id!='' $where";

    $querys = mysqli_query($con,$sqls);
    $totalData = mysqli_num_rows($querys);
    $totalFiltered = $totalData;
    if (!empty($requestData['search']['value'])) { 
        $sql .= " AND (product_name LIKE '%".$requestData['search']['value']."%' ";        
        $sql .= " OR mrp LIKE '".$requestData['search']['value']."' OR ws_rate LIKE '".$requestData['search']['value']."' )";
    }
    $sql .= " ORDER BY product_name ASC LIMIT ".$requestData['start']." ,".$requestData['length']." ";
    //echo $sql;
    $query = mysqli_query($con,$sql);
    //$totalFiltered = mysql_num_rows($query);
    $data = array();

    $i = 1;
    while ($row = mysqli_fetch_array($query)) { // preparing an array

      $catgArr = Get_Fetch_Data($con,$row['catg_slno'], 'All', 'category_details');

      $action = "<input type='hidden' class='id' value=".$row['id'].">
      <span style='white-space:nowrap;float: right;'>
      <a class='btn btn-sm bg-success-light mr-2' href='aditedit_product.php?slno=$row[id]'><i class='fe fe-pencil'></i></a>&nbsp;
      <a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></a></span>";

      if ($row[status] == 'Active') {$status = "Active"; $class = 'bg-success';}
      else {$status = "In-Active";  $class = 'bg-danger';}

      $nestedData = array();
      $nestedData[] = "<div>$i</div>";     
      $nestedData[] = "<div style='white-space:nowrap;'>$row[ProductCode]</div>";
      $nestedData[] = "<div style='white-space:nowrap;'>$row[product_name]</div>";
      $nestedData[] = "<div style='white-space:nowrap;'>$catgArr[catg_name]</div>";
      $nestedData[] = "<div style='white-space:nowrap;'>$row[mrp]</div>";
      $nestedData[] = "<div style='white-space:nowrap;'>$row[ws_rate]</div>";
      $nestedData[] = "<div style='white-space:nowrap;'>$row[status]</div>";           
      $nestedData[] = "<div style='white-space:nowrap;'><i class='fe fe-clock text-warning mr-1'></i> $row[Add_time]</div>";
      $nestedData[] = "$action";
      $data[] = $nestedData;
      $i++;
    }

    $json_data = array(
        "draw" => intval($requestData['draw']),
        "recordsTotal" => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data" => $data
    );
    echo json_encode($json_data);
}


if ($_REQUEST['part'] == 'Get_City_List_State'){
  $result = Get_Fetch_Data($con,$_POST['state'],'All','state_details');
  $cityhtml = "<option value=''>All City of $result[state_name]</option>";
  $city_qry = mysqli_query($con,"SELECT * from city_details where state='".$_POST['state']."' && status='Y'");
  while ($cityArr = mysqli_fetch_array($city_qry)){
    $cityhtml .= "<option value=".$cityArr['id'].">$cityArr[city_name]</option>";
  }
  echo $cityhtml;
}

?>
