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


if($_POST['part'] == 'Delete_Agent_Data'){?>
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

  if ($_POST['part'] == 'Delete_Customers_Data'){?>
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

   if ($_POST['part'] == 'Delete_Vendors_Data'){?>
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

if ($_POST['part'] == 'changeyears'){
  mysqli_query($con,"update Years set Year='".$_POST['years']."' where id='1'");
  ?>

<?php } 
   if ($_POST['part'] == 'Delete_Transport_Data'){?>
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

   if ($_POST['part'] == 'Delete_Team_Data'){?>
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

  if ($_POST['part'] == 'Delete_Lead_Data'){?>
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
if ($_POST['part'] == 'Generate_EInvoice_Confirmation'){?>
<div class="modal-header bg-danger">
  <h5 class="modal-title">Are You Sure to generate E-invoice</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
</div>
<div class="modal-body">
  <form method="post" action="">
    <input type="hidden" name="id" value="<?php echo $_POST['id']; ?>">
    <input type="hidden" name="random_move" value="<?php echo $_SESSION['random_move']; ?>">
    <div class="row form-row">
      <div class="col-6">
        <button class="btn btn-danger" name="Generate">Generate</button>
      </div>
      <div class="col-6">
        <button class="btn btn-info" data-dismiss="modal" aria-label="Close" style="float: right;">Cancel</button>
      </div>
    </div>
  </form>
</div>
<?php
}

  if ($_REQUEST['part'] == 'All_Brand_Data') {

      $requestData = $_REQUEST;

      $sqls = "SELECT * FROM brand_details where id!='' $where";

      $sql = "SELECT * FROM brand_details where id!='' $where";

      $querys = mysqli_query($con,$sqls);

      $totalData = mysqli_num_rows($querys);

      $totalFiltered = $totalData;

      if (!empty($requestData['search']['value']))

      { // if there is a search parameter, $requestData['search']['value'] contains search parameter

          $sql .= " AND ( brand LIKE '%" . $requestData['search']['value'] . "%' ";

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

          $action = "<input type='hidden' class='id' value=" . $row['id'] . "><span style='white-space:nowrap;float: right;'> <a class='btn btn-sm bg-success-light mr-2 updateLinks' href='javascript:void'><i class='fe fe-pencil'></i></a>&nbsp; <a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></a></span>";

          if ($row['images'] != '')

          {

              $photo = "<a href='Product/" . $row['images'] . "' target='_blank'><img src='Product/" . $row['images'] . "' height='50' width='50' style='border-radius: 50%;'></a>";

          }

          else

          {

              $photo = "<img src='Banner/no-icons.png' height='40' style='border-radius: 12px;'>";

          }

          if ($row[status] == 'Active')

          {

              $class = 'bg-success';

          }

          else

          {

              $class = 'bg-danger';

          }

          $nestedData = array();

          $nestedData[] = "<div class='first'>$row[brand]</div>";

          $nestedData[] = "<div class='second'>$photo";

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

  if ($_POST['part'] == 'Brand_data_Update') {

      $row = Get_Fetch_Data($con,$_POST['id'], 'All', 'brand_details'); ?>
<div class="modal-header ">
  <h5 class="modal-title">Update Brand Detail</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
</div>
<div class="modal-body">
  <form action="" method="post" enctype="multipart/form-data">
    <div class="row form-row">
      <div class="col-12">
        <div class="form-group">
          <label> Brand Name</label>
          <input type="text" class="form-control" value="<?php echo $row['brand']; ?>" name="brand" required>
        </div>
      </div>
      <div class="col-12">
        <div class="form-group">
          <label> Update Logo</label>
          <input type="file" class="form-control UploaderFile" name="images">
        </div>
      </div>
      <div class="col-12">
        <div class="form-group">
          <label>Status</label>
          <select class="form-control" name="status">
            <?php $arr = ['Active', 'Inactive'];

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
    <button class="btn btn-success" name="UpdateBrand">Update</button>
  </form>
</div>
<?php

  }

  //Categorys


if ($_REQUEST['part'] == 'All_Invoiceformat_Data'){

      $requestData = $_REQUEST;

      $sqls = "SELECT * FROM invoice_format where id!='' $where";

      $sql = "SELECT * FROM invoice_format where id!='' $where";

      $querys = mysqli_query($con,$sqls);

      $totalData = mysqli_num_rows($querys);

      $totalFiltered = $totalData;

      if (!empty($requestData['search']['value']))

      { // if there is a search parameter, $requestData['search']['value'] contains search parameter

          $sql .= " AND ( InFormat LIKE '%" . $requestData['search']['value'] . "%' ";

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

          $action = "<input type='hidden' class='id' value=" . $row['id'] . "><span style='white-space:nowrap;float: right;'><a class='btn btn-sm bg-success-light mr-2 updateLinks' href='javascript:void'><i class='fe fe-pencil'></i></a>&nbsp;<a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></a></span>";

          if ($row[status] == 'Active'){

              $class = 'bg-success';

          } else {

              $class = 'bg-danger';

          }

         

         

 if($row[types]=='Return'){ $types="Sale Return"; } 
 if($row[types]=='Invoice'){ $types="Sale Invoice"; }        

          $nestedData = array();
		  $nestedData[] = "<div class='first'>$types</div>";
          $nestedData[] = "<div class='first'>$row[InFormat]</div>";
		  $nestedData[] = "<div class='first'>$row[last_no]</div>";
         

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
  if ($_POST['part'] == 'getamountinvoicecheckbox'){
    $row = Get_Fetch_Data($con,$_POST['oid'], 'Debit', 'All_Payment');
    echo $row["Debit"];
  }

  if ($_POST['part'] == 'Get_GMinvoicecalculate'){
    $row = Get_Fetch_Data($con,$_POST['supplierid'], 'Margin', 'supplier');
    $totalsale=Get_GMinvoicecalculate($con,$_POST['startdate'],$_POST['enddate'],$_POST['supplierid']);
    $margin=$row['Margin'];
    $famount=$totalsale*$margin/100;
    echo "$totalsale|$margin|$famount";
  }

  if ($_POST['part'] == 'Invoiceformat_data_Update'){

      $row = Get_Fetch_Data($con,$_POST['id'], 'All', 'invoice_format'); ?>
<div class="modal-header ">
  <h5 class="modal-title">Update Invoice Format Detail</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
</div>
<div class="modal-body">
  <form action="" method="post" enctype="multipart/form-data">
    <div class="row form-row">
    <div class="col-6">
             <input type="radio" name="types" value="Invoice" id="Invoices" <?php if($row['types']=='Invoice'){ echo 'checked'; }?>><label for="Invoices">&nbsp;Sales Invoice</label>
            </div>
            <div class="col-6">
             <input type="radio" name="types" value="Return" id="Returns" <?php if($row['types']=='Return'){ echo 'checked'; }?>><label for="Returns">&nbsp;Sales Return</label>
            </div>
      <div class="col-6">
        <div class="form-group">
          <label> Invoice Format Name<span class="text-danger">*</span></label>
          <input type="text" class="form-control" value="<?php echo $row['InFormat']; ?>" name="InvoiceFormat" required>
        </div>
      </div>
      <div class="col-6">
        <div class="form-group">
          <label> Last No<span class="text-danger">*</span></label>
          <input type="text" class="form-control" value="<?php echo $row['last_no']; ?>" name="last_no" required>
        </div>
      </div>
      <div class="col-12">
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
    <button class="btn btn-success" name="Updateinvoiceformat">Update</button>
  </form>
</div>
<?php

  }
  if ($_REQUEST['part'] == 'All_Tax_Data'){

      $requestData = $_REQUEST;

      $sqls = "SELECT * FROM GstTax where id!='' $where";

      $sql = "SELECT * FROM GstTax where id!='' $where";

      $querys = mysqli_query($con,$sqls);

      $totalData = mysqli_num_rows($querys);

      $totalFiltered = $totalData;

      if (!empty($requestData['search']['value']))

      { // if there is a search parameter, $requestData['search']['value'] contains search parameter

          $sql .= " AND ( Pcgst LIKE '%" . $requestData['search']['value'] . "%' ";

          $sql .= " OR Psgst LIKE '%" . $requestData['search']['value'] . "%' )";

      }

      $sql .= "  ORDER BY id desc  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";

      //echo $sqls;

      $query = mysqli_query($con,$sql);

      //$totalFiltered = mysql_num_rows($query);

      $data = array();

      $i = 1;

      while ($row = mysqli_fetch_array($query))

      { // preparing an array

          $action = "<input type='hidden' class='id' value=" . $row['id'] . "><span style='white-space:nowrap;float: right;'><a class='btn btn-sm bg-success-light mr-2 updateLinks' href='javascript:void'><i class='fe fe-pencil'></i></a>&nbsp;<a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></a></span>";
          $nestedData = array();
          $nestedData[] = "<div class='first'>$row[Pcgst]</div>";
          $nestedData[] = "<div class='first'>$row[Psgst]</div>";
          $nestedData[] = "<div class='first'>$row[Pigst]</div>";
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
  if ($_REQUEST['part'] == 'All_Category_Data'){

      $requestData = $_REQUEST;

      $sqls = "SELECT * FROM category_details where id!='' $where";

      $sql = "SELECT * FROM category_details where id!='' $where";

      $querys = mysqli_query($con,$sqls);

      $totalData = mysqli_num_rows($querys);

      $totalFiltered = $totalData;

      if (!empty($requestData['search']['value']))

      { // if there is a search parameter, $requestData['search']['value'] contains search parameter

          $sql .= " AND ( category LIKE '%" . $requestData['search']['value'] . "%' ";

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

          $action = "<input type='hidden' class='id' value=" . $row['id'] . "><span style='white-space:nowrap;float: right;'><a class='btn btn-sm bg-success-light mr-2 updateLinks' href='javascript:void'><i class='fe fe-pencil'></i></a>&nbsp;<a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></a></span>";

          if ($row[status] == 'Active'){

              $class = 'bg-success';

          } else {

              $class = 'bg-danger';

          }

         

         

         

          $nestedData = array();

          

          $nestedData[] = "<div class='first'>$row[category]</div>";

         

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
if ($_POST['part'] == 'Gsttax_data_Update'){

      $row = Get_Fetch_Data($con,$_POST['id'], 'All', 'GstTax'); ?>
<div class="modal-header ">
  <h5 class="modal-title">Update Gst Tax Detail</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
</div>
<div class="modal-body">
  <form action="" method="post" enctype="multipart/form-data">
          <div class="row form-row">
            <div class="col-12 col-sm-4">
              <div class="form-group">
                <label> CGST<span class="text-danger">*</span></label>
                <input type="text" name="pcgst" class="form-control" value="<?php echo $row['Pcgst'];?>" required>
              </div>
            </div>
            <div class="col-12 col-sm-4">
              <div class="form-group">
                <label> SGST<span class="text-danger">*</span></label>
                <input type="text" name="psgst" class="form-control" required value="<?php echo $row['Psgst'];?>">
              </div>
            </div>
            <div class="col-12 col-sm-4">
              <div class="form-group">
                <label> IGST<span class="text-danger">*</span></label>
                <input type="text" name="pigst" class="form-control" required value="<?php echo $row['Pigst'];?>">
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
  if ($_POST['part'] == 'Category_data_Update'){

      $row = Get_Fetch_Data($con,$_POST['id'], 'All', 'category_details'); ?>
<div class="modal-header ">
  <h5 class="modal-title">Update Department Detail</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
</div>
<div class="modal-body">
  <form action="" method="post" enctype="multipart/form-data">
    <div class="row form-row">
      <div class="col-12">
        <div class="form-group">
          <label> Department Name<span class="text-danger">*</span></label>
          <input type="text" class="form-control" value="<?php echo $row['category']; ?>" name="category" required>
        </div>
      </div>
      <div class="col-12">
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
    <button class="btn btn-success" name="UpdateCategory">Update</button>
  </form>
</div>
<?php

  }

  if ($_REQUEST['part'] == 'All_Team_Data'){

      $requestData = $_REQUEST;


      $sqls = "SELECT * FROM admin_signup where level='2' $where";

      $sql = "SELECT * FROM admin_signup where level='2' $where";

      $querys = mysqli_query($con,$sqls);

      $totalData = mysqli_num_rows($querys);

      $totalFiltered = $totalData;

      if (!empty($requestData['search']['value']))

      { // if there is a search parameter, $requestData['search']['value'] contains search parameter

          $sql .= " AND ( name LIKE '%" . $requestData['search']['value'] . "%' ";

           $sql .= " OR mobile LIKE '%" . $requestData['search']['value'] . "%' )";

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

          $role = Get_Fetch_Data($con,$row['role'], 'All', 'role');

          $action = "<input type='hidden' class='id' value=" . $row['id'] . "> <span style='white-space:nowrap;float: right;'> <a class='btn btn-sm bg-success-light mr-2 updateLinks' href='javascript:void'><i class='fe fe-pencil'></i></a>&nbsp; <a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></a></span>";

          if ($row[status] == 'Active')

          {

              $class = 'bg-success';

          } else {

              $class = 'bg-danger';

          }

          if ($row['photo'] != '')

          {

              $photo = "<a href='Banner/" . $row['photo'] . "' data-lightbox='photos'><img src='Banner/" . $row['photo'] . "' style='height: 70px; width: 70px;

              border-color: aliceblue !important; padding: 1px; border: 1px solid;  border-radius: 50%; box-shadow: 0px 0px 5px #ccc;'></a>";        

          } else {

              $photo = "<img src='Banner/noimages.jpg'  style='height: 70px; width: 70px; border-color: aliceblue !important; padding: 1px; border: 1px solid;

              border-radius: 50%; box-shadow: 0px 0px 5px #ccc;'>";

          }

          $nestedData = array();
			$nestedData[] = "<div class='first'>$photo</div>";
          $nestedData[] = "<div class='first'>$row[name]</div>";

          $nestedData[] = "<div class='first'>$row[mobile]</div>";

         $nestedData[] = "<div class='first'>$row[email]</div>";

         $nestedData[] = "<div class='first'>$role[rname]</div>";

          $nestedData[] = "<div class='third'><span class='badge badge-pill $class inv-badge'>$row[status]</span>";

          $nestedData[] = "<div class='fourth'><i class='fe fe-clock text-warning mr-1'></i> $row[create_time]";

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

  if ($_POST['part'] == 'Team_data_Update') {

      $row = Get_Fetch_Data($con,$_POST['id'], 'All', 'admin_signup'); ?>
<div class="modal-header ">
  <h5 class="modal-title">Update Team Detail</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
</div>
<div class="modal-body">
  <form action="" method="post" enctype="multipart/form-data">
    <div class="row form-row">
      <div class="col-12">
        <div class="form-group">
          <label> Role<span class="text-danger">*</span></label>
          <select name="role" class="form-control" required>
            <option value="">Select</option>
            <?php

              $Csql = mysqli_query($con,"select * from role");

              while ($Crow = mysqli_fetch_array($Csql))

              {

                  if ($row['role'] == $Crow['id'])

                  {

                      echo "<option value=" . $Crow['id'] . " selected>$Crow[rname]</option>";

                  }

                  else

                  {

                      echo "<option value=" . $Crow['id'] . ">$Crow[rname]</option>";

                  }

              }

              ?>
          </select>
        </div>
      </div>
      <div class="col-12 col-sm-12">
        <div class="form-group">
          <label> Name<span class="text-danger">*</span></label>
          <input type="text" class="form-control" placeholder="Enter  Name" name="name" value="<?php echo $row["name"];?>" required>
        </div>
      </div>
      <div class="col-12 col-sm-12">
        <div class="form-group">
          <label> Mobile<span class="text-danger">*</span></label>
          <input type="text" class="form-control" placeholder="Enter  Mobile" name="mobile" value="<?php echo $row["mobile"];?>" onkeypress='return /[0-9]/i.test(event.key)' maxlength="10" minlength="10" required>
        </div>
      </div>
      <div class="col-12 col-sm-12">
        <div class="form-group">
          <label> Email</label>
          <input type="email" class="form-control" placeholder="Enter  Email" name="email" value="<?php echo $row["email"];?>">
        </div>
      </div>
      <div class="col-12 col-sm-12">
              <div class="form-group">
                <label>  Address</label>
                <textarea class="form-control" placeholder="Enter  Address" name="address"><?php echo $row["address"];?></textarea>
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <div class="form-group">
                <label>   Update Photo</label>
                <input type="file" class="form-control" name="photo">
              </div>
            </div>
      <div class="col-6">
        <div class="form-group">
          <label>Status<span class="text-danger">*</span></label>
          <select class="form-control" name="status">
            <?php $arr =array('Active', 'Inactive');

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
    <button class="btn btn-success" name="UpdateTeam">Update</button>
  </form>
</div>
<?php

  } 

if ($_REQUEST['part'] == 'All_SubCategory_Data'){
$requestData = $_REQUEST;
if ($_REQUEST['category'] != '')
{
$where .= " and category='" . $_REQUEST['category'] . "'";
}
if ($_REQUEST['status'] != '')
{
$where .= " and status='" . $_REQUEST['status'] . "'";
}
$sqls = "SELECT * FROM subcategory_details where id!='' $where";
$sql = "SELECT * FROM subcategory_details where id!='' $where";
$querys = mysqli_query($con,$sqls);
$totalData = mysqli_num_rows($querys);
$totalFiltered = $totalData;
if (!empty($requestData['search']['value']))
{ // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql .= " AND ( subcategory LIKE '%" . $requestData['search']['value'] . "%' ";
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
$category = Get_Fetch_Data($con,$row['category'], 'All', 'category_details');
$action = "<input type='hidden' class='id' value=" . $row['id'] . "> <span style='white-space:nowrap;float: right;'> <a class='btn btn-sm bg-success-light mr-2 updateLinks' href='javascript:void'><i class='fe fe-pencil'></i></a>&nbsp; <a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></a></span>";
if ($row[status] == 'Active')
{
$class = 'bg-success';
} else {
$class = 'bg-danger';
}
$nestedData = array();
$nestedData[] = "<div class='first'>$category[category]</div>";
$nestedData[] = "<div class='first'>$row[subcategory]</div>";
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

 if ($_POST['part'] == 'Remove_Hsn_Tax_item') {
mysqli_query($con,"delete from Hsn_tax_range where id='".$_POST['id']."'");	 
 }
if ($_POST['part'] == 'SubCategory_data_Update') {
$row = Get_Fetch_Data($con,$_POST['id'], 'All', 'subcategory_details'); 
?>
<div class="modal-header ">
  <h5 class="modal-title">Update Category Detail</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
</div>
<div class="modal-body">
  <form action="" method="post" enctype="multipart/form-data">
    <div class="row form-row">
      <div class="col-12">
        <div class="form-group">
          <label> Department<span class="text-danger">*</span></label>
          <select name="category" class="form-control" required>
            <option value="">Department</option>
            <?php

              $Csql = mysqli_query($con,"select * from category_details where status='Active'");

              while ($Crow = mysqli_fetch_array($Csql))

              {

                  if ($row['category'] == $Crow['id'])

                  {

                      echo "<option value=" . $Crow['id'] . " selected>$Crow[category]</option>";

                  }

                  else

                  {

                      echo "<option value=" . $Crow['id'] . ">$Crow[category]</option>";

                  }

              }

              ?>
          </select>
        </div>
      </div>
      <div class="col-12">
        <div class="form-group">
          <label> Category Name<span class="text-danger">*</span></label>
          <input type="text" class="form-control" value="<?php echo $row['subcategory']; ?>" name="subcategory" required>
        </div>
      </div>
      <div class="col-12">
        <div class="form-group">
          <label>Status<span class="text-danger">*</span></label>
          <select class="form-control" name="status">
            <?php $arr = [ 'Active', 'Inactive'];

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

  if ($_POST['part'] == 'Add_Catalogue_Image_Part')

  { ?>
<tr>
  <td><input type="file" class="form-control" name="photo[]" required></td>
  <td><input type="text" class="form-control" name="cat_code[]" placeholder="Enter SKU Code" required></td>
  <td><select class="form-control" name="status[]" required>
      <?php $arr = ['Instock', 'Outstock'];

      foreach ($arr as $status){

          echo "<option value=" . $status . ">$status</option>";

      }

      ?>
    </select></td>
  <td><a href="javascript:void" class="btn-xs btn-danger RemoveR"><i class="fa fa-remove" aria-hidden="true"></i></a></td>
</tr>
<?php

  } if ($_POST['part'] == 'Add_Document_Part') {?>
<tr>
  <td><input type="file" class="form-control UploaderFile" name="photo[]"></td>
  <td><a href="javascript:void" class="btn btn-sm bg-danger-light mr-2 Remove"><i class="fa fa-remove" aria-hidden="true"></i></a></td>
</tr>
<?php

  } if ($_POST['part'] == 'Add_Document_PartS'){ ?>
<tr>
  <td><input type="file" class="form-control UploaderFile" name="photo[]"></td>
  <td><a href="javascript:void" class="btn-xs btn-danger RemoveS"><i class="fa fa-remove" aria-hidden="true"></i></a></td>
</tr>
<?php

  } if ($_POST['part'] == 'Add_Color_Part') { ?>
<tr>
  <td><input type="text" class="form-control" name="size_name[]" placeholder="Size Name"></td>
  <td><a href="javascript:void" class="btn btn-sm bg-danger-light mr-2 Remove"><i class="fa fa-remove" aria-hidden="true"></i></a></td>
</tr>
<?php

  } if ($_POST['part'] == 'Remove_Product_Color') {

      mysqli_query($con,"delete from product_size where id='" . $_POST['did'] . "'");

  } if ($_POST['part'] == 'Remove_Documents') {

      mysqli_query($con,"delete from product_images where id='" . $_POST['did'] . "'");

  } if ($_POST['part'] == 'Remove_Product_Rate') {

      mysqli_query($con,"delete from product_rate where id='" . $_POST['did'] . "'");

  } if ($_REQUEST['part'] == 'Get_Subcategory') {

      $html = "<option value=''>Select</option>";
      $Csql = mysqli_query($con,"select * from subcategory_details where category='" . $_POST['category'] . "' and status='Active'");
      while ($Crow = mysqli_fetch_array($Csql)){
	  $html .= "<option value=" . $Crow['id'] . ">$Crow[subcategory]</option>";
      }

      echo $html;

  } if ($_REQUEST['part'] == 'Get_SubSubcategory') {

      $html = "<option value=''>Select</option>";

      $Csql = mysqli_query($con,"select * from sub_subcategory_details where subcat='" . $_POST['subcategory'] . "' and status='Active'");

      while ($Crow = mysqli_fetch_array($Csql))

      {

          $html .= "<option value=" . $Crow['id'] . ">$Crow[subcategory]</option>";

      }

      echo $html;

  }

  

  if ($_REQUEST['part'] == 'Get_state_plan')

  {

      $Csql = mysql_query($con,"select * from dealer_pricing  where id='" . $_POST['state'] . "'");

      while ($Crow = mysqli_fetch_array($Csql))

      {

          $html .= "<option value=" . $Crow['id'] . ">$Crow[state_code]-$Crow[margin_rate]</option>";

      }

      echo $html;

  }

  

  if ($_REQUEST['part'] == 'All_Sub_SubCategory_Data')

  {

      $requestData = $_REQUEST;

      if ($_REQUEST['category'] != '')

      {

          $where .= " and cat='" . $_REQUEST['category'] . "'";

      }

      if ($_REQUEST['subcategory'] != '')

      {

          $where .= " and subcat='" . $_REQUEST['subcategory'] . "'";

      }

      if ($_REQUEST['status'] != '')

      {

          $where .= " and status='" . $_REQUEST['status'] . "'";

      }

      $sqls = "SELECT * FROM sub_subcategory_details where id!='' $where";

      $sql = "SELECT * FROM sub_subcategory_details where id!='' $where";

      $querys = mysqli_query($con,$sqls);

      $totalData = mysqli_num_rows($querys);

      $totalFiltered = $totalData;

      if (!empty($requestData['search']['value']))

      { // if there is a search parameter, $requestData['search']['value'] contains search parameter

          $sql .= " AND ( subcategory LIKE '%" . $requestData['search']['value'] . "%' ";

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

          $category = Get_Fetch_Data($con,$row['cat'], 'All', 'category_details');

          $subcategory = Get_Fetch_Data($con,$row['subcat'], 'All', 'subcategory_details');

          $action = "<input type='hidden' class='id' value=" . $row['id'] . ">

  <span style='white-space:nowrap;float: right;'>

  <a class='btn btn-sm bg-success-light mr-2 updateLinks' href='javascript:void'><i class='fe fe-pencil'></i></a>&nbsp;

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

          $nestedData[] = "<div class='first'>$category[category]</div>";

          $nestedData[] = "<div class='first'>$subcategory[subcategory]</div>";

          $nestedData[] = "<div class='first'>$row[subcategory]</div>";

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

  if ($_POST['part'] == 'SubSubCategory_data_Update')

  {

      $row = Get_Fetch_Data($con,$_POST['id'], 'All', 'sub_subcategory_details');

  ?>
<div class="modal-header ">
  <h5 class="modal-title">Update Sub Sub-Category Detail</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
</div>
<div class="modal-body">
  <form action="" method="post" enctype="multipart/form-data">
    <div class="row form-row">
      <div class="col-12">
        <div class="form-group">
          <label> Category </label>
          <select name="category" id="categoryss" class="form-control" required>
            <option value="">Category</option>
            <?php

              $Csql = mysqli_query($con,"select * from category_details where status='Active'");

              while ($Crow = mysqli_fetch_array($Csql))

              {

                  if ($row['cat'] == $Crow['id'])

                  {

                      echo "<option value=" . $Crow['id'] . " selected>$Crow[category]</option>";

                  }

                  else

                  {

                      echo "<option value=" . $Crow['id'] . ">$Crow[category]</option>";

                  }

              }

              ?>
          </select>
        </div>
      </div>
      <div class="col-12">
        <div class="form-group">
          <label> Sub Category </label>
          <select name="subcategory" id="subcategoryss" class="form-control" required>
            <option value="">Sub Category</option>
            <?php

              $Csql = mysqli_query($con,"select * from subcategory_details where status='Active' and category='" . $row['cat'] . "'");

              while ($Crow = mysqli_fetch_array($Csql))

              {

                  if ($row['subcat'] == $Crow['id'])

                  {

                      echo "<option value=" . $Crow['id'] . " selected>$Crow[subcategory]</option>";

                  }

                  else

                  {

                      echo "<option value=" . $Crow['id'] . ">$Crow[subcategory]</option>";

                  }

              }

              ?>
          </select>
        </div>
      </div>
      <div class="col-12">
        <div class="form-group">
          <label> Sub Sub-Category Name</label>
          <input type="text" class="form-control" value="<?php echo $row['subcategory']; ?>" name="subsubcategory" required>
        </div>
      </div>
      <div class="col-12">
        <div class="form-group">
          <label>Status</label>
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
    <button class="btn btn-success" name="UpdateSubCategory">Update</button>
  </form>
</div>
<?php

  }

  if ($_POST['part'] == 'Check_Supplier_Emailid')

  {

      $Check = Get_Count_Data($con,$_POST['email'], 'email', 'supplier_details');

      if ($Check > 0)

      {

          echo "This Email Id already resgietered with us Please try another email account.";

      }

  }

  

  if ($_REQUEST['part'] == 'All_Reseller_Data')

  {

      $requestData = $_REQUEST;

      if ($_REQUEST['from'] != '' && $_REQUEST['to'] != '')

      {

          $ff = explode('/', $_REQUEST['from']);

          $from = $ff[2] . '-' . $ff[1] . '-' . $ff[0];

          $tt = explode('/', $_REQUEST['to']);

          $to = $tt[2] . '-' . $tt[1] . '-' . $tt[0];

          $where .= " and STR_TO_DATE(`create_time`, '%d/%m/%Y') between '" . $from . "' and '" . $to . "'";

      }

      if ($_REQUEST['status'] != '')

      {

          $where .= " and status='" . $_REQUEST['status'] . "'";

      }

      $sqls = "SELECT * FROM supplier_details where id!='' $where";

      $sql = "SELECT * FROM supplier_details where id!='' $where";

      $querys = mysqli_query($con,$sqls);

      $totalData = mysqli_num_rows($con,$querys);

      $totalFiltered = $totalData;

      if (!empty($requestData['search']['value']))

      { // if there is a search parameter, $requestData['search']['value'] contains search parameter

          $sql .= " AND ( company LIKE '%" . $requestData['search']['value'] . "%' ";

          $sql .= " OR name LIKE '%" . $requestData['search']['value'] . "%'";

          $sql .= " OR mobile LIKE '%" . $requestData['search']['value'] . "%'";

          $sql .= " OR email LIKE '%" . $requestData['search']['value'] . "%'";

          $sql .= " OR address LIKE '%" . $requestData['search']['value'] . "%'";

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

          if ($row['company'] != '')

          {

              $company = "<span class='badge badge-pill bg-primary inv-badge'>$row[company]</span><br>";

          }

          else

          {

              $company = "";

          }

          $action = "<input type='hidden' class='id' value=" . $row['id'] . ">

  <span style='white-space:nowrap;float: right;'>

  <a class='btn btn-sm bg-primary-light viewLinks' href='javascript:void'><i class='fe fe-search'></i></a>&nbsp;

  <a class='btn btn-sm bg-success-light updateLinks' href='javascript:void'><i class='fe fe-pencil'></i></a>&nbsp;

  <a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></a></span>";

          if ($row[status] == 'Active')

          {

              $class = 'bg-success';

          }

          else

          {

              $class = 'bg-danger';

          }

          $PendingProduct = Get_Reseller_Product_Cout($con,$row['id'], 'Pending');

          $InstockProduct = Get_Reseller_Product_Cout($con,$row['id'], 'Instock');

          $OutstockProduct = Get_Reseller_Product_Cout($con,$row['id'], 'Outstock');

          $nestedData = array();

          $nestedData[] = "<div class='first' style='font-size: 13px;'>$company$row[name]</div>";

          $nestedData[] = "<div class='first'>$row[mobile]</div>";

          $nestedData[] = "<div class='second'>$row[email]</div>";

          $nestedData[] = "<div class='first'>$row[city]</div>";

          $nestedData[] = "<div class='first'>$row[gst_no]</div>";

          $nestedData[] = "<div class='first' style='white-space: nowrap;'>

      <a href='AllProducts.php?supplier=" . $row['id'] . "&brand=&category=&subcategory=&status=Pending&Search=' class='btn btn-sm bg-warning-light mr-1' title='Pending Product'>$PendingProduct</a>

      <a href='AllProducts.php?supplier=" . $row['id'] . "&brand=&category=&subcategory=&status=Instock&Search=' class='btn btn-sm bg-success-light mr-1' title='Instock Product'>$InstockProduct</a>

      <a href='AllProducts.php?supplier=" . $row['id'] . "&brand=&category=&subcategory=&status=Outstock&Search=' class='btn btn-sm bg-danger-light' title='Out Of Stock Product'>$OutstockProduct</a></div>";

          $nestedData[] = "<div class='first'>$row[amt_percent] %</div>";

          $nestedData[] = "<div class='third'><span class='badge badge-pill $class inv-badge'>$row[status]</span>

      <div class='create_time'>$row[create_time]</div></div>";

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

  if ($_POST['part'] == 'Ressller_data_Update')

  {

      $row = Get_Fetch_Data($con,$_POST['id'], 'All', 'supplier_details');

  ?>
<div class="modal-header ">
  <h5 class="modal-title">Update Reseller Account</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
</div>
<div class="modal-body">
  <form action="" method="post" enctype="multipart/form-data">
    <div class="row form-row">
      <div class="col-6">
        <div class="form-group">
          <label> Organization Name </label>
          <input type="text" class="form-control Capitalize" value="<?php echo $row['company']; ?>" name="company" required>
        </div>
      </div>
      <div class="col-6">
        <div class="form-group">
          <label> Full Name </label>
          <input type="text" class="form-control Capitalize" value="<?php echo $row['name']; ?>" name="name" required>
        </div>
      </div>
      <div class="col-6">
        <div class="form-group">
          <label> Mobile No </label>
          <input type="text" class="form-control" value="<?php echo $row['mobile']; ?>" name="mobile" required>
        </div>
      </div>
      <div class="col-6">
        <div class="form-group">
          <label> Gender </label>
          <select class="form-control" name="gender" required>
            <?php

            $Arrs = array(

                'Male',

                'Female'

            );

            foreach ($Arrs as $gender)

            {

                if ($row['gender'] == $gender)

                {

                    echo "<option value='" . $gender . "' selected>$gender</option>";

                }

                else

                {

                    echo "<option value='" . $gender . "'>$gender</option>";

                }

            }

            ?>
          </select>
        </div>
      </div>
      <div class="col-6">
        <div class="form-group">
          <label> Email Id/Username </label>
          <input type="text" class="form-control" value="<?php echo $row['email']; ?>" name="email" required readonly>
        </div>
      </div>
      <div class="col-6">
        <div class="form-group">
          <label> Password </label>
          <input type="text" class="form-control" placeholder="Change Password" name="password">
        </div>
      </div>
      <div class="col-12">
        <div class="form-group">
          <label> Communication Address </label>
          <textarea class="form-control Capitalize" name="address" required>

          <?php echo $row['address']; ?>

          </textarea>
        </div>
      </div>
      <div class="col-4">
        <div class="form-group">
          <label> City </label>
          <input type="text" class="form-control Capitalize" value="<?php echo $row['city']; ?>" name="city" required>
        </div>
      </div>
      <div class="col-4">
        <div class="form-group">
          <label> State </label>
          <input type="text" class="form-control Capitalize" value="<?php echo $row['state']; ?>" name="state" required>
        </div>
      </div>
      <div class="col-4">
        <div class="form-group">
          <label> Pincode </label>
          <input type="text" class="form-control" value="<?php echo $row['pincode']; ?>" name="pincode" required>
        </div>
      </div>
      <div class="col-4">
        <div class="form-group">
          <label> Comission (%) </label>
          <input type="number" class="form-control" value="<?php echo $row['amt_percent']; ?>" name="amt_percent" required>
        </div>
      </div>
      <div class="col-4">
        <div class="form-group">
          <label> PAN No </label>
          <input type="text" class="form-control Capitalize" value="<?php echo $row['pan_no']; ?>" name="pan_no">
        </div>
      </div>
      <div class="col-4">
        <div class="form-group">
          <label> GST No </label>
          <input type="text" class="form-control Capitalize" value="<?php echo $row['gst_no']; ?>" name="gst_no">
        </div>
      </div>
      <div class="col-6">
        <div class="form-group">
          <label> Update Photo </label>
          <input type="file" class="form-control UploaderFile" name="photo">
        </div>
      </div>
      <div class="col-6">
        <div class="form-group">
          <label> Bank Name </label>
          <select name="bank" class="form-control">
            <option value="">Select Bank</option>
            <?php

              $Csql = mysqli_query($con,"select * from bank_details where status='Active'");

              while ($Crow = mysqli_fetch_array($Csql))

              {

                  if ($row['bank'] == $Crow['id'])

                  {

                      echo "<option value=" . $Crow['id'] . " selected>$Crow[bank_name]</option>";

                  }

                  else

                  {

                      echo "<option value=" . $Crow['id'] . ">$Crow[bank_name]</option>";

                  }

              }

              ?>
          </select>
        </div>
      </div>
      <div class="col-6">
        <div class="form-group">
          <label> Account No </label>
          <input type="text" class="form-control Capitalize" value="<?php echo $row['account_no']; ?>" name="account_no">
        </div>
      </div>
      <div class="col-6">
        <div class="form-group">
          <label> Account Holder Name </label>
          <input type="text" class="form-control Capitalize" value="<?php echo $row['account_name']; ?>" name="account_name">
        </div>
      </div>
      <div class="col-6">
        <div class="form-group">
          <label> IFSC Code </label>
          <input type="text" class="form-control Capitalize" value="<?php echo $row['IFSC']; ?>" name="IFSC">
        </div>
      </div>
      <div class="col-6">
        <div class="form-group">
          <label>Status</label>
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
    <button class="btn btn-success" name="UpdateReseller">Update</button>
  </form>
</div>
<?php

  }

  if ($_POST['part'] == 'Ressller_data_View')

  {

      $row = Get_Fetch_Data($con,$_POST['id'], 'All', 'supplier_details');

      $Bank = Get_Fetch_Data($con,$row['bank'], 'bank_name', 'bank_details');

      if ($row['photo'] != '')

      {

          $photo = "../seller/Banner/$row[photo]";

      }

      else

      {

          $photo = "../seller/Banner/noimages.jpg";

      }

  ?>
<div class="modal-header ">
  <h5 class="modal-title">Reseller Account Details</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
</div>
<div class="modal-body">
  <table class="table table-bordered">
    <tr>
      <td width="30%"><strong>Name</strong></td>
      <td width="55%"><?php echo $row['name']; ?></td>
      <td rowspan="3" width="15%"><img src="<?php echo $photo; ?>" height="100"></td>
    </tr>
    <tr>
      <td><strong>Organization</strong></td>
      <td><?php echo $row['company']; ?></td>
    </tr>
    <tr>
      <td><strong>Mobile No</strong></td>
      <td><?php echo $row['mobile']; ?></td>
    </tr>
    <tr>
      <td><strong>Email Id/Username</strong></td>
      <td colspan="2"><?php echo $row['email']; ?></td>
    </tr>
    <tr>
      <td><strong>Gender</strong></td>
      <td colspan="2"><?php echo $row['gender']; ?></td>
    </tr>
    <tr>
      <td><strong>Address</strong></td>
      <td colspan="2"><?php echo $row['address']; ?></td>
    </tr>
    <tr>
      <td><strong>City</strong></td>
      <td colspan="2"><?php echo $row['city']; ?></td>
    </tr>
    <tr>
      <td><strong>State</strong></td>
      <td colspan="2"><?php echo $row['state']; ?></td>
    </tr>
    <tr>
      <td><strong>Pincode</strong></td>
      <td colspan="2"><?php echo $row['pincode']; ?></td>
    </tr>
    <tr>
      <td><strong>PAN No</strong></td>
      <td colspan="2"><?php echo $row['pan_no']; ?></td>
    </tr>
    <tr>
      <td><strong>GST No</strong></td>
      <td colspan="2"><?php echo $row['gst_no']; ?></td>
    </tr>
    <tr>
      <td><strong>Bank Name</strong></td>
      <td colspan="2"><?php echo $Bank['bank_name']; ?></td>
    </tr>
    <tr>
      <td><strong>Account No</strong></td>
      <td colspan="2"><?php echo $row['account_no']; ?></td>
    </tr>
    <tr>
      <td><strong>Account Holder</strong></td>
      <td colspan="2"><?php echo $row['account_name']; ?></td>
    </tr>
    <tr>
      <td><strong>IFSC Code</strong></td>
      <td colspan="2"><?php echo $row['IFSC']; ?></td>
    </tr>
    <tr>
      <td><strong>Create Time</strong></td>
      <td colspan="2"><?php echo $row['create_time']; ?></td>
    </tr>
    <tr>
      <td><strong>Status</strong></td>
      <td colspan="2"><?php echo $row['status']; ?></td>
    </tr>
  </table>
</div>
<?php

  }

  if ($_REQUEST['part'] == 'All_Product_Data_Part')

  {

      $requestData = $_REQUEST;

      if ($_REQUEST['category'] != '')

      {

          $where .= " and category='" . $_REQUEST['category'] . "'";

      }

      if ($_REQUEST['subcategory'] != '')

      {

          $where .= " and subcategory='" . $_REQUEST['subcategory'] . "'";

      }

      if ($_REQUEST['status'] != '')

      {

          $where .= " and status='" . $_REQUEST['status'] . "'";

      }

      if ($_REQUEST['cat'] != '')

      {

          $where .= " and pid='" . $_REQUEST['cat'] . "'";

      }

  

      $sqls = "SELECT pc.* FROM `product_catalogue` pc LEFT JOIN product_details pd on pc.pid=pd.id where pc.id!='' $where";

      $sql = "SELECT pc.* FROM `product_catalogue` pc LEFT JOIN product_details pd on pc.pid=pd.id where pc.id!='' $where";

      $querys = mysqli_query($con,$sqls);

      $totalData = mysqli_num_rows($querys);

      $totalFiltered = $totalData;

      if (!empty($requestData['search']['value']))

      { // if there is a search parameter, $requestData['search']['value'] contains search parameter

          $sql .= " AND ( product LIKE '%" . $requestData['search']['value'] . "%' ";

          $sql .= " OR pr_code LIKE '%" . $requestData['search']['value'] . "%'";

          $sql .= " OR mrp LIKE '%" . $requestData['search']['value'] . "%'";

          $sql .= " OR status LIKE '%" . $requestData['search']['value'] . "%' )";

      }

      $sql .= "  ORDER BY pc.id asc  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";

      //echo $sqls;

      $query = mysqli_query($con,$sql);

      //$totalFiltered = mysql_num_rows($query);

      $data = array();

      $i = 1;

      while ($row = mysqli_fetch_array($query))

      { // preparing an array

          $Product = Get_Fetch_Data($con,$row['pid'], 'All', 'product_details');

          $category = Get_Fetch_Data($con,$Product['category'], 'category', 'category_details');

          $action = "<input type='hidden' class='id' value=" . $row['id'] . ">

  <span style='white-space:nowrap;float: right;'>

  <a class='btn btn-sm bg-success-light updateLinks' href='javascript:void;'><i class='fe fe-pencil'></i></a>&nbsp;

  <a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></a></span>";

          if ($row[status] == 'Instock')

          {

              $class = 'bg-success';

          }

          else if ($row[status] == 'Pending')

          {

              $class = 'bg-warning';

          }

          else

          {

              $class = 'bg-danger';

          }

  

          if ($row[images] != '')

          {

              $ProductImages = "$row[images]";

          }

          else

          {

              $ProductImages = "noproducts.png";

          }

          $nestedData = array();

          $nestedData[] = "<a href='Product/$ProductImages' data-lightbox='photos'><img src='Product/$ProductImages' style='height:70px;width:70px;border-color: aliceblue !important;;padding: 1px;border: 1px solid;border-radius: 50%;

      box-shadow: 0px 0px 5px #ccc;'></a>";

          $nestedData[] = "<div class='first'>$row[sku_code]</div>";

          $nestedData[] = "<div class='third'><span class='badge badge-pill $class inv-badge'>$row[status]</span><div class='create_time'>$row[add_time]</div></div>";

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

  

  if ($_REQUEST['part'] == 'All_Catalogue_Data_Part')

  {

      $requestData = $_REQUEST;

      if ($_REQUEST['category'] != '')

      {

          $where .= " and category='" . $_REQUEST['category'] . "'";

      }

      if ($_REQUEST['subcategory'] != '')

      {

          $where .= " and subcategory='" . $_REQUEST['subcategory'] . "'";

      }

  

      $sqls = "SELECT * from product_details where id!='' $where";

      $sql = "SELECT * from product_details where id!='' $where";

      $querys = mysqli_query($con,$sqls);

      $totalData = mysqli_num_rows($querys);

      $totalFiltered = $totalData;

      if (!empty($requestData['search']['value']))

      { // if there is a search parameter, $requestData['search']['value'] contains search parameter

          $sql .= " AND ( product LIKE '%" . $requestData['search']['value'] . "%' ";

          $sql .= " OR pr_code LIKE '%" . $requestData['search']['value'] . "%'";

          $sql .= " OR mrp LIKE '%" . $requestData['search']['value'] . "%' )";

      }

      $sql .= "  ORDER BY product, id asc  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";

      //echo $sqls;

      $query = mysqli_query($con,$sql);

      //$totalFiltered = mysql_num_rows($query);

      $data = array();

      $i = 1;

      while ($row = mysqli_fetch_array($query))

      { // preparing an array

          $category = Get_Fetch_Data($con,$row['category'], 'category', 'category_details');

          $subcategory = Get_Fetch_Data($con,$row['subcategory'], 'subcategory', 'subcategory_details');

          $action = "<input type='hidden' class='id' value=" . $row['id'] . ">

  <span style='white-space:nowrap;float: right;'>

  <a class='btn btn-sm bg-primary-light viewLinks' href='javascript:void'><i class='fe fe-search'></i></a>&nbsp;

  <a class='btn btn-sm bg-success-light' href='UpdateProduct.php?id=" . $row['id'] . "'><i class='fe fe-pencil'></i></a>&nbsp;

  <a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></a></span>";

          $Items = Get_Count_Data($con,$row['id'], 'pid', 'product_catalogue');

          $nestedData = array();

          $nestedData[] = "<div class='first'>$row[product]</div>";

          $nestedData[] = "<div class='first'>$row[pr_code]</div>";

          $nestedData[] = "<div class='first'>$category[category]</div>";

          $nestedData[] = "<div class='first'>$subcategory[subcategory]</div>";

          $nestedData[] = "<div class='first'>$row[mrp_catl]-$row[mrp_indv]</div>";

          $nestedData[] = "<div class='third'><a href='AllProducts.php?cat=$row[id]' class='badge badge-pill badge-success inv-badge'>$Items</a></div>";

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

  if ($_POST['part'] == 'Remove_Documents')

  {

      mysqli_query($con,"delete from product_images where id='" . $_POST['did'] . "'");

  }

  

  if ($_POST['part'] == 'Product_data_View')

  {

      //$row=Get_Fetch_Data($_POST['id'],'All','product_catalogue');

      $product = Get_Fetch_Data($con,$_POST['id'], 'All', 'product_details');

      $category = Get_Fetch_Data($con,$product['category'], 'category', 'category_details');

      $subcategory = Get_Fetch_Data($con,$product['subcategory'], 'subcategory', 'subcategory_details');

      if ($row[images] != '')

      {

          $ProductImages = "$row[images]";

      }

      else

      {

          $ProductImages = "noproducts.png";

      }?>
<div class="modal-header ">
  <h5 class="modal-title">Catalogue Details</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
</div>
<div class="modal-body">
  <h5 style="color:#000000"><i class="fa fa-file-text" aria-hidden="true"></i> Product Details</h5>
  <div class="row form-row step_1">
    <div class="col-4">
      <div class="form-group">
        <label class="text-dark">Category</label>
        <p class="c-detail"> <?php echo $category['category']; ?> </p>
      </div>
    </div>
    <div class="col-4">
      <div class="form-group">
        <label class="text-dark">Sub Category</label>
        <p class="c-detail"> <?php echo $subcategory['subcategory']; ?> </p>
      </div>
    </div>
    <div class="col-4"> <img src="./Product/<?=(!empty($product['cover_img']) ? $product['cover_img'] : "no-img.png"); ?>" class="img-fluid"> </div>
    <div class="col-4">
      <div class="form-group">
        <label class="text-dark">Product Name</label>
        <p class="c-detail"> <?php echo $product['product']; ?> </p>
      </div>
    </div>
    <div class="col-4">
      <div class="form-group">
        <label class="text-dark">Product Code</label>
        <p class="c-detail"> <?php echo $product['pr_code']; ?> </p>
      </div>
    </div>
    <div class="col-4">
      <div class="form-group">
        <label class="text-dark">Qty</label>
        <p class="c-detail"> <?php echo $product['tot_qty']; ?> </p>
      </div>
    </div>
  </div>
  <h5 style="color:#000000"><i class="fa fa-file-text" aria-hidden="true"></i> Rate Details</h5>
  <div class="row form-row step_1">
    <div class="col-md-4">
      <label class="text-dark"> Rate Chart</label>
    </div>
    <div class="col-md-8">
      <label class="text-dark"> Catalogue</label>
    </div>
    <div class="col-md-12">
      <div class="row">
        <div class="col-4">
          <div class="form-group border-bottom">
            <label class="text-danger">MRP</label>
          </div>
        </div>
        <div class="col-8 px-1">
          <div class="form-group">
            <p class="c-detail"> <?php echo $product['mrp_catl']; ?> </p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-4">
          <div class="form-group border-bottom">
            <label class="text-danger">Wholesaler</label>
          </div>
        </div>
        <div class="col-8 px-1">
          <div class="form-group">
            <p class="c-detail"> <?php echo $product['whol_catl']; ?> </p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-4">
          <div class="form-group border-bottom">
            <label class="text-danger">Semi Wholesaler</label>
          </div>
        </div>
        <div class="col-8 px-1">
          <div class="form-group">
            <p class="c-detail"> <?php echo $product['dist_catl']; ?> </p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-4">
          <div class="form-group border-bottom">
            <label class="text-danger">Retailer</label>
          </div>
        </div>
        <div class="col-8 px-1">
          <div class="form-group">
            <p class="c-detail"> <?php echo $product['ret_catl']; ?> </p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-4">
          <div class="form-group border-bottom">
            <label class="text-danger">Sub-Retailer</label>
          </div>
        </div>
        <div class="col-8 px-1">
          <div class="form-group">
            <p class="c-detail"> <?php echo $product['subret_catl']; ?> </p>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!---

    <table class="table table-bordered">

    <tr><td width="30%"><strong>Category</strong></td><td width="50%"><?php echo $category['category']; ?></td></tr>

    <tr><td><strong>Sub Category</strong></td><td><?php echo $subcategory['subcategory']; ?></td></tr>

    <tr><td><strong>Product Name</strong></td><td><?php echo $product['product']; ?></td></tr>

    <tr><td><strong>Product Code</strong></td><td><?php echo $product['pr_code']; ?></td></tr>

    <tr><td><strong>Qty</strong></td><td><?php echo $product['tot_qty']; ?></td></tr>

    <tr><td colspan="3">

    <table class="table table-bordered">

    <tr><th>Rate Chart</th><th>Catalogue</th><th>Individual</th></tr>

    <tr><th>MRP</th><th><?php echo $product['mrp_catl']; ?></th><th><?php echo $product['mrp_indv']; ?></th></tr>

    <tr><th>Wholesaler</th><th><?php echo $product['whol_catl']; ?></th><th><?php echo $product['whol_indv']; ?></th></tr>

    <tr><th>Semi Wholesaler</th><th><?php echo $product['dist_catl']; ?></th><th><?php echo $product['dist_indv']; ?></th></tr>

    <tr><th>Retailer</th><th><?php echo $product['ret_catl']; ?></th><th><?php echo $product['ret_indv']; ?></th></tr>

    <tr><th>Sub-Retailer</th><th><?php echo $product['subret_catl']; ?></th><th><?php echo $product['subret_indv']; ?></th></tr>

    </table>

    </td></tr>

    </table>-->

</div>

<?php

  }

  

  if ($_REQUEST['part'] == 'All_Customer_Data')

  {

      $requestData = $_REQUEST;

      if ($_REQUEST['from'] != '' && $_REQUEST['to'] != '')

      {

          $ff = explode('/', $_REQUEST['from']);

          $from = $ff[2] . '-' . $ff[1] . '-' . $ff[0];

          $tt = explode('/', $_REQUEST['to']);

          $to = $tt[2] . '-' . $tt[1] . '-' . $tt[0];

          $where .= " and STR_TO_DATE(`add_time`, '%d/%m/%Y') between '" . $from . "' and '" . $to . "'";

      }

      if ($_REQUEST['status'] != '')

      {

          $where .= " and status='" . $_REQUEST['status'] . "'";

      }

      if ($_REQUEST['user_type'] != '')

      {

          $where .= " and user_type='" . $_REQUEST['user_type'] . "'";

      }

      if ($_REQUEST['state'] != '')

      {

          $where .= " and state='" . $_REQUEST['state'] . "'";

      }

      if ($_REQUEST['city'] != '')

      {

          $where .= " and city='" . $_REQUEST['city'] . "'";

      }

      $sqls = "SELECT * FROM user_details where id!='' $where";

      $sql = "SELECT * FROM user_details where id!='' $where";

      $querys = mysqli_query($con,$sqls);

      $totalData = mysqli_num_rows($querys);

      $totalFiltered = $totalData;

      if (!empty($requestData['search']['value']))

      { // if there is a search parameter, $requestData['search']['value'] contains search parameter

          $sql .= " AND ( shop_name LIKE '%" . $requestData['search']['value'] . "%' ";

          $sql .= " OR name LIKE '%" . $requestData['search']['value'] . "%'";

          $sql .= " OR mobile LIKE '%" . $requestData['search']['value'] . "%'";

          $sql .= " OR email LIKE '%" . $requestData['search']['value'] . "%'";

          $sql .= " OR referral_code LIKE '%" . $requestData['search']['value'] . "%')";

      }

      $sql .= "  ORDER BY id desc  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";

      //echo $sql;

      $query = mysqli_query($con,$sql);

      //$totalFiltered = mysql_num_rows($query);

      $data = array();

      $i = 1;

      while ($row = mysqli_fetch_array($query))

      { // preparing an array

          $shopname = "<br><span class='badge badge-pill bg-primary inv-badge'>$row[shop_name]</span>";

          $action = "<input type='hidden' class='id' value=" . $row['id'] . ">

  <span style='white-space:nowrap;float: right;'>

  <a class='btn btn-sm bg-success-light viewLinks' href='javascript:void'><i class='fe fe-search'></i></a>&nbsp;

  <a class='btn btn-sm bg-success-light updateLinks' href='javascript:void'><i class='fe fe-pencil'></i></a>&nbsp;

  <a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></i></a></span>";

          if ($row[status] == 'Active')

          {

              $class = 'bg-success';

          }

          else

          {

              $class = 'bg-danger';

          }

          $user_type = Rate_Names($con,$row[user_type]);

          $team = Get_Fetch_Data($con,$row['employee'], 'name', 'admin_signup');

          $state = Get_Fetch_Data($con,$row['state'], 'All', 'state_details');

          $city = Get_Fetch_Data($con,$row['city'], 'All', 'city_details');

          $nestedData = array();

          $nestedData[] = "

      <div class='first'><b>$row[company]</b><br>

  <small>$row[name]</small><br>

  <small class=''>Mob. $row[mobile]</small><br>

                </div>";

          $nestedData[] = "<div class='first'>$user_type</div>";

  

          $nestedData[] = "<div class='first'><b>State :</b>$state[state_name]<br><b>City :</b>$city[city_name]</div>";

          $nestedData[] = "<div class='first'>$row[credit_limit]</div>";

          $nestedData[] = "<div class='first'>$team[name]</div>";

          $nestedData[] = "<div class='third'><span class='badge badge-pill $class inv-badge'>$row[status]</span>

      <div class='create_time'>$row[add_time]</div></div>";

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

  

  //Baner

  if ($_REQUEST['part'] == 'All_Banner_Data')

  {

      $requestData = $_REQUEST;

      if ($_REQUEST['from'] != '' && $_REQUEST['to'] != '')

      {

          $ff = explode('/', $_REQUEST['from']);

          $from = $ff[2] . '-' . $ff[1] . '-' . $ff[0];

          $tt = explode('/', $_REQUEST['to']);

          $to = $tt[2] . '-' . $tt[1] . '-' . $tt[0];

          $where .= " and STR_TO_DATE(`expiry`, '%d/%m/%Y') between '" . $from . "' and '" . $to . "'";

      }

      if ($_REQUEST['status'] != '')

      {

          $where .= " and status='" . $_REQUEST['status'] . "'";

      }

      $sqls = "SELECT * FROM banner_details where id!='' $where";

      $sql = "SELECT *,STR_TO_DATE(`expiry`, '%d/%m/%Y') as expirydate FROM banner_details where id!='' $where";

      $querys = mysqli_query($con,$sqls);

      $totalData = mysqli_num_rows($querys);

      $totalFiltered = $totalData;

      if (!empty($requestData['search']['value']))

      { // if there is a search parameter, $requestData['search']['value'] contains search parameter

          $sql .= " AND ( title LIKE '%" . $requestData['search']['value'] . "%' ";

          $sql .= " OR expiry LIKE '%" . $requestData['search']['value'] . "%'";

          $sql .= " OR types LIKE '%" . $requestData['search']['value'] . "%'";

          $sql .= " OR start_date LIKE '%" . $requestData['search']['value'] . "%'";

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

          $coupon = "<span class='badge badge-pill bg-primary inv-badge'>$row[coupon]</span><br>";

          $action = "<input type='hidden' class='id' value=" . $row['id'] . ">

  <span style='white-space:nowrap;float: right;'>

  <a class='btn btn-sm bg-success-light updateLinks' href='javascript:void'><i class='fe fe-pencil'></i></a>&nbsp;

  <a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></a></span>";

          if ($row[status] == 'Active')

          {

              $class = 'bg-success';

          }

          else

          {

              $class = 'bg-danger';

          }

          if ($row['expirydate'] >= date('Y-m-d'))

          {

              $Copstatus = "";

          }

          else

          {

              $Copstatus = "<br><span class='badge badge-pill bg-danger inv-badge'>Expired</span>";

          }

          if ($row['images'] != '')

          {

              $photo = "<a href='Banner/" . $row['images'] . "' data-lightbox='photos'><img src='Banner/" . $row['images'] . "'  style='height: 70px;

      width: 70px;

      border-color: aliceblue !important;

      padding: 1px;

      border: 1px solid;

      border-radius: 50%;

      box-shadow: 0px 0px 5px #ccc;'></a>";

          }

          else

          {

              $photo = "<img src='Banner/noimages.jpg'   style='height: 70px;

      width: 70px;

      border-color: aliceblue !important;

      padding: 1px;

      border: 1px solid;

      border-radius: 50%;

      box-shadow: 0px 0px 5px #ccc;'>";

          }

          $category = Get_Fetch_Data($con,$row['category'], 'All', 'category_details');

          $nestedData = array();

          $nestedData[] = "<div class='first'>$row[title]</div>";

          $nestedData[] = "$photo";

          $nestedData[] = "<div class='first'>$row[start_date]</div>";

          $nestedData[] = "<div class='third'>$row[expiry]$Copstatus</div>";

          $nestedData[] = "<div class='first'>$category[category]</div>";

          $nestedData[] = "<div class='third'><span class='badge badge-pill $class inv-badge'>$row[status]</span></div>";

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

  if ($_POST['part'] == 'Banner_data_Update')

  {

      $row = Get_Fetch_Data($con,$_POST['id'], 'All', 'banner_details');

  ?>

<div class="modal-header ">

  <h5 class="modal-title">Update Banner Details</h5>

  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>

</div>

<div class="modal-body">

  <form action="" method="post" enctype="multipart/form-data">

    <div class="row form-row">

      <?php if ($row['category'] != '')

        { ?>

      <div class="col-6">

        <div class="form-group">

          <label>Category</label>

          <select class="form-control" name="category">

            <option value="">Select</option>

            <?php

              $csql = mysqli_query($con,"select * from category_details where status='Active'");

              while ($crows = mysqli_fetch_array($csql))

              {

                  if ($row['category'] == $crows['id'])

                  {

                      echo "<option value=" . $crows['id'] . " selected>$crows[category]</option>";

                  }

                  else

                  {

                      echo "<option value=" . $crows['id'] . ">$crows[category]</option>";

                  }

              }

              ?>

          </select>

        </div>

      </div>

      <?php

        } ?>

      <div class="col-6">

        <div class="form-group">

          <label> Banner Title </label>

          <input type="text" class="form-control Capitalize" value="<?php echo $row['title']; ?>" name="title" required> 

        </div>

      </div>

      <div class="col-6">

        <div class="form-group">

          <label> Update Image <span style="font-size: 13px;color: #f71d1d;"> Size should be 480 X 285 px</span></label>

          <input type="file" class="form-control UploaderFile" name="images"> 

        </div>

      </div>

      <div class="col-6">

        <div class="form-group">

          <label> Start Date </label>

          <input type="text" class="form-control datepicker" value="<?php echo $row['start_date']; ?>" name="start_date" required> 

        </div>

      </div>

      <div class="col-6">

        <div class="form-group">

          <label> Expiry Date </label>

          <input type="text" class="form-control datepicker" value="<?php echo $row['expiry']; ?>" name="expiry" required> 

        </div>

      </div>

      <div class="col-6">

        <div class="form-group">

          <label>Status</label>

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

    <button class="btn btn-success" name="UpdateBanner">Update</button>

  </form>

</div>

<?php

  }

  if ($_REQUEST['part'] == 'Agent_Customer'){
$Datss=Get_Fetch_Data($con,$_REQUEST['agentid'],"Agent_Type","agent_details");
if($Datss['Agent_Type']=='Customer'){
$tablename='customer_details';	
} else {
$tablename='vendor_details';	
}
      $requestData = $_REQUEST;

     if ($_REQUEST['agentid'] != '')

      {

          $where .= " and Agentid='" . $_REQUEST['agentid'] . "'";

      }

      $sqls = "select * from $tablename where id!='' $where";

      $sql = "select * from $tablename where id!='' $where";

      $querys = mysqli_query($con,$sqls);

      $totalData = mysqli_num_rows($querys);

      $totalFiltered = $totalData;

      if (!empty($requestData['search']['value']))

      { // if there is a search parameter, $requestData['search']['value'] contains search parameter

          $sql .= " AND ( FName LIKE '%" . $requestData['search']['value'] . "%' ";

          $sql .= " OR Cname LIKE '%" . $requestData['search']['value'] . "%'";

          $sql .= " OR LName LIKE '%" . $requestData['search']['value'] . "%' )";

         

      }

      $sql .= "  ORDER BY id desc  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";

      //echo $sqls;

      $query = mysqli_query($con,$sql);

      //$totalFiltered = mysql_num_rows($query);

      $data = array();

      $i = 1;

      while ($row = mysqli_fetch_array($query))

      { // preparing an array

      $city=Get_Fetch_Data($con,$row["City"],"city_name","city_details");

      $commission=Get_Fetch_Data($con,$row["Agentid"],"commsion","agent_details");
if($Datss['Agent_Type']=='Customer'){
$totalsale=Vendor_Total_Sale($con,$row["id"]);
} else {
$totalsale=Supplier_Total_Sale($con,$row["id"]);	
}
      $ttsale=intval($totalsale);

      $comm=!empty($row["Agent_Commission"]) ? $row["Agent_Commission"] : $commission["commsion"];

      $tcommsion=$totalsale * $comm/100;

      

          $action = "<input type='hidden' class='id' value=" . $row['id'] . ">

  <span style='white-space:nowrap;float: right;'></span>";

           if ($row['status'] == 'Active')

          {

              $class = 'bg-success';

          }

          else

          {

              $class = 'bg-danger';

          }

          $nestedData = array();

          $nestedData[] = "<div class='first'>$row[Cname] ($row[FName] $row[LName])</div>";

          $nestedData[] = "<div class='first'>$city[city_name]</div>";

          $nestedData[] = "<div class='first'>$comm</div>";

          $nestedData[] = "<div class='first'>$ttsale</div>";

           $nestedData[] = "<div class='first'>$tcommsion</div>";

           

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

  

  if ($_REQUEST['part'] == 'All_Products_Data'){
$requestData = $_REQUEST;
if($_REQUEST['supplier']!=''){
$where.=" and supplier='".$_REQUEST['supplier']."'"; 
}
$sqls = "SELECT * FROM `product_details` where id!='' $where";
$sql = "SELECT * FROM `product_details` where id!='' $where";
$querys = mysqli_query($con,$sqls);
$totalData = mysqli_num_rows($querys);
$totalFiltered = $totalData;
if (!empty($requestData['search']['value']))
{ // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql .= " AND ( product LIKE '%" . $requestData['search']['value'] . "%' ";
$sql .= " OR hsn_code LIKE '%" . $requestData['search']['value'] . "%'";
$sql .= " OR status LIKE '%" . $requestData['search']['value'] . "%' )";
}
$sql .= " ORDER BY id desc LIMIT " . $requestData['start'] . " ," . $requestData['length'] . " ";
//echo $sqls;
$query = mysqli_query($con,$sql);
//$totalFiltered = mysql_num_rows($query);
$data = array();
$i = 1;
while ($row = mysqli_fetch_array($query))
{ // preparing an array
  if(Get_Role_Features($con,$Userrow['role'],'Products','Updates')=='on'){
  $Update="<a class='btn btn-sm bg-success-light updateLinks' href='javascript:void'><i class='fe fe-pencil'></i></a>";
}
if(Get_Role_Features($con,$Userrow['role'],'Products','Deletes')=='on'){
  $Delete="&nbsp;<a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></a>";
}
$action = "<input type='hidden' class='id' value=" . $row['id'] . ">
<span style='white-space:nowrap;float: right;'>$Update$Delete</span>";

 if ($row['status'] == 'Active')
{
$class = 'bg-success';
}
else
{
$class = 'bg-danger';
}
$unit=Get_Fetch_Data($con,$row['Unit'],"unit_name","unit_details");
$hsncode=Get_Fetch_Data($con,$row['hsn_code'],"hsncode","HsnList");
$nestedData = array();
$nestedData[] = "<div class='first'>$row[product]</div>";
$nestedData[] = "<div class='first'>$hsncode[hsncode]</div>";
$nestedData[] = "<div class='first'>$unit[unit_name]</div>";
$nestedData[] = "<span class='badge badge-pill $class inv-badge'>$row[status]</span>
<div style='font-size:9px;'>$row[add_time]</div>";
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


  if ($_REQUEST['part'] == 'All_Agent_Data'){

      $requestData = $_REQUEST;
	if($_REQUEST['Agent_Type']!=''){ $where.=" and Agent_Type='".$_REQUEST['Agent_Type']."'"; }
    if($_REQUEST['status']!=''){ $where.=" and status='".$_REQUEST['status']."'"; } 

      $sqls = "select * from agent_details where id!='' $where";

      $sql = "select * from agent_details where id!='' $where";

      $querys = mysqli_query($con,$sqls);

      $totalData = mysqli_num_rows($querys);

      $totalFiltered = $totalData;

      if (!empty($requestData['search']['value']))

      { // if there is a search parameter, $requestData['search']['value'] contains search parameter

          $sql .= " AND ( name LIKE '%" . $requestData['search']['value'] . "%' ";

          $sql .= " OR email LIKE '%" . $requestData['search']['value'] . "%'";

          $sql .= " OR mobile LIKE '%" . $requestData['search']['value'] . "%'";

          $sql .= " OR address LIKE '%" . $requestData['search']['value'] . "%'";

          $sql .= " OR efrom LIKE '%" . $requestData['search']['value'] . "%'";

          $sql .= " OR commsion LIKE '%" . $requestData['search']['value'] . "%'";

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
        if(Get_Role_Features($con,$Userrow['role'],'Agent','Shows')=='on'){
$view=" <a class='btn btn-sm bg-success-light' href='view_agent.php?id=$row[id]'><i class='fa fa-eye'></i></a>";
}
if(Get_Role_Features($con,$Userrow['role'],'Agent','Updates')=='on'){
$update="&nbsp;<a class='btn btn-sm bg-success-light updateLinks' href='javascript:void'><i class='fe fe-pencil'></i></a>";
}
if(Get_Role_Features($con,$Userrow['role'],'Agent','Deletes')=='on'){
$delete="&nbsp;<a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></a>";
}
          $action = "<input type='hidden' class='id' value=" . $row['id'] . ">

  <span style='white-space:nowrap;float: right;'>$view$update$delete</span>";

           if ($row['status'] == 'Active')

          {

              $class = 'bg-success';

          }

          else

          {

              $class = 'bg-danger';

          }
		  if($row['Agent_Type']=='Supplier'){
		  $Customers="<a href='vendors.php?agent=$row[id]'>".Get_Count_Data($con,$row['id'],'Agentid','vendor_details')."</a>";  
		  } if($row['Agent_Type']=='Customer'){
		  $Customers="<a href='allcustomers.php?agent=$row[id]'>".Get_Count_Data($con,$row['id'],'Agentid','customer_details')."</a>";  
		  }
          $nestedData = array();
		  
		  $nestedData[] = "<div class='first'>$row[BrokerCode]</div>";
		  $nestedData[] = "<div class='first'><b>$row[Company]</b></div><span class='nnmae'>$row[name]</span>";
          

          $nestedData[] = "<div class='first'>$row[mobile]</div>";
          $nestedData[] = "<div class='third'><span class='badge badge-pill $class inv-badge'>$row[status]</span>

        <div class='create_time'>$row[add_time]</div></div>";

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

if ($_REQUEST['part'] == 'All_Supplier_Data'){
  $requestData = $_REQUEST;
  if ($_REQUEST['area'] != '')
  {
  $where .= " and Area='" . $_REQUEST['area'] . "'";
  }
  if ($_REQUEST['Executive'] != '')
  {
  $where .= " and Executive='" . $_REQUEST['Executive'] . "'";
  }
  if ($_REQUEST['Deals'] != '')
  {
  $where .= " and Deals='" . $_REQUEST['Deals'] . "'";
  }
  if ($_REQUEST['supplier_type'] != '')
  {
  $where .= " and SupplierType='" . $_REQUEST['supplier_type'] . "'";
  }
  $sqls = "select * from supplier where id!='' $where";
  $sql = "select * from supplier where id!='' $where";
  $querys = mysqli_query($con,$sqls);
  $totalData = mysqli_num_rows($querys);
  $totalFiltered = $totalData;
  if (!empty($requestData['search']['value']))
  { // if there is a search parameter, $requestData['search']['value'] contains search parameter
  $sql .= " AND ( CName LIKE '%" . $requestData['search']['value'] . "%' ";
  $sql .= " OR Name LIKE '%" . $requestData['search']['value'] . "%'";
  $sql .= " OR GST LIKE '%" . $requestData['search']['value'] . "%'";
  $sql .= " OR PMobile LIKE '%" . $requestData['search']['value'] . "%'";
  $sql .= " OR Email LIKE '%" . $requestData['search']['value'] . "%'";
  $sql .= " OR Executive LIKE '%" . $requestData['search']['value'] . "%'";
  $sql .= " OR Status LIKE '%" . $requestData['search']['value'] . "%' )";
  }
  $sql .= " ORDER BY id desc LIMIT " . $requestData['start'] . " ," . $requestData['length'] . " ";
  //echo $sqls;
  $query = mysqli_query($con,$sql);
  //$totalFiltered = mysql_num_rows($query);
  $data = array();
  $i = 1;
  while ($row = mysqli_fetch_array($query))
  { // preparing an array
  $state=Get_Fetch_Data($con,$row["State"],"state_name","state_details");
  $city=Get_Fetch_Data($con,$row["City"],"city_name","city_details");
  $area=Get_Fetch_Data($con,$row["Area"],"area_name","area_details");
  
  $executive=Get_Fetch_Data($con,$row["Executive"],"name","admin_signup");

  $totalOrderByexe = total_supplier_order_by_executive($con,$row['id']);

  $suppliergroup=Get_Fetch_Data($con,$row["Supplier_Group"],"name","Supplier_group");
  if(Get_Role_Features($con,$Userrow['role'],'Supplier','Shows')=='on'){
  $view="<a class='btn btn-sm bg-success-light viewLinks' href='javascript:void'><i class='fe fe-search'></i></a>";
  }if(Get_Role_Features($con,$Userrow['role'],'Supplier','Updates')=='on'){
  $update="&nbsp;<a class='btn btn-sm bg-success-light ' href='update_supplier.php?id=$row[id]'><i class='fe fe-pencil'></i></a>";
  }if(Get_Role_Features($con,$Userrow['role'],'Supplier','Deletes')=='on'){
  $delete="&nbsp;<a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></a>";
  }
  $action = "<input type='hidden' class='id' value=".$row['id'].">
  <span style='white-space:nowrap;float: right;'>$view$update$delete</span>";
  if ($row['status'] == 'Active')
  {
  $class = 'bg-success';
  }
  else
  {
  $class = 'bg-success ';
  }
if($row['SupplierType']==2){$suppliertype="Grey Supplier";}else{$suppliertype="Normal Supplier";}
  $nestedData = array();
  $nestedData[] = "<div class='first'><input type='checkbox' name='print[]' value='$row[id]'></div>";
  $nestedData[] = "<div class='third'>$suppliergroup[name]</div>";
  $nestedData[] = "<div class='third'>$row[Supplier_Code]</div>";
  $nestedData[] = "<div class='third'><a href='Ledger.php?id=$row[id]'>$row[CName]</a></div>";
  $nestedData[] = "<div class='third'>$row[OMobile]</div>";
  $nestedData[] = "<div class='third'>$row[GST]</div>";
  $nestedData[] = "<div class='third'>$area[area_name]</div>";
  $nestedData[] = "<div class='third' style='white-space: nowrap;'>$state[state_name]</div>";
  $nestedData[] = "<div class='third' style='white-space: nowrap;'>$city[city_name]</div>";
  $nestedData[] = "<div class='third'>$executive[name]  <a href='javascript:void' class='executive_viewLinks'>$totalOrderByexe</a></div>";
  $nestedData[] = "<div class='third'><span class='badge badge-pill $class inv-badge'>$row[Status]</span></div>";

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

if ($_REQUEST['part'] == 'All_BilledSupplier_Data'){
  $startdate="01/".date("m/Y");
  $enddate="31/".date("m/Y");
$requestData = $_REQUEST;
if ($_REQUEST['area'] != '')
{
$where .= " and Area='" . $_REQUEST['area'] . "'";
}
if ($_REQUEST['Executive'] != '')
{
$where .= " and Executive='" . $_REQUEST['Executive'] . "'";
}
if ($_REQUEST['Deals'] != '')
{
$where .= " and Deals='" . $_REQUEST['Deals'] . "'";
}

$sqls = "select count(table1.id) as countss from supplier table1 LEFT JOIN GM_Invoice_Details table2 ON table1.id=table2.supplier where start_date <= '".$startdate."' AND end_date >= '".$enddate."' $where";

$sql = "select  table1.*,table2.finalamount,table2.InvoiceNo from supplier table1 LEFT JOIN GM_Invoice_Details table2 ON table1.id=table2.supplier where start_date <= '".$startdate."' AND end_date >= '".$enddate."' $where";
$querys = mysqli_query($con,$sqls);
$totalData = mysqli_num_rows($querys);
$totalFiltered = $totalData;
if (!empty($requestData['search']['value']))
{ // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql .= " AND ( table1.CName LIKE '%" . $requestData['search']['value'] . "%' ";
$sql .= " OR table1.Name LIKE '%" . $requestData['search']['value'] . "%'";
$sql .= " OR table1.GST LIKE '%" . $requestData['search']['value'] . "%'";
$sql .= " OR table1.PMobile LIKE '%" . $requestData['search']['value'] . "%'";
$sql .= " OR table1.Email LIKE '%" . $requestData['search']['value'] . "%'";
$sql .= " OR table1.Executive LIKE '%" . $requestData['search']['value'] . "%'";
$sql .= " OR table1.Status LIKE '%" . $requestData['search']['value'] . "%' )";
}
$sql .= " ORDER BY table2.id desc LIMIT " . $requestData['start'] . " ," . $requestData['length'] . " ";
//echo $sqls;
$query = mysqli_query($con,$sql);
//$totalFiltered = mysql_num_rows($query);
$data = array();
$i = 1;
while ($row = mysqli_fetch_array($query))
{ // preparing an array
$state=Get_Fetch_Data($con,$row["State"],"state_name","state_details");
$city=Get_Fetch_Data($con,$row["City"],"city_name","city_details");
$area=Get_Fetch_Data($con,$row["Area"],"area_name","area_details");
$executive=Get_Fetch_Data($con,$row["Executive"],"name","admin_signup");
$nestedData = array();
$nestedData[] = "<div class='third'>$row[Supplier_Code]</div>";
$nestedData[] = "<div class='third'><a href='Ledger.php?id=$row[id]'>$row[CName]</a></div>";
$nestedData[] = "<div class='third'>$row[GST]</div>";
$nestedData[] = "<div class='third'>$area[area_name]</div>";
$nestedData[] = "<div class='third' style='white-space: nowrap;'>$state[state_name]</div>";
$nestedData[] = "<div class='third' style='white-space: nowrap;'>$city[city_name]</div>";
$nestedData[] = "<div class='third'>$executive[name]</div>";
$nestedData[] = "<div class='third'>$row[InvoiceNo]</div>";
$nestedData[] = "<div class='third'>$row[finalamount]</div>";
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


  if ($_REQUEST['part'] == 'All_Buyers_Data'){
$requestData = $_REQUEST;
if ($_REQUEST['area'] != '')
{
$where .= " and Area='" . $_REQUEST['area'] . "'";
}
if ($_REQUEST['Executive'] != '')
{
$where .= " and Executive='" . $_REQUEST['Executive'] . "'";
}
if ($_REQUEST['Deals'] != '')
{
$where .= " and Deals='" . $_REQUEST['Deals'] . "'";
}
if ($_REQUEST['buyer_type'] != '')
{
$where .= " and Buyer_Type='" . $_REQUEST['buyer_type'] . "'";
}
$sqls = "select * from buyer_details where id!='' $where";
$sql = "select * from buyer_details where id!='' $where";
$querys = mysqli_query($con,$sqls);
$totalData = mysqli_num_rows($querys);
$totalFiltered = $totalData;
if (!empty($requestData['search']['value']))
{ // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql .= " AND ( CName LIKE '%" . $requestData['search']['value'] . "%' ";
$sql .= " OR Name LIKE '%" . $requestData['search']['value'] . "%'";
$sql .= " OR GST LIKE '%" . $requestData['search']['value'] . "%'";
$sql .= " OR PMobile LIKE '%" . $requestData['search']['value'] . "%'";
$sql .= " OR RCompany LIKE '%" . $requestData['search']['value'] . "%'";
$sql .= " OR RName LIKE '%" . $requestData['search']['value'] . "%'";
$sql .= " OR RGst LIKE '%" . $requestData['search']['value'] . "%'";
$sql .= " OR Address LIKE '%" . $requestData['search']['value'] . "%'";
$sql .= " OR RAddress LIKE '%" . $requestData['search']['value'] . "%'";
$sql .= " OR RPMobile LIKE '%" . $requestData['search']['value'] . "%'";
$sql .= " OR Executive LIKE '%" . $requestData['search']['value'] . "%'";
$sql .= " OR BuyerCode LIKE '%" . $requestData['search']['value'] . "%'";
$sql .= " OR Status LIKE '%" . $requestData['search']['value'] . "%' )";
}
$sql .= " ORDER BY id desc LIMIT " . $requestData['start'] . " ," . $requestData['length'] . " ";
//echo $sqls;
$query = mysqli_query($con,$sql);
//$totalFiltered = mysql_num_rows($query);
$data = array();
$i = 1;
while ($row = mysqli_fetch_array($query))
{ // preparing an array
$state=Get_Fetch_Data($con,$row["State"],"state_name","state_details");
$city=Get_Fetch_Data($con,$row["City"],"city_name","city_details");
$executive=Get_Fetch_Data($con,$row["Executive"],"name","admin_signup");
$totalOrderByexe = total_buyer_order_by_executive($con,$row['id']);
if(Get_Role_Features($con,$Userrow['role'],'Buyer','Shows')=='on'){
$view="<a class='btn btn-sm bg-success-light viewLinks' href='javascript:void'><i class='fe fe-search'></i></a>";
}if(Get_Role_Features($con,$Userrow['role'],'Buyer','Updates')=='on'){
$update="&nbsp;<a class='btn btn-sm bg-success-light ' href='update_Buyer.php?id=$row[id]'><i class='fe fe-pencil'></i></a>";
}if(Get_Role_Features($con,$Userrow['role'],'Buyer','Deletes')=='on'){
$delete="&nbsp;<a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></a>";
}

$action = "<input type='hidden' class='id' value=" . $row['id'] . ">
<span style='white-space:nowrap;float: right;'>$view$update$delete</span>";
if ($row['Status'] == 'Active')
{
$class = 'bg-success';
}
else
{
$class = 'bg-danger ';
}

$nestedData = array();
$nestedData[] = "<div class='first'><input type='checkbox' name='print[]' value='$row[id]'></div>";
$nestedData[] = "<div class='third'>$row[BuyerCode]</div>";
$nestedData[] = "<div class='third'><a href='customerledger.php?cid=$row[id]'>$row[CName]</a></div>";
$nestedData[] = "<div class='third'>$row[OMobile]</div>";
$nestedData[] = "<div class='third'>$row[GST]</div>";
$nestedData[] = "<div class='third'>$row[Name]</div>";
$nestedData[] = "<div class='third' style='white-space: nowrap;'>$city[city_name]</div>";
$nestedData[] = "<div class='third' style='white-space: nowrap;'>$state[state_name]</div>";
 $nestedData[] = "<div class='third'>$executive[name] <a href='javascript:void' class='executive_viewLinks'>$totalOrderByexe</a></div>";
$nestedData[] = "<div class='third'><span class='badge badge-pill $class inv-badge'>$row[Status]</span></div>";

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

if ($_REQUEST['part'] == 'allfollowupleads'){
$requestData = $_REQUEST;
if ($_REQUEST['from'] != '' && $_REQUEST['to'] != '')

      {

          $ff = explode('/', $_REQUEST['from']);

          $from = $ff[2] . '-' . $ff[1] . '-' . $ff[0];

          $tt = explode('/', $_REQUEST['to']);

          $to = $tt[2] . '-' . $tt[1] . '-' . $tt[0];

          $where .= " and STR_TO_DATE(`table2.FDate`, '%d/%m/%Y') between '" . $from . "' and '" . $to . "'";

      }
      if($_REQUEST['status']=="today"){
        $where .=" and STR_TO_DATE(`FDate`, '%d/%m/%Y')='".date('Y-m-d')."'";
      }
// $sqls = "select id,CName from supplier where id!='' and Status='Active' $where";
      $sqls = "select table1.id as supplierid,table1.CName,table2.* from supplier table1 LEFT JOIN Lead_Followup table2 ON table1.id=table2.Sid $where";
$sql = "select table1.id as supplierid,table1.CName,table2.* from supplier table1 LEFT JOIN Lead_Followup table2 ON table1.id=table2.Sid $where";
$querys = mysqli_query($con,$sqls);
$totalData = mysqli_num_rows($querys);
$totalFiltered = $totalData;
if (!empty($requestData['search']['value']))
{ // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql .= " AND ( table1.CName LIKE '%" . $requestData['search']['value'] . "%' ";
$sql .= " OR table1.Status LIKE '%" . $requestData['search']['value'] . "%' )";
}
$sql .= " ORDER BY table1.id desc LIMIT " . $requestData['start'] . " ," . $requestData['length'] . " ";
//echo $sqls;
$query = mysqli_query($con,$sql);
//$totalFiltered = mysql_num_rows($query);
$data = array();
$i = 1;
while ($row = mysqli_fetch_array($query))
{ // preparing an array
  //$ldetails=Get_Fetch_Fields($con,"Sid",$row['id'],"All","Lead_Followup");
$executive=Get_Fetch_Data($con,$row["Team"],"name","admin_signup");
$folloupstatus=Get_Fetch_Data($con,$row["LStatus"],"Name","LeadStatus");

$totqty = Get_SaleOrders_Qty($con,"qty","sid",$row['supplierid']);
$recqty = Get_SaleOrders_Qty($con,"Tot_qty","sid",$row['supplierid']);
$nestedData = array();
$pendingqty= $totqty - $recqty;
$nestedData[] = "<div class='third'><a href='addfollowup.php?id=$row[supplierid]'>$row[CName]</a><br>$folloupstatus[Name]</div>";
$nestedData[] = "<div class='third'>Tot Qty : $totqty <br> Pending Qty :  $pendingqty</div>";
$nestedData[] = "<div class='third'>$row[FDate]</div>";
$nestedData[] = "<div class='third'>$executive[name]</div>";
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

if ($_REQUEST['part'] == 'todayfollowupleads'){
$requestData = $_REQUEST;
if ($_REQUEST['from'] != '' && $_REQUEST['to'] != '')

      {

          $ff = explode('/', $_REQUEST['from']);

          $from = $ff[2] . '-' . $ff[1] . '-' . $ff[0];

          $tt = explode('/', $_REQUEST['to']);

          $to = $tt[2] . '-' . $tt[1] . '-' . $tt[0];

          $where .= " and STR_TO_DATE(FDate, '%d/%m/%Y') between '" . $from . "' and '" . $to . "'";

      }
      if($_REQUEST['status']=="today"){
        
        $where .=" and FDate='".date("d/m/Y")."'";

      }
  $sqls = "select * from Lead_Followup where id!=''  $where";
  $sql = "select * from Lead_Followup where id!=''  $where";
      
$querys = mysqli_query($con,$sqls);
$totalData = mysqli_num_rows($querys);
$totalFiltered = $totalData;
if (!empty($requestData['search']['value']))
{ // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql .= " AND ( FDate LIKE '%" . $requestData['search']['value'] . "%' ";
$sql .= " OR add_time LIKE '%" . $requestData['search']['value'] . "%' )";
}
$sql .= " ORDER BY id desc LIMIT " . $requestData['start'] . " ," . $requestData['length'] . " ";
//echo $sqls;
$query = mysqli_query($con,$sql);
//$totalFiltered = mysql_num_rows($query);
$data = array();
$i = 1;
while ($row = mysqli_fetch_array($query))
{ // preparing an array
  $sdetails=Get_Fetch_Fields($con,"id",$row['Sid'],"id,CName","supplier");
$executive=Get_Fetch_Data($con,$row["Team"],"name","admin_signup");
$folloupstatus=Get_Fetch_Data($con,$row["LStatus"],"Name","LeadStatus");

$totqty = Get_SaleOrders_Qty($con,"qty","sid",$row['Sid']);
$recqty = Get_SaleOrders_Qty($con,"Tot_qty","sid",$row['Sid']);
$nestedData = array();
$pendingqty= $totqty - $recqty;
$nestedData[] = "<div class='third'><a href='addfollowup.php?id=$sdetails[id]'>$sdetails[CName]</a><br>$folloupstatus[Name]</div>";
$nestedData[] = "<div class='third'>Tot Qty : $totqty <br> Pending Qty :  $pendingqty</div>";
$nestedData[] = "<div class='third'>$row[FDate]</div>";
$nestedData[] = "<div class='third'>$executive[name]</div>";
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
if ($_REQUEST['part'] == 'AllLeadremark'){
$requestData = $_REQUEST;
$sqls = "select * from Lead_Remark where id!='' and Sid='".$_REQUEST['supplier']."' $where";
$sql = "select * from Lead_Remark where id!='' and Sid='".$_REQUEST['supplier']."' $where";
$querys = mysqli_query($con,$sqls);
$totalData = mysqli_num_rows($querys);
$totalFiltered = $totalData;
if (!empty($requestData['search']['value']))
{ // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql .= " AND ( Remark LIKE '%" . $requestData['search']['value'] . "%' ";
$sql .= " OR add_time LIKE '%" . $requestData['search']['value'] . "%' )";
}
$sql .= " ORDER BY id desc LIMIT " . $requestData['start'] . " ," . $requestData['length'] . " ";
//echo $sqls;
$query = mysqli_query($con,$sql);
//$totalFiltered = mysql_num_rows($query);
$data = array();
$i = 1;
while ($row = mysqli_fetch_array($query))
{ // preparing an array

$nestedData = array();

$nestedData[] = "<div class='third'>$row[Remark]</div>";
$nestedData[] = "<div class='third'>$row[add_time]</div>";
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


if ($_POST['part'] == 'Buyer_data_View'){
  $row = Get_Fetch_Data($con,$_POST['id'], 'All', 'buyer_details');
  $state=Get_Fetch_Data($con,$row["State"],"state_name","state_details");
  $city=Get_Fetch_Data($con,$row["City"],"city_name","city_details");
  $state1=Get_Fetch_Data($con,$row["RState"],"state_name","state_details");
  $city1=Get_Fetch_Data($con,$row["RCity"],"city_name","city_details");
  $executive=Get_Fetch_Data($con,$row["Executive"],"name","admin_signup");
  ?>
  <div class="modal-header ">
    <h5 class="modal-title">Buyer Details</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
  </div>
  <div class="modal-body">
    <form method="post" action="" class="table-responsive">
    
	  <div class="col-sm-12 pl-0">  
      <fieldset style="min-height:50px;">
      <legend><b> Buyer Details </b> </legend>
      </fieldset>
      </div>
      <div class="row form-row step_1">
        <div class="col-4">
          <div class="form-group">
            <label class="text-dark">Buyer Code</label>
            <p class="c-detail">
              <?php echo $row['BuyerCode']; ?>
            </p>
          </div>
        </div>
        <div class="col-4">
          <div class="form-group">
            <label class="text-dark">
              <th>GST. Treatment</th>
            </label>
            <p class="c-detail">
              <?php echo $row['Buyer_Tpe']; ?>
            </p>
          </div>
        </div>

        <div class="col-4">
          <div class="form-group">
            <label class="text-dark">
              <th>GST No.</th>
            </label>
            <p class="c-detail">
              <?php echo $row['GST']; ?>
            </p>
          </div>
        </div>

        <div class="col-4">
          <div class="form-group">
            <label class="text-dark">Company Name</label>
            <p class="c-detail">
              <?php echo $row['CName']; ?>
            </p>
          </div>
        </div>
        <div class="col-4">
          <div class="form-group">
            <label class="text-dark">Name </label>
            <p class="c-detail">
              <?php echo $row['Name']; ?>
            </p>
          </div>
        </div>
        <div class="col-4">
          <div class="form-group">
            <label class="text-dark">Email
            </label>
            <p class="c-detail">
              <?php echo $row['Email']; ?>
            </p>
          </div>
        </div>
        <div class="col-6">
          <div class="form-group">
            <label class="text-dark">Firm Address</label>
            <p class="c-detail">
              <?php echo $row['Address']; ?>
            </p>
          </div>
        </div>
        <div class="col-6">
          <div class="form-group">
            <label class="text-dark">Billty Address</label>
            <p class="c-detail">
              <?php echo $row['billty_address']; ?>
            </p>
          </div>
        </div>
        <div class="col-4">
          <div class="form-group">
            <label class="text-dark">State
            </label>
            <p class="c-detail">
              <?php echo $state['state_name']; ?>
            </p>
          </div>
        </div>
        <div class="col-4">
          <div class="form-group">
            <label class="text-dark">City
            </label>
            <p class="c-detail">
              <?php echo $city['city_name']; ?>
            </p>
          </div>
        </div>
        <div class="col-4">
          <div class="form-group">
            <label class="text-dark">City/other 
            </label>
            <p class="c-detail">
              <?php echo $city['buyer_city_other']; ?>
            </p>
          </div>
        </div>

        <div class="col-4">
          <div class="form-group">
            <label class="text-dark">Pincode</label>
            <p class="c-detail">
              <?php echo $row['pincode']; ?>
            </p>
          </div>
        </div>
        <div class="col-4">
          <div class="form-group">
            <label class="text-dark">Type Of Buyer</label>
            <p class="c-detail">
              <?php echo $row['type_buyer']; ?>
            </p>
          </div>
        </div>


      </div>


	   <div class="col-sm-12 pl-0">  
      <fieldset style="min-height:50px;">
      <legend><b> Pay Details </b> </legend>
      </fieldset>
      </div>
      <div class="row form-row step_1" >
        <div class="col-4">
          <div class="form-group">
            <label class="text-dark">Payment Mode(in Days)</label>
            <p class="c-detail">
               <?php echo $row['credit_days']; ?>
            </p>
          </div>
        </div>
        <div class="col-4">
          <div class="form-group">
            <label class="text-dark">Credit Amount Limit</label>
            <p class="c-detail">
              <?php echo $row['credit_limit']; ?>
            </p>
          </div>
        </div>
        <div class="col-4">
          <div class="form-group">
            <label class="text-dark">Payment Mode</label>
            <p class="c-detail">
              <?php  
                echo $row['payment_mode'];
                 ?>
            </p>
          </div>
        </div>

        <div class="col-12">
         <div class="form-group row">
          <label class="text-dark">Buyer Contact Detail</label>
          <table class="table table-hover table-center mb-0 table-bordered">
          <?php   
          //echo "SELECT * FROM buyer_contact_detail WHERE buyer_id='".$row['id']."' && ctype='1' ";   
          $teamcquery = mysqli_query($con, "SELECT * FROM buyer_contact_detail WHERE buyer_id='".$row['id']."' && ctype='1' ");
          while($teamCRow=mysqli_fetch_array($teamcquery) ) {
            ?>
            <tr>
            <td> <?php echo $teamCRow['contact_name']?> </td>

            <td><?php echo $teamCRow['mobile_no']?></td>
            </tr>
            <?php  
          }
          ?>      
          </table>
        </div>
      </div>

      <div class="col-12">
         <div class="form-group row">
          <label class="text-dark">Accountant Contact Detail</label>
          <table class="table table-hover table-center mb-0 table-bordered">
          <?php      
          $teamcquery = mysqli_query($con, "SELECT * FROM buyer_contact_detail WHERE buyer_id='".$row['id']."' && ctype='2' ");
          while($teamCRow=mysqli_fetch_array($teamcquery) ) {
            ?>
            <tr>
            <td> <?php echo $teamCRow['contact_name']?> </td>

            <td><?php echo $teamCRow['mobile_no']?></td>
            </tr>
            <?php  
          }
          ?>      
          </table>
        </div>
      </div>

      <div class="col-12">
         <div class="form-group row">
          <label class="text-dark">Reference Contact Detail</label>
          <table class="table table-hover table-center mb-0 table-bordered">
          <?php      
          $teamcquery = mysqli_query($con, "SELECT * FROM buyer_contact_detail WHERE buyer_id='".$row['id']."' && ctype='3' ");
          while($teamCRow=mysqli_fetch_array($teamcquery) ) {
            ?>
            <tr>
            <td> <?php echo $teamCRow['company_name']?> </td>  

            <td> <?php echo $teamCRow['contact_name']?> </td>

            <td><?php echo $teamCRow['mobile_no']?></td>
            </tr>
            <?php  
          }
          ?>      
          </table>
        </div>
      </div>

      </div>

    
	  <div class="col-sm-12 pl-0">  
      <fieldset style="min-height:50px;">
      <legend><b> Admin Details </b> </legend>
      </fieldset>
      </div>
      <div class="row form-row step_1" >
        <div class="col-4">
          <div class="form-group">
            <label class="text-dark">Assign Executive</label>
            <p class="c-detail">
              <?php echo $executive['name']; ?>
            </p>
          </div>
        </div>
        <div class="col-4">
          <div class="form-group">
            <label class="text-dark">Status</label>
            <p class="c-detail">
              <?php echo $row['Status']?>
            </p>
          </div>
        </div>
        
      </div>
      
    </form>
  </div>
<?php
}
if ($_POST['part'] == 'Buyer_data_Update'){
$row = Get_Fetch_Data($con,$_POST['id'], 'All', 'buyer_details');
?>
<div class="modal-header ">
  <h5 class="modal-title">Update Buyer Details</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
</div>
<div class="modal-body">
  <form action="" method="post" enctype="multipart/form-data">
    <div class="row form-row step_1">
      <div class="col-6">
        <div class="form-group">
          <label> Buyer Type <span class="text-danger">*</span></label>
          <input class="form-check-input" type="radio" name="Buyer_Tpe" id="" value="Registered" <?php if($row['Buyer_Tpe']=="Registered"){echo "checked";}?>> <label for="ctype">&nbsp;Registered</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input class="form-check-input" type="radio" name="Buyer_Tpe" id=" " value="UnRegistered" <?php if($row['Buyer_Tpe']=="UnRegistered"){echo "checked";}?>> <label for="ctype_2">&nbsp;UnRegistered</label>
        </div>
      </div>
      <div class="col-4">
        <div class="form-group">
          <label>Buyer Code</label>
           <input type="text" class="form-control"   placeholder="Buyer Code  " value="<?php echo $row['BuyerCode'];?>"  readonly required> 
        </div>
      </div>
      <div class="col-4">
        <div class="form-group">
          <label>Company Name</label>
           <input type="text" class="form-control" id="CName"  placeholder="Company Name  " name="CName" value="<?php echo $row['CName'];?>" required> 
        </div>
      </div>
      <div class="col-4">
        <div class="form-group">
          <label>Name<span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="Name"  placeholder="Enter Name" name="Name" value="<?php echo $row['Name'];?>"  required>
        </div>
      </div>
      <div class="col-4">
        <div class="form-group">
          <label>GST No<span class="text-danger">*</span></label>
          <input type="text" class="form-control"    placeholder="GST No. " name="GST" value="<?php echo $row['GST'];?>"  maxlength="15" minlength="15"> 
        </div>
      </div>
      <div class="col-4">
        <div class="form-group">
          <label>Address</label>
          <textarea type="text" class="form-control"    placeholder="Address " name="Address"  ><?php echo $row['Address'];?></textarea> 
        </div>
      </div>
     
      
    
      <div class="col-4">
        <div class="form-group">
          <label>State</label>
          <select class="form-control custom-select state select2" name="State" id="statess">
            <option value="">Select State</option>
            <?php
              $Esql=mysqli_query($con,"select * from state_details where status='Active'");
              
              while($Erow=mysqli_fetch_array($Esql)){
                if($row['State']==$Erow['id']){
              echo "<option value=".$Erow['id']." selected>$Erow[state_name]</option>"; 
              }else{
                echo "<option value=".$Erow['id']." >$Erow[state_name]</option>";
              }
              }
              
              ?>                   
          </select>
        </div>
      </div>
      <div class="col-4">
        <div class="form-group">
          <label>City</label>
          <select class="form-control custom-select state select2" name="City" id="cityss">
          <?php 
            $citys=mysqli_query($con,"select * from city_details where state='".$row['State']."'");
            while($Erow=mysqli_fetch_array($citys)){
              if($row['City']==$Erow['id']){
                echo "<option value=".$Erow['id']." selected>$Erow[city_name]</option>"; 
              }else{
                echo "<option value=".$Erow['id'].">$Erow[city_name]</option>"; 
              }
            }
            ?>
          </select>
        </div>
      </div>
      <div class="col-4">
        <div class="form-group">
          <label>Mobile No.</label>
          <input type="text" class="form-control" id="PMobile" placeholder="Mobile No.1" pattern="[6-9]{1}[0-9]{9}" minlength="10" maxlength="10" onkeypress="return /[0-9]/i.test(event.key)" value="<?php echo $row['PMobile'];?>" readonly required> 
        </div>
      </div>
      <div class="col-4">
        <div class="form-group">
          <label>Alternate Mobile </label>
           <input type="text" class="form-control" id="LName" placeholder="Mobile No.2" name="AMobile" pattern="[6-9]{1}[0-9]{9}" minlength="10" maxlength="10" value="<?php echo $row['AMobile'];?>" onkeypress="return /[0-9]/i.test(event.key)">
        </div>
      </div>
    </div>
     <h5 style="color:#000000"><i class="fa fa-file-text" aria-hidden="true"></i> Referred By </h5>

      <div class="row form-row step_1">
      
      <div class="col-4">
        <div class="form-group">
          <label>Company Name</label>
           <input type="text" class="form-control" id="CName"  placeholder="Company Name  " name="RCompany" value="<?php echo $row['RCompany'];?>"   required> 
        </div>
      </div>
      <div class="col-4">
        <div class="form-group">
          <label>Name<span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="Name"  placeholder="Enter Name" name="RName" value="<?php echo $row['RName'];?>"   required>
        </div>
      </div>
      <div class="col-4">
        <div class="form-group">
          <label>GST No<span class="text-danger">*</span></label>
          <input type="text" class="form-control"    placeholder="GST No. " name="RGst" value="<?php echo $row['RGst'];?>"  maxlength="15" minlength="15"> 
        </div>
      </div>
      <div class="col-4">
        <div class="form-group">
          <label>Address</label>
          <textarea type="text" class="form-control"    placeholder="Address " name="Address"  ><?php echo $row['RAddress'];?></textarea> 
        </div>
      </div>
     
      
    
      <div class="col-4">
        <div class="form-group">
          <label>State</label>
          <select class="form-control custom-select state select2" name="RState" id="statess">
            <option value="">Select State</option>
            <?php
              $Esql1=mysqli_query($con,"select * from state_details where status='Active'");
              
              while($Erow=mysqli_fetch_array($Esql1)){
                if($row['RState']==$Erow['id']){
              echo "<option value=".$Erow['id']." selected>$Erow[state_name]</option>"; 
              }else{
                echo "<option value=".$Erow['id']." >$Erow[state_name]</option>";
              }
              }
              
              ?>                   
          </select>
        </div>
      </div>
      <div class="col-4">
        <div class="form-group">
          <label>City</label>
          <select class="form-control custom-select state select2" name="RCity" id="cityss">
          <?php 
            $cityss=mysqli_query($con,"select * from city_details where state='".$row['RState']."'");
            while($Erow=mysqli_fetch_array($cityss)){
              if($row['RCity']==$Erow['id']){
                echo "<option value=".$Erow['id']." selected>$Erow[city_name]</option>"; 
              }else{
                echo "<option value=".$Erow['id'].">$Erow[city_name]</option>"; 
              }
            }
            ?>
          </select>
        </div>
      </div>
      <div class="col-4">
        <div class="form-group">
          <label>Mobile No.</label>
          <input type="text" class="form-control" id="RPMobile" placeholder="Mobile No.1" name="RPMobile" pattern="[6-9]{1}[0-9]{9}" minlength="10" maxlength="10" onkeypress="return /[0-9]/i.test(event.key)" value="<?php echo $row['RPMobile'];?>" required> 
        </div>
      </div>
      <div class="col-4">
        <div class="form-group">
          <label>Alternate Mobile </label>
           <input type="text" class="form-control" id="LName" placeholder="Mobile No.2" name="RAMobile" pattern="[6-9]{1}[0-9]{9}" minlength="10" maxlength="10" value="<?php echo $row['RAMobile'];?>" onkeypress="return /[0-9]/i.test(event.key)">
        </div>
      </div>

      
    </div>
<h5 style="color:#000000"><i class="fa fa-file-text" aria-hidden="true"></i> Admin Part</h5>
<div class="row form-row step_1">
      
      <div class="col-4">
        <div class="form-group">
          <label>Assign Executive</label>
           
           <select class="form-control" name="Executive" required>
                      <option value="">Select Executive</option>
                      <?php
                        $executive=mysqli_query($con,"select * from admin_signup where status='Active' and role='5'");
                              while($Erow=mysqli_fetch_array($executive)){
                                if($row['Executive']==$Erow['id']){
                                echo "<option value=".$Erow['id']." selected>$Erow[name]</option>"; 
                              }else{
                                echo "<option value=".$Erow['id'].">$Erow[name]</option>"; 
                              }
                              }
                              
                              ?>  
                    </select>
        </div>
      </div>

       <div class="col-4">
        <div class="form-group">
          <label>Status</label>
           <select class="form-control" name="Status" required>
              <option value="">Select Status</option>
              <option value="Active" <?php if($row['Status']=="Active"){echo "selected";}?>>Active</option>
              <option value="InActive" <?php if($row['Status']=="InActive"){echo "selected";}?>>InActive</option>
            </select>
        </div>
      </div>

      </div>
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    <input type="hidden" name="random_move" value="<?php echo $_SESSION['random_move']; ?>">
    <button class="btn btn-success float-right mr-3" name="updatebuyer">Update</button>
  </form>
</div>
<?php
}

  if ($_REQUEST['part'] == 'All_Transport_Data'){
      $requestData = $_REQUEST;
      $sqls = "select * from transport_details";
      $sql = "select * from transport_details";
      $querys = mysqli_query($con,$sqls);
      $totalData = mysqli_num_rows($querys);
      $totalFiltered = $totalData;
      if (!empty($requestData['search']['value']))
      { // if there is a search parameter, $requestData['search']['value'] contains search parameter

          $sql .= " AND ( transport LIKE '%" . $requestData['search']['value'] . "%' ";

          $sql .= " OR owner LIKE '%" . $requestData['search']['value'] . "%'";

          $sql .= " OR mobile LIKE '%" . $requestData['search']['value'] . "%'";

          $sql .= " OR address LIKE '%" . $requestData['search']['value'] . "%'";

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
if(Get_Role_Features($con,$Userrow['role'],'Transport','Updates')=='on'){
$Update="<a class='btn btn-sm bg-success-light updateLinks' href='javascript:void'><i class='fe fe-pencil'></i></a>";
}
if(Get_Role_Features($con,$Userrow['role'],'Transport','Deletes')=='on'){
$Delete="&nbsp;<a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></a>";
}
          $action = "<input type='hidden' class='id' value=" . $row['id'] . ">

  <span style='white-space:nowrap;float: right;'>$Update$Delete</span>";

           if ($row['status'] == 'Active')

          {

              $class = 'bg-success';

          }

          else

          {

              $class = 'bg-danger';

          }

          $nestedData = array();

          $nestedData[] = "<div class='first'>$row[transport]</div>";

          $nestedData[] = "<div class='first'>$row[owner]</div>";

          $nestedData[] = "<div class='first'>$row[mobile]</div>";

          $nestedData[] = "<div class='first'>$row[address]</div>";

          $nestedData[] = "<div class='third'><span class='badge badge-pill $class inv-badge'>$row[status]</span>

        <!---<div class='create_time'>$row[add_time]</div>---></div>";

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

  if ($_REQUEST['part'] == 'All_Member_Data'){

      $requestData = $_REQUEST;

      if ($_REQUEST['role'] != '')

      {

          $where .= " and ads.role='" . $_REQUEST['role'] . "'";

      }

      if ($_REQUEST['status'] != '')

      {

          $where .= " and ads.status='" . $_REQUEST['status'] . "'";

      }

      if ($_REQUEST['state'] != '')

      {

          $where .= " and ads.state='" . $_REQUEST['state'] . "'";

      }

      if ($_REQUEST['city'] != '')

      {

          $where .= " and ads.city='" . $_REQUEST['city'] . "'";

      }

      $sqls = "SELECT ads.* FROM admin_signup ads LEFT JOIN user_details uds on ads.id=uds.employee where level!='1' $where";

      $sql = "SELECT ads.* FROM admin_signup ads LEFT JOIN user_details uds on ads.id=uds.employee where level!='1'  $where";

      $querys = mysqli_query($con,$sqls);

      $totalData = mysqli_num_rows($querys);

      $totalFiltered = $totalData;

      if (!empty($requestData['search']['value']))

      { // if there is a search parameter, $requestData['search']['value'] contains search parameter

          $sql .= " AND ( ads.name LIKE '%" . $requestData['search']['value'] . "%' ";

          $sql .= " OR ads.mobile LIKE '%" . $requestData['search']['value'] . "%'";

          $sql .= " OR uds.company LIKE '%" . $requestData['search']['value'] . "%'";

          $sql .= " OR ads.mobile LIKE '%" . $requestData['search']['value'] . "%'";

          $sql .= " OR uds.name LIKE '%" . $requestData['search']['value'] . "%'";

          $sql .= " OR ads.status LIKE '%" . $requestData['search']['value'] . "%' )";

      }

      $sql .= "  ORDER BY ads.id desc  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";

      //echo $sqls;

      $query = mysqli_query($con,$sql);

      //$totalFiltered = mysql_num_rows($query);

      $data = array();

      $i = 1;

      while ($row = mysqli_fetch_array($query))

      { // preparing an array

          $action = "<input type='hidden' class='id' value=" . $row['id'] . ">

  <span style='white-space:nowrap;float: right;'>

  <a class='btn btn-sm bg-success-light updateLinks' href='javascript:void'><i class='fe fe-pencil'></i></a>&nbsp;

  <a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></a></span>";

          if ($row[status] == 'Active')

          {

              $class = 'bg-success';

          }

          else

          {

              $class = 'bg-danger';

          }

          if ($row['photo'] != '')

          {

              $photo = "<a href='Banner/" . $row['photo'] . "' target='_blank'><img src='Banner/" . $row['photo'] . "' height='50' width='50' style='border-radius: 50%;'></a>";

          }

          else

          {

              $photo = "<img src='Banner/noimages.jpg' height='40' style='border-radius: 12px;'>";

          }

          $role = Get_Fetch_Data($con,$row['role'], 'All', 'role_details');

          $state = Get_Fetch_Data($con,$row['state'], 'All', 'state_details');

          $city = Get_Fetch_Data($con,$row['city'], 'All', 'city_details');

          $User = Get_Fetch_Data_fiedls($con,$row['id'], 'employee', 'company', 'user_details');

          if ($User['company'] != '')

          {

              $CustomerName = "<br><span class='badge badge-pill bg-primary inv-badge'>$User[company]</span>";

          }

          else

          {

              $CustomerName = "";

          }

          $Rate_Names = Rate_Names($row[rates]);

          $nestedData = array();

          $nestedData[] = "<div class='first'>$row[name]$CustomerName</div>";

          $nestedData[] = "<div class='first'>$row[mobile]</div>";

          $nestedData[] = "<div class='first'>$row[designation]</div>";

          $nestedData[] = "<div class='first'>State :$state[state_name]<br>City :$city[city_name]</div>";

          $nestedData[] = "<div class='first'>$Rate_Names</div>";

          $nestedData[] = "<div class='first'><span class='badge badge-pill bg-primary inv-badge'>$role[role_name]</span></div>";

          $nestedData[] = "$photo";

          $nestedData[] = "<div class='third'><span class='badge badge-pill $class inv-badge'>$row[status]</span>

      <div class='create_time'>$row[create_time]</div></div>";

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
if ($_POST['part'] == 'Stock_View_Logs'){
$row = Get_Fetch_Data($con,$_POST['id'], 'All', 'product_details');
$hsncode = Get_Fetch_Data($con,$row['hsn_code'], 'hsncode', 'HsnList');
$Stocks=product_stock($con,$row['id']);
?>
<div class="modal-header ">
<h5 class="modal-title">Total Stock : <?=$Stocks;?></h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
</div>
<div class="modal-body">
<div class="row form-row">
<div class="col-md-4 col-sm-12">
<label> Product</label>
<div class="form-group">
<?=$row['product'];?>
</div>
</div>
<div class="col-md-4 col-sm-12">
<label> Barcode</label>
<div class="form-group">
<?=$row['barcode'];?>
</div>
</div>
<div class="col-md-4 col-sm-12">
<label> HSN</label>
<div class="form-group">
<?=$hsncode['hsncode'];?>
</div>
</div>
<div class="col-sm-12">
<table class="table table-bordered">
<tr><th>Type</th><th>Date</th><th>Qty</th></tr>
<?php
$Sqls=mysqli_query($con,"SELECT concat('ch',id) as ids,'Challan' as types,qty,(select order_date from challan_details where id=ci.oid) as dates FROM `challan_items` ci WHERE pid='".$row['id']."' UNION SELECT concat('vo',id) as ids,'Voucher' as types,qty,(select order_date from voucher_details where id=vi.oid) as dates FROM `voucher_items` vi WHERE pid='".$row['id']."' and vstatus='Open' UNION SELECT concat('in',id) as ids,'Invoice' as types,qty,(select order_date from invoice_details where id=iil.oid) as dates FROM `invoice_item_list` iil WHERE pid='".$row['id']."' order by str_to_date(dates,'%d/%m/%Y')");
while($Rows=mysqli_fetch_array($Sqls)){
if($Rows[types]=='Challan'){ $Quantity="+"; $colors="#45b64c"; }
if($Rows[types]=='Voucher'){ $Quantity="+"; $colors="#45b64c"; }
if($Rows[types]=='Invoice'){ $Quantity="-"; $colors="#ec3131"; }
echo "<tr style='color: $colors;'><td>$Rows[types]</td><td>$Quantity $Rows[qty]</td><td>$Rows[dates]</td></tr>";	
}
?>
</table>
</div>
</div>
</div>
<?php
}
if ($_POST['part'] == 'Product_data_Update'){
$row = Get_Fetch_Data($con,$_POST['id'], 'All', 'product_details');
?>
<div class="modal-header ">
  <h5 class="modal-title">Update Products Details</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
</div>
<div class="modal-body">
  <form method="post" action="" enctype="multipart/form-data">
    <div class="row form-row">
      <div class="col-md-12 col-sm-12">
        <div class="form-group">
          <label> Item  Name</label>
          <input type="text" class="form-control" name="product" value="<?php echo $row['product'];?>"  required>
        </div>
      </div>
      <div class="col-md-12 col-sm-12">
        <div class="form-group">
          <label> HSN CODE</label>
          <select class="form-control" name="hsncode">
            <option value="">Select HSN Code</option>
            <?php 
            $Hsql=mysqli_query($con,"SELECT * FROM HsnList where status='Active'");
            while($Brows=mysqli_fetch_array($Hsql)){
              if($row['hsn_code']==$Brows['id']){
              echo "<option value=" .$Brows['id']. " selected>$Brows[hsncode]</option>";
            }else{
              echo "<option value=" .$Brows['id']. ">$Brows[hsncode]</option>";
            }
          }
            ?>
          </select>
        </div>
      </div>
      <div class="col-12 col-sm-12">
              <div class="form-group">
                <label>Unit of Measure</label>
          <select class="form-control" name="unit">
            <option value="">Select Measure</option>
            <?php 
            $Msql=mysqli_query($con,"SELECT * FROM unit_details where status='Active'");
            while($Brows=mysqli_fetch_array($Msql)){
              if($row['Unit']==$Brows['id']){
              echo "<option value=" .$Brows['id']. " selected>$Brows[unit_name]</option>";
            }else{
               echo "<option value=" .$Brows['id']. ">$Brows[unit_name]</option>";
            }
            }
            ?>
          </select>
              </div>
            </div>
      <div class="col-md-12">
        <div class="form-group">
          <label>Status</label>
          <select class="form-control" name="status" required>
            <option value="Active" <?php if($row['status']=="Active"){echo "selected";}?>>Active</option>
            <option value="Inactive" <?php if($row['status']=="Inactive"){echo "selected";}?>>Inactive</option>
          </select>
        </div>
      </div>
    </div>
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    <input type="hidden" name="random_move" value="<?php echo $_SESSION['random_move']; ?>">
    <button class="btn btn-dark " name="Updateproduct">Update</button>
  </form>
</div>
<?php
}
if ($_POST['part'] == 'Agent_data_Update'){
$row = Get_Fetch_Data($con,$_POST['id'], 'All', 'agent_details');
  ?>

<div class="modal-header ">

  <h5 class="modal-title">Update Agent Details</h5>

  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>

</div>

<div class="modal-body">

  <form action="" method="post" enctype="multipart/form-data">
<div class="col-sm-12 pl-0">  
      <fieldset style="min-height:50px;">
      <legend><b> Personal Details </b> </legend>
      </fieldset>
      </div>
 <div class="row form-row step_1">

              <div class="col-4">
              <div class="form-group">
                <label>Agent Code<span class="text-danger">*</span></label>

                <input type="text" class="form-control" value="<?php echo $row["BrokerCode"];?>" id="SupplierCodee"  placeholder="Enter Code" name="acode" readonly>
                <p><span id="validatesuppliercodee" style="color: green;"></span></p>

              </div>

            </div>

             <div class="col-4">

              <div class="form-group">

                <label>Agent Name<span class="text-danger">*</span></label>

                <input type="text" class="form-control Capitalize" value="<?php echo $row["Broker"];?>"  placeholder="Enter Name"  required>

              </div>

            </div>
            <div class="col-4">
              <div class="form-group">
                <label>GST. Treatment</label>
                <select class="custom-select form-control" id="GstType" name="GstType" required>
              <option value="1" <?php if($row['GstType']=="1"){echo "selected";}?>>Registered</option>
              <option value="2" <?php if($row['GstType']=="2"){echo "selected";}?>>Unregistered</option>
              </select>
              </div>
            </div>

              <div class="col-4">
              <div class="form-group">
                <label>GSTIN No</label>
                <input type="text" class="form-control" placeholder="Enter GST" name="gst" value="<?php echo $row["GSTIN"];?>">
              </div>
            </div>
            <div class="col-4">
              <div class="form-group">
                <label>PAN No.</label>
                <input type="text" class="form-control " name="pan_no" placeholder="Pan No" id="panno" maxlength="10" value="<?php echo $row["PanNo"];?>">
              </div>
            </div>
            <div class="col-4">

              <div class="form-group">

                <label>Company Name</label>

                <input type="text" class="form-control" placeholder="Enter company" name="company" value="<?php echo $row["Company"];?>">

              </div>

            </div>

             <div class="col-4">

              <div class="form-group">

                <label>Comm Rate %</label>

                <input type="text" class="form-control numval" placeholder="Enter commission" value="<?php echo $row["commsion"];?>"  name="commission">

              </div>

            </div>
<div class="col-4">
              <div class="form-group">
                <label>Mobile<span class="text-danger">*</span></label>
                <input type="text" class="form-control" placeholder="Enter Mobile No" value="<?php echo $row["mobile"];?>" name="mobile" onkeypress='return /[0-9]/i.test(event.key)' maxlength="10" minlength="10" required>
              </div>
            </div>
            
            <div class="col-4">
              <div class="form-group">
                <label>Email<span class="text-danger">*</span></label>
                <input type="email" class="form-control" placeholder="Enter Email id" value="<?php echo $row["email"];?>" name="email" >
              </div>
            </div>
            

             <div class="col-6">
              <div class="form-group">
                <label>Address</label>
                <textarea class="form-control Capitalize" placeholder="Enter Address" value="" name="address"><?php echo $row["Address"];?></textarea>
              </div>
            </div>
            
            
			</div>

		
<div class="col-sm-12 pl-0">  
      <fieldset style="min-height:50px;">
      <legend><b> Accounts  Details </b> </legend>
      </fieldset>
      </div>
		<div class="row form-row step_1">

            <div class="col-4">

              <div class="form-group">

                <label>Bank </label>

                <input type="text" class="form-control" placeholder="Enter Bank Name" name="bank" value="<?php echo $row["BankName"];?>">

              </div>

            </div>

			 <div class="col-4">

              <div class="form-group">

                <label>Acc No</label>

                <input type="text" class="form-control" placeholder="Enter Acc No" name="accno" value="<?php echo $row["Account"];?>">

              </div>

            </div>

            <div class="col-4">

              <div class="form-group">

                <label>Branch</label>

                <input type="text" class="form-control" placeholder="Enter Branch" name="branch" value="<?php echo $row["Branch"];?>">

              </div>

            </div>

             <div class="col-4">

              <div class="form-group">

                <label>IFSC Code</label>

                <input type="text" class="form-control" placeholder="Enter IFSC Code" name="ifsc" value="<?php echo $row["Ifsc"];?>">

              </div>

            </div>

             

            

             <div class="col-4">

              <div class="form-group">

                <label>Remark</label>

                <input type="text" class="form-control" placeholder="Enter Remark" name="Remark" value="<?php echo $row["Reamrk"];?>">

              </div>

            </div>

           <div class="col-4">

              <div class="form-group">

                <label>Status</label>

               

              <select name="status" class="form-control Capitalize" required>

                    <option value="">Select Status</option>

                    <option value="Active" <?php if($row['status']=="Active"){echo "selected";}?>>Active</option>

                    <option value="In-Active" <?php if($row['status']=="In-Active"){echo "selected";}?>>In-Active</option>

                </select>

              </div>

            </div>
			
           <div class="col-md-12">
		   <hr>
		   <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

    <input type="hidden" name="random_move" value="<?php echo $_SESSION['random_move']; ?>">

    <button class="btn btn-dark " name="Updateagent" id="saveuss">Update</button>
		   </div> 

          </div>

			

   

    

  </form>

</div>

<?php

  }

if ($_POST['part'] == 'Transport_data_Update'){
$row = Get_Fetch_Data($con,$_POST['id'], 'All', 'transport_details');
?>

<div class="modal-header ">

  <h5 class="modal-title">Update Transport Details</h5>

  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>

</div>

<div class="modal-body">

  <form action="" method="post" enctype="multipart/form-data">


<div class="col-sm-12 pl-0">  
      <fieldset style="min-height:50px;">
      <legend><b> Basic Details </b> </legend>
      </fieldset>
      </div>
    <div class="row form-row step_1">
      <div class="col-6">
        <div class="form-group">
          <label> Transport Name <span class="text-danger">*</span></label>
          <input type="text" class="form-control" value="<?php echo $row['transport']; ?>" name="name" required> 
        </div>
      </div>

        <div class="col-4">
              <div class="form-group">
                <label>Owner Name</label>
                <input type="text" class="form-control" placeholder="Enter Owner Name" value="<?php echo $row['owner']; ?>" name="oname">
              </div>
            </div>

      <div class="col-4">
        <div class="form-group">
          <label>Mobile No<span class="text-danger">*</span></label>
          <input type="text" class="form-control" value="<?php echo $row['mobile']; ?>" name="mobile" onkeypress='return /[0-9]/i.test(event.key)' maxlength="10" minlength="10" required> 
        </div>
      </div>

      
<div class="col-4">
              <div class="form-group">
                <label>Alternate Mobile No</label>
                <input type="text" class="form-control" placeholder="Enter Mobile No" name="mobile1" onkeypress='return /[0-9]/i.test(event.key)' maxlength="10" minlength="10" value=" <?php echo $row['mobile2']; ?>" required>
              </div>
            </div>
            <div class="col-4">
              <div class="form-group">
                <label>Phone 1</label>
                <input type="text" class="form-control" placeholder="Enter Phone No" value="<?php echo $row['phone1']; ?>" name="phone1" >
              </div>
            </div>
             <div class="col-4">
              <div class="form-group">
                <label>Phone 2</label>
                <input type="text" class="form-control" placeholder="Enter Phone No" value="<?php echo $row['phone2']; ?>" name="phone2" >
              </div>
            </div>
            <div class="col-4">
              <div class="form-group">
                <label>GSTIN No</label>
                <input type="text" class="form-control" placeholder="Enter GST" name="gst" maxlength="15" minlength="15" value="<?php echo $row['GST']; ?>">
              </div>
            </div>


      <div class="col-4">

        <div class="form-group">

          <label>Address</label>

         
          <textarea class="form-control" name="address"><?php echo $row['address']; ?></textarea>

        </div>

      </div>

     <div class="col-4">
              <div class="form-group">
                <label>State</label>
                
                <select class="form-control custom-select state select2" name="State" id="statess">

                            <option value="">Select State</option>

                            <?php

                              $Esql=mysqli_query($con,"select * from state_details where status='Active'");

                              while($Erow=mysqli_fetch_array($Esql)){
                                if($row['State']==$Erow['id']){
                              echo "<option value=".$Erow['id']." selected>$Erow[state_name]</option>"; 
                              }else{
                                echo "<option value=".$Erow['id']." >$Erow[state_name]</option>";
                              }
                              }

                              ?>                   

                          </select>
              </div>
            </div>

             <div class="col-4">
              <div class="form-group">
                <label>City</label>
                
                <select class="form-control custom-select state select2" name="City" id="cityss">
                  <?php 
                  $citys=mysqli_query($con,"select * from city_details where state='".$row['State']."'");
                  while($Erow=mysqli_fetch_array($citys)){
                    if($row['City']==$Erow['id']){
                      echo "<option value=".$Erow['id']." selected>$Erow[city_name]</option>"; 
                    }else{
                      echo "<option value=".$Erow['id'].">$Erow[city_name]</option>"; 
                    }
                  }
                  ?>
                                              

                          </select>
              </div>
            </div>
             <div class="col-4">
              <div class="form-group">
                <label>Pincode</label>
                
                <input type="text" class="form-control" id="inputPassword" placeholder="Pincode" name="Pincode" maxlength="6" minlength="6" onkeypress='return /[0-9]/i.test(event.key)' value="<?php echo $row['Pincode']; ?>">  
              </div>
            </div>
			</div>
			<div class="col-sm-12 pl-0">  
      <fieldset style="min-height:50px;">
      <legend><b> Bank Details </b> </legend>
      </fieldset>
      </div>
			<div class="row form-row step_1">
            
            <div class="col-4">
              <div class="form-group">
                <label>Bank </label>
                <input type="text" class="form-control" placeholder="Enter Bank Name" name="bank" value="<?php echo $row['Bank']; ?>">
              </div>
            </div>
       <div class="col-4">
              <div class="form-group">
                <label>Acc No</label>
                <input type="text" class="form-control" placeholder="Enter Acc No" name="accno" value="<?php echo $row['AccNo']; ?>">
              </div>
            </div>
            <div class="col-4">
              <div class="form-group">
                <label>Branch</label>
                <input type="text" class="form-control" placeholder="Enter Branch" name="branch" value="<?php echo $row['Branch']; ?>">
              </div>
            </div>
             <div class="col-4">
              <div class="form-group">
                <label>IFSC Code</label>
                <input type="text" class="form-control" placeholder="Enter IFSC Code" name="ifsc" value="<?php echo $row['IFSC']; ?>">
              </div>
            </div>

     <div class="col-4">

              <div class="form-group">

                <label>Status</label>

               

                <select name="status" class="form-control Capitalize" required>

                    <option value="">Select Status</option>

                    <option value="Active" <?php if($row['status']=="Active"){echo "selected";}?>>Active</option>

                    <option value="In-Active" <?php if($row['status']=="In-Active"){echo "selected";}?>>In-Active</option>

                </select>

              </div>

            </div>
<div class="col-md-12">
<hr>
 <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

    <input type="hidden" name="random_move" value="<?php echo $_SESSION['random_move']; ?>">

    <button class="btn btn-dark " name="Updatetransport">Update</button>
</div>
    </div> 

    

   

   

  </form>

</div>

<?php

  }

if ($_REQUEST['part'] == 'Get_Sale_Invoive_Tax'){
  $supplier=Get_Fetch_Data($con,$_POST['customer'],"id,State","supplier");
  $buyer=Get_Fetch_Data($con,$_POST['buyer'],"id,transport","buyer_details");
  ?>

  <div class="table-responsive">
    <table class="table table-hover table-bordered table-striped table-center mb-0" id="myTableF">
      <thead>
        <tr>
          <th style="width:370px">Invoice No </th>
           <th style="width:370px">Invoice Date </th>
          <th style="width:370px">Product Name </th>
		      <th style="width: 120px;">Unit of Measure </th>
          <th style="width: 120px;">Quantity </th>
          <th style="width: 100px;">Rate </th>
           <th style="width: 100px;">Gst </th>
          <th style="width: 140px;
            text-align: right;
            padding-right: 35px !important;">Amount </th>
        </tr>
      </thead>
      <tbody>
        <tr>

        <td>
        <input type="text" name="invoiceno[]"  class="form-control minvoiceno" id="minvoiceno">
        </td>
        <td>
        <input type="text" name="inv_date[]"  class="form-control datepickerss" id="inv_date">
        </td>

        <td>
        <select   class="form-control select2 product" name="pid[]"  style="width:98%;" id="product">
        <option value="">Select Item</option>
        <?php
        $Asql=mysqli_query($con,"select * from product_details where status='Active'");
        while($Asql1=mysqli_fetch_array($Asql)){
        echo "<option value=".$Asql1['id']." >$Asql1[product]</option>"; 
        }
        ?> 
        </select>
        </td>
		   <td> <select class="form-control select2 Unit" name="unit[]"  id="unit">
          <option value="">Select Unit</option>
          </select></td>
          <td> <input type="number" class="form-control qty" name="qty[]"  placeholder="Enter Quantity" id="qty" ></td>

          <td><input type="number" class="form-control rate" name="rate[]"  placeholder="Enter Rate" id="rate"  > </td>
          <td class="gsttax" id="gsttax">
            
          </td>
          <input type="hidden" class="cgst" name="cgst[]" >
          <input type="hidden" class="cgst_amt" name="cgst_amt[]" >
          <input type="hidden" class="sgst" name="sgst[]" >
          <input type="hidden" class="sgst_amt" name="sgst_amt[]" >
          <input type="hidden" class="igst" name="igst[]" >
          <input type="hidden" class="igst_amt" name="igst_amt[]">
          <td>
            <div class="d-flex justify-content-end"><input type="text" class="form-control Amount" name="Amount[]"  placeholder="Amount" id="Amount" readonly><span class="float-right ml-3">
              <a href="javascript:void" class="AddF"><i class="fa fa-plus-circle text-info" aria-hidden="true"></i></a>  
              </span>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="form-group row w-100 mt-2 border py-2" style="background:#f9f9f9;">
  <div class="col-md-5" id="ShippingAddress">
  <div class="form-group row mb-0">
  <label for="inputPassword" class="col-sm-4 col-form-label fs-12">LR No. :  </label>
  <div class="col-sm-8"> 
  <input type="text" class="form-control input-small" placeholder="LR No. :  " name="ledgerno"> 
  </div>
  </div>

  <div class="form-group row mb-0">
  <label for="inputPassword" class="col-sm-4 col-form-label fs-12">LR Date :  </label>
  <div class="col-sm-8"> 
  <input type="text" class="form-control input-small datepickerss" placeholder="Enter LR Date:  " name="lrdate"> 
  </div>
  </div>
  <div class="form-group row mb-0">
  <label for="inputPassword" class="col-sm-4 col-form-label fs-12 nowrap">Transport Name : </label>                  
  <div class="col-sm-8">
    <select class="form-control select2 transport input-small" name="transport">

    <option value="">Select Transport</option>

    <?php

      $Esql=mysqli_query($con,"select * from transport_details where id!=''");
      while($Erow=mysqli_fetch_array($Esql)){
  if($buyer['transport']==$Erow['id']){
         echo "<option value=".$Erow['id']." selected>$Erow[transport]</option>"; 
        }else{
          echo "<option value=".$Erow['id'].">$Erow[transport]</option>"; 
        }
      }

      ?>                   

  </select>
  </div>
  </div>

  

  </div>
  <div class="col-md-3"></div>
  <div class="col-md-4 pr-0">
  <table class="inner-table  mb-0 w-100">
  <tbody>
      
  <tr>
  <td>Sub Total</td>
  <td colspan="4">&nbsp;</td>
  <td class="text-right pr-2">
  <input type="hidden" name="totqty" id="totqty">
  <input type="hidden" name="Subtotal" id="Subtotal">
  <span id="SubtotalShow">00.00</span></td>
  </tr>



  <tr>
  <tr>
  <td><b>Total (₹)</b></td>
  <td colspan="4">&nbsp;</td>
  <td class="text-right pr-2"><b>
  <input type="hidden" name="TotalAmount" id="TotalAmount"><span id="TotalAmountShow">00.00</span></b>
  </td>
  </tr>
  </tbody>
  </table>
  
  <hr class="w-100">
  <input type="hidden" name="random_move" value="<?php echo $_SESSION['random_move']; ?>">
  <button type="submit" class="btn btn-dark mr-3 float-right" name="AddOrder">Submit</button>
  </div>
  </div>
  </div>
  </div>

  
  </form>
  <?php
}

if ($_REQUEST['part'] == 'Sale_Order_Tax'){

  $supplier=Get_Fetch_Data($con,$_POST['customer'],"id,State","supplier");
  $buyer=Get_Fetch_Data($con,$_POST['buyer'],"transport","buyer_details");
  ?>

  <div class="table-responsive">
    <table class="table table-hover table-bordered table-striped table-center mb-0" id="myTableF">
      <thead>
        <tr>
          <th style="width:120px">Image</th>
          <th style="width:180px">Product Code</th>
          <th style="width:220px">Product Name </th>
          <th style="width:150px">Unit of Measure</th>          
          <th style="width: 120px;">Quantity </th>
          <th style="width: 100px;">Rate </th>
          <th style="width: 140px; text-align: right; padding-right: 35px !important;">Amount </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td> <input type="file" class="form-control" name="attachment[]" id="prodimage"></td>
          <td> <input type="text" class="form-control" name="pcode[]"  placeholder="Enter Product Code" id="pcode"></td>

          <td>
            <div class="d-flex">
              <div class="position-relative w-100">
                <div class="d-flex w-100 align-items-center">
                  <span class="w-100">
                    <select class="form-control select2 input-small product" name="pid[]" style="width:98%;">
                      <option value="">Select Item</option>
                      <?php
                        $Asql=mysqli_query($con,"select * from product_details where status='Active'");
                             while($Asql1=mysqli_fetch_array($Asql)){
                               echo "<option value=".$Asql1['id']." >$Asql1[product]</option>"; 
                           }
                        ?> 
                    </select>
                  </span>
                </div>
              </div>
            </div>
          </td>
          <td> 
          <select class="form-control select2 Unit" name="unit[]" >
          <option value="">Select Unit</option>
          </select>
          </td>

          <td> <input type="number" class="form-control qty" name="qty[]"  placeholder="Enter Quantity" ></td>
          <td>
            <input type="number" class="form-control rate" name="rate[]"  placeholder="Enter Rate"> 
             <span>
              <select name="rate_type[]" class="form-control">
              <option value="Approx">Approx</option>  
              <option value="Fixed">Fixed</option>  
              </select>
              </span> 
          </td>

          <td>
            <div class="d-flex justify-content-end"><input type="text" class="form-control Amount" name="Amount[]"  placeholder="Amount" readonly><span class="float-right ml-3">
              <a href="javascript:void" class="AddF"><i class="fa fa-plus-circle text-info" aria-hidden="true"></i></a>  
              </span>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="form-group row w-100 mt-2 border pt-2" style="background:#f9f9f9;">
  <div class="col-md-5" id="ShippingAddress">
  <!-- <div class="form-group row">
  <label for="inputPassword" class="col-sm-4 col-form-label">LR No. :  </label>
  <div class="col-sm-8"> 
  <input type="text" class="form-control" placeholder="LR No.:" name="LRNo"> 
  </div>
  </div> -->
  <div class="form-group row mb-0">
  <label for="inputPassword" class="col-sm-5 col-form-label">Transport Name : </label>                  
  <div class="col-sm-7">
  <!-- <input type="text" class="form-control" placeholder="Enter Trnasport Name" name="transport">  -->

  <select class="form-control select2 input-small" name="transport" id="transport">
  <option value="">Select Transport</option>
  <?php
  $Esql=mysqli_query($con,"select * from transport_details where id!=''");
  while($Erow=mysqli_fetch_array($Esql)){
    if($buyer['transport']==$Erow['id']){
    echo "<option value=".$Erow['id']." selected>$Erow[transport]</option>"; 
  }else{
    echo "<option value=".$Erow['id'].">$Erow[transport]</option>";
  }
  }
  ?> 
  </select>
  <!-- <a class="ml-1" data-toggle="modal" href="#AddnewCustomer"><i class="fa fa-plus-circle text-success" aria-hidden="true"></i></a> -->
  </div>
  </div>

   <div class="form-group row mb-0">
  <label class="col-sm-5 col-form-label nowrap">Item Dispatch (In Days): </label>                  
  <div class="col-sm-7">
    <input type="text" name="dispatch_days" class="form-control numval input-small" >

  <!-- <select class="form-control select2 dispatch_days input-small" name="dispatch_days">
  <option value="">Select</option>                          
  <option value="7">7</option>
  <option value="15">15</option>
  <option value="30">30</option> 
  <option value="45">45</option>      
  <option value="60">60</option>
  <option value="90">90</option>
  </select>  -->
  </div>
  </div>

  <div class="form-group row mb-0">
  <label class="col-sm-5 col-form-label nowrap">Gst : </label>                  
  <div class="col-sm-6">
  <select class="form-control select2 dispatch_days input-small" name="gstslot" id="gstslot">
  <option value="">Select Gst</option>                          
  <option value="5">5%</option>
  <option value="12">12%</option>
  <option value="bill">As Per Bill</option> 
  <option value="Manual">Manual</option>        
  </select> 
  </div>

  <label class="col-sm-5 col-form-label nowrap manualgst" style="display:none;">Manual Gst : </label>
  <div class="col-sm-6 manualgst" style="display:none;">
  <input type="text" name="manualgst" class="form-control">
  </div>
  </div>

  <div class="form-group row mb-0">
  <label class="col-sm-5 col-form-label nowrap">Sales Executive: </label>                  
  <div class="col-sm-6">
  <select class="form-control select2 dispatch_days input-small" name="Executive" id="Executive">
  <option value="">Select One</option>                          
  <?php
  $saleEQry = mysqli_query($con,"SELECT * from admin_signup where designation='EXECUTIVE' && status='Active' ");
  while($Vrows=mysqli_fetch_array($saleEQry)) {
    ?>
    <option value="<?php echo $Vrows['id']?>"><?php echo $Vrows['name']?></option>
    <?php
  }
  ?>
  </select> 
  </div>
  </div>


  </div>

  <div class="col-md-2"></div>
  <div class="col-md-5 ">
  <table class="inner-table  mb-0 w-100">
  <tbody>
  <?php 
  $Vsqls=mysqli_query($con,"SELECT DCommision,credit_days from supplier where id='".$_POST["customer"]."' ");
    $Vrows=mysqli_fetch_array($Vsqls);
    $Lastdiscount=LastDiscount_Buyer_Supplier($con,$_POST['buyer'],$_POST["customer"]);
    if($Lastdiscount['buyer_discount'] > 0 || $Lastdiscount['payment_days']!=''){
  $commission=$Lastdiscount['special_discount'];
  $paymentdays=$Lastdiscount['payment_days'];
    }else{
      $commission=$Vrows['DCommision'];
      $paymentdays=$Vrows['credit_days'];
    }
  ?>
  <tr>
    <td>Payment Days</td>
    <td>
    <input type="text" name="payment_days" id="payment_days" class="form-control input-small" value="<?php echo $paymentdays;?>">
    
    </td>

    <td colspan="3">Discount(%)</td>
    <td class="text-right pr-2">
    <input type="text" class="form-control specialDiscount input-small" name="special_discount" id="specialDiscount" value="<?php echo $commission;?>" style="width:100px"></td>
    </tr>
    
    <tr>
    <td>Sub Total</td>
    <td colspan="4">&nbsp;</td>
    <td class="text-right pr-2">
    <input type="hidden" name="totqty" id="totqty">
    <input type="hidden" name="Subtotal" id="Subtotal">
    <span id="SubtotalShow">00.00</span></td>
    </tr> 

    <?php 
    /*
    if($supplier["State"]=="8"){
      ?>
      <tr>
      <td class='text-warning'>CGST(+)</td>
      <td colspan='4'>
      <div class='d-flex w-50 '>
      <select class='form-control p-2 h-30 border-left-0' id='cgstcharge' name='cgsttax'>
      <option value=''>Select</option>
      <option value="2.5">2.5%</option>
      <option value="6">6%</option>
      <option value="9">9%</option>
      </select>
      </div></td>
      <td class='text-right pr-5'>
      <input type='hidden' name='cgstamount' id='cgstamount'>
      <span id='CGstchargeShow' class='text-warning'>00.00</span></td>

      </tr>

      <tr>
      <td class='text-warning'>SGST(+)</td>
      <td colspan='4'>
      <div class='d-flex w-50 '>
      <select class='form-control p-2 h-30 border-left-0' id='sgstcharge' name='sgsttax'>
      <option value=''>Select</option>
      <option value="2.5">2.5%</option>
      <option value="6">6%</option>
      <option value="9">9%</option>
      </select>
      </div></td>
      <td class='text-right pr-5'>
      <input type='hidden' name='sgstamount' id='sgstamount'>
      <span id='SGstchargeShow' class='text-warning'>00.00</span></td>

      </tr>
      <?php 
    } 
    else{
      ?>
      <tr>
      <td class='text-warning'>IGST(+)</td>
      <td colspan='4'>
      <div class='d-flex w-50 '>
      <select class='form-control p-2 h-30 border-left-0' id='Igstcharge' name='Igstcharge'>
      <option value=''>Select</option>
      <option value="5">5%</option>
      <option value="12">12%</option>
      <option value="18">18%</option>
      </select>
      </div></td>
      <td class='text-right pr-5'>
      <input type='hidden' name='igstamount' id='igstamount'>
      <span id='IGstchargeShow' class='text-warning'>00.00</span></td>

        </tr>
      <?php 
    } */?>


  <tr>
  <tr>
  <td><b>Total (₹)</b></td>
  <td colspan="4">&nbsp;</td>
  <td class="text-right pr-2"><b>
  <input type="hidden" name="TotalAmount" id="TotalAmount"><span id="TotalAmountShow">00.00</span></b>
  </td>
  </tr>
  </tbody>
  </table>
  <hr class="w-100">
  <input type="hidden" name="random_move" value="<?php echo $_SESSION['random_move']; ?>">
  <button type="submit" class="btn btn-dark ml-3 mb-2 float-right" name="AddOrder">Submit</button>
  </div>
  </div>
  </div>
  </div>

  
  </form>
  <?php
}

if ($_POST['part'] == 'Admin_data_Update'){

      $row = Get_Fetch_Data($con,$_POST['id'], 'All', 'admin_signup');

  ?>

<div class="modal-header ">

  <h5 class="modal-title">Update Member Details</h5>

  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>

</div>

<div class="modal-body">

  <form action="" method="post" enctype="multipart/form-data">

    <h5 style="color:#000000"><i class="fa fa-file-text" aria-hidden="true"></i> Profile Details</h5>

    <div class="row form-row step_1">

      <div class="col-6">

        <div class="form-group">

          <label> Full Name <span class="text-danger">*</span></label>

          <input type="text" class="form-control Capitalize" value="<?php echo $row['name']; ?>" name="name" required> 

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label>Mobile No<span class="text-danger">*</span></label>

          <input type="text" class="form-control Capitalize" value="<?php echo $row['mobile']; ?>" name="mobile" required> 

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label>Email Id</label>

          <input type="text" class="form-control" value="<?php echo $row['email']; ?>" name="email"> 

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label>Gender</label>

          <select class="form-control" name="gender">

          <?php

            $arr = array(

                'Male',

                'Female'

            );

            foreach ($arr as $gender)

            {

                if ($gender == $row['gender'])

                {

                    echo "<option value=" . $gender . " selected>$gender</option>";

                }

                else

                {

                    echo "<option value=" . $gender . ">$gender</option>";

                }

            }

            ?>

          </select>

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label>Address</label>

          <input type="text" class="form-control Capitalize" value="<?php echo $row['address']; ?>" name="address"> 

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label>State<span class="text-danger">*</span></label>

          <select class="form-control select2 state" name="state" id="statess" required>

            <option value="">Select State</option>

            <?php

              $Esql = mysqli_query($con,"select * from state_details where status='Active'");

              while ($Erow = mysqli_fetch_array($Esql))

              {

                  if ($row['state'] == $Erow['id'])

                  {

                      echo "<option value=" . $Erow['id'] . " selected>$Erow[state_name]</option>";

                  }

                  else

                  {

                      echo "<option value=" . $Erow['id'] . ">$Erow[state_name]</option>";

                  }

              }

              ?>

          </select>

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label>City<span class="text-danger">*</span></label>

          <select class="form-control select2" name="city" id="cityss" required>

            <option value="">Select City</option>

            <?php

              $CEsql = mysqli_query($con,"select * from city_details where state='" . $row['state'] . "' and status='Active'");

              while ($Erow = mysqli_fetch_array($CEsql))

              {

                  if ($row['city'] == $Erow['id'])

                  {

                      echo "<option value=" . $Erow['id'] . " selected>$Erow[city_name]</option>";

                  }

                  else

                  {

                      echo "<option value=" . $Erow['id'] . ">$Erow[city_name]</option>";

                  }

              }

              ?>

          </select>

        </div>

      </div>

    </div>

    <h5 style="color:#000000"><i class="fa fa-file-text" aria-hidden="true"></i> Company Details</h5>

    <div class="row form-row step_1">

      <div class="col-4">

        <div class="form-group">

          <label>Designation</label>

          <input type="text" class="form-control Capitalize" value="<?php echo $row['designation']; ?>" name="designation" required> 

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label>Select Rate<span class="text-danger">*</span></label>

          <select class="form-control" name="rates" required>

            <option value="">Select Rate</option>

            <?php

              $arrs = array(

                  'Wholesaler' => 'Wholesaler',

                  'Distributor' => 'Semi Wholesaler',

                  'Retailer' => 'Retailer',

                  'Sub-Retailer' => 'Sub-Retailer'

              );

              foreach ($arrs as $key => $rates)

              {

                  if ($row['rates'] == $key)

                  {

                      echo "<option value=" . $key . " selected>$rates</option>";

                  }

                  else

                  {

                      echo "<option value=" . $key . ">$rates</option>";

                  }

              }

              ?>

          </select>

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label>Select Role</label>

          <select class="form-control" name="role">

            <option value="">Select Role</option>

            <?php

              $rsql = mysqli_query($con,"select * from role_details where status='Active'");

              while ($rrow = mysqli_fetch_array($rsql))

              {

                  if ($rrow['id'] == $row['role'])

                  {

                      echo "<option value=" . $rrow['id'] . " selected>$rrow[role_name]</option>";

                  }

                  else

                  {

                      echo "<option value=" . $rrow['id'] . ">$rrow[role_name]</option>";

                  }

              }

              ?>

          </select>

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label> Update Photo </label>

          <input type="file" class="form-control" name="photo"> 

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label> Update Document1</label>

          <input type="file" class="form-control" name="document1"> 

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label> Update Document2</label>

          <input type="file" class="form-control" name="document2"> 

        </div>

      </div>

      <div class="col-12">

        <div class="form-group">

          <label> Monthly Salary<span class="text-danger">*</span></label>

          <input type="text" class="form-control" name="salary" value="<?php echo $row['salary']; ?>" required> 

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label>Status</label>

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

    <button class="btn btn-success float-right mr-3" name="UpdateMember">Update</button>

  </form>

</div>

<?php

  }

  if ($_REQUEST['part'] == 'Return_Sale_Data_Part'){

      $requestData = $_REQUEST;

      if ($_REQUEST['from'] != '' && $_REQUEST['to'] != '')

      {

          $ff = explode('/', $_REQUEST['from']);

          $from = $ff[2] . '-' . $ff[1] . '-' . $ff[0];

          $tt = explode('/', $_REQUEST['to']);

          $to = $tt[2] . '-' . $tt[1] . '-' . $tt[0];

          $where .= " and STR_TO_DATE(`order_date`, '%d/%m/%Y') between '" . $from . "' and '" . $to . "'";

      }

      if ($_REQUEST['company'] != '')

      {

          $where .= " and uid='" . $_REQUEST['company'] . "'";

      }

      if ($_REQUEST['payment_status'] != '')

      {

          $where .= " and payment_status='" . $_REQUEST['payment_status'] . "'";

      }

      $sqls = "SELECT * FROM invoice_details where invoiceno!='' $where";

      $sql = "SELECT * FROM invoice_details where invoiceno!='' $where";

      $querys = mysqli_query($con,$sqls);

      $totalData = mysql_num_rows($querys);

      $totalFiltered = $totalData;

      if (!empty($requestData['search']['value']))

      { // if there is a search parameter, $requestData['search']['value'] contains search parameter

          $sql .= " AND ( orderid LIKE '%" . $requestData['search']['value'] . "%' ";

          $sql .= " OR order_date LIKE '%" . $requestData['search']['value'] . "%'";

          $sql .= " OR name LIKE '%" . $requestData['search']['value'] . "%'";

          $sql .= " OR mobile LIKE '%" . $requestData['search']['value'] . "%'";

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

          $coupon = "<span class='badge badge-pill bg-primary inv-badge'>$row[coupon]</span><br>";

          $action = "<input type='hidden' class='id' value=" . $row['id'] . ">

  <span style='white-space:nowrap;float: right;'>

  <a class='btn btn-sm bg-success-light' href='update_return_sale.php?invoice=$row[id]'><i class='fe fe-pencil'></i></a>&nbsp;

  <a class='btn btn-sm bg-success-light viewLinks' href='javascript:void'><i class='fe fe-search'></i></a>&nbsp;

  <a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></a></span>";

          if ($row[status] == 'Delivered')

          {

              $class = 'bg-success';

          }

          else if ($row[status] == 'Placed')

          {

              $class = 'bg-warning';

          }

          else if ($row[status] == 'Dispatch')

          {

              $class = 'bg-primary';

          }

          else

          {

              $class = 'bg-danger';

          }

          $Orders = Get_CustomerOrder_Amounts($con,$row['id']);

          $User = Get_Fetch_Data($con,$row['uid'], 'id,FName,LName', 'customer_details');

          if ($User['Cname'] != '')

          {

              $Company = "<span style=''>" . strtoupper($User[Cname]) . "</span>";

          }

          else

          {

              $Company = "<span style=''>" . strtoupper($User[name]) . "</span>";

          }

          /*if($row['status']=='Dispatch'){

          $PrintInvoice="<br><a class='badge badge-pill bg-success inv-badge' href='PrintOrder.php?id=$row[id]'>Print Bill</a>";

          } else { $PrintInvoice=""; }

          */

          if ($row['payment_status'] == 'success')

          {

              $OrderColor = "style='color: #57d447;'";

          }

          if ($row['payment_status'] == 'failure')

          {

              $OrderColor = "style='color: #fb0c59;'";

          }

          if ($row['payment_status'] == 'Pending')

          {

              $OrderColor = "style='color: #1f1e1e;'";

          }

          $ordersstatus=ucwords($row["order_status"]);

          //$PrintInvoice="<br><a class='badge badge-pill bg-success inv-badge' href='PrintOrder.php?id=$row[id]'>Print Bill</a>";

          $PrintInvoice = "<br><a class='badge badge-pill bg-success inv-badge' href='javascript:void' onclick='Open($row[id])'>Print</a>";

          $nestedData = array();

          $nestedData[] = "<div class='first' $OrderColor><input type='checkbox' name='print[]' value='$row[id]'></div>";

          $nestedData[] = "<div class='first' $OrderColor><a href='invoice-print.php?id=$row[id]'>$row[invoiceno]</a></div>";

           

          $nestedData[] = "<div class='first' $OrderColor>$row[order_date]</div>";

          $nestedData[] = "<div class='first' $OrderColor>$User[FName] $User[LName]</div>";

          

          

          $nestedData[] = "<div class='first' $OrderColor>$row[final_amount]</div>";

          $nestedData[] = "<div class='first' $OrderColor>$row[add_time]</div>";

          

         

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

  if ($_REQUEST['part'] == 'All_Invoice_Data_Part'){
$requestData = $_REQUEST;
if ($_REQUEST['from'] != '' && $_REQUEST['to'] != '')
{
$ff = explode('/', $_REQUEST['from']);
$from = $ff[2] . '-' . $ff[1] . '-' . $ff[0];
$tt = explode('/', $_REQUEST['to']);
$to = $tt[2] . '-' . $tt[1] . '-' . $tt[0];
$where .= " and STR_TO_DATE(`order_date`, '%d/%m/%Y') between '" . $from . "' and '" . $to . "'";
}
if ($_REQUEST['company'] != '')
{
$where .= " and uid='" . $_REQUEST['company'] . "'";
}
if ($_REQUEST['payment_status'] != '')
{
$where .= " and payment_status='" . $_REQUEST['payment_status'] . "'";
}
$sqls = "SELECT * FROM invoice_details where id!='' $where";
$sql = "SELECT * FROM invoice_details where id!='' $where";
$querys = mysqli_query($con,$sqls);
$totalData = mysqli_num_rows($querys);
$totalFiltered = $totalData;
if (!empty($requestData['search']['value']))
{ // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql .= " AND ( orderid LIKE '%" . $requestData['search']['value'] . "%' ";
$sql .= " OR order_date LIKE '%" . $requestData['search']['value'] . "%'";
$sql .= " OR name LIKE '%" . $requestData['search']['value'] . "%'";
$sql .= " OR mobile LIKE '%" . $requestData['search']['value'] . "%'";
$sql .= " OR status LIKE '%" . $requestData['search']['value'] . "%' )";
}
$sql .= " ORDER BY id desc LIMIT " . $requestData['start'] . " ," . $requestData['length'] . " ";
//echo $sqls;
$query = mysqli_query($con,$sql);
//$totalFiltered = mysql_num_rows($query);
$data = array();
$i = 1;
while ($row = mysqli_fetch_array($query))
{ // preparing an array
$action = "<input type='hidden' class='id' value=" . $row['id'] . ">
<span style='white-space:nowrap;float: right;'>
<a class='btn btn-sm bg-success-light' href='update_invoice.php?invoice=$row[id]'><i class='fe fe-pencil'></i></a> 
<a class='btn btn-sm bg-success-light viewLinks' href='javascript:void'><i class='fe fe-search'></i></a> 
<a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></a></span>";
if($row['ack_no']!=''){
$Einvoice ="<span style='white-space: nowrap;'><b>AckNo:</b> $row[ack_no]</span><br><span style='white-space: nowrap;'><b>AckDt:</b> $row[ack_date]</span>"; 
} else {
$Einvoice = "<a href='javascript:void' class='badge badge-pill bg-primary inv-badge GenerateEinvoice'>Generate</a>";
}
$Orders = Get_CustomerOrder_Amounts($con,$row['id']);
$User = Get_Fetch_Data($con,$row['uid'], 'id,Cname,FName,LName', 'customer_details');
//$PrintInvoice="<br><a class='badge badge-pill bg-success inv-badge' href='PrintOrder.php?id=$row[id]'>Print Bill</a>";
$Get_Invoice_Data_Quantity=Get_Invoice_Data_Quantity($con,$row["id"]);
if($Get_Invoice_Data_Quantity['ReturnQty']>0){ 
$ReturnQty="/<span class='text-danger'>$Get_Invoice_Data_Quantity[ReturnQty]</span>";
} else { $ReturnQty=""; }
$PrintInvoice = "<br><a class='badge badge-pill bg-success inv-badge' href='javascript:void' onclick='Open($row[id])'>Print</a>";
$nestedData = array();
$nestedData[] = "<div class='first' $OrderColor><input type='checkbox' name='print[]' value='$row[id]'></div>";
$nestedData[] = "<div class='first' $OrderColor>$row[order_date]</div>";
$nestedData[] = "<div class='first' $OrderColor style='white-space: nowrap;'><a href='invoice-print.php?id=$row[id]'>$row[invoiceno]</a></div>";
$nestedData[] = "<div class='first' $OrderColor><b>$User[Cname]</b><span class='nnmae'>$User[FName] $User[LName]</span></div>";
$nestedData[] = "<div class='first' $OrderColor>$row[final_amount]</div>";
$nestedData[] = "<div class='first' $OrderColor>$Einvoice</div>";
$nestedData[] = "<div class='first' $OrderColor>E-Bill</div>";
$nestedData[] = "<div class='first' $OrderColor>$row[status]</div>";
$nestedData[] = "<div class='first' $OrderColor>Tally</div>";
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

if ($_REQUEST['part'] == 'All_Sale_Data_Part'){
  $requestData = $_REQUEST;
  if ($_REQUEST['from'] != '' && $_REQUEST['to'] != '')
  {
  $ff = explode('/', $_REQUEST['from']);
  $from = $ff[2] . '-' . $ff[1] . '-' . $ff[0];
  $tt = explode('/', $_REQUEST['to']);
  $to = $tt[2] . '-' . $tt[1] . '-' . $tt[0];
  $where .= " and STR_TO_DATE(`add_time`, '%d/%m/%Y') between '" . $from . "' and '" . $to . "'";
  }
  if($SelYears['Year']!=$currnetyear){
  $where .= " and Year='".$SelYears['Year']."'";  
  }else{
  $where .= " and  STR_TO_DATE(`add_time`, '%d/%m/%Y') between '" . $ex . "' and '" . $ex1 . "'"; 
  }

  if ($_REQUEST['company'] != '')
  {
  $where .= " and uid='" . $_REQUEST['company'] . "'";
  }
  if ($_REQUEST['payment_status'] != '')
  {
  $where .= " and payment_status='" . $_REQUEST['payment_status'] . "'";
  }

  $sqls = "select a.*,b.orderid,b.order_date,b.LR,b.buyerid,b.supplierid,b.Transport,GM_Payment_Status  from sale_items as a,sale_details as b where a.oid=b.id $where group by a.Inv_no";
  $sql = "select a.*,b.orderid,b.order_date,b.LR,b.buyerid,b.supplierid,GM_Payment_Status,b.Transport  from sale_items as a,sale_details as b where a.oid=b.id $where";
  $querys = mysqli_query($con,$sqls);
  $totalData = mysqli_num_rows($querys);
  $totalFiltered = $totalData;
  if (!empty($requestData['search']['value']))
  { // if there is a search parameter, $requestData['search']['value'] contains search parameter
  $sql .= " AND ( b.orderid LIKE '%" . $requestData['search']['value'] . "%' ";
  $sql .= " OR b.order_date LIKE '%" . $requestData['search']['value'] . "%'";
  $sql .= " OR b.LR LIKE '%" . $requestData['search']['value'] . "%'";
  $sql .= " OR b.Transport LIKE '%" . $requestData['search']['value'] . "%'";
  $sql .= " OR a.Inv_no LIKE '%" . $requestData['search']['value'] . "%'";
  $sql .= " OR b.status LIKE '%" . $requestData['search']['value'] . "%' )";
  }
  $sql .= " group by a.Inv_no ORDER BY id desc LIMIT " . $requestData['start'] . " ," . $requestData['length'] . " ";
  
  //echo $sqls;
  $query = mysqli_query($con,$sql);
  //$totalFiltered = mysql_num_rows($query);
  $data = array();
  $i = 1;
  while ($row = mysqli_fetch_array($query))
  { // preparing an array
    if(Get_Role_Features($con,$Userrow['role'],'Sales-Invoice','Updates')=='on'){
    $Update="&nbsp;<a class='btn btn-sm bg-success-light' href='update_sale.php?id=$row[id]'><i class='fe fe-pencil'></i></a>";
}
if(Get_Role_Features($con,$Userrow['role'],'Sales-Invoice','Shows')=='on'){
    $View="<a class='btn btn-sm bg-success-light viewLinks' href='javascript:void'><i class='fe fe-search'></i></a>";
}
if(Get_Role_Features($con,$Userrow['role'],'Sales-Invoice','Deletes')=='on'){
    $Delete="&nbsp;<a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></a>";
}
  $action = "<input type='hidden' class='id' value=" . $row['id'] . ">
  <span style='white-space:nowrap;float: right;'>$View$Update$Delete</span>";

  $Ordersamount = Get_SaleOrder_Amounts($con,$row['id']);
  $Ordersqty = Get_SaleOrder_Qty($con,$row['id']);
  $buyername = Get_Fetch_Data($con,$row['buyerid'], 'id,CName,City,Buyer_Type', 'buyer_details');
  $suppliername = Get_Fetch_Data($con,$row['supplierid'], 'id,CName,SupplierType', 'supplier');
   $transport = Get_Fetch_Data($con,$row['Transport'], 'id,transport', 'transport_details');
  $buyercity = Get_Fetch_Data($con,$buyername['City'], 'All', 'city_details');
  $Tsale=Total_Sale_Invoice_Qty($con,$row['oid'],$row['Inv_no']);

  $buyertype = ($buyername['Buyer_Type']==1)?('Normal'):('Grey');
  $supplietype = ($suppliername['SupplierType']==1)?('Normal'):('Grey');

  $nestedData = array();
  $nestedData[] = "<div class='first' $OrderColor>$row[order_date]</div>";
  $nestedData[] = "<div class='first' $OrderColor style='white-space: nowrap;'>$row[orderid]</div>";
  $nestedData[] = "<div class='first' $OrderColor>$buyername[CName]<br><span style='color:#eb4e14'>$buyertype</span></div>";
  $nestedData[] = "<div class='first' $OrderColor>$suppliername[CName]<br><span style='color:#eb4e14'>$supplietype</span></div>";
  $nestedData[] = "<div class='first' $OrderColor>$buyercity[city_name]</div>";
  $nestedData[] = "<div class='first' $OrderColor>$row[Inv_no]</div>";
  $nestedData[] = "<div class='first' $OrderColor>$row[Inv_date]</div>";

  $nestedData[] = "<div class='first' $OrderColor>$Tsale[totalqty]</div>";
  $nestedData[] = "<div class='first' $OrderColor>$Tsale[totalamount]</div>";
  $nestedData[] = "<div class='first' $OrderColor>$row[LR]</div>";
  $nestedData[] = "<div class='first' $OrderColor>$transport[transport]</div>";
  $nestedData[] = "<div class='first' $OrderColor>$row[GM_Payment_Status]</div>";
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

if ($_REQUEST['part'] == 'All_SaleOrder_Data_Part'){
  $requestData = $_REQUEST;
  if ($_REQUEST['from'] != '' && $_REQUEST['to'] != '')
  {
  $ff = explode('/', $_REQUEST['from']);
  $from = $ff[2] . '-' . $ff[1] . '-' . $ff[0];
  $tt = explode('/', $_REQUEST['to']);
  $to = $tt[2] . '-' . $tt[1] . '-' . $tt[0];
  $where .= " and STR_TO_DATE(`add_time`, '%d/%m/%Y') between '" . $from . "' and '" . $to . "'";
  }
  // else{
  //   $where .= " and  STR_TO_DATE(`add_time`, '%d/%m/%Y') between '" . $ex . "' and '" . $ex1 . "'";
  // }

  if($SelYears['Year']!=$currnetyear){
  $where .= " and Year='".$SelYears['Year']."'";  
  }else{
  $where .= " and  STR_TO_DATE(`add_time`, '%d/%m/%Y') between '" . $ex . "' and '" . $ex1 . "'"; 
  }
  if ($_REQUEST['company'] != '')
  {
  $where .= " and uid='" . $_REQUEST['company'] . "'";
  }
  if ($_REQUEST['payment_status'] != '')
  {
  $where .= " and payment_status='" . $_REQUEST['payment_status'] . "'";
  }
  $sqls = "SELECT * FROM salesorder where id!='' $where";
  $sql = "SELECT * FROM salesorder where id!='' $where";
  $querys = mysqli_query($con,$sqls);
  $totalData = mysqli_num_rows($querys);
  $totalFiltered = $totalData;
  if (!empty($requestData['search']['value']))
  { // if there is a search parameter, $requestData['search']['value'] contains search parameter
  $sql .= " AND ( orderid LIKE '%" . $requestData['search']['value'] . "%' ";
  $sql .= " OR order_date LIKE '%" . $requestData['search']['value'] . "%'";
  $sql .= " OR LRNo LIKE '%" . $requestData['search']['value'] . "%'";
  $sql .= " OR transport LIKE '%" . $requestData['search']['value'] . "%'";
  $sql .= " OR status LIKE '%" . $requestData['search']['value'] . "%' )";
  }
  $sql .= " ORDER BY id desc LIMIT " . $requestData['start'] . " ," . $requestData['length'] . " ";
  //echo $sqls;
  $query = mysqli_query($con,$sql);
  //$totalFiltered = mysql_num_rows($query);
  $data = array();
  $i = 1;
  while ($row = mysqli_fetch_array($query)) { // preparing an array

$View="<a class='btn btn-sm bg-success-light viewLinks' href='javascript:void'><i class='fe fe-search'></i></a>";
  if(Get_Role_Features($con,$Userrow['role'],'Sales-Order','Deletes')=='on'){  
    $Delete="&nbsp;<a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></a>";    
  }if(Get_Role_Features($con,$Userrow['role'],'Sales-Order','Updates')=='on'){
      $Update="&nbsp;<a class='btn btn-sm bg-success-light' href='update_ordersale.php?id=$row[id]'><i class='fe fe-pencil'></i></a>"; 
  }  

  if($row['status'] == 'Complete'){
    $class = 'bg-success';
    $action = "<input type='hidden' class='id' value=".$row['id'].">    
    <a class='btn btn-sm bg-success-light viewLinks' href='javascript:void'><i class='fe fe-search'></i></a> ";
  }
  else {
    $class = 'bg-warning';
    $action = "<input type='hidden' class='id' value=".$row['id'].">    
    <span style='white-space:nowrap;float: right;'>$View$Update$Delete</span>";
  }  


  $Pendingqty = Get_SaleOrders_Qty($con,"qty","oid",$row['id']);
  $recqty = Get_SaleOrders_Qty($con,"Tot_qty","oid",$row['id']);
  $buyername = Get_Fetch_Data($con,$row['buyerid'], 'id,CName,Buyer_Type', 'buyer_details');
  $suppliername = Get_Fetch_Data($con,$row['supplierid'], 'id,CName,SupplierType', 'supplier');

  $buyertype = ($buyername['Buyer_Type']==1)?('Normal'):('Grey');
  $supplietype = ($suppliername['SupplierType']==1)?('Normal'):('Grey');

  $nestedData = array();
  $nestedData[] = "<div class='first' $OrderColor>$row[order_date]</div>";
  $nestedData[] = "<div class='first' $OrderColor style='white-space: nowrap;'>$row[orderid]</div>";
  $nestedData[] = "<div class='first' $OrderColor><a href='viewBuyerOrder.php?buyerid=$row[buyerid]'>$buyername[CName]</a><br><small>$buyertype</samll></div>";
  $nestedData[] = "<div class='first' $OrderColor><a href='viewSupplierOrder.php?supplierid=$row[supplierid]'>$suppliername[CName]</a><br><small>$supplietype</samll></div>";
  $nestedData[] = "<div class='' $OrderColor>$Pendingqty</div>";
  $nestedData[] = "<div class='' $OrderColor>$recqty</div>";
  $nestedData[] = "<div class='first' $OrderColor>$row[final_amount]<br><small>$row[rate_type]</small></div>";
  $nestedData[] = "<div class='third' $OrderColor><span class='badge badge-pill $class inv-badge $class'>$row[status]</span>";
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

if ($_REQUEST['part'] == 'All_Saleyearly_Data_Part'){
$requestData = $_REQUEST;
if ($_REQUEST['from'] != '' && $_REQUEST['to'] != '')
{
$ff = explode('/', $_REQUEST['from']);
$from = $ff[2] . '-' . $ff[1] . '-' . $ff[0];
$tt = explode('/', $_REQUEST['to']);
$to = $tt[2] . '-' . $tt[1] . '-' . $tt[0];
$where .= " and STR_TO_DATE(`add_time`, '%d/%m/%Y') between '" . $from . "' and '" . $to . "'";
}

if($SelYears['Year']!=$currnetyear){
$where .= " and Year='".$SelYears['Year']."'";  
}else{
$where .= " and  STR_TO_DATE(`add_time`, '%d/%m/%Y') between '" . $ex . "' and '" . $ex1 . "'"; 
}
if ($_REQUEST['supplier'] != '')
{
$where .= " and supplierid='" . $_REQUEST['supplier'] . "'";
}
if ($_REQUEST['payment_status'] != '')
{
$where .= " and payment_status='" . $_REQUEST['payment_status'] . "'";
}
if ($_REQUEST['todayreport'] != '' && $_REQUEST['todayreport']=="1")
{
$where .= " and STR_TO_DATE(`add_time`, '%d/%m/%Y')='".date('Y-m-d')."'";
}
if ($_REQUEST['monthlyreport'] != '' && $_REQUEST['monthlyreport']=="1")
{
$where .= " and STR_TO_DATE(`add_time`, '%d/%m/%Y') like '%".date('Y-m-')."%'";
}
if ($_REQUEST['yearlyreport'] != '' && $_REQUEST['yearlyreport']=="1")
{
$where .= " and STR_TO_DATE(`add_time`, '%d/%m/%Y') like '%".date('Y-')."%'";
}
$sqls = "SELECT * FROM sale_details where id!='' $where";
$sql = "SELECT * FROM sale_details where id!='' $where";
$querys = mysqli_query($con,$sqls);
$totalData = mysqli_num_rows($querys);
$totalFiltered = $totalData;
if (!empty($requestData['search']['value']))
{ // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql .= " AND ( orderid LIKE '%" . $requestData['search']['value'] . "%' ";
$sql .= " OR order_date LIKE '%" . $requestData['search']['value'] . "%'";
$sql .= " OR LR LIKE '%" . $requestData['search']['value'] . "%'";
$sql .= " OR Transport LIKE '%" . $requestData['search']['value'] . "%'";
$sql .= " OR status LIKE '%" . $requestData['search']['value'] . "%' )";
}
$sql .= " ORDER BY id desc LIMIT " . $requestData['start'] . " ," . $requestData['length'] . " ";
//echo $sqls;
$query = mysqli_query($con,$sql);
//$totalFiltered = mysql_num_rows($query);
$data = array();
$i = 1;
while ($row = mysqli_fetch_array($query))
{ // preparing an array

  if(Get_Role_Features($con,$Userrow['role'],'Report','Shows')=='on'){
  $View="<a class='btn btn-sm bg-success-light viewLinks' href='javascript:void'><i class='fe fe-search'></i></a>";
}
$action = "<input type='hidden' class='id' value=" . $row['id'] . ">
<span style='white-space:nowrap;float: right;'>

</span>";

$Ordersamount = Get_SaleOrder_Amounts($con,$row['id']);
$Ordersqty = Get_SaleOrder_Qty($con,$row['id']);
$buyername = Get_Fetch_Data($con,$row['buyerid'], 'id,CName', 'buyer_details');
$suppliername = Get_Fetch_Data($con,$row['supplierid'], 'id,CName', 'supplier');

$nestedData = array();
$nestedData[] = "<div class='first' $OrderColor>$row[order_date]</div>";
$nestedData[] = "<div class='first' $OrderColor style='white-space: nowrap;'>$row[orderid]</div>";
$nestedData[] = "<div class='first' $OrderColor>$buyername[CName]</div>";
$nestedData[] = "<div class='first' $OrderColor>$suppliername[CName]</div>";
$nestedData[] = "<div class='first' $OrderColor>$Ordersqty</div>";
$nestedData[] = "<div class='first' $OrderColor>$row[final_amount]</div>";
$nestedData[] = "<div class='first' $OrderColor>$row[LR]</div>";
$nestedData[] = "<div class='first' $OrderColor>$row[Transport]</div>";
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

if ($_REQUEST['part'] == 'All_GMInvoice_Data_Part'){
$requestData = $_REQUEST;
if ($_REQUEST['from'] != '' && $_REQUEST['to'] != '')
{
$ff = explode('/', $_REQUEST['from']);
$from = $ff[2] . '-' . $ff[1] . '-' . $ff[0];
$tt = explode('/', $_REQUEST['to']);
$to = $tt[2] . '-' . $tt[1] . '-' . $tt[0];
$where .= " and STR_TO_DATE(`add_time`, '%d/%m/%Y') between '" . $from . "' and '" . $to . "'";
}
// else{
//   $where .= " and  STR_TO_DATE(`add_time`, '%d/%m/%Y') between '" . $ex . "' and '" . $ex1 . "'";
// }

if($SelYears['Year']!=$currnetyear){
$where .= " and Year='".$SelYears['Year']."'";  
}else{
$where .= " and  STR_TO_DATE(`add_time`, '%d/%m/%Y') between '" . $ex . "' and '" . $ex1 . "'"; 
}

if ($_REQUEST['supplier'] != '')
{
$where .= " and supplier='" . $_REQUEST['supplier'] . "'";
}
if ($_REQUEST['monthlyreport'] != '' && $_REQUEST['monthlyreport']=="1")
{
$where .= " and STR_TO_DATE(`add_time`, '%d/%m/%Y') like '%".date('Y-m-')."%'";
}
if ($_REQUEST['payment_status'] != '')
{
$where .= " and payment_status='" . $_REQUEST['payment_status'] . "'";
}
$sqls = "SELECT * FROM GM_Invoice_Details where id!='' $where";
$sql = "SELECT * FROM GM_Invoice_Details where id!='' $where";
$querys = mysqli_query($con,$sqls);
$totalData = mysqli_num_rows($querys);
$totalFiltered = $totalData;
if (!empty($requestData['search']['value']))
{ // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql .= " AND ( invoice_id LIKE '%" . $requestData['search']['value'] . "%' ";
$sql .= " OR invoice_date LIKE '%" . $requestData['search']['value'] . "%'";
$sql .= " OR start_date LIKE '%" . $requestData['search']['value'] . "%'";
$sql .= " OR end_date LIKE '%" . $requestData['search']['value'] . "%'";
$sql .= " OR remark LIKE '%" . $requestData['search']['value'] . "%' )";
}
$sql .= " ORDER BY id desc LIMIT " . $requestData['start'] . " ," . $requestData['length'] . " ";
//echo $sqls;
$query = mysqli_query($con,$sql);
//$totalFiltered = mysql_num_rows($query);
$data = array();
$i = 1;
while ($row = mysqli_fetch_array($query))
{ // preparing an array
  if(Get_Role_Features($con,$Userrow['role'],'Report','Updates')=='on'){
$Update="<a class='btn btn-sm bg-success-light' href='updategm_invoice.php?id=$row[id]'><i class='fe fe-pencil'></i></a>";
}if(Get_Role_Features($con,$Userrow['role'],'Report','Deletes')=='on'){
$Delete="&nbsp;<a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></a>";
}
$action = "<input type='hidden' class='id' value=" . $row['id'] . ">
<span style='white-space:nowrap;float: right;'>$Update$Delete</span>";
$suppliername = Get_Fetch_Data($con,$row['supplier'], 'id,CName', 'supplier');
$nestedData = array();
$nestedData[] = "<div class='first' $OrderColor>$row[invoice_date]</div>";
$nestedData[] = "<div class='first' $OrderColor style='white-space: nowrap;'>$row[invoice_id] ($row[InvoiceNo])</div>";
$nestedData[] = "<div class='first' $OrderColor>$suppliername[CName]</div>";
$nestedData[] = "<div class='first' $OrderColor>$row[finalamount]</div>";
$nestedData[] = "<div class='first' $OrderColor>$row[start_date]<br>$row[end_date]</div>";
$nestedData[] = "<div class='' $OrderColor>$row[Payment_Status]</div>";
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


if ($_REQUEST['part'] == 'All_GMPaymentreciept_Data_Part'){
$requestData = $_REQUEST;
if ($_REQUEST['from'] != '' && $_REQUEST['to'] != '')
{
$ff = explode('/', $_REQUEST['from']);
$from = $ff[2] . '-' . $ff[1] . '-' . $ff[0];
$tt = explode('/', $_REQUEST['to']);
$to = $tt[2] . '-' . $tt[1] . '-' . $tt[0];
$where .= " and STR_TO_DATE(`add_time`, '%d/%m/%Y') between '" . $from . "' and '" . $to . "'";
}
// else{
//   $where .= " and  STR_TO_DATE(`add_time`, '%d/%m/%Y') between '" . $ex . "' and '" . $ex1 . "'";
// }

if($SelYears['Year']!=$currnetyear){
$where .= " and Year='".$SelYears['Year']."'";  
}else{
$where .= " and  STR_TO_DATE(`add_time`, '%d/%m/%Y') between '" . $ex . "' and '" . $ex1 . "'"; 
}

if ($_REQUEST['supplier'] != '')
{
$where .= " and Supplierid='" . $_REQUEST['supplier'] . "'";
}
if ($_REQUEST['monthlyreport'] != '' && $_REQUEST['monthlyreport']=="1")
{
$where .= " and STR_TO_DATE(`add_time`, '%d/%m/%Y') like '%".date('Y-m-')."%'";
}

if ($_REQUEST['payment_status'] != '')
{
$where .= " and payment_status='" . $_REQUEST['payment_status'] . "'";
}
$sqls = "SELECT * FROM Gminvoice_PaymentDetails where id!='' and Trans_Tpe='Credit' $where";
$sql = "SELECT * FROM Gminvoice_PaymentDetails where id!='' and Trans_Tpe='Credit' $where";
$querys = mysqli_query($con,$sqls);
$totalData = mysqli_num_rows($querys);
$totalFiltered = $totalData;
if (!empty($requestData['search']['value']))
{ // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql .= " AND ( slipno LIKE '%" . $requestData['search']['value'] . "%' ";
$sql .= " OR PaymentMode LIKE '%" . $requestData['search']['value'] . "%'";
$sql .= " OR Reciept_date LIKE '%" . $requestData['search']['value'] . "%' )";

}
$sql .= " ORDER BY id desc LIMIT " . $requestData['start'] . " ," . $requestData['length'] . " ";
//echo $sqls;
$query = mysqli_query($con,$sql);
//$totalFiltered = mysql_num_rows($query);
$data = array();
$i = 1;
while ($row = mysqli_fetch_array($query))
{ // preparing an array
if(Get_Role_Features($con,$Userrow['role'],'Report','Deletes')=='on'){
$Delete="<a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></a>";
}
$action = "<input type='hidden' class='id' value=" . $row['id'] . ">
<span style='white-space:nowrap;float: right;'>$Delete</span>";
$suppliername = Get_Fetch_Data($con,$row['Supplierid'], 'id,CName', 'supplier');
if($row['PaymentMode']=="1"){
  $paymentmode="Cash";
}elseif($row['PaymentMode']=="2"){
  $paymentmode="Upi";
}elseif($row['PaymentMode']=="3"){
  $paymentmode="Net Banking";
}elseif($row['PaymentMode']=="4"){
  $paymentmode="Cheque";
}else{
 $paymentmode=""; 
}
$nestedData = array();
$nestedData[] = "<div class='first' $OrderColor>$suppliername[CName]</div>";
$nestedData[] = "<div class='first' $OrderColor>$row[slipno]</div>";
$nestedData[] = "<div class='first' $OrderColor>$row[Reciept_date]</div>";
$nestedData[] = "<div class='first' $OrderColor>$row[Credit]</div>";
$nestedData[] = "<div class='first' $OrderColor>$paymentmode</div>";
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


if ($_REQUEST['part'] == 'All_Paymentreciept_Data_Part'){
$requestData = $_REQUEST;
if ($_REQUEST['from'] != '' && $_REQUEST['to'] != '')
{
$ff = explode('/', $_REQUEST['from']);
$from = $ff[2] . '-' . $ff[1] . '-' . $ff[0];
$tt = explode('/', $_REQUEST['to']);
$to = $tt[2] . '-' . $tt[1] . '-' . $tt[0];
$where .= " and STR_TO_DATE(`add_time`, '%d/%m/%Y') between '" . $from . "' and '" . $to . "'";
}
// else{
//   $where .= " and  STR_TO_DATE(`add_time`, '%d/%m/%Y') between '" . $ex . "' and '" . $ex1 . "'";
// }

if($SelYears['Year']!=$currnetyear){
$where .= " and Year='".$SelYears['Year']."'";  
}else{
$where .= " and  STR_TO_DATE(`add_time`, '%d/%m/%Y') between '" . $ex . "' and '" . $ex1 . "'"; 
}
if ($_REQUEST['supplier'] != '')
{
$where .= " and Supplierid='" . $_REQUEST['supplier'] . "'";
}
if ($_REQUEST['buyer'] != '')
{
$where .= " and Buyerid='" . $_REQUEST['buyer'] . "'";
}
if ($_REQUEST['monthlyreport'] != '' && $_REQUEST['monthlyreport']=="1")
{
$where .= " and STR_TO_DATE(`add_time`, '%d/%m/%Y') like '%".date('Y-m-')."%'";
}
$sqls = "SELECT * FROM All_Payment where id!='' and Trans_Tpe='Credit' $where";
$sql = "SELECT * FROM All_Payment where id!='' and Trans_Tpe='Credit' $where";
$querys = mysqli_query($con,$sqls);
$totalData = mysqli_num_rows($querys);
$totalFiltered = $totalData;
if (!empty($requestData['search']['value']))
{ // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql .= " AND ( slipno LIKE '%" . $requestData['search']['value'] . "%' ";
$sql .= " OR PaymentMode LIKE '%" . $requestData['search']['value'] . "%'";
$sql .= " OR Reciept_date LIKE '%" . $requestData['search']['value'] . "%' )";

}
$sql .= " ORDER BY id desc LIMIT " . $requestData['start'] . " ," . $requestData['length'] . " ";
//echo $sqls;
$query = mysqli_query($con,$sql);
//$totalFiltered = mysql_num_rows($query);
$data = array();
$i = 1;
while ($row = mysqli_fetch_array($query))
{ // preparing an array
  if(Get_Role_Features($con,$Userrow['role'],'Report','Deletes')=='on'){
  $Delete="<a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></a>";
}
$action = "<input type='hidden' class='id' value=" . $row['id'] . ">
<span style='white-space:nowrap;float: right;'>$Delete</span>";
$suppliername = Get_Fetch_Data($con,$row['Supplierid'], 'id,CName', 'supplier');
$buyerid = Get_Fetch_Data($con,$row['Buyerid'], 'id,CName', 'buyer_details');
if($row['PaymentMode']=="1"){
  $paymentmode="Cash";
}elseif($row['PaymentMode']=="2"){
  $paymentmode="Upi";
}elseif($row['PaymentMode']=="3"){
  $paymentmode="Net Banking";
}elseif($row['PaymentMode']=="4"){
  $paymentmode="Cheque";
}else{
 $paymentmode=""; 
}
$nestedData = array();
$nestedData[] = "<div class='first' $OrderColor>$suppliername[CName]</div>";
$nestedData[] = "<div class='first' $OrderColor>$buyerid[CName]</div>";
$nestedData[] = "<div class='first' $OrderColor>$row[slipno]</div>";
$nestedData[] = "<div class='first' $OrderColor>$row[Reciept_date]</div>";
$nestedData[] = "<div class='first' $OrderColor>$row[Credit]</div>";
$nestedData[] = "<div class='first' $OrderColor>$paymentmode</div>";
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



if ($_REQUEST['part'] == 'AllSupplier_ledger'){
$requestData = $_REQUEST;
if ($_REQUEST['from'] != '' && $_REQUEST['to'] != '')
{
$ff = explode('/', $_REQUEST['from']);
$from = $ff[2] . '-' . $ff[1] . '-' . $ff[0];
$tt = explode('/', $_REQUEST['to']);
$to = $tt[2] . '-' . $tt[1] . '-' . $tt[0];
$where .= " and STR_TO_DATE(`add_time`, '%d/%m/%Y') between '" . $from . "' and '" . $to . "'";
}

if($SelYears['Year']!=$currnetyear){
$where .= " and Year='".$SelYears['Year']."'";  
}else{
$where .= " and  STR_TO_DATE(`add_time`, '%d/%m/%Y') between '" . $ex . "' and '" . $ex1 . "'"; 
}
if ($_REQUEST['supplierid'] != '')
{
$where .= " and Supplierid='" . $_REQUEST['supplierid'] . "'";
}
if ($_REQUEST['company'] != '')
{
$where .= " and Buyerid='" . $_REQUEST['company'] . "'";
}
$sqls = "SELECT * FROM All_Payment where id!='' $where";
$sql = "SELECT * FROM All_Payment where id!='' $where";
$querys = mysqli_query($con,$sqls);
$totalData = mysqli_num_rows($querys);
$totalFiltered = $totalData;
if (!empty($requestData['search']['value']))
{ // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql .= " AND ( orderid LIKE '%" . $requestData['search']['value'] . "%' ";
$sql .= " OR order_date LIKE '%" . $requestData['search']['value'] . "%'";
$sql .= " OR LR LIKE '%" . $requestData['search']['value'] . "%'";
$sql .= " OR Transport LIKE '%" . $requestData['search']['value'] . "%'";
$sql .= " OR status LIKE '%" . $requestData['search']['value'] . "%' )";
}
$sql .= " ORDER BY id desc LIMIT " . $requestData['start'] . " ," . $requestData['length'] . " ";
//echo $sql;
$query = mysqli_query($con,$sql);
//$totalFiltered = mysql_num_rows($query);
$data = array();
$i = 1;
while ($row = mysqli_fetch_array($query))
{ // preparing an array
  $action = "<input type='hidden' class='id' value=" . $row['id'] . ">
<span style='white-space:nowrap;float: right;'>
<a class='btn btn-sm bg-success-light viewLinks' href='javascript:void'><i class='fe fe-search'></i></a> 
</span>";
$buyername = Get_Fetch_Data($con,$row['Buyerid'], 'id,CName', 'buyer_details');
$refrenceid = Get_Fetch_Data($con,$row['oid'], 'orderid,invoiceno', 'sale_details');

$orderid=$refrenceid['invoiceno']!='' ? $refrenceid['invoiceno'] : $row['slipno'];

if($row['PaymentMode']=="1"){
$paymentmode="Cash";
}elseif($row['PaymentMode']=="2"){
  $paymentmode="Upi";
}elseif($row['PaymentMode']=="3"){
  $paymentmode="Net Banking";
}
elseif($row['Cheque']=="4"){
  $paymentmode="Cheque";
}else{
  $paymentmode="Other";
}

if($row['Debit']!=''){
  $amttpe="Sale To $buyername[CName] Bill No ($orderid)";
}elseif($row['Credit']!='' && $row['GR_Status']=="1"){
 $amttpe="Goods Return By  $buyername[CName]  For Bill No ($orderid)"; 
}else{
  $amttpe="Payment Recieved By  $buyername[CName] Payment Mode $paymentmode For Bill No ($orderid)"; 
}
$dte=substr($row['add_time'], 0, strrpos($row['add_time'], ' '));
$nestedData = array();
$nestedData[] = "<div class='first' $OrderColor>$dte</div>";
$nestedData[] = "<div class='first' $OrderColor>$buyername[CName]</div>";
$nestedData[] = "<div class='first' $OrderColor style='white-space: nowrap;'>$amttpe</div>";
$nestedData[] = "<div class='first' $OrderColor>$row[Debit]</div>";
$nestedData[] = "<div class='first' $OrderColor>$row[Credit]</div>";
$nestedData[] = "<div class='first text-right' $OrderColor>$row[OutstandingBalance]</div>";
//$nestedData[] = "$action";
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
if ($_REQUEST['part'] == 'AllBuyer_ledgerdata'){
$requestData = $_REQUEST;
if ($_REQUEST['from'] != '' && $_REQUEST['to'] != '')
{
$ff = explode('/', $_REQUEST['from']);
$from = $ff[2] . '-' . $ff[1] . '-' . $ff[0];
$tt = explode('/', $_REQUEST['to']);
$to = $tt[2] . '-' . $tt[1] . '-' . $tt[0];
$where .= " and STR_TO_DATE(`add_time`, '%d/%m/%Y') between '" . $from . "' and '" . $to . "'";
}

if($SelYears['Year']!=$currnetyear){
$where .= " and Year='".$SelYears['Year']."'";  
}else{
$where .= " and  STR_TO_DATE(`add_time`, '%d/%m/%Y') between '" . $ex . "' and '" . $ex1 . "'"; 
}
if ($_REQUEST['Buyerid'] != '')
{
$where .= " and Buyerid='" . $_REQUEST['Buyerid'] . "'";
}
if ($_REQUEST['company'] != '')
{
$where .= " and Supplierid='" . $_REQUEST['company'] . "'";
}
$sqls = "SELECT * FROM All_Payment where id!='' $where";
$sql = "SELECT * FROM All_Payment where id!='' $where";
$querys = mysqli_query($con,$sqls);
$totalData = mysqli_num_rows($querys);
$totalFiltered = $totalData;
if (!empty($requestData['search']['value']))
{ // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql .= " AND ( orderid LIKE '%" . $requestData['search']['value'] . "%' ";
$sql .= " OR order_date LIKE '%" . $requestData['search']['value'] . "%'";
$sql .= " OR LR LIKE '%" . $requestData['search']['value'] . "%'";
$sql .= " OR Transport LIKE '%" . $requestData['search']['value'] . "%'";
$sql .= " OR status LIKE '%" . $requestData['search']['value'] . "%' )";
}
$sql .= " ORDER BY id desc LIMIT " . $requestData['start'] . " ," . $requestData['length'] . " ";
//echo $sqls;
$query = mysqli_query($con,$sql);
//$totalFiltered = mysql_num_rows($query);
$data = array();
$i = 1;
while ($row = mysqli_fetch_array($query))
{ // preparing an array
$buyername = Get_Fetch_Data($con,$row['Supplierid'], 'id,CName', 'supplier');
$refrenceid = Get_Fetch_Data($con,$row['oid'], 'invoiceno,orderid', 'sale_details');
$orderid=$refrenceid['invoiceno']!='' ? $refrenceid['invoiceno'] : $row['slipno'];
if($row['Debit']!=''){
  $amttpe="Purchase By $buyername[CName] Bill No ($orderid)";
}elseif($row['Credit']!='' && $row['GR_Status']=="1"){
 $amttpe="Goods Returns To $buyername[CName] For Bill No ($orderid)"; 
}else{
  $amttpe="Payment To $buyername[CName] For Bill No ($orderid)";
}
$nestedData = array();
$dte=substr($row['add_time'], 0, strrpos($row['add_time'], ' '));
$nestedData[] = "<div class='first' $OrderColor>$dte</div>";
$nestedData[] = "<div class='first' $OrderColor style='white-space: nowrap;'>$amttpe</div>";
$nestedData[] = "<div class='first sdebit' $OrderColor>$row[Debit]</div>";
$nestedData[] = "<div class='first' $OrderColor>$row[Credit]</div>";
$nestedData[] = "<div class='first text-right' $OrderColor>$row[CustomerOutstanding]</div>";
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

  if ($_REQUEST['part'] == 'All_Return_Purchase'){

      $requestData = $_REQUEST;

      if ($_REQUEST['from'] != '' && $_REQUEST['to'] != '')

      {

          $ff = explode('/', $_REQUEST['from']);

          $from = $ff[2] . '-' . $ff[1] . '-' . $ff[0];

          $tt = explode('/', $_REQUEST['to']);

          $to = $tt[2] . '-' . $tt[1] . '-' . $tt[0];

          $where .= " and STR_TO_DATE(`order_date`, '%d/%m/%Y') between '" . $from . "' and '" . $to . "'";

      }

      if ($_REQUEST['company'] != '')

      {

          $where .= " and uid='" . $_REQUEST['company'] . "'";

      }

      if ($_REQUEST['payment_status'] != '')

      {

          $where .= " and payment_status='" . $_REQUEST['payment_status'] . "'";

      }

      $sqls = "SELECT * FROM order_details where id!='' and invoice_no!='' and order_status='2' $where";

      $sql = "SELECT * FROM order_details where id!='' and invoice_no!='' and order_status='2' $where";

      $querys = mysqli_query($con,$sqls);

      $totalData = mysqli_num_rows($querys);

      $totalFiltered = $totalData;

      if (!empty($requestData['search']['value']))

      { // if there is a search parameter, $requestData['search']['value'] contains search parameter

          $sql .= " AND ( orderid LIKE '%" . $requestData['search']['value'] . "%' ";

          $sql .= " OR order_date LIKE '%" . $requestData['search']['value'] . "%'";

          $sql .= " OR name LIKE '%" . $requestData['search']['value'] . "%'";

          $sql .= " OR mobile LIKE '%" . $requestData['search']['value'] . "%'";
          $sql .= " OR invoice_no LIKE '%" . $requestData['search']['value'] . "%'";

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

          $coupon = "<span class='badge badge-pill bg-primary inv-badge'>$row[coupon]</span><br>";

          $action = "<input type='hidden' class='id' value=" . $row['id'] . ">

  <span style='white-space:nowrap;float: right;'>

  <a class='btn btn-sm bg-success-light ' href='update_return_purchase.php?challanno=$row[challanno]&supplier=$row[uid]'><i class='fe fe-pencil'></i></a>&nbsp;

  <a class='btn btn-sm bg-success-light viewLinks' href='javascript:void'><i class='fe fe-search'></i></a>&nbsp;

  <a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></a></span>";

          if ($row[status] == 'Delivered')

          {

              $class = 'bg-success';

          }

          else if ($row[status] == 'Placed')

          {

              $class = 'bg-warning';

          }

          else if ($row[status] == 'Dispatch')

          {

              $class = 'bg-primary';

          }

          else

          {

              $class = 'bg-danger';

          }

          $Orders = Get_Order_Amounts($con,$row['id']);

          $User = Get_Fetch_Data($con,$row['uid'], 'id,name,company', 'user_details');

          if ($User['company'] != '')

          {

              $Company = "<span style=''>" . strtoupper($User[company]) . "</span>";

          }

          else

          {

              $Company = "<span style=''>" . strtoupper($User[name]) . "</span>";

          }

          /*if($row['status']=='Dispatch'){

          $PrintInvoice="<br><a class='badge badge-pill bg-success inv-badge' href='PrintOrder.php?id=$row[id]'>Print Bill</a>";

          } else { $PrintInvoice=""; }

          */

          if ($row['payment_status'] == 'success')

          {

              $OrderColor = "style='color: #57d447;'";

          }

          if ($row['payment_status'] == 'failure')

          {

              $OrderColor = "style='color: #fb0c59;'";

          }

          if ($row['payment_status'] == 'Pending')

          {

              $OrderColor = "style='color: #1f1e1e;;'";

          }

          //$PrintInvoice="<br><a class='badge badge-pill bg-success inv-badge' href='PrintOrder.php?id=$row[id]'>Print Bill</a>";

          $PrintInvoice = "<br><a class='badge badge-pill bg-success inv-badge' href='javascript:void' onclick='Open($row[id])'>Print</a>";

          $nestedData = array();

          $nestedData[] = "<div class='first' $OrderColor><input type='checkbox' name='print[]' value='$row[id]'></div>";

          $nestedData[] = "<div class='first' $OrderColor>$row[orderid]</div>";
          $nestedData[] = "<div class='first' $OrderColor>$row[invoice_no]</div>";
           

          $nestedData[] = "<div class='first' $OrderColor>$row[order_date]</div>";

          $nestedData[] = "<div class='first' $OrderColor>$Company<br>$row[name]</div>";

         

          

          $nestedData[] = "<div class='first' $OrderColor>$Orders[quantity]</div>";

          $nestedData[] = "<div class='first' $OrderColor>" . number_format((float)$row['final_amount'], 2, '.', '') . "</div>";

          

          $nestedData[] = "<div class='third' $OrderColor><span class='badge badge-pill $class inv-badge'>$row[status]</span>

      <div class='create_time'>$row[add_time]</div></div>";

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

  if ($_REQUEST['part'] == 'All_Challan_Data_Part'){
      $requestData = $_REQUEST;
      if ($_REQUEST['from'] != '' && $_REQUEST['to'] != '')
      {
          $ff = explode('/', $_REQUEST['from']);
          $from = $ff[2] . '-' . $ff[1] . '-' . $ff[0];
          $tt = explode('/', $_REQUEST['to']);
          $to = $tt[2] . '-' . $tt[1] . '-' . $tt[0];
          $where .= " and STR_TO_DATE(`challandte`, '%d/%m/%Y') between '" . $from . "' and '" . $to . "'";
      }
      if ($_REQUEST['company'] != '')
      {
          $where .= " and uid='" . $_REQUEST['company'] . "'";
      }
      if ($_REQUEST['status'] != ''){
          $where .= " and status='" . $_REQUEST['status'] . "'";
      } if ($_REQUEST['status']==''){
          $where .= " and status='Pending'";
      }
      $sqls = "SELECT * FROM challan_details where id!='' $where";
      $sql = "SELECT * FROM challan_details where id!='' $where";
      $querys = mysqli_query($con,$sqls);
      $totalData = mysqli_num_rows($querys);
      $totalFiltered = $totalData;
      if (!empty($requestData['search']['value']))
      { // if there is a search parameter, $requestData['search']['value'] contains search parameter
          $sql .= " AND ( orderid LIKE '%" . $requestData['search']['value'] . "%' ";
		  $sql .= " OR challanno LIKE '%" . $requestData['search']['value'] . "%'";
          $sql .= " OR challandte LIKE '%" . $requestData['search']['value'] . "%'";
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
          $coupon = "<span class='badge badge-pill bg-primary inv-badge'>$row[coupon]</span><br>";
if ($row[status] == 'Billed'){
$class = 'bg-success';
$action = "<input type='hidden' class='id' value=" . $row['id'] . ">";
} else {
$class = 'bg-warning';
$action = "<input type='hidden' class='id' value=" . $row['id'] . ">
<span style='white-space:nowrap;float: right;'>
<a class='btn btn-sm bg-success-light ' href='update_challan.php?id=$row[id]'><i class='fe fe-pencil'></i></a>&nbsp;
<a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></a></span>";
}
          $Orders = Get_Order_Amounts($con,$row['id']);
          $User = Get_Fetch_Data($con,$row['uid'], 'id,FName,Cname', 'vendor_details');
              $Company = "<b style=''>" . strtoupper($User[Cname]) . "</b>";
          //$PrintInvoice="<br><a class='badge badge-pill bg-success inv-badge' href='PrintOrder.php?id=$row[id]'>Print Bill</a>";
          $PrintInvoice = "<br><a class='badge badge-pill bg-success inv-badge' href='javascript:void' onclick='Open($row[id])'>Print</a>";
          $nestedData = array();
          $nestedData[] = "<div class='first' $OrderColor><input type='checkbox' name='print[]' value='$row[id]'></div>";
          $nestedData[] = "<div class='first' $OrderColor><a href='javascript:void' class='viewLinks'>$row[orderid]</a></div>";
          $nestedData[] = "<div class='first' $OrderColor>$row[challandte]</div>";
          $nestedData[] = "<div class='first' $OrderColor>$row[challanno]</div>";
          $nestedData[] = "<div class='first' $OrderColor>$Company<span class='nnmae'>City</span></div>";
		  $nestedData[] = "<a href='javascript:void' class='ViewItemsLists' $OrderColor>$Orders[items]</a>";
          $nestedData[] = "<div class='first' $OrderColor>$Orders[quantity]</div>";
          $nestedData[] = "<div class='first' $OrderColor>" . number_format((float)$row['final_amount'], 2, '.', '') . "</div>";
          $nestedData[] = "<div class='third' $OrderColor><span class='badge badge-pill $class inv-badge'>$row[status]</span>
      <!--<div class='create_time'>$row[add_time]</div>---></div>";
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

if ($_POST['part'] == 'View_Supplier_with_executive_View') {
    
    $gQuery = mysqli_query($con,"SELECT * from salesorder where supplierid='".$_POST['id']."' ");
    ?>
    <div class="modal-header ">
    <h5 class="modal-title">Supplier Sales Order</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
    </div>
    <div class="modal-body">
    <?php
    if(mysqli_num_rows($gQuery)>0) {
      ?>      
      <table class="table table-bordered">
      <thead>
      <tr>
      <th>Ref-No </th>
      <th>Date</th>
      <th>Buyer</th>      
      <th>Executive </th>
      </tr>
      </thead>
      <tbody>
      <?php
      while($row = mysqli_fetch_array($gQuery)) {
        $exeArr=Get_Fetch_Data($con,$row['Executive'],"name","admin_signup");
        $buyer=Get_Fetch_Data($con,$row['buyerid'],"CName","buyer_details");        
        ?>
        <tr>          
        <td><?php echo $row['orderid']?></td>
        <td><?php echo $row['order_date']?></td>
        <td><?php echo $buyer['CName']?></td>        
        <td><?php echo $exeArr['name']?></td>
        
        </tr>  
        <?php
      }
      ?>
      </tbody>
      </table>
      </div>
      <?php
    }
    else {
      ?>
      <div class="text-danger">Sorry No Record Found.</div>
      <?php
    }
}
if ($_POST['part'] == 'View_Buyer_with_executive_View') {
    
    $gQuery = mysqli_query($con,"SELECT * from salesorder where buyerid='".$_POST['id']."' ");
    ?>
    <div class="modal-header ">
    <h5 class="modal-title">Buyer Sales Order</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
    </div>
    <div class="modal-body">
    <?php
    if(mysqli_num_rows($gQuery)>0) {
      ?>      
      <table class="table table-bordered">
      <thead>
      <tr>
      <th>Ref-No </th>
      <th>Date</th>
      <th>Supplier</th>      
      <th>Executive </th>
      </tr>
      </thead>
      <tbody>
      <?php
      while($row = mysqli_fetch_array($gQuery)) {
        $exeArr=Get_Fetch_Data($con,$row['Executive'],"name","admin_signup");
        $buyer=Get_Fetch_Data($con,$row['supplierid'],"CName","supplier");        
        ?>
        <tr>          
        <td><?php echo $row['orderid']?></td>
        <td><?php echo $row['order_date']?></td>
        <td><?php echo $buyer['CName']?></td>        
        <td><?php echo $exeArr['name']?></td>
        
        </tr>  
        <?php
      }
      ?>
      </tbody>
      </table>
      </div>
      <?php
    }
    else {
      ?>
      <div class="text-danger">Sorry No Record Found.</div>
      <?php
    }
}

  if ($_POST['part'] == 'Supplierdetails_data_View'){
    $row = Get_Fetch_Data($con,$_POST['id'], 'All', 'supplier');
    $state=Get_Fetch_Data($con,$row["State"],"state_name","state_details");
    $city=Get_Fetch_Data($con,$row["City"],"city_name","city_details");
    $executive=Get_Fetch_Data($con,$row["Executive"],"name","admin_signup");
    $area=Get_Fetch_Data($con,$row["Area"],"area_name","area_details");?>
    <div class="modal-header ">
    <h5 class="modal-title">Supplier Details</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
    </div>
    <div class="modal-body">
    <form method="post" action="" class="table-responsive">
    	  
	   <div class="col-sm-12 pl-0">  
      <fieldset style="min-height:50px;">
      <legend><b> Supplier Details </b> </legend>
      </fieldset>
      </div>
      <div class="row form-row step_1">
         <div class="col-4">
          <div class="form-group">
            <label class="text-dark">Supplier Code</label>
            <p class="c-detail">
              <?php echo $row['Supplier_Code']; ?>
            </p>
          </div>
        </div>
        <div class="col-4">
          <div class="form-group">
            <label class="text-dark">Company Name</label>
            <p class="c-detail">
              <?php echo $row['CName']; ?>
            </p>
          </div>
        </div>
        <div class="col-4">
          <div class="form-group">
            <label class="text-dark">Name </label>
            <p class="c-detail">
              <?php echo $row['Name']; ?>
            </p>
          </div>
        </div>
        
        
        <div class="col-4">
          <div class="form-group">
            <label class="text-dark">State
            </label>
            <p class="c-detail">
              <?php echo $state['state_name']; ?>
            </p>
          </div>
        </div>
        <div class="col-4">
          <div class="form-group">
            <label class="text-dark">City
            </label>
            <p class="c-detail">
              <?php echo $city['city_name']; ?>
            </p>
          </div>
        </div>
        <div class="col-4">
          <div class="form-group">
            <label class="text-dark">City/other</label>
            <p class="c-detail">
              <?php echo $row['supplier_city_other']; ?>
            </p>
          </div>
        </div>

        <div class="col-12">
          <div class="form-group">
            <label class="text-dark">Address</label>
            <p class="c-detail">
              <?php echo $row['address']; ?>
            </p>
          </div>
        </div>

        <div class="col-4">
          <div class="form-group">
            <label class="text-dark">GST. Treatment</label>
            <p class="c-detail">
              <?php echo ($row['GstType']==1)?('Registered'):('Unregistered'); ?>
            </p>
          </div>
        </div>
        <div class="col-4">
          <div class="form-group">
            <label class="text-dark">GST No</label>
            <p class="c-detail">
              <?php echo $row['GST']; ?>
            </p>
          </div>
        </div>

        <div class="col-4">
          <div class="form-group">
            <label class="text-dark">Pan No</label>
            <p class="c-detail">
              <?php echo $row['PanNo']; ?>
            </p>
          </div>
        </div>

        <div class="col-4">
          <div class="form-group">
            <label class="text-dark">Email</label>
            <p class="c-detail">
              <?php echo $row['Email']; ?>
            </p>
          </div>
        </div>
        <div class="col-4">
          <div class="form-group">
            <label class="text-dark">Area</label>
            <p class="c-detail">
              <?php echo $area['area_name']; ?>
            </p>
          </div>
        </div>
         <div class="col-4">
          <div class="form-group">
            <label class="text-dark">Deals IN</label>
            <p class="c-detail">
              <?php echo $row['Deals']; ?>
            </p>
          </div>
        </div>
        <div class="col-4">
          <div class="form-group">
            <label class="text-dark">Type Of Supplier</label>
            <p class="c-detail">
              <?php echo $row['type_supplier']; ?>
            </p>
          </div>
        </div>
      </div>

      <div class="col-12">
         <div class="form-group row">
          <label class="text-dark">Supplier Contact Detail</label>
          <table class="table table-hover table-center mb-0 table-bordered">
          <?php      
          $teamcquery = mysqli_query($con, "SELECT * FROM supplier_contact_detail WHERE supplier_id='".$row['id']."' && ctype='1' ");
          while($teamCRow=mysqli_fetch_array($teamcquery) ) {
            ?>
            <tr>
            <td> <?php echo $teamCRow['contact_name']?> </td>

            <td><?php echo $teamCRow['mobile_no']?></td>
            </tr>
            <?php  
          }
          ?>      
          </table>
        </div>
      </div>

      <div class="col-12">
         <div class="form-group row">
          <label class="text-dark">Team Coordination Detail</label>
          <table class="table table-hover table-center mb-0 table-bordered">
          <?php      
          $teamcquery = mysqli_query($con, "SELECT * FROM supplier_contact_detail WHERE supplier_id='".$row['id']."' && ctype='2' ");
          while($teamCRow=mysqli_fetch_array($teamcquery) ) {
            ?>
            <tr>
            <td> <?php echo $teamCRow['contact_name']?> </td>

            <td><?php echo $teamCRow['mobile_no']?></td>
            </tr>
            <?php  
          }
          ?>      
          </table>
        </div>
      </div>
       
	   <div class="col-sm-12 pl-0">  
      <fieldset style="min-height:50px;">
      <legend><b> Bank Details </b> </legend>
      </fieldset>
      </div>
	  
      <div class="row form-row step_1"  >
        <div class="col-4">
          <div class="form-group">
            <label class="text-dark">Account No.</label>
            <p class="c-detail">
               <?php echo $row['account_no']; ?>
            </p>
          </div>
        </div>
        <div class="col-4">
          <div class="form-group">
            <label class="text-dark">IFSC Code</label>
            <p class="c-detail">
              <?php echo $row['ifsc_code']; ?>
            </p>
          </div>
        </div>
        <div class="col-4">
          <div class="form-group">
            <label class="text-dark">Branch</label>
            <p class="c-detail">
              <?php  
                echo $row['branch'];
                 ?>
            </p>
          </div>
        </div>
        <div class="col-4">
          <div class="form-group">
            <label class="text-dark">Bank Name</label>
            <p class="c-detail">
              <?php  
                echo $row['bank_name'];
                 ?>
            </p>
          </div>
        </div>
      </div>
	 
	   <div class="col-sm-12 pl-0">  
      <fieldset style="min-height:50px;">
      <legend><b> Pay Details </b> </legend>
      </fieldset>
      </div>
	   
      <div class="row form-row step_1">
        <div class="col-4">
          <div class="form-group">
            <label class="text-dark">Mode of Payment in Days</label>
            <p class="c-detail">
               <?php echo $row['credit_days']; ?>
            </p>
          </div>
        </div>
        <div class="col-4">
          <div class="form-group">
            <label class="text-dark">Credit Amount Limit</label>
            <p class="c-detail">
              <?php echo $row['credit_limit']; ?>
            </p>
          </div>
        </div>
        <div class="col-4">
          <div class="form-group">
            <label class="text-dark">Commission (%)</label>
            <p class="c-detail">
              <?php  
                echo $row['commission'];
                 ?>
            </p>
          </div>
        </div>        
      </div>

<div class="col-sm-12 pl-0">  
      <fieldset style="min-height:50px;">
      <legend><b> Admin Details </b> </legend>
      </fieldset>
      </div>

      <div class="row form-row step_4" >
        <div class="col-4">
          <div class="form-group">
            <label class="text-dark">Executive Name</label>
            <p class="c-detail">
               <?php echo $executive['name']; ?>
            </p>
          </div>
        </div>
        <div class="col-4">
          <div class="form-group">
            <label class="text-dark">Tie-Up Margin %</label>
            <p class="c-detail">
              <?php echo $row['Margin']; ?>
            </p>
          </div>
        </div>
        <div class="col-4">
          <div class="form-group">
            <label class="text-dark">Status</label>
            <p class="c-detail">
              <?php  
                echo $row['Status'];
                 ?>
            </p>
          </div>
        </div>
      </div>
	  </div>

     

     
    </form>
    </div>
<?php
}

  if ($_POST['part'] == 'Vendordetails_data_View'){

      $row = Get_Fetch_Data($con,$_POST['id'], 'All', 'vendor_details');

    //   $user = Get_Fetch_Data($row['uid'], 'All', 'vendor_details');

  ?>

<div class="modal-header ">

  <h5 class="modal-title">Supplier Details</h5>

  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>

</div>

<div class="modal-body">

  <form method="post" action="" class="table-responsive">

    <h5 style="color:#000000"><i class="fa fa-file-text" aria-hidden="true"></i> Supplier Details</h5>

    <div class="row form-row step_1">

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark"><th>Supplier Code</th></label>

          <p class="c-detail">

            <?php echo $row['Vendor_Code']; ?>

          </p>

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Name</label>

          <p class="c-detail">

            <?php echo $row['FName']; ?> &nbsp; <?php echo $row['LName']; ?>

          </p>

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Company Name </label>

          <p class="c-detail">

            <?php echo $row['Cname']; ?>

          </p>

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Supplier Display Name

 </label>

          <p class="c-detail">

            <?php echo $row['VDN']; ?>

          </p>

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Supplier Email Id</label>

          <p class="c-detail">

            <?php echo $row['Email']; ?>

          </p>

        </div>

      </div>

 <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Supplier What's App No</label>

          <p class="c-detail">

            <?php echo $row['swn']; ?>

          </p>

        </div>

      </div>

 <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Supplier Calling No</label>

          <p class="c-detail">

            <?php echo $row['scn']; ?>

          </p>

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Tally Ladger Name/Code

</label>

          <p class="c-detail">

            <?php echo $row['TLC']; ?>

          </p>

        </div>

      </div>

       <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Department

</label>

          <p class="c-detail">

            <?php  
            $depar=explode(",", $row['department']);
            foreach($depar as $deparr){
            $deid = Get_Fetch_Data($con,$deparr, 'category', 'category_details');
            echo $deid['category']." ,";
            }
             ?>

          </p>

        </div>

      </div>

       <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Tally Ladger

</label>

          <p class="c-detail">

            <?php echo $row['TallyLedger']; ?>

          </p>

        </div>

      </div>

    </div>

    

    <h5 style="color:#000000"><i class="fa fa-file-text" aria-hidden="true"></i> GST Details</h5>

    <div class="row form-row step_1" style="background: #f3f1f1;">

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark">GST Treatment</label>

          <p class="c-detail">

            <?php 
            if($row['GstTreatment']=="1"){
              echo "Composition";
            }elseif($row['GstTreatment']=="2"){
              echo "Consumer";
            }elseif($row['GstTreatment']=="3"){
              echo "Regular";
            }elseif($row['GstTreatment']=="4"){
              echo "Unregistered"; 
            }
             ?>

          </p>

        </div>

      </div>

      <div class="col-4">
        <div class="form-group">
          <label class="text-dark">Source of Supply</label>
          <p class="c-detail">
            <?php  
            $sssupply = Get_Fetch_Data($con,$row['SSupply'], 'All', 'state_details');
            echo $sssupply['state_name'];
             ?>
          </p>
        </div>
      </div>
      <div class="col-4">
        <div class="form-group">
          <label class="text-dark">Gst No</label>
          <p class="c-detail">
            <?php  
            
            echo $row['gstno'];
             ?>
          </p>
        </div>
      </div>

      

    </div>

    

    <h5 style="color:#000000"><i class="fa fa-file-text" aria-hidden="true"></i> MRP Details</h5>

    <div class="row form-row step_1" style="    background: #ffffd0;">

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark">MRP (%)</label>

          <p class="c-detail">

            <?php echo $row['mrp']; ?>

          </p>

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark">WS (%)</label>

          <p class="c-detail">

            <?php echo $row['ws']?>

          </p>

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Nearest (₹)</label>

          <p class="c-detail">

            <?php echo $row['nearst']?>

          </p>

        </div>

      </div>

    </div>

    <h5 style="color:#000000"><i class="fa fa-file-text" aria-hidden="true"></i> Address Details</h5>

    <div class="row form-row step_1">

      <div class="col-4">
        <div class="form-group">
          <label class="text-dark"><th>Address 1</th></label>
          <p class="c-detail">
            <?php echo $row['Address']; ?>
          </p>
        </div>
      </div>

<div class="col-4">
        <div class="form-group">
          <label class="text-dark"><th>Address 2</th></label>
          <p class="c-detail">
            <?php echo $row['address2']; ?>
          </p>
        </div>
      </div>

      <?php 

      $state = Get_Fetch_Data($con,$row['State'], 'All', 'state_details');

      $city = Get_Fetch_Data($con,$row['City'], 'All', 'city_details');

      ?>

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark">State</label>

          <p class="c-detail">

            <?php echo $state['state_name']; ?>

          </p>

        </div>

      </div>

      <div class="col-4">
        <div class="form-group">
          <label class="text-dark">City </label>
          <p class="c-detail">
            <?php echo $city['city_name']; ?>
          </p>
        </div>
      </div>

      <div class="col-4">
        <div class="form-group">
          <label class="text-dark">Pincode
 </label>
          <p class="c-detail">
            <?php echo $row['Pincode']; ?>
          </p>
        </div>
      </div>
    </div>
<h5 style="color:#000000"><i class="fa fa-file-text" aria-hidden="true"></i> Login Details</h5>

    <div class="row form-row step_1" style="    background: #ffffd0;">

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Username</label>

          <p class="c-detail">

            <?php echo $row['UserName']; ?>

          </p>

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Password</label>

          <p class="c-detail">

            <?php echo $row['Password']?>

          </p>

        </div>

      </div>
    </div>

    <h5 style="color:#000000"><i class="fa fa-file-text" aria-hidden="true"></i> Documents Details</h5>

    <div class="row form-row step_1" style="    background: #f3f1f1;">
<?php 
$idproof=$row['IdProof']!='' ? "vendordocuments/idproof/".$row['IdProof'] : "Banner/noproducts.png";
$AddressProof=$row['AddressProof']!='' ? "vendordocuments/address/".$row['AddressProof'] : "Banner/noproducts.png";
$PanCard=$row['PanCard']!='' ? "vendordocuments/pancard/".$row['PanCard'] : "Banner/noproducts.png";
$Cheque=$row['Cheque']!='' ? "vendordocuments/cheque/".$row['Cheque'] : "Banner/noproducts.png";
?>
      <div class="col-3">

        <div class="form-group">

          <label class="text-dark">Id Proof</label>
<p class="c-detail">
          <img src="<?php echo $idproof;?>" style='width:76px;'>
</p>
        </div>

      </div>

      <div class="col-3">

        <div class="form-group">

          <label class="text-dark">Address Proof</label>

         
<p class="c-detail">
           <img src="<?php echo $AddressProof;?>" style='width:76px;'>
</p>
         
        </div>

      </div>
      <div class="col-3">

        <div class="form-group">

          <label class="text-dark">Pan Card</label>
<p class="c-detail">
          <img src="<?php echo $PanCard;?>" style='width:76px;'>
</p>
        </div>

      </div>
       <div class="col-3">

        <div class="form-group">

          <label class="text-dark">Cheque</label>

         
<p class="c-detail">
            <img src="<?php echo $Cheque;?>" style='width:76px;'>
</p>
         

        </div>

      </div>
    </div>
    <h5 style="color:#000000"><i class="fa fa-file-text" aria-hidden="true"></i> Bank Details</h5>

    <div class="row form-row step_1" style="background: #ffffd0;">

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Bank Name</label>

          <p class="c-detail">

            <?php echo $row['BankName'] ?>

          </p>

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Bank Account No.</label>

          <p class="c-detail">

            <?php echo $row['AccountNo']; ?>

          </p>

        </div>

      </div>

       <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Branch</label>

          <p class="c-detail">

            <?php echo $row['Branch']; ?>

          </p>

        </div>

      </div>

       <div class="col-4">

        <div class="form-group">

          <label class="text-dark">IFSC Code</label>

          <p class="c-detail">

            <?php echo $row['IFSC']; ?>

          </p>

        </div>

      </div>
    </div>

    <h5 style="color:#000000"><i class="fa fa-file-text" aria-hidden="true"></i> Other Details</h5>

    <div class="row form-row step_1">

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Transport</label>

          <p class="c-detail">

            <?php 
        $transsport = Get_Fetch_Data($con,$row['Transportid'], 'transport', 'transport_details');
               echo $transsport['transport']; ?>

          </p>

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Agent Name</label>

          <p class="c-detail">

            <?php 
            $agentname = Get_Fetch_Data($con,$row['Agentid'], 'name', 'agent_details');
               echo $agentname['name']; ?>

          </p>

        </div>

      </div>

       <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Agent Commission</label>

          <p class="c-detail">

            <?php echo $row['Agent_Commission']; ?>

          </p>

        </div>

      </div>

       <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Status</label>

          <p class="c-detail">

            <?php echo $row['Status']; ?>

          </p>

        </div>

      </div>
    </div>

  </form>

  

    

    

    

   

</div>

<?php

  }

  if ($_POST['part'] == 'Invoice_data_View'){

      $row = Get_Fetch_Data($con,$_POST['id'], 'All', 'invoice_details');

      $user = Get_Fetch_Data($con,$row['uid'], 'All', 'customer_details');

  ?>

<div class="modal-header ">

  <h5 class="modal-title">Invoice Details</h5>

  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>

</div>

<div class="modal-body">

  <form method="post" action="" class="table-responsive">

    <h5 style="color:#000000"><i class="fa fa-file-text" aria-hidden="true"></i> Invoice Details</h5>

    <div class="row form-row step_1">

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark"><th>Ref-ID</th></label>

          <p class="c-detail">

            <?php echo $row['orderid']; ?>

          </p>

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Invoice Date</label>

          <p class="c-detail">

            <?php echo $row['order_date']; ?>

          </p>

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Invoice No </label>

          <p class="c-detail">

            <?php echo $row['invoiceno']; ?>

          </p>

        </div>

      </div>
    </div>

    <h5 style="color:#000000"><i class="fa fa-file-text" aria-hidden="true"></i> Billing Address</h5>

    <div class="row form-row step_1" style="background: #f3f1f1;">

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Customer</label>

          <p class="c-detail">

            <?php echo $user['Cname']; ?>

          </p>

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Mobile</label>

          <p class="c-detail">

            <?php echo $user['ccn']; ?>

          </p>

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Address </label>

          <p class="c-detail">

              <?php 

              

              $state = Get_Fetch_Data($con,$user['State'], 'All', 'state_details');

      $city = Get_Fetch_Data($con,$user['City'], 'All', 'city_details');

              ?>

            <?php echo $user['Address'] . " $city[city_name] $state[state_name] - $user[Pincode]"; ?>

          </p>

        </div>

      </div>

    </div>

    

    <h5 style="color:#000000"><i class="fa fa-file-text" aria-hidden="true"></i> Bill Details</h5>

    <div class="row form-row step_1" style="    background: #ffffd0;">

      <div class="col-12">

        <table class="table table-bordered">

          <tr>

            <th>Item</th>
            <th>HSN Code</th>
            <th>Qty</th>
            <th>Rate</th>
            <th>Discount</th>
            <th>Tax</th>
            <th>Amount</th>

          </tr>

          <?php

            $Prdsql = mysqli_query($con,"select * from invoice_item_list where oid='" . $row['id'] . "' order by id");

            while ($Prrow = mysqli_fetch_array($Prdsql))

            {
if($Prrow['sgst']>0){
$Taxs="<div style='font-size:11px;color:red;    white-space: nowrap;'>CGST: $Prrow[cgst_amt] @$Prrow[cgst]%</div><div style='font-size:11px;color:red;    white-space: nowrap;'>SGST: $Prrow[sgst_amt] @$Prrow[sgst]%</div>";	
} else {
$Taxs="<span style='font-size:11px;color:red;white-space: nowrap;'>IGST: $Prrow[igst_amt] @$Prrow[igst]%</span>";
}

                $cProw = Get_Fetch_Data($con,$Prrow['pid'], 'All', 'product_details');

                $hsncode=Get_Fetch_Data($con,$cProw[hsn_code],"hsncode","HsnList");

                echo "<tr><td>$cProw[product]<br>$cProw[barcode]</td><td>$hsncode[hsncode]</td><td>

            $Prrow[qty]</td><td>$Prrow[price]</td><td>$Prrow[Discountamt]</td><td>$Taxs</td><td>$Prrow[amount]</td></tr>";

            }

            ?>

          <tr>

            <td colspan="6">Subtotal</td>

            <td>

              <?php echo number_format((float)$row['subtotal'], 2, '.', ''); ?>

            </td>

          </tr>

          <?php 
          if ($row['discount'] > 0)

            { ?>

          <tr>

            <td colspan="6" style="color:#0C3;">Discount (-)</td>

            <td>

              <?php echo number_format((float)$row['discount'], 2, '.', ''); ?>

            </td>

          </tr>

          <?php

            }

          if ($row['cgstamount'] > 0)

            { ?>

          <tr>

            <td colspan="6" style="color:#dc3545;">CGST Charge(+)</td>

            <td>

              
              <?php echo number_format((float)intval($row['cgstamount']), 2, '.', ''); ?>

            </td>

          </tr>

          <?php

            }


if ($row['sgstamount'] > 0)

            { ?>

          <tr>

            <td colspan="6" style="color:#dc3545;">SGST Charge (+)</td>

            <td>

              <?php echo number_format((float)intval($row['sgstamount']), 2, '.', ''); ?>

            </td>

          </tr>

          <?php

            }
            if ($row['igstamount'] > 0)

            { ?>

          <tr>

            <td colspan="6" style="color:#dc3545;">IGST Charge (+)</td>

            <td>

              <?php echo number_format((float)intval($row['igstamount']), 2, '.', ''); ?>
            </td>

          </tr>

          <?php } 
            $OTsql=mysqli_query($con,"select * from invoice_other_charges where oid='".$row["id"]."'");
			$Otnums=mysqli_num_rows($OTsql);
		  if($Otnums>0) { ?>
          <tr><td colspan="3" >Other Charges</td><td colspan="4">
          <table class="table table-bordered">
<?php
while($OTrow=mysqli_fetch_array($OTsql)){
$Ochrow = Get_Fetch_Data($con,$OTrow['Ocharge'], 'All', 'charges_details');
if($Ochrow['charge_type']=='Plus'){ $Otherchargeval=" (+)"; } else { $Otherchargeval=" (-)"; }
?>
<tr>
<td style="color:#dc3545;width: 253px;" class="text-right"  ><?=$Ochrow[charge_name];?></td>
<td class="text-right pr-3" style="color:#dc3545;"><?=$OTrow[Otherchargeval];?></td>
</tr>
<?php
}
?>
          </table>
          </td></tr>
          <?php } if ($row['roundoff']!='')  { ?>
          <tr>
            <td colspan="6" style="color:#dc3545;">Round off (+/-)</td>
            <td style="color:#dc3545;">
              <?php echo number_format((float)$row['roundoff'], 2, '.', ''); ?>
            </td>
          </tr>
          <?php } ?>

          <tr>

            <td colspan="6"><strong>Final Amount</strong></td>

            <td><strong><?php echo number_format((float)$row['final_amount'], 2, '.', '') ?></strong></td>

          </tr>
          
        </table>

      </div>

    </div>

    

</div>

<?php

  }
if ($_POST['part'] == 'Sale_data_View'){
  $usale = Get_Fetch_Data($con,$_POST['id'], 'All', 'sale_items');
      $row = Get_Fetch_Data($con,$usale['oid'], 'All', 'sale_details');
      $buyername = Get_Fetch_Data($con,$row['buyerid'], 'id,CName', 'buyer_details');
      $suppliername = Get_Fetch_Data($con,$row['supplierid'], 'id,CName', 'supplier');

  ?>

<div class="modal-header ">

  <h5 class="modal-title">Sale Details</h5>

  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>

</div>

<div class="modal-body">

  <form method="post" action="" class="table-responsive">

<div class="col-sm-12 pl-0">  
      <fieldset style="min-height:50px;">
      <legend><b> Sale Details </b> </legend>
      </fieldset>
      </div>
    <div class="row form-row step_1">

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark"><th>Ref-ID</th></label>

          <p class="c-detail">

            <?php echo $row['orderid']; ?>

          </p>

        </div>

      </div>
      

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Sale Date</label>

          <p class="c-detail">

            <?php echo $row['order_date']; ?>

          </p>

        </div>

      </div>

      
    </div>
<div class="col-sm-12 pl-0">  
      <fieldset style="min-height:50px;">
      <legend><b> Vendor Details </b> </legend>
      </fieldset>
      </div>
   
    <div class="row form-row step_1" >

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Buyer Name</label>

          <p class="c-detail">

            <?php echo $buyername['CName']; ?>

          </p>

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Supplier Name</label>

          <p class="c-detail">

            <?php echo $suppliername['CName']; ?>

          </p>

        </div>

      </div>

     
    </div>

<div class="col-sm-12 pl-0">  
      <fieldset style="min-height:50px;">
      <legend><b> Product Details </b> </legend>
      </fieldset>
      </div>
   


    <div class="row form-row step_1" >

      <div class="col-12">

        <table class="table table-bordered">

          <tr>
            <th>Invoice No</th>
            <th>Invoice Date</th>
            <th>Item</th>
            <th>HSN Code</th>
            <th>Qty</th>
            <th>Rate</th>
            <th>Amount</th>

          </tr>

          <?php
$Prdsql = mysqli_query($con,"select * from sale_items where oid='".$usale['oid']."' and Inv_no='".$usale['Inv_no']."' order by id");
while ($Prrow = mysqli_fetch_array($Prdsql))
{
$cProw = Get_Fetch_Data($con,$Prrow['pid'], 'product,hsn_code', 'product_details');
$hsncode = Get_Fetch_Data($con,$cProw['hsn_code'], 'hsncode', 'HsnList');
echo "<tr><td>$Prrow[Inv_no]</td><td>$Prrow[Inv_date]</td><td>$cProw[product]</td><td>$hsncode[hsncode]</td><td>
$Prrow[qty]</td><td>$Prrow[price]</td><td>$Prrow[amount]</td></tr>";
}

            ?>

          
            <?php 
            if($row['IGST']> 0){
            ?>
           <tr>

            <td colspan="4"><strong>IGST</strong></td>

            <td><strong><?php echo number_format((float)$row['IGST'], 2, '.', '') ?></strong></td>

          </tr>
        <?php } if($row['CGST']> 0){?>
<tr>

            <td colspan="4"><strong>CGST</strong></td>

            <td><strong><?php echo number_format((float)$row['CGST'], 2, '.', '') ?></strong></td>

          </tr>
        <?php } if($row['SGST']> 0){ ?>
          <tr>

            <td colspan="4"><strong>SGST</strong></td>

            <td><strong><?php echo number_format((float)$row['SGST'], 2, '.', '') ?></strong></td>

          </tr>
        <?php } ?>
          <tr>

            <td colspan="6"><strong>Final Amount</strong></td>

            <td><strong><?php echo number_format((float)$row['final_amount'], 2, '.', '') ?></strong></td>

          </tr>
          
        </table>

      </div>

    </div>

    

</div>

<?php

  }
  if ($_POST['part'] == 'Saleorder_data_View'){
      $row = Get_Fetch_Data($con,$_POST['id'], 'All', 'salesorder');
      $buyername = Get_Fetch_Data($con,$row['buyerid'], 'id,CName', 'buyer_details');
      $suppliername = Get_Fetch_Data($con,$row['supplierid'], 'id,CName', 'supplier');

  ?>

<div class="modal-header ">

  <h5 class="modal-title">Sale Order Details</h5>

  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>

</div>

<div class="modal-body">

<form method="post" action="" class="table-responsive">
<div class="col-sm-12 pl-0">  
      <fieldset style="min-height:50px;">
      <legend><b> Sale Details </b> </legend>
      </fieldset>
      </div>
    <div class="row form-row step_1">
      <div class="col-4">
        <div class="form-group">

          <label class="text-dark"><th>Ref-ID</th></label>

          <p class="c-detail">

            <?php echo $row['orderid']; ?>

          </p>

        </div>

      </div>
     

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Sale Order Date</label>

          <p class="c-detail">

            <?php echo $row['order_date']; ?>

          </p>

        </div>

      </div>

      <?php 
      $tname=Get_Fetch_Data($con,$row['transport'],"transport","transport_details");
      ?>
      <div class="col-4">
        <div class="form-group">
          <label class="text-dark">Transport Name</label>
          <p class="c-detail">
            <?php echo $tname['transport']; ?>
          </p>
        </div>
      </div>

      <div class="col-4">
        <div class="form-group">
          <label class="text-dark">Dispatch (In Days)</label>
          <p class="c-detail">
            <?php echo $row['dispatch_days']; ?>
          </p>
        </div>
      </div>

      <div class="col-4">
        <div class="form-group">
          <label class="text-dark">Order Mode</label>
          <p class="c-detail">
            <?php echo ($row['order_mode']=='1')?('On Call'):('Party Visit')?>
          </p>
        </div>
      </div>

      <div class="col-4">
        <div class="form-group">
          <label class="text-dark">City/Outer</label>
          <p class="c-detail">
            <?php echo $row['supplier_city_other']; ?>
          </p>
        </div>
      </div>

      
    </div>
	<div class="col-sm-12 pl-0">  
      <fieldset style="min-height:50px;">
      <legend><b> Vendor Details </b> </legend>
      </fieldset>
      </div>

 

    <div class="row form-row step_1" >

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Buyer Name</label>

          <p class="c-detail">

            <?php echo $buyername['CName']; ?>

          </p>

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Supplier Name</label>

          <p class="c-detail">

            <?php echo $suppliername['CName']; ?>

          </p>

        </div>

      </div>

     
    </div>
    <div class="col-sm-12 pl-0">  
      <fieldset style="min-height:50px;">
      <legend><b> Other Details </b> </legend>
      </fieldset>
      </div>

      <div class="row form-row step_1" >

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Transport Name</label>

          <p class="c-detail">

            <?php  
$transportname=Get_Fetch_Data_fiedls($con,$row["transport"],"id","transport","transport_details");
            echo $transportname['transport']; ?>

          </p>

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Item Dispatch Days</label>

          <p class="c-detail">

            <?php echo $row['dispatch_days']; ?>

          </p>

        </div>

      </div>
      <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Gst</label>

          <p class="c-detail">

            <?php 
            if($row['gstslot']=="Manual" && $row['manualgst']!=''){$manualgst=":".$row['manualgst'];}else{$manualgst="";}
            echo $row['gstslot']; 
            ?>&nbsp;<?php echo $manualgst;?>

          </p>

        </div>

      </div>

     
    </div>

    <div class="col-sm-12 pl-0">  
      <fieldset style="min-height:50px;">
      <legend><b> Product Details </b> </legend>
      </fieldset>
      </div>


    <div class="row form-row step_1" >

      <div class="col-12">
        <table class="table table-bordered">
          <tr>
            <th>Photo</th>
            <th>Item</th>
            <th>HSN Code</th>
            <th>UOM</th>
            <th>Total Qty</th>
            <th>Recieved Qty</th>
            <th>Rate</th>
            <th>Amount</th>
          </tr>

          <?php
          $Prdsql = mysqli_query($con,"select * from salesorder_items where oid='".$row['id']."' order by id");
          while ($Prrow = mysqli_fetch_array($Prdsql)) {
            $Pendingqty=$Prrow['qty'] - $Prrow['Tot_qty'];
            $cProw = Get_Fetch_Data($con,$Prrow['pid'], 'product,hsn_code', 'product_details');
            $unitArr = Get_Fetch_Data($con,$Prrow['unit'], 'unit_name', 'unit_details');

            if($Prrow['prod_img']) {
              $Photos="<a href='$URLS/SOttachment/".$Prrow['prod_img']."' data-lightbox='photos'><img src='$URLS/SOttachment/".$Prrow['prod_img']."' style='width:40px;'></a>";
            }
            else {
              $Photos="<a href='$URLS/Banner/noimagesa.jpg' data-lightbox='photos'><img src='$URLS/Banner/noimagesa.jpg' style='width: 40px;height: 40px;border-radius: 50%;'></a>"; 
            }

            echo "<tr><td>$Photos</td><td>$cProw[product]</td><td>$cProw[hsn_code]</td><td>$unitArr[unit_name]</td><td>
            $Prrow[qty]</td><td>Recieved : $Prrow[Tot_qty]<br>Pending : $Pendingqty</td><td>$Prrow[price]</td><td>$Prrow[amount]</td></tr>";
          }

            ?>
            <tr>
            <td colspan="6"><strong>SubTotal</strong></td>
            <td><strong><?php echo number_format((float)$row['subtotal'], 2, '.', '') ?></strong></td>
            </tr>

            <tr>
            <td colspan="6"><strong>Special Discount(%)</strong> (Payment In <?php echo $row['payment_days']?> Days)</td>
            <td><strong><?php echo $row['special_discount'] ?></strong></td>
            </tr>
          
            <!-- <?php 
            if($row['IGST']> 0){
            ?>
            <tr>
            <td colspan="5"><strong>IGST</strong></td>
            <td><strong><?php echo number_format((float)$row['IGST'], 2, '.', '') ?></strong></td>
            </tr>
            <?php } if($row['CGST']> 0){?>
            <tr>
            <td colspan="5"><strong>CGST</strong></td>
            <td><strong><?php echo number_format((float)$row['CGST'], 2, '.', '') ?></strong></td>
            </tr>
            <?php } if($row['SGST']> 0){ ?>
            <tr>
            <td colspan="5"><strong>SGST</strong></td>
            <td><strong><?php echo number_format((float)$row['SGST'], 2, '.', '') ?></strong></td>
            </tr>
            <?php } ?> -->

            <tr>
            <td colspan="6"><strong>Final Amount</strong></td>
            <td><strong><?php echo number_format((float)$row['final_amount'], 2, '.', '') ?></strong></td>
            </tr>
          
        </table>

      </div>

    </div>

    

</div>

<?php

  }
  if ($_POST['part'] == 'Payment_Details'){
      $row = Get_Fetch_Data($con,$_POST['id'], 'All', 'All_Payment');
      $supplier = Get_Fetch_Data($con,$row['Supplierid'], 'CName', 'supplier');
      $srefn = Get_Fetch_Data($con,$row['oid'], 'orderid,invoiceno,order_date', 'sale_details');
      
  ?>
<div class="modal-header ">
  <h5 class="modal-title">Payment Details</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
</div>
<div class="modal-body">

  <form method="post" action="" class="table-responsive">

    <h6 style="color:#000000"><i class="fa fa-file-text" aria-hidden="true"></i> Payment Details</h6>

    <div class="row form-row step_1">

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark"><th>Ref-ID</th></label>

          <p class="c-detail m-0">

           <?php echo $row['slipno']!='' ? $row['slipno'] : $srefn['orderid'];?>

          </p>

        </div>

      </div>
      <div class="col-4">

        <div class="form-group">

          <label class="text-dark"><th>Invoice No</th></label>

          <p class="c-detail m-0">

           <?php echo $row['pinvoice']!='' ? $row['pinvoice'] : $srefn['invoiceno'];?>

          </p>

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Payment Date</label>

          <p class="c-detail m-0">

            <?php echo $row['Reciept_date']!='' ? $row['Reciept_date'] : $srefn['order_date']; ?>

          </p>

        </div>

      </div>
      <?php if($row['PaymentMode']!=''){?>
      <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Payment Mode</label>

          <p class="c-detail m-0">

            <?php 
            if($row['PaymentMode']=="1"){
  $paymentmode="Cash";
}elseif($row['PaymentMode']=="2"){
  $paymentmode="Upi";
}elseif($row['PaymentMode']=="3"){
  $paymentmode="Net Banking";
}elseif($row['PaymentMode']=="4"){
  $paymentmode="Cheque";
}else{
 $paymentmode=""; 
} 
echo $paymentmode;
?>

          </p>

        </div>

      </div>
<?php } if($row['Remark']!=''){ ?>
        
       <div class="col-8">
        <div class="form-group">
          <label class="text-dark">Note </label>
          <p class="c-detail">
            <?php echo $row['Remark']; ?>
          </p>
        </div>
      </div>
    <?php } ?>
      <div class="col-8">
        <div class="form-group">
          <label class="text-dark">Add Time </label>
          <p class="c-detail">
            <?php echo $row['add_time']; ?>
          </p>
        </div>
      </div>
      <div class="col-4">
        <div class="form-group">
          <?php if($row['Attachement']!=''){ ?>
          <a href="OAttachment/<?=$row['Attachement'];?>" download class="btn btn-sm bg-success mr-2 float-right text-white font-weight-bold">Download Attachment</a>
          <?php } ?>
        </div>
      </div>
    </div>

    <h6 style="color:#000000"><i class="fa fa-file-text" aria-hidden="true"></i> Buyer Details</h6>
<?php 
  $buyer = Get_Fetch_Data($con,$row['Buyerid'], 'Name,CName,PMobile', 'buyer_details');
?>
    <div class="row form-row step_1" >

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Name</label>

          <p class="c-detail">

            <?php echo $buyer['Name']; ?>

          </p>

        </div>

      </div>
       <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Company Name</label>

          <p class="c-detail">

            <?php echo $buyer['CName']; ?>

          </p>

        </div>

      </div>
      

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Mobile</label>

          <p class="c-detail">

            <?php echo $buyer['PMobile']; ?>

          </p>

        </div>

      </div>

      

    </div>

    

    <h6 style="color:#000000"><i class="fa fa-file-text" aria-hidden="true"></i> Item Details</h6>

    <div class="row form-row step_1"  >

      <div class="col-12">

<table class="table table-bordered">

          <tr>
            <th>Sale Ref-No</th>
            <th>Total Amount</th>
            <th>Paid AMount</th>
          </tr>

<?php
$Prdsql = mysqli_query($con,"select * from Sale_payment_details where paymentid='" . $row['id'] . "' order by id");
$subtotalamount="";
$totalamount="";
while ($Prrow = mysqli_fetch_array($Prdsql)){
  $subtotalamount+=$Prrow['AmountPaid'];
  $totalamount+=$Prrow['AmountPay'];
$saleref=Get_Fetch_Data($con,$Prrow["oid"],"orderid","sale_details");

echo "<tr><td>$saleref[orderid]</td><td>$Prrow[AmountPay]</td><td>$Prrow[AmountPaid]</td></tr>";
}
?>

          <tr>

            <td colspan="2" class="text-right">Subtotal</td>
            <td class="text-right">
              <?php echo number_format((float)$subtotalamount, 2, '.', ''); ?>
            </td>
          </tr>
          <?php 
		  if ($row['GSReturn'] > 0) {  ?>
          <tr>
            <td colspan="2" class="text-right" style="color:#0C3;">GS Return (+)</td>
            <td style="color:#0C3;" class="text-right">
              <?php echo number_format((float)$row['GSReturn'], 2, '.', ''); ?>
            </td>
          </tr>
          
          <?php } ?>

		  
          


          <!-- </table> -->
          </td></tr>
          
         
          <tr>
            <td colspan="2" class="text-right"><strong>Final Amount</strong></td>
            <td class="text-right"><strong><?php echo $totalamount; ?></strong></td>
          </tr>
        </table>

      </div>

    </div>

    

  </form>

 

</div>

<?php

  }
  if ($_POST['part'] == 'Bill_data_View'){
$row = Get_Fetch_Data($con,$_POST['id'], 'All', 'bill_details');
      $user = Get_Fetch_Data($con,$row['uid'], 'All', 'vendor_details');
      ?>
<div class="modal-header ">
  <h5 class="modal-title">Bill Details</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
</div>
<div class="modal-body">

  <form method="post" action="" class="table-responsive">

    <h6 style="color:#000000"><i class="fa fa-file-text" aria-hidden="true"></i> Bill Details</h6>

    <div class="row form-row step_1">

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark"><th>Ref-ID</th></label>

          <p class="c-detail">

            <?php echo $row['bill_no']; ?>

          </p>

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Bill Date</label>

          <p class="c-detail">

            <?php echo $row['invoice_date']; ?>

          </p>

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Invoice No </label>

          <p class="c-detail">

            <?php echo $row['invoice_no']; ?>

          </p>

        </div>

      </div>
       <div class="col-8">
        <div class="form-group">
          <label class="text-dark">Note </label>
          <p class="c-detail">
            <?php echo $row['bill_note']; ?>
          </p>
        </div>
      </div>
      <div class="col-4">
        <div class="form-group">
          <?php if($row['attachmet']!=''){ ?>
          <a href="OAttachment/<?=$row['attachmet'];?>" download class="btn btn-sm bg-success mr-2 float-right text-white font-weight-bold">Download Attachment</a>
          <?php } ?>
        </div>
      </div>
    </div>

    <h6 style="color:#000000"><i class="fa fa-file-text" aria-hidden="true"></i> Supplier Details</h6>

    <div class="row form-row step_1"  >

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Name</label>

          <p class="c-detail">

            <?php echo $user['FName']. $user['LName']; ?>

          </p>

        </div>

      </div>
       <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Company Name</label>

          <p class="c-detail">

            <?php echo $user['Cname']; ?>

          </p>

        </div>

      </div>
      <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Supplier Code</label>

          <p class="c-detail">

            <?php echo $user['Vendor_Code']; ?>

          </p>

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Mobile</label>

          <p class="c-detail">

            <?php echo $user['scn']; ?>

          </p>

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Address </label>

          <p class="c-detail">

              <?php 

              

              $state = Get_Fetch_Data($con,$user['State'], 'All', 'state_details');

      $city = Get_Fetch_Data($con,$user['City'], 'All', 'city_details');

              ?>

            <?php echo $user['Address'] . " $city[city_name] $state[state_name] - $user[Pincode]"; ?>

          </p>

        </div>

      </div>

    </div>

    

    <h6 style="color:#000000"><i class="fa fa-file-text" aria-hidden="true"></i> Item Details</h6>

    <div class="row form-row step_1"  >

      <div class="col-12">

        <table class="table table-bordered">

          <tr>

            <th>Item</th>

            <th>HSN Code</th>

            <th>Rate</th>

            <th>Qty</th>
			<th>Discount</th>
            <th>Tax</th>
            <th class="text-right">Amount</th>
          </tr>
          <?php
            $Prdsql = mysqli_query($con,"select * from bill_items where oid='" . $row['id'] . "' order by id");
            while ($Prrow = mysqli_fetch_array($Prdsql))
            {

              $vendorcode=Get_Fetch_Data($con,$Prrow["sid"],"id,Vendor_Code","vendor_details");
                $cProw = Get_Fetch_Data($con,$Prrow['pid'], 'All', 'product_details');
                $hsncode=Get_Fetch_Data($con,$cProw[hsn_code],"hsncode","HsnList");
                $Item = Get_Fetch_Data($con,$Prrow['item'], 'id,cat_code', 'product_catalogue');
if($Prrow["cgst_amt"]>0){
$Tax="<div style='font-size:12px;color:green;'>CGST: $Prrow[cgst_amt] @$Prrow[cgst]%</div><div style='font-size:12px;color:green;'>SGST: $Prrow[sgst_amt] @$Prrow[sgst]%</div>";
} else {
$Tax="<span style='font-size:12px;color:green;'>IGST: $Prrow[igst_amt] @$Prrow[igst]%</span>"; 
}
if($Prrow['DiscountType']=='Percent'){
$DiscountType="$Prrow[DiscountVal]%";	
} else {
$DiscountType="₹ $Prrow[DiscountVal]";	
}
if($Prrow['Discountamt']>0){
$Discountamt="<div style='font-size:11px;color:red;white-space: nowrap;'>$Prrow[Discountamt] @$DiscountType</div>";	
} else {
$Discountamt="";	
}
echo "<tr><td>$cProw[product] - $vendorcode[Vendor_Code]<br><span style='font-size:12px;'>$cProw[description]</span></td><td>$hsncode[hsncode]</td><td>
$Discountamt</td><td>$Tax</td><td >$Prrow[price]</br></td><td>

            $Prrow[qty]</div></td><td class='text-right'>$Prrow[amount]</td></tr>";

            }


          if ($row['discount'] > 0) {  ?>

          <tr>

            <td colspan="6" style="color:#0C3;text-align:right">Discount [<?= $DisVal;?>] (-)</td>

            <td style="color:#0C3;text-align:right">

              <?php echo number_format((float)$row['discount'], 2, '.', ''); ?>

            </td>

          </tr>

          <?php } if ($row['cgstamount'] > 0){ ?>
          <tr>

            <td colspan="6" style="color:#dc3545;text-align:right">CGST (+)</td>

            <td style="color:#dc3545;text-align:right">

              <?php echo number_format((float)intval($row['cgstamount']), 2, '.', ''); ?></td>

          </tr>

          <?php } if ($row['sgstamount'] > 0) { ?>

          <tr>

            <td colspan="6" style="color:#dc3545;text-align:right">SGST (+)</td>

            <td style="color:#dc3545;text-align:right">

              <?php echo number_format((float)intval($row['sgstamount']), 2, '.', ''); ?>

            </td>

          </tr>

          <?php } if ($row['igstamount'] > 0)  { ?>

          <tr>

            <td colspan="6" style="color:#dc3545;text-align:right">IGST (+)</td>

            <td style="color:#dc3545;text-align:right">

              <?php echo number_format((float)intval($row['igstamount']), 2, '.', ''); ?>

            </td>

          </tr>

          <?php } 
$OTsql=mysqli_query($con,"select * from bill_other_charges where oid='".$row["id"]."'");
$Otnums=mysqli_num_rows($OTsql);
		  if($Otnums>0) { ?>
          <tr><td colspan="3">Other Charges</td><td colspan="4">
          <table class="table table-bordered">
<?php
while($OTrow=mysqli_fetch_array($OTsql)){
$Ochrow = Get_Fetch_Data($con,$OTrow['Ocharge'], 'All', 'charges_details');
if($Ochrow['charge_type']=='Plus'){ $Otherchargeval=" (+)"; } else { $Otherchargeval=" (-)"; }
?>
<tr>
<td style="color:#dc3545;"><?=$Ochrow[charge_name].$Otherchargeval;?></td>
<td class="text-right pr-3" style="color:#dc3545;"><?=$OTrow[Othercharge];?></td>
</tr>
<?php
}
?>
          </table>
          </td></tr>
          <?php } ?>
          <tr>
            <td colspan="6" style="text-align:right"><strong>Final Amount</strong></td>
            <td style="text-align:right"><strong><?php echo $row['final_amount']; ?></strong></td>
          </tr>

        </table>

      </div>

    </div>

    

  </form>

 

</div>
  <?php } 

  if ($_REQUEST['part'] == 'Update_Shipping_Box')

  {

      $row = Get_Fetch_Data($con,$_POST['id'], 'All', 'order_details');

  

  ?>

<div class="modal-header ">

  <h5 class="modal-title">Update Order Shipping</h5>

  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>

</div>

<div class="modal-body">

  <form method="post" action="" class="table-responsive">

    <table class="table table-bordered" style="margin:10px; color:#000; margin-bottom:10px; width:98%;">

      <tr>

        <td width="25%"><strong>Order ID</strong></td>

        <td width="35%">

          <?php echo $row['orderid']; ?>

        </td>

        <td width="25%"><strong>Order Status</strong></td>

        <td width="35%">

          <?php echo $row['status']; ?>

        </td>

      </tr>

      <tr>

        <td width="25%"><strong>Payment Status</strong></td>

        <td width="35%">

          <?php echo $row['payment_status']; ?>

        </td>

        <td width="25%"><strong>Transaction Id</strong></td>

        <td width="35%">

          <?php echo $row['txn_id']; ?>

        </td>

      </tr>

    </table>

    <table class="table table-bordered" style="margin:10px; color:#000; margin-bottom:10px; width:98%;">

      <tr>

        <th colspan="2">Shipping Address</th>

      </tr>

      <tr>

        <td>Name</td>

        <td>

          <input type="text" class="form-control" name="name" value="<?php echo $row['name']; ?>" />

        </td>

      </tr>

      <tr>

        <td>Mobile</td>

        <td>

          <input type="text" class="form-control" name="mobile" value="<?php echo $row['mobile']; ?>" />

        </td>

      </tr>

      <tr>

        <td>Address</td>

        <td colspan="3">

          <textarea class="form-control" name="address">

          <?php echo $row['address']; ?>

          </textarea>

        </td>

      </tr>

      <tr>

        <td>State</td>

        <td>

          <input type="text" class="form-control" name="state" value="<?php echo $row['state']; ?>" />

        </td>

      </tr>

      <tr>

        <td>City</td>

        <td>

          <input type="text" class="form-control" name="city" value="<?php echo $row['city']; ?>" />

        </td>

      </tr>

      <tr>

        <td>Pincode</td>

        <td>

          <input type="text" class="form-control" name="pincode" value="<?php echo $row['pincode']; ?>" />

        </td>

      </tr>

      <tr>

        <td colspan="2">

          <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

          <input type="hidden" name="random_move" value="<?php echo $_SESSION['random_move']; ?>">

          <button class="btn btn-success" name="UpdateShipping">Update</button>

        </td>

      </tr>

    </table>

  </form>

</div>

<?php

  }

  if ($_REQUEST['part'] == 'All_notification_List')

  {

      $requestData = $_REQUEST;

      if ($_REQUEST['from'] != '' && $_REQUEST['to'] != '')

      {

          $ff = explode('/', $_REQUEST['from']);

          $from = $ff[2] . '-' . $ff[1] . '-' . $ff[0];

          $tt = explode('/', $_REQUEST['to']);

          $to = $tt[2] . '-' . $tt[1] . '-' . $tt[0];

          $where .= " and STR_TO_DATE(`send_time`, '%d/%m/%Y') between '" . $from . "' and '" . $to . "'";

      }

      $sqls = "SELECT * FROM team_notification where user_type='Admin' $where";

      $sql = "SELECT * FROM team_notification where user_type='Admin' $where";

      $querys = mysqli_query($con,$sqls);

      $totalData = mysqli_num_rows($querys);

      $totalFiltered = $totalData;

      if (!empty($requestData['search']['value']))

      { // if there is a search parameter, $requestData['search']['value'] contains search parameter

          $sql .= " AND ( subject LIKE '%" . $requestData['search']['value'] . "%' ";

          $sql .= " OR message LIKE '%" . $requestData['search']['value'] . "%'";

          $sql .= " OR purpose LIKE '%" . $requestData['search']['value'] . "%' )";

      }

      $sql .= "  ORDER BY id desc  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";

      //echo $sqls;

      $query = mysqli_query($sql);

      //$totalFiltered = mysql_num_rows($query);

      $data = array();

      $i = 1;

      while ($row = mysqli_fetch_array($query))

      { // preparing an array

          $action = "<input type='hidden' class='id' value=" . $row['id'] . ">

  <span style='white-space:nowrap;float: right;'>

  <a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></a></span>";

          $nestedData = array();

          $nestedData[] = "<div class='first'>$row[subject]</div>";

          $nestedData[] = "<div class='first'>$row[message]</div>";

          $nestedData[] = "<div class='first'>$row[purpose]</div>";

          $nestedData[] = "<div class='first'>$row[send_time]</div>";

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

  //Alerts

  if ($_REQUEST['part'] == 'All_Alerts_Data')

  {

      $requestData = $_REQUEST;

      if ($_REQUEST['from'] != '' && $_REQUEST['to'] != '')

      {

          $ff = explode('/', $_REQUEST['from']);

          $from = $ff[2] . '-' . $ff[1] . '-' . $ff[0];

          $tt = explode('/', $_REQUEST['to']);

          $to = $tt[2] . '-' . $tt[1] . '-' . $tt[0];

          $where .= " and STR_TO_DATE(`expiry`, '%d/%m/%Y') between '" . $from . "' and '" . $to . "'";

      }

      if ($_REQUEST['status'] != '')

      {

          $where .= " and status='" . $_REQUEST['status'] . "'";

      }

      $sqls = "SELECT * FROM alert_details where id!='' $where";

      $sql = "SELECT *,STR_TO_DATE(`expiry`, '%d/%m/%Y') as expirydate FROM alert_details where id!='' $where";

      $querys = mysqli_query($con,$sqls);

      $totalData = mysqli_num_rows($querys);

      $totalFiltered = $totalData;

      if (!empty($requestData['search']['value']))

      { // if there is a search parameter, $requestData['search']['value'] contains search parameter

          $sql .= " AND ( message LIKE '%" . $requestData['search']['value'] . "%' ";

          $sql .= " OR expiry LIKE '%" . $requestData['search']['value'] . "%'";

          $sql .= " OR start_date LIKE '%" . $requestData['search']['value'] . "%'";

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

          $coupon = "<span class='badge badge-pill bg-primary inv-badge'>$row[coupon]</span><br>";

          $action = "<input type='hidden' class='id' value=" . $row['id'] . ">

  <span style='white-space:nowrap;float: right;'>

  <a class='btn btn-sm bg-success-light updateLinks' href='javascript:void'><i class='fe fe-pencil'></i></a>&nbsp;

  <a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></a></span>";

          if ($row[status] == 'Active')

          {

              $class = 'bg-success';

          }

          else

          {

              $class = 'bg-danger';

          }

          if ($row['expirydate'] >= date('Y-m-d'))

          {

              $Copstatus = "";

          }

          else

          {

              $Copstatus = "<br><span class='badge badge-pill bg-danger inv-badge'>Expired</span>";

          }

          if ($row['images'] != '')

          {

              $photo = "<a href='../seller/Banner/" . $row['images'] . "' target='_blank'><img src='../seller/Banner/" . $row['images'] . "' height='50' width='50' style='border-radius: 50%;'></a>";

          }

          else

          {

              $photo = "#NA";

          }

          $Response = Get_Count_Data($con,$row['id'], 'alert_id', 'alert_response');

          $nestedData = array();

          $nestedData[] = "<div class='first'>$row[alert_for]</div>";

          $nestedData[] = "<div class='first'>$row[message]</div>";

          $nestedData[] = "$photo";

          $nestedData[] = "<div class='first'>$row[start_date]</div>";

          $nestedData[] = "<div class='third'>$row[expiry]$Copstatus</div>";

          $nestedData[] = "<a href='AlertResponse.php?alert_id=$row[id]'>$Response</a>";

          $nestedData[] = "<div class='third'><span class='badge badge-pill $class inv-badge'>$row[status]</span></div>";

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

  if ($_POST['part'] == 'Alerts_data_Update')

  {

      $row = Get_Fetch_Data($con,$_POST['id'], 'All', 'alert_details');

  ?>

<div class="modal-header ">

  <h5 class="modal-title">Update Alert Details</h5>

  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>

</div>

<div class="modal-body">

  <form action="" method="post" enctype="multipart/form-data">

    <div class="row form-row">

      <div class="col-12">

        <div class="form-group">

          <label> Message </label>

          <textarea class="form-control Capitalize" name="message" required>

          <?php echo $row['message']; ?>

          </textarea>

        </div>

      </div>

      <div class="col-12">

        <div class="form-group">

          <label> Update Image </label>

          <input type="file" class="form-control UploaderFile" name="images"> 

        </div>

      </div>

      <div class="col-6">

        <div class="form-group">

          <label> Start Date </label>

          <input type="text" class="form-control datepicker" value="<?php echo $row['start_date']; ?>" name="start_date" required> 

        </div>

      </div>

      <div class="col-6">

        <div class="form-group">

          <label> Expiry Date </label>

          <input type="text" class="form-control datepicker" value="<?php echo $row['expiry']; ?>" name="expiry" required> 

        </div>

      </div>

      <div class="col-6">

        <div class="form-group">

          <label>Alert For</label>

          <select class="form-control" name="alert_for">

          <?php

            $arr = array(

                'Team',

                'Supplier'

            );

            foreach ($arr as $alert_for)

            {

                if ($alert_for == $row['alert_for'])

                {

                    echo "<option value=" . $alert_for . " selected>$alert_for</option>";

                }

                else

                {

                    echo "<option value=" . $alert_for . ">$alert_for</option>";

                }

            }

            ?>

          </select>

        </div>

      </div>

      <div class="col-6">

        <div class="form-group">

          <label>Status</label>

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

    <button class="btn btn-success" name="UpdateAlert">Update</button>

  </form>

</div>

<?php

  }

  

  if ($_REQUEST['part'] == 'All_Alerts_Response_Data')

  {

      $requestData = $_REQUEST;

      if ($_REQUEST['from'] != '' && $_REQUEST['to'] != '')

      {

          $ff = explode('/', $_REQUEST['from']);

          $from = $ff[2] . '-' . $ff[1] . '-' . $ff[0];

          $tt = explode('/', $_REQUEST['to']);

          $to = $tt[2] . '-' . $tt[1] . '-' . $tt[0];

          $where .= " and STR_TO_DATE(`add_time`, '%d/%m/%Y') between '" . $from . "' and '" . $to . "'";

      }

      if ($_REQUEST['user_type'] != '')

      {

          $where .= " and user_type='" . $_REQUEST['user_type'] . "'";

      }

      if ($_REQUEST['alert_id'] != '')

      {

          $where .= " and alert_id='" . $_REQUEST['alert_id'] . "'";

      }

      $sqls = "SELECT * FROM alert_response where id!='' $where";

      $sql = "SELECT * FROM alert_response where id!='' $where";

      $querys = mysqli_query($con,$sqls);

      $totalData = mysqli_num_rows($querys);

      $totalFiltered = $totalData;

      if (!empty($requestData['search']['value']))

      { // if there is a search parameter, $requestData['search']['value'] contains search parameter

          $sql .= " AND ( user_type LIKE '%" . $requestData['search']['value'] . "%' ";

          $sql .= " OR action LIKE '%" . $requestData['search']['value'] . "%'";

          $sql .= " OR add_time LIKE '%" . $requestData['search']['value'] . "%' )";

      }

      $sql .= "  ORDER BY id desc  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";

      //echo $sqls;

      $query = mysqli_query($con,$sql);

      //$totalFiltered = mysql_num_rows($query);

      $data = array();

      $i = 1;

      while ($row = mysqli_fetch_array($query))

      { // preparing an array

          $action = "<input type='hidden' class='id' value=" . $row['id'] . ">

  <span style='white-space:nowrap;float: right;'>

  <a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></a></span>";

          if ($row['action'] == 'Accept')

          {

              $class = 'bg-success';

          }

          else

          {

              $class = 'bg-danger';

          }

          if ($row['user_type'] == 'Team')

          {

              $User = Get_Fetch_Data($con,$row['uid'], 'id,name,mobile', 'admin_signup');

          }

          else

          {

              $User = Get_Fetch_Data($con,$row['uid'], 'id,company,name,mobile', 'supplier_details');

          }

          $nestedData = array();

          $nestedData[] = "<div class='first'>$User[name]</div>";

          $nestedData[] = "<div class='first'>$User[mobile]</div>";

          $nestedData[] = "<div class='first'>$row[action]</div>";

          $nestedData[] = "<div class='third'>$row[add_time]</div>";

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

  

  if ($_REQUEST['part'] == 'Supplier_Order_Data_Part')

  {

      $requestData = $_REQUEST;

      if ($_REQUEST['from'] != '' && $_REQUEST['to'] != '')

      {

          $ff = explode('/', $_REQUEST['from']);

          $from = $ff[2] . '-' . $ff[1] . '-' . $ff[0];

          $tt = explode('/', $_REQUEST['to']);

          $to = $tt[2] . '-' . $tt[1] . '-' . $tt[0];

          $where .= " and STR_TO_DATE(`ordertime`, '%d/%m/%Y') between '" . $from . "' and '" . $to . "'";

      }

      if ($_REQUEST['status'] != '')

      {

          $where .= " and sup_status='" . $_REQUEST['status'] . "'";

      }

      if ($_REQUEST['supplier'] != '')

      {

          $where .= " and pds.supplier='" . $_REQUEST['supplier'] . "'";

      }

      $sqls = "SELECT op.* FROM `order_product` op left join product_details pds on op.pid=pds.id where pds.id!='' $where";

      $sql = "SELECT op.* FROM `order_product` op left join product_details pds on op.pid=pds.id where pds.id!='' $where";

      $querys = mysqli_query($con,$sqls);

      $totalData = mysqli_num_rows($querys);

      $totalFiltered = $totalData;

      if (!empty($requestData['search']['value']))

      { // if there is a search parameter, $requestData['search']['value'] contains search parameter

          $sql .= " AND ( ordertime LIKE '%" . $requestData['search']['value'] . "%' ";

          $sql .= " OR product LIKE '%" . $requestData['search']['value'] . "%'";

          $sql .= " OR pr_code LIKE '%" . $requestData['search']['value'] . "%'";

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

          $coupon = "<span class='badge badge-pill bg-primary inv-badge'>$row[coupon]</span><br>";

          $action = "<input type='hidden' class='id' value=" . $row['id'] . ">

  <span style='white-space:nowrap;float: right;'>

  <a class='btn btn-sm bg-success-light viewLinks' href='javascript:void'><i class='fe fe-search'></i></a>";

          if ($row['sup_status'] == 'Delivered')

          {

              $class = 'bg-success';

              $Prints = "";

          }

          else if ($row['sup_status'] == 'Pending' || $row['sup_status'] == 'Placed')

          {

              $class = 'bg-warning';

              $Prints = "";

          }

          else if ($row['sup_status'] == 'Dispatch')

          {

              $class = 'bg-primary';

              $Prints = "<a href='PrintBill.php?pid=" . $row['id'] . "' class='badge badge-pill bg-info inv-badge'>Print Bill</a>";

          }

          else

          {

              $class = 'bg-danger';

              $Prints = "";

          }

          $order = Get_Fetch_Data($con,$row['oid'], 'id,orderid', 'order_details');

          $product = Get_Fetch_Data($con,$row['pid'], 'All', 'product_details');

          if ($product['supplier'] != 0)

          {

              $supplier = Get_Fetch_Data($con,$product['supplier'], 'id,company', 'supplier_details');

              $Reseller = "<span class='badge badge-pill bg-primary inv-badge'>$supplier[company]</span><br>";

          }

          else

          {

              $Reseller = "";

          }

  

          $ProductPic = Get_Product_Images($con,$product['id']);

          if ($ProductPic != '')

          {

              $ProductImages = "$ProductPic";

          }

          else

          {

              $ProductImages = "noproducts.png";

          }

          $CustPrice = number_format((float)$product['cust_price'], 2, '.', '');

          $TotalCustPrice = $product['cust_price'] * $row['qty'];

          $SupPrice = number_format((float)$product['supplier_price'], 2, '.', '');

          $TotalSupPrice = $product['supplier_price'] * $row['qty'];

          $nestedData = array();

          $nestedData[] = "<div class='first'><input type='hidden' class='oid' value=" . $row['oid'] . "><a href='javascript:void' class='badge badge-pill bg-primary inv-badge ViewOrder'>$order[orderid]</a></div>";

          $nestedData[] = "<div class='first'>$row[ordertime]</div>";

          $nestedData[] = "<a href='http://avbpl.com/website/product-details.php?pid=" . $product['id'] . "' target='_blank'><img src='$URLS/seller/Product/$ProductImages' style='height:70px;width:70px;border-color: aliceblue !important;;padding: 4px;border: 1px solid;'></a>";

          $nestedData[] = "<div class='first'>$Reseller$product[product] - $product[pr_code]</div>";

          $nestedData[] = "<div class='first'>$CustPrice<br>$SupPrice</div>";

          $nestedData[] = "<div class='first'>$row[qty]</div>";

          $nestedData[] = "<div class='first'>" . number_format((float)$TotalCustPrice, 2, '.', '') . "<br>" . number_format((float)$TotalSupPrice, 2, '.', '') . "</div>";

          $nestedData[] = "<div class='third'><span class='badge badge-pill $class inv-badge'>$row[sup_status]</span>$Prints</div>";

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

  if ($_POST['part'] == 'Supplier_Order_data_View'){

      $order = Get_Fetch_Data($con,$_POST['id'], 'All', 'order_product');

      $row = Get_Fetch_Data($con,$order['oid'], 'All', 'order_details');

      $product = Get_Fetch_Data($con,$order['pid'], 'All', 'product_details');

      $ProductPic = Get_Product_Images($con,$product['id']);

      if ($ProductPic != '')

      {

          $ProductImages = "$ProductPic";

      }

      else

      {

          $ProductImages = "noproducts.png";

      }

      $TotalPrice = $product['supplier_price'] * $order['qty'];

  ?>

<div class="modal-header ">

  <h5 class="modal-title">Order Details</h5>

  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>

</div>

<div class="modal-body">

  <form method="post" action="">

    <table class="table table-bordered" style="margin:10px; color:#000; margin-bottom:10px; width:98%;">

      <tr>

        <td><strong>Order ID</strong></td>

        <td>

          <?php echo $row['orderid']; ?>

        </td>

      </tr>

      <tr>

        <td><strong>Order Date</strong></td>

        <td>

          <?php echo $row['order_date']; ?>

        </td>

      </tr>

      <tr>

        <td><strong>Product</strong></td>

        <td>

          <?php echo "<a href='http://avbpl.com/website/product-details.php?pid=" . $product['id'] . "' target='_blank'><img src='$URLS/seller/Product/$ProductImages' style='height:100px;width:100px;border-color: aliceblue !important;padding: 4px;border: 1px solid;'></a><br><span class='badge badge-pill bg-primary inv-badge'>$product[product] - $product[pr_code]</span>"; ?>

        </td>

      </tr>

      <tr>

        <td><strong>Rate</strong></td>

        <td>

          <?php echo $product['supplier_price']; ?>

        </td>

      </tr>

      <tr>

        <td><strong>Quantity</strong></td>

        <td>

          <?php echo $order['qty']; ?>

        </td>

      </tr>

      <tr>

        <td><strong>Total Amount</strong></td>

        <td>

          <?php echo $TotalPrice; ?>

        </td>

      </tr>

      <?php if ($order['sup_status'] == 'Pending')

        { ?>

      <tr>

        <td><strong>Order Status</strong></td>

        <td>

          <select class="form-control" name="sup_status">

          <?php

            $Arrs = array(

                'Pending',

                'Delivered',

                'Cancel'

            );

            foreach ($Arrs as $status)

            {

                if ($status == $order['sup_status'])

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

        </td>

      </tr>

      <tr>

        <td colspan="2">

          <input type="hidden" name="id" value="<?php echo $order['id']; ?>">

          <input type="hidden" name="random_move" value="<?php echo $_SESSION['random_move']; ?>">

          <button class="btn btn-success" name="UpdateSupplierOrder">Update</button>

        </td>

      </tr>

      <?php

        }

        else

        { ?>

      <tr>

        <td><strong>Order Status</strong></td>

        <td>

          <?php echo $order['sup_status']; ?>

        </td>

      </tr>

      <?php

        } ?>

    </table>

  </form>

</div>

<?php

  }

  if ($_POST['part'] == 'Order_data_View_Seller')

  {

      $row = Get_Fetch_Data($con,$_POST['id'], 'All', 'order_details');

      $state = Get_Fetch_Data($con,$row['state'], 'All', 'state_details');

      $city = Get_Fetch_Data($con,$row['city'], 'All', 'city_details');

  ?>

<div class="modal-header ">

  <h5 class="modal-title">Order Details</h5>

  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>

</div>

<div class="modal-body">

  <form method="post" action="" class="table-responsive">

    <table class="table table-bordered" style="margin:10px; color:#000; margin-bottom:10px; width:98%;">

      <tr>

        <td width="15%"><strong>Order ID</strong></td>

        <td width="35%">

          <?php echo $row['orderid']; ?>

        </td>

        <td width="15%"><strong>Order Date</strong></td>

        <td width="35%">

          <?php echo $row['order_date']; ?>

        </td>

      </tr>

      <tr>

        <td><strong>Customer Name</strong></td>

        <td>

          <?php echo $row['name']; ?>

        </td>

        <td><strong>Mobile No</strong></td>

        <td>

          <?php echo $row['mobile']; ?>

        </td>

      </tr>

      <tr>

        <td><strong>Address</strong></td>

        <td colspan="3">

          <?php echo $row['address']; ?>

        </td>

      </tr>

      <tr>

        <td><strong>State</strong></td>

        <td>

          <?php echo $state['state_name']; ?>

        </td>

      <tr>

        <td><strong>City</strong></td>

        <td>

          <?php echo $city['city_name']; ?>

        </td>

        <td><strong>Pincode</strong></td>

        <td>

          <?php echo $row['pincode']; ?>

        </td>

      </tr>

      <tr>

        <td colspan="4">

          <table class="table table-bordered">

            <tr>

              <th>Images</th>

              <th style=" width:50%;">Product</th>

              <th>Qty</th>

              <th>Rate</th>

              <th>GST</th>

              <th>Amount</th>

              <th>Supl-Status</th>

            </tr>

            <?php

              $psql = mysqli_query($con,"select * from order_product where oid='" . $row['id'] . "'");

              while ($prows = mysqli_fetch_array($psql))

              {

                  $product = Get_Fetch_Data($con,$prows['pid'], 'id,product,pr_code', 'product_details');

                  $ProductPic = Get_Product_Images($con,$product['id']);

                  if ($ProductPic != '')

                  {

                      $ProductImages = "$ProductPic";

                  }

                  else

                  {

                      $ProductImages = "noproducts.png";

                  }

                  if ($prows['sizes'] != '')

                  {

                      $Sizes = Get_Fetch_Data($con,$prows['sizes'], 'All', 'size_details');

                      $Sizess = "<br>Size : $Sizes[size_name]";

                  }

                  else

                  {

                      $Sizess = "";

                  }

                  if ($prows['colors'] != '')

                  {

                      $colors = Get_Fetch_Data($con,$prows['colors'], 'All', 'product_color');

                      $Color = "<br>Color : $colors[color_name]";

                  }

                  else

                  {

                      $Color = "";

                  }

                  $Images = "<a href='product-details.php?pid=$product[id]'><img src='../seller/Product/$ProductImages' style='height:70px; width:70px;'/></a>";

                  echo "<tr><td>$Images</td><td style=' width:50%;'>$product[product] - $product[pr_code]$Sizess$Color</td><td>$prows[qty]</td><td>$prows[price]</td><td>$prows[gst_amt] @$prows[gst]%</td><td>$prows[amount]

              </td><td>$prows[sup_status]</td></tr>";

              }

              ?>

            <tr>

              <th colspan="4">Subtotal</th>

              <th>

                <?php echo $row['subtotal']; ?>

              </th>

              <th>&nbsp;</th>

            </tr>

            <?php if ($row['discount'] != '')

              { ?>

            <tr>

              <th colspan="4"> Discount </th>

              <th>

                <?php echo $row['discount']; ?>

              </th>

              <th>&nbsp;</th>

            </tr>

            <?php

              } ?>

            <tr>

              <th colspan="4">Final Amount</th>

              <th>

                <?php echo $row['final_amount']; ?>

              </th>

              <th>&nbsp;</th>

            </tr>

          </table>

        </td>

      </tr>

    </table>

  </form>

</div>

<?php

  } if ($_POST['part'] == 'Customer_data_Update'){

      $row = Get_Fetch_Data($con,$_POST['id'], 'All', 'user_details'); ?>

<div class="modal-header ">

  <h5 class="modal-title">Update <?php echo $row['user_type']; ?> Account</h5>

  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>

</div>

<div class="modal-body">

  <form action="" method="post" enctype="multipart/form-data">

    <h5 style="color:#000000"><i class="fa fa-file-text" aria-hidden="true"></i> Profile Details</h5>

    <div class="row form-row step_1">

      <div class="col-4">

        <div class="form-group">

          <label>Full Name<span class="text-danger">*</span></label>

          <input type="text" class="form-control" value="<?php echo $row['name']; ?>" name="name" required> 

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label>Company Name<span class="text-danger">*</span></label>

          <input type="text" class="form-control" value="<?php echo $row['company']; ?>" name="company" required> 

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label>Mobile<span class="text-danger">*</span></label>

          <input type="text" class="form-control" value="<?php echo $row['mobile']; ?>" name="mobile" required readonly> 

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label>Email Id</label>

          <input type="text" class="form-control" value="<?php echo $row['email']; ?>" name="email"> 

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label>DOB</label>

          <input type="text" class="form-control datepicker" placeholder="Enter DOB" name="dob" value="<?php echo $row['dob']; ?>">

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label>Adrress<span class="text-danger">*</span></label>

          <input type="text" class="form-control Capitalize" value="<?php echo $row['address']; ?>" name="address" required> 

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label>State<span class="text-danger">*</span></label>

          <select class="form-control select2 state" name="state" id="statess" required>

            <option value="">All State</option>

            <?php

              $Esql = mysql_query("select * from state_details where status='Active'");

              while ($Erow = mysql_fetch_array($Esql))

              {

                  if ($row['state'] == $Erow['id'])

                  {

                      echo "<option value=" . $Erow['id'] . " selected>$Erow[state_name]</option>";

                  }

                  else

                  {

                      echo "<option value=" . $Erow['id'] . ">$Erow[state_name]</option>";

                  }

              }

              ?>

          </select>

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label>City<span class="text-danger">*</span></label>

          <select class="form-control select2" name="city" id="cityss" required>

            <option value="">All City</option>

            <?php

              $CEsql = mysqli_query($con,"select * from city_details where state='" . $row['state'] . "' and status='Active'");

              while ($Erow = mysqli_fetch_array($CEsql))

              {

                  if ($row['city'] == $Erow['id'])

                  {

                      echo "<option value=" . $Erow['id'] . " selected>$Erow[city_name]</option>";

                  }

                  else

                  {

                      echo "<option value=" . $Erow['id'] . ">$Erow[city_name]</option>";

                  }

              }

              ?>

          </select>

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label>Pin Code<span class="text-danger">*</span></label>

          <input type="text" class="form-control" value="<?php echo $row['pincode']; ?>" name="pincode" required> 

        </div>

      </div>

    </div>

    <h5 style="color:#000000"><i class="fa fa-file-text" aria-hidden="true"></i> Company Details</h5>

    <div class="row form-row step_1">

      <div class="col-4">

        <div class="form-group">

          <label>GST No.</label>

          <input type="text" class="form-control" value="<?php echo $row['gst_no']; ?>" name="gst_no"> 

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label>Transport Name</label>

          <input type="text" class="form-control" value="<?php echo $row['transport_name']; ?>" name="transport_name"> 

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label>Refrence by Name</label>

          <input type="text" class="form-control" value="<?php echo $row['ref_name']; ?>" name="ref_name"> 

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label>Refrence Mobile No</label>

          <input type="text" class="form-control" value="<?php echo $row['ref_mobile']; ?>" name="ref_mobile"> 

        </div>

      </div>

    </div>

    <h5 style="color:#000000"><i class="fa fa-file-text" aria-hidden="true"></i> Admin Details</h5>

    <div class="row form-row step_1">

      <div class="col-4">

        <div class="form-group">

          <label>Buying Rate*<span class="text-danger">*</span></label>

          <select class="form-control" name="buying_rate" required>

            <option value="">Select</option>

            <?php $arrs = array('Wholesaler' => 'Wholesaler', 'Distributor' => 'Semi Wholesaler', 'Retailer' => 'Retailer', 'Sub-Retailer' => 'Sub-Retailer');

              foreach ($arrs as $key => $user_type)

              {

                  if ($row['buying_rate'] == $key)

                  {

                      echo "<option value=" . $key . " selected>$user_type</option>";

                  }

                  else

                  {

                      echo "<option value=" . $key . ">$user_type</option>";

                  }

              }

              ?>

          </select>

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label>Allocate Employee</label>

          <select class="form-control select2" name="employee">

            <option value="">Select Employee</option>

            <?php

              $Esql = mysqli_query($con,"select * from admin_signup where role='3'");

              while ($Erow = mysqli_fetch_array($Esql))

              {

                  $Ratename = Rate_Names($Erow[rates]);

                  $City = Get_Fetch_Data($con,$Erow['city'], 'All', 'city_details');

                  $user = Get_Fetch_Data_fiedls($con,$Erow['id'], 'employee', 'All', 'user_details');

                  if ($user['employee'] == $Erow['id'])

                  {

                      $display = 'disabled';

                  }

                  else

                  {

                      $display = '';

                  }

                  if ($row['employee'] == $Erow['id'])

                  {

                      echo "<option value=" . $Erow['id'] . " selected $display>$Erow[name] ($Ratename - $City[city_name])</option>";

                  }

                  else

                  {

                      echo "<option value=" . $Erow['id'] . " $display>$Erow[name] ($Ratename - $City[city_name])</option>";

                  }

              }

              ?>

          </select>

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label>Selling Rate*<span class="text-danger">*</span></label>

          <select class="form-control" name="selling_rate" required>

            <option value="">Select</option>

            <?php $arrs = array('Wholesaler' => 'Wholesaler', 'Distributor' => 'Semi Wholesaler', 'Retailer' => 'Retailer', 'Sub-Retailer' => 'Sub-Retailer');

              foreach ($arrs as $key => $user_type)

              {

                  if ($row['selling_rate'] == $key)

                  {

                      echo "<option value=" . $key . " selected>$user_type</option>";

                  }

                  else

                  {

                      echo "<option value=" . $key . ">$user_type</option>";

                  }

              }

              ?>

          </select>

        </div>

      </div>

      <div class="col-12">

        <div class="form-group">

          <label>Status</label>

          <select class="form-control" name="status">

          <?php $arr = array(   'Active', 'Inactive' );

            foreach ($arr as $status) {

                if ($status == $row['status']) {

                    echo "<option value=" . $status . " selected>$status</option>";

                } else {

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

    <button type="submit" class="btn btn-dark float-right mr-2" name="UpdateCustomer">Update</button>

  </form>

  <!----

    <form  action="" method="post" enctype="multipart/form-data">

    <div class="row form-row">

    <div class="col-6">

    <div class="form-group">

    <label> Full Name <span class="text-danger">*</span></label>

    <input type="text" class="form-control" value="<?php echo $row['name']; ?>" name="name" required>

    </div>

    </div>

    <div class="col-6">

    <div class="form-group">

    <label> Company Name <span class="text-danger">*</span></label>

    <input type="text" class="form-control" value="<?php echo $row['company']; ?>" name="company" required>

    </div>

    </div>

    <div class="col-6">

    <div class="form-group">

    <label> Mobile No <span class="text-danger">*</span></label>

    <input type="text" class="form-control" value="<?php echo $row['mobile']; ?>" name="mobile" required readonly>

    </div>

    </div>

    <div class="col-6">

    <div class="form-group">

    <label> Email Id </label>

    <input type="text" class="form-control" value="<?php echo $row['email']; ?>" name="email" >

    </div>

    </div>

    <div class="col-12">

    <div class="form-group">

    <label> Address<span class="text-danger">*</span></label>

    <input type="text" class="form-control Capitalize" value="<?php echo $row['address']; ?>" name="address" required>

    </div>

    </div>

    <div class="col-4">

    <div class="form-group">

    <label>State<span class="text-danger">*</span></label>

    <select class="form-control select2 state" name="state" id="statess" required>

    <option value="">All State</option>

    <?php

      $Esql = mysql_query("select * from state_details where status='Active'");

      while ($Erow = mysql_fetch_array($Esql))

      {

          if ($row['state'] == $Erow['id'])

          {

              echo "<option value=" . $Erow['id'] . " selected>$Erow[state_name]</option>";

          }

          else

          {

              echo "<option value=" . $Erow['id'] . ">$Erow[state_name]</option>";

          }

      }

      ?>                   

    </select>

    </div>

    </div>

    <div class="col-4">

    <div class="form-group">

    <label>City<span class="text-danger">*</span></label>

    <select class="form-control select2" name="city" id="cityss" required>

    <option value="">All City</option>

    <?php

      $CEsql = mysql_query("select * from city_details where state='" . $row['state'] . "' and status='Active'");

      while ($Erow = mysql_fetch_array($CEsql))

      {

          if ($row['city'] == $Erow['id'])

          {

              echo "<option value=" . $Erow['id'] . " selected>$Erow[city_name]</option>";

          }

          else

          {

              echo "<option value=" . $Erow['id'] . ">$Erow[city_name]</option>";

          }

      }

      ?> 

    </select>

    </div>

    </div>

    <div class="col-4">

    <div class="form-group">

    <label> Pincode<span class="text-danger">*</span></label>

    <input type="text" class="form-control" value="<?php echo $row['pincode']; ?>" name="pincode" required>

    </div>

    </div>

    

    <div class="col-6">

    <div class="form-group">

    <label>GST No.</label>

    <input type="text" class="form-control" value="<?php echo $row['gst_no']; ?>" name="gst_no">

    </div>

    </div>

    <div class="col-6">

    <div class="form-group">

    <label>Transport Name</label>

    <input type="text" class="form-control" value="<?php echo $row['transport_name']; ?>" name="transport_name">

    </div>

    </div>

    

    <div class="col-6">

    <div class="form-group">

    <label>User Type<span class="text-danger">*</span></label>

    <select class="form-control" name="user_type" required>

    <option value="">Select</option>

    <?php

      $arrs = array(

          'Wholesaler' => 'Wholesaler',

          'Distributor' => 'Semi Wholesaler',

          'Retailer' => 'Retailer',

          'Sub-Retailer' => 'Sub-Retailer'

      );

      foreach ($arrs as $key => $user_type)

      {

          if ($row['user_type'] == $key)

          {

              echo "<option value=" . $key . " selected>$user_type</option>";

          }

          else

          {

              echo "<option value=" . $key . ">$user_type</option>";

          }

      }

      ?>                   

    </select>

    </div>

    </div>

    <div class="col-6">

    <div class="form-group">

    <label>Allocate Employee</label>

    <select class="form-control select2" name="employee">

    <option value="">Select Employee</option>

    <?php

      $Esql = mysql_query("select * from admin_signup where role=3");

      while ($Erow = mysql_fetch_array($Esql))

      {

          $Ratename = Rate_Names($Erow[rates]);

          $City = Get_Fetch_Data($Erow['city'], 'All', 'city_details');

          if ($row['employee'] == $Erow['id'])

          {

              echo "<option value=" . $Erow['id'] . " selected>$Erow[name] ($Ratename - $City[city_name])</option>";

          }

          else

          {

              echo "<option value=" . $Erow['id'] . ">$Erow[name] ($Ratename - $City[city_name])</option>";

          }

      }

      ?>                   

    </select>

    </div>

    </div>

    <div class="col-4">

    <div class="form-group">

    <label>Credit Limit</label>

    <input type="text" class="form-control" value="<?php echo $row['credit_limit']; ?>" name="credit_limit">

    </div>

    </div>

    <div class="col-4">

    <div class="form-group">

    <label>Refrence by Name</label>

    <input type="text" class="form-control" value="<?php echo $row['ref_name']; ?>" name="ref_name">

    </div>

    </div>

    <div class="col-4">

    <div class="form-group">

    <label>Refrence Mobile No</label>

    <input type="text" class="form-control" value="<?php echo $row['ref_mobile']; ?>" name="ref_mobile">

    </div>

    </div>

    <div class="col-4">

    <div class="form-group">

    <label>Open Balance</label>

    <select class="form-control" name="openinig_balance">

    <option value="">Select</option>

    <?php

      $arrs = array(

          'Debit',

          'Credit'

      );

      foreach ($arrs as $openinig_balance)

      {

          if ($row['openinig_balance'] == $openinig_balance)

          {

              echo "<option value=" . $openinig_balance . " selected>$openinig_balance</option>";

          }

          else

          {

              echo "<option value=" . $openinig_balance . ">$openinig_balance</option>";

          }

      }

      ?> 

    </select>

    </div>

    </div> 

    <div class="col-4">

    <div class="form-group">

    <label style="visibility: hidden;">Open Amount</label>

    <input type="number" class="form-control" value="<?php echo $row['openinig_amount']; ?>" name="openinig_amount">

    </div>

    </div> 

    <div class="col-4">

    <div class="form-group">

    <label>As On </label>

    <input type="text" class="form-control datepickers" name="openinig_date" value="<?php echo $row['openinig_date']; ?>">

    </div>

    </div>

    

    <div class="col-4">

    <div class="form-group">

    <label>Status</label>

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

    <button class="btn btn-success" name="UpdateCustomer">Update</button>

    </form> ---->

</div>

<?php

  }

  if ($_POST['part'] == 'Customer_data_View')

  {

      $row = Get_Fetch_Data($con,$_POST['id'], 'All', 'user_details');

      $employee = Get_Fetch_Data($con,$row['employee'], 'id,name', 'admin_signup');

      if ($row['photo'] != '')

      {

          $photo = "Banner/$row[photo]";

      }

      else

      {

          $photo = "Banner/noimages.jpg";

      }

      $state = Get_Fetch_Data($con,$row['state'], 'All', 'state_details');

      $city = Get_Fetch_Data($con,$row['city'], 'All', 'city_details');

  ?>

<div class="modal-header ">

  <h5 class="modal-title"><?php echo $row['user_type']; ?> Account Details</h5>

  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>

</div>

<div class="modal-body">

  <h5 style="color:#000000"><i class="fa fa-file-text" aria-hidden="true"></i> Profile Details</h5>

  <div style="width:100px;height:100px;position:absolute; right:10px;top:20px;"><img src="<?php echo $photo; ?>" style="width: 100px;    height: 100px;    border-radius: 50%;    box-shadow: 0px 3px 5px #ccc;    border: 2px solid #ccc;"></div>

  <div class="row form-row step_1">

    <div class="col-4">

      <div class="form-group">

        <label class="text-dark">Full Name</label>

        <p class="c-detail">

          <?php echo $row['name']; ?>

        </p>

      </div>

    </div>

    <div class="col-4">

      <div class="form-group">

        <label class="text-dark">Company Name</label>

        <p class="c-detail">

          <?php echo $row['company']; ?>

        </p>

      </div>

    </div>

    <div class="col-4">

      <div class="form-group">

        <label class="text-dark">Mobile No</label>

        <p class="c-detail">

          <?php echo $row['mobile']; ?>

        </p>

      </div>

    </div>

    <div class="col-4">

      <div class="form-group">

        <label class="text-dark">Email Id</label>

        <p class="c-detail">

          <?php echo $row['email']; ?>

        </p>

      </div>

    </div>

    <div class="col-4">

      <div class="form-group">

        <label class="text-dark">DOB</label>

        <p class="c-detail">

          <?php echo $row['dob']; ?>

        </p>

      </div>

    </div>

    <div class="col-4">

      <div class="form-group">

        <label class="text-dark">Adrress</label>

        <p class="c-detail">

          <?php echo $row['address']; ?>

        </p>

      </div>

    </div>

    <div class="col-4">

      <div class="form-group">

        <label class="text-dark">State</label>

        <p class="c-detail">

          <?php echo $row['state_name']; ?>

        </p>

      </div>

    </div>

    <div class="col-4">

      <div class="form-group">

        <label class="text-dark">City</label>

        <p class="c-detail">

          <?php echo $city['city_name']; ?>

        </p>

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

  </div>

  <h5 style="color:#000000"><i class="fa fa-file-text" aria-hidden="true"></i> Company Details</h5>

  <div class="row form-row step_1">

    <div class="col-4">

      <div class="form-group">

        <label class="text-dark">GST No.</label>

        <p class="c-detail">

          <?php echo $row['gst_no']; ?>

        </p>

      </div>

    </div>

    <div class="col-4">

      <div class="form-group">

        <label class="text-dark">Transport Name</label>

        <p class="c-detail">

          <?php echo $row['transport_name']; ?>

        </p>

      </div>

    </div>

  </div>

  <h5 style="color:#000000"><i class="fa fa-file-text" aria-hidden="true"></i> Admin Details</h5>

  <div class="row form-row step_1">

    <div class="col-4">

      <div class="form-group">

        <label class="text-dark">Allocate Employee</label>

        <p class="c-detail">

          <?php echo $employee['name']; ?>

        </p>

      </div>

    </div>

    <div class="col-4">

      <div class="form-group">

        <label class="text-dark">Buying Rate </label>

        <p class="c-detail">

          <?php echo $row['buying_rate']; ?>

        </p>

      </div>

    </div>

    <div class="col-4">

      <div class="form-group">

        <label class="text-dark">Selling Rate </label>

        <p class="c-detail">

          <?php echo $row['selling_rate']; ?>

        </p>

      </div>

    </div>

    <?php if ($row['document1'] != '')

      { ?>

    <div class="col-4">

      <div class="form-group">

        <label class="text-dark">Document 1</label>

        <p class="c-detail"><a href="Banner/<?=$row[document1]; ?>" target="_blank">Document</a></p>

      </div>

    </div>

    <?php

      }

      if ($row['document2'] != '')

      { ?>

    <div class="col-4">

      <div class="form-group">

        <label class="text-dark">Document 2</label>

        <p class="c-detail"><a href="Banner/<?=$row[document2]; ?>" target="_blank">Document</a></p>

      </div>

    </div>

    <?php

      } ?>

    <div class="col-4">

      <div class="form-group">

        <label class="text-dark">Create Time</label>

        <p class="c-detail">

          <?php echo $row['add_time']; ?>

        </p>

      </div>

    </div>

    <div class="col-4">

      <div class="form-group">

        <label class="text-dark">Status</label>

        <p class="c-detail">

          <?php echo $row['status']; ?>

        </p>

      </div>

    </div>

  </div>

  <!-- 

    <table class="table table-bordered">

    <tr><td width="30%"><strong>Name</strong></td><td width="55%"><?php echo $row['name']; ?>

    </td><td rowspan="3" width="15%"><img src="<?php echo $photo; ?>" height="100"></td></tr>

    <tr><td><strong>Company</strong></td><td><?php echo $row['company']; ?></td></tr>

    <tr><td><strong>Mobile No</strong></td><td><?php echo $row['mobile']; ?></td></tr>

    <tr><td><strong>Email Id</strong></td><td colspan="2"><?php echo $row['email']; ?></td></tr>

    <tr><td><strong>Address</strong></td><td colspan="2"><?php echo $row['address']; ?></td></tr>

    <tr><td><strong>State</strong></td><td colspan="2"><?php echo $state['state_name']; ?></td></tr>

    <tr><td><strong>City</strong></td><td colspan="2"><?php echo $city['city_name']; ?></td></tr>

    <tr><td><strong>Pincode</strong></td><td colspan="2"><?php echo $row['pincode']; ?></td></tr>

    <tr><td><strong>GST No</strong></td><td colspan="2"><?php echo $row['gst_no']; ?></td></tr>

    <tr><td><strong>Transport Name</strong></td><td colspan="2"><?php echo $row['transport_name']; ?></td></tr>

    <tr><td><strong>Credit Limit</strong></td><td colspan="2"><?php echo $row['credit_limit']; ?></td></tr>

    <tr><td><strong>Allocate Employee</strong></td><td colspan="2"><?php echo $employee['name']; ?></td></tr>

    <tr><td><strong>Opening Balance</strong></td><td colspan="2"><?php echo $row['openinig_balance']; ?></td></tr>

    <tr><td><strong>Opening Amount</strong></td><td colspan="2"><?php echo $row['openinig_amount']; ?></td></tr>

    <tr><td><strong>Opening Date</strong></td><td colspan="2"><?php echo $row['openinig_date']; ?></td></tr>

    <?php if ($row['document1'] != '')

      { ?>

    <tr><td><strong>Document 1</strong></td><td colspan="2"><a href="Banner/<?=$row[document1]; ?>" target="_blank">Document</a></td></tr>

    <?php

      }

      if ($row['document2'] != '')

      { ?>

    <tr><td><strong>Document 2</strong></td><td colspan="2"><a href="Banner/<?=$row[document2]; ?>" target="_blank">Document</a></td></tr>

    <?php

      } ?>

    <tr><td><strong>Create Time</strong></td><td colspan="2"><?php echo $row['add_time']; ?></td></tr>

    <tr><td><strong>Status</strong></td><td colspan="2"><?php echo $row['status']; ?></td></tr>

    </table> ---> 
  
</div>
<?php

  }

  //Catalogue

  if ($_REQUEST['part'] == 'All_Catalogue_Data')

  {

      $requestData = $_REQUEST;

      $sqls = "SELECT * FROM catalogue_details where id!='' $where";

      $sql = "SELECT * FROM catalogue_details where id!='' $where";

      $querys = mysqli_query($con,$sqls);

      $totalData = mysqli_num_rows($querys);

      $totalFiltered = $totalData;

      if (!empty($requestData['search']['value']))

      { // if there is a search parameter, $requestData['search']['value'] contains search parameter

          $sql .= " AND ( catalogue LIKE '%" . $requestData['search']['value'] . "%' ";

          $sql .= " OR status LIKE '%" . $requestData['search']['value'] . "%' )";

      }

      $sql .= "  ORDER BY id asc  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";

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

          if ($row[status] == 'Active')

          {

              $class = 'bg-success';

          }

          else

          {

              $class = 'bg-danger';

          }

          if ($row['images'] != '')

          {

              $photo = "<a href='Product/" . $row['images'] . "' target='_blank'><img src='Product/" . $row['images'] . "' height='50' width='50' style='border-radius: 50%;'></a>";

          }

          else

          {

              $photo = "<img src='Banner/no-icons.png' height='40' style='border-radius: 12px;'>";

          }

          if ($row['mob_icon'] != '')

          {

              $mob_icon = "<a href='Product/" . $row['mob_icon'] . "' target='_blank'><img src='Product/" . $row['mob_icon'] . "' height='50' width='50' style='border-radius: 50%;'></a>";

          }

          else

          {

              $mob_icon = "<img src='Banner/no-icons.png' height='40' style='border-radius: 12px;'>";

          }

          $nestedData = array();

          $nestedData[] = "<div class='first'>$row[catalogue]</div>";

          $nestedData[] = "<div class='second'>$photo</div>";

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

  if ($_POST['part'] == 'Catalogue_data_Update')

  {

      $row = Get_Fetch_Data($con,$_POST['id'], 'All', 'catalogue_details');

  ?>
<div class="modal-header ">
  <h5 class="modal-title">Update Catalogue Detail</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
</div>
<div class="modal-body">
  <form action="" method="post" enctype="multipart/form-data">
    <div class="row form-row">
      <div class="col-12">
        <div class="form-group">
          <label> Catalogue Name</label>
          <input type="text" class="form-control" value="<?php echo $row['catalogue']; ?>" name="catalogue" required>
        </div>
      </div>
      <div class="col-6 col-sm-6">
        <div class="form-group">
          <label>Update Image</label>
          <input type="file" class="form-control UploaderFile" name="images">
        </div>
      </div>
      <div class="col-6">
        <div class="form-group">
          <label>Status</label>
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
    <button class="btn btn-success" name="UpdateCatalogue">Update</button>
  </form>
</div>
<?php

  }

  

  if ($_POST['part'] == 'Catalogue_Item_data_Update')

  {

      $row = Get_Fetch_Data($con,$_POST['id'], 'All', 'product_catalogue');

  ?>
<div class="modal-header ">
  <h5 class="modal-title">Update Catalogue Item</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
</div>
<div class="modal-body">
<form method="post" action="" enctype="multipart/form-data">
  <div class="row form-row">
    <div class="col-12 px-1">
      <div class="form-group">
        <label>SKU Code*</label>
        <input type="hidden" id="#pidSku" name="id" value="<?php echo $row['id']; ?>">
        <input type="text" class="form-control skuCode" id="skuCode" name="sku_code" placeholder="Enter SKU Code" value="<?php echo $row['sku_code']; ?>" required>
        <div class="skuCode-err" style="display:none;"></div>
      </div>
    </div>
    <div class="col-12 px-1">
      <div class="form-group">
        <label>Production No.*</label>
        <input type="text" class="form-control" name="pro_no" placeholder="Enter Production Number" value="<?php echo $row['pro_no']; ?>" required>
      </div>
    </div>
    
    <!--<div class="col-6 px-1">

      <div class="form-group">

          <label>Mrp*</label>

          <input type="text" class="form-control border-color" value="<?php echo $row['mrp_indv'];?>" name="mrp_indv" required>

      </div>

      </div>-->
    
    <div class="col-6 px-1">
      <div class="form-group">
        <label>Wholesale*</label>
        <input type="text" class="form-control border-color" value="<?php echo $row['whol_indv'];?>"  name="whol_indv" required>
      </div>
    </div>
    <div class="col-6 px-1">
      <div class="form-group">
        <label>Semi Wholeseller*</label>
        <input type="text" class="form-control border-color" value="<?php echo $row['dist_indv'];?>" name="dist_indv" required>
      </div>
    </div>
    <div class="col-6 px-1">
      <div class="form-group">
        <label>Retailer*</label>
        <input type="text" class="form-control border-color"  value="<?php echo $row['ret_indv'];?>" name="ret_indv" required>
      </div>
    </div>
    <div class="col-6 px-1">
      <div class="form-group">
        <label>Sub-Retailer*</label>
        <input type="text" class="form-control border-color" value="<?php echo $row['subret_indv'];?>" name="subret_indv" required>
      </div>
    </div>
    <div class="col-12 px-1">
      <div class="form-group">
        <label>Image</label>
        <input type="file" class="form-control" name="photo">
      </div>
    </div>
    <div class="col-12 px-1">
      <div class="form-group">
        <label>Status*</label>
        <select class="form-control" name="status" required>
          <?php

          $arr = ['Instock', 'Outstock'];

          foreach ($arr as $status){

              echo "<option value=".$status." ". ($status == $row['status']?"selected":"").">$status</option>";

          }

          ?>
        </select>
      </div>
    </div>
  </div>
  <input type="hidden" name="random_move" value="<?php echo $_SESSION['random_move']; ?>">
  <button type="submit" class="btn btn-success btn-block" name="UpdateCatalogue">Update Item</button>
</form>
<?php

  }

  

  if ($_POST['part'] == 'Add_Invoice_Item_Table_Part'){

      

          $row = Get_Fetch_Data($con,$_POST['item'], 'All', 'product_details');

          $customer = Get_Fetch_Data($con,$_POST['customer'], 'id,user_type', 'user_details');

          

      

  ?>
<tr>
  <td><div class="d-flex">
      <div class="position-relative w-100">
        <div class="d-flex w-100 align-items-center"> <span class="w-100">
          <select   class="form-control select3 catalogue" name="catalogue[]" required style="width:98%;">
            <option value="">Select Item</option>
            <?php

            if ($_POST['item'] != '')

      {

          $where = " and b.barcode='" . $_POST['item'] . "'";

      }
      if ($_POST['supplierid'] != '')

      {

          $where = " and b.sid='" . $_POST['supplierid'] . "'";

      }
            

                          
                $Itmsqls=mysqli_query($con,"select a.product,a.hsn_code,b.id as opid,b.oid,b.sid,b.pid from product_details as a, order_product as b where a.id=b.pid group by b.pid, b.sid order by b.id desc");

                while ($Itmrows = mysqli_fetch_array($Itmsqls))

                {
                              //$oids=Get_Fetch_Data_fiedls($con,$Itmrows["oid"],"id","uid","order_details");
                    $vendorcode=Get_Fetch_Data($con,$Itmrows["sid"],"id,Vendor_Code","vendor_details");
                    $hsncode=Get_Fetch_Data($con,$Itmrows[hsn_code],"hsncode","HsnList");
                    $checkqty=invoiceproduct_stock($con,$Itmrows["id"],$Itmrows["sid"]);
                      //if($checkqty > "0"){
                    if ($_POST['item'] == $Itmrows['id'])

                    {

                        echo "<option value=".$Itmrows['opid']."-".$Itmrows['pid'].">($vendorcode[Vendor_Code])  $Itmrows[product] - $hsncode[hsncode]</option>";

                    }

                    else

                    {

                        echo "<option value=".$Itmrows['opid']."-".$Itmrows['pid'].">($vendorcode[Vendor_Code])  $Itmrows[product] - $hsncode[hsncode]</option>";

                    //}
                  }
                }

                ?>
          </select>
          </span> </div>
      </div>
    </div></td>
  
  <!--<td>--> 
  
  <!--    <div class="col-md-2 pl-1"><a data-toggle="modal" href="#AddNewCustomer"><i class="fa fa-plus-circle text-success" style="font-size: 22px; margin-top:8px;" aria-hidden="true"></i></a></div>--> 
  
  <!--</td>-->
  
  <td style='display:none;'><select class="form-control select3 item" name="item[]">
      <option value="">All Item</option>
      <?php

        $SubItmsqls = mysqli_query($con,"select * from product_catalogue where pid='" . $_POST['item'] . "' order by id desc");

        while ($SubItmrows = mysqli_fetch_array($SubItmsqls))

        {

            if ($_POST['subitem'] == $SubItmrows['id'])

            {

                echo "<option value=" . $SubItmrows['id'] . " selected>$SubItmrows[cat_code]</option>";

            }

            else

            {

                echo "<option value=" . $SubItmrows['id'] . ">$SubItmrows[cat_code]</option>";

            }

        }

        ?>
    </select></td>
  <td><input type="number" class="form-control qty" name="qty[]" placeholder="Enter Quantity" required value="1"></td>
  <td><input type="number" class="form-control rate" name="rate[]" placeholder="Enter Rate" required value="<?=$MRP; ?>"></td>
  <td><div class="d-flex justify-content-end">
      <input type="text" class="form-control Amount" name="Amount[]" style="width:80px;" placeholder="Amount" value="<?=$Amount; ?>" readonly>
      <span class="float-right ml-2"> <a href="javascript:void" class="RemoveR"><i class="fe fe-trash text-danger" aria-hidden="true"></i></a> </span> </div></td>
</tr>
<?php

  }

if ($_POST['part'] == 'Add_Order_Item_Table_Part_Invoice'){

  //$challan=Get_Fetch_Data($con,$_POST['catalogue'],'id,pid','challan_items');
  $product=Get_Fetch_Data($con,$_POST['catalogue'],"id,product,barcode,hsn_code","product_details");
  $totalstock=product_stock($con,$product["id"]);
  if($totalstock>0){ $Stocks="<div class='InStockshow'>Stock: $totalstock</div>"; } else { $Stocks="<div class='OutStockshow'>Stock: $totalstock</div>"; }
  ?>
  <tr>
    
  <td>
  <select class="form-control select3 catalogue" name="catalogue[]">
  <?php
  $HsnList=Get_Fetch_Data($con,$product['hsn_code'],"id,hsncode","HsnList");
  echo "<option value=".$product['id']." selected>$product[product] - $HsnList[hsncode]</option>";
  ?>
  </select>
  <div style="font-size:11px; color:#F00;padding-left: 16px;">Barcode: <?=$product['barcode'];?></div>
  </td>
  <td><input type="text" class="form-control qtyed qty" name="qty[]" value="<?=$_POST['qty'];?>">
  <?=$Stocks;?></td>
  <td><input type="text" class="form-control Rated rate" name="rate[]" value="<?=$_POST['rate'];?>">
   
  </td>
  <td>
  <div class="d-flex w-50 ">
  <input type="hidden" class="Discountamt" name="Discountamt[]" value="<?=$_POST['Discountamt'];?>">
  <input type="number" class="form-control p-2 h-30 DiscountVal" name="DiscountVal[]" value="<?=$_POST['DiscountVal'];?>" style="width: 50px;">
  <select name="DiscountType[]" class="form-control p-2 h-30 border-left-0 DiscountType" style="width: 50px;">
  <?php
  $arrs=array('Percent'=>'%','Rupees'=>'₹');
  foreach($arrs as $key=>$DiscountType){
  if($key==$_POST['DiscountType']){
  echo "<option value=".$key." selected>$DiscountType</option>";
  } else {
  echo "<option value=".$key.">$DiscountType</option>";	
  }
  }
  ?>
  </select>
  </div>
  </td>
    <td style="padding:0px;"><span class="Taxs">
  <?php
  if($_POST['sgst']>0){
  echo "<div style='font-size:11px;color:red; white-space: nowrap;'>CGST: $_POST[cgst_amt] @$_POST[cgst]%</div><div style='font-size:11px;color:red; white-space: nowrap;'>SGST: $_POST[sgst_amt] @$_POST[sgst]%</div>";	
  } else {
  echo "<span style='font-size:11px;color:red;white-space: nowrap;'>IGST: $_POST[igst_amt] @$_POST[igst]%</span>";
  }
  ?>
  </span>
  <input type="hidden" class="cgst" name="cgst[]" value="<?=$_POST['cgst'];?>"><input type="hidden" class="cgst_amt" name="cgst_amt[]" value="<?=$_POST['cgst_amt'];?>">
  <input type="hidden" class="sgst" name="sgst[]" value="<?=$_POST['sgst'];?>"><input type="hidden" class="sgst_amt" name="sgst_amt[]" value="<?=$_POST['sgst_amt'];?>">
  <input type="hidden" class="igst" name="igst[]" value="<?=$_POST['igst'];?>"><input type="hidden" class="igst_amt" name="igst_amt[]" value="<?=$_POST['igst_amt'];?>">
  </td>
  <td><div class="d-flex justify-content-end">
  <input type="hidden" class="Subtotal" name="Subtotals[]" value="<?=$_POST['Subtotal'];?>">
      <input type="text" class="form-control Amount" name="Amount[]" style="    width: 80px;" placeholder="Amount" value="<?=$_POST['Amount'];?>" readonly>
      <span class="float-right ml-2"> <a href="javascript:void" class="RemoveR"><i class="fe fe-trash text-danger" aria-hidden="true"></i></a> </span> </div></td>
  </tr>
  <?php	
} 

if ($_POST['part'] == 'Add_Order_Item_Table_Part') {

  ?>
  <tr>
    <td> <input type="file" class="form-control" name="attachment[]" id="prodimage"></td>

    <td> <input type="text" class="form-control" name="pcode[]"  placeholder="Enter Product Code"></td>
  <td><div class="d-flex">
  <div class="position-relative w-100">
  <div class="d-flex w-100 align-items-center"> <span class="w-100">
  <select class="form-control select3 catalogue product" name="pid[]" style="width:98%;">
  <option value="">Select Item</option>
  <?php

  $Asql=mysqli_query($con,"select * from product_details where status='Active'");
  while($Asql1=mysqli_fetch_array($Asql)){
  echo "<option value=".$Asql1['id']." >$Asql1[product]</option>"; 
  }
  ?> 
  </select>
  </span> </div>
  </div>
  </div></td>

  <td> 
 <select class="form-control select2 Unit" name="unit[]" >
          <option value="">Select Unit</option>
          </select>
  </td>  

  <td><input type="number" class="form-control qty" name="qty[]" placeholder="Enter Quantity"  value="1"></td>
  <td>
  <input type="number" class="form-control rate" name="rate[]" placeholder="Enter Rate"   value="<?=$MRP; ?>">
  <span>
  <select class="form-control select3 rate_type" name="rate_type[]">
  <option value="Approx">Approx</option>  
  <option value="Fixed">Fixed</option>      
  <!-- <option value="<?php echo $_POST['rate_type'];?>"><?php echo $_POST['rate_type'];?></option>  -->
  </select>
  </span> 
  </td>

  <td><div class="d-flex justify-content-end">
  <input type="text" class="form-control Amount" name="Amount[]" placeholder="Amount" value="<?=$Amount; ?>" readonly>
  <span class="float-right ml-3"> <a href="javascript:void" class="RemoveR"><i class="fa fa-minus-circle text-danger" aria-hidden="true"></i></a> </span> </div></td>
  </tr>
  <?php
}
if($_POST['part']=="Get_Gst_Amount"){
$product=Get_Fetch_Data($con,$_POST['product'],"hsn_code","product_details");
$Amount=$_POST['qty']*$_POST['rate'];
$tax=Get_Hsn_range_tax($con,$Amount,$product['hsn_code']);
$GstTax = Get_Fetch_Data($con,$tax['tax'], 'All', 'GstTax');
$buyer=Get_Fetch_Data($con,$_POST['buyer'],"id,CName,State","buyer_details");
if($buyer['State']==8){
$CGST=$Amount*$GstTax['Pcgst']/100;  $SGST=$Amount*$GstTax['Psgst']/100; $IGST=0;
$CGSTPer=$GstTax['Pcgst']; $SGSTPer=$GstTax['Psgst']; $IGSTPer=0; 
$totalTax=$CGST+$SGST; $ShowTax="SGST : $GstTax[Psgst]% ,CGST : $GstTax[Pcgst]%";
$Taxable="<div style='font-size:9px;color:red;white-space: nowrap;'>CGST: $CGST @".round($GstTax[Pcgst])."%</div><div style='font-size:9px;color:red;white-space: nowrap;'>SGST: $SGST @".round($GstTax[Psgst])."%</div>";  

} else {
$IGST=$Amount*$GstTax['Pigst']/100; $CGST=0; $SGST=0; $totalTax=$IGST;  
$CGSTPer=0; $SGSTPer=0; $IGSTPer=$GstTax['Pigst']; $ShowTax="IGST : $GstTax[Pigst]%";
$Taxable="<span style='font-size:9px;color:red;white-space: nowrap;'>IGST: $IGST @".round($GstTax[Pigst])."%</span>";
}
$totalamt=$Amount+$totalTax;
echo "$Taxable|$totalamt|$GstTax[Pcgst]|$CGST|$GstTax[Psgst]|$SGST|$GstTax[Pigst]|$IGST";
}
if ($_POST['part'] == 'Add_Sale_Item_Table_Part') {
$product=Get_Fetch_Data($con,$_POST['product'],"hsn_code","product_details");
$Amount=$_POST['qty']*$_POST['rate'];
$tax=Get_Hsn_range_tax($con,$Amount,$product['hsn_code']);
$GstTax = Get_Fetch_Data($con,$tax['tax'], 'All', 'GstTax');
$buyer=Get_Fetch_Data($con,$_POST['buyer'],"id,CName,State","buyer_details");
if($buyer['State']==8){
$CGST=$Amount*$GstTax['Pcgst']/100;  $SGST=$Amount*$GstTax['Psgst']/100; $IGST=0;
$CGSTPer=$GstTax['Pcgst']; $SGSTPer=$GstTax['Psgst']; $IGSTPer=0; 
$totalTax=$CGST+$SGST; $ShowTax="SGST : $GstTax[Psgst]% ,CGST : $GstTax[Pcgst]%";
$Taxable="<div style='font-size:9px;color:red;white-space: nowrap;'>CGST: $CGST @".round($GstTax[Pcgst])."%</div><div style='font-size:9px;color:red;white-space: nowrap;'>SGST: $SGST @".round($GstTax[Psgst])."%</div>";  

} else {
$IGST=$Amount*$GstTax['Pigst']/100; $CGST=0; $SGST=0; $totalTax=$IGST;  
$CGSTPer=0; $SGSTPer=0; $IGSTPer=$GstTax['Pigst']; $ShowTax="IGST : $GstTax[Pigst]%";
$Taxable="<span style='font-size:9px;color:red;white-space: nowrap;'>IGST: $IGST @".round($GstTax[Pigst])."%</span>";
}
$Tamount=$Amount+$totalTax;
  ?>
  <tr>
<td><input type="text" name="invoiceno[]"  class="form-control minvoiceno"  value="<?php echo $_POST['minvoiceno'];?>"></td>
<td>
    <input type="text" name="inv_date[]"  class="form-control datepickerss"  value="<?php echo $_POST['inv_date'];?>">
          </td>


  <td><div class="d-flex">
  <div class="position-relative w-100">
  <div class="d-flex w-100 align-items-center"> <span class="w-100">
  <select class="form-control select3 catalogue product" name="pid[]" required style="width:98%;">
  <option value="">Select Item</option>
  <?php

  $Asql=mysqli_query($con,"select * from product_details where status='Active'");
  while($Asql1=mysqli_fetch_array($Asql)){
    if($Asql1['id']==$_POST['product']){
  echo "<option value=".$Asql1['id']." selected>$Asql1[product]</option>"; 
  }else{
    echo "<option value=".$Asql1['id']." >$Asql1[product]</option>"; 
  }
}
  ?> 
  </select>
  </span> </div>
  </div>
  </div></td>

  <td> 
 <select class="form-control select2 Unit" name="unit[]" required="">
          <option value="">Select Unit</option>
          <?php 
          $PUnit=Get_Fetch_Data($con,$_POST['product'],"Unit","product_details");
        $Unit=Get_Fetch_Data($con,$PUnit['Unit'],"id,unit_name","unit_details");
        echo "<option value=" . $Unit['id'] . " selected>$Unit[unit_name]</option>";
          ?>
          </select>
  </td>  

  <td><input type="number" class="form-control qty" name="qty[]" placeholder="Enter Quantity" value="<?php echo $_POST['qty'];?>" required value="1"></td>

  <td><input type="number" class="form-control rate" name="rate[]" placeholder="Enter Rate" required  value="<?php echo $_POST['rate'];?>"></td>
  <td><a class="gsttax"><?php echo $Taxable;?></a>
    <input type="hidden" class="cgst" name="cgst[]" value="<?=$CGSTPer;?>">
    <input type="hidden" class="cgst_amt" name="cgst_amt[]" value="<?=$CGST;?>">
    <input type="hidden" class="sgst" name="sgst[]" value="<?=$SGSTPer;?>">
    <input type="hidden" class="sgst_amt" name="sgst_amt[]" value="<?=$SGST;?>">
    <input type="hidden" class="igst" name="igst[]" value="<?=$IGSTPer;?>">
    <input type="hidden" class="igst_amt" name="igst_amt[]" value="<?=$IGST;?>">
  </td>
  <td><div class="d-flex justify-content-end">
  <input type="text" class="form-control Amount" name="Amount[]" placeholder="Amount" value="<?=$Tamount; ?>" readonly>
  <span class="float-right ml-3"> <a href="javascript:void" class="RemoveR"><i class="fa fa-minus-circle text-danger" aria-hidden="true"></i></a> </span> </div></td>
  </tr>
  <?php
}
if ($_POST['part'] == 'Add_Order_Item_GMinvoiceTable_Part')
{

?>
<tr>
<td><div class="d-flex">
<div class="position-relative w-100">
<div class="d-flex w-100 align-items-center"> <span class="w-100">

<input type="text" name="gmname[]" placeholder="Enter Product Name" class="form-control">
</span> </div>
</div>
</div></td>
<td><input type="text" class="form-control qty" name="saleamount[]" placeholder="Enter Sale Amount" onkeypress="return /[0-9]/i.test(event.key)" required></td>
<td><input type="number" class="form-control rate" name="rate[]" placeholder="Enter Percentage" required  value="<?=$MRP; ?>"></td>
<td><div class="d-flex justify-content-end">
<input type="text" class="form-control Amount" name="Amount[]" placeholder="Commission Amount" value="<?=$Amount; ?>" readonly>
<span class="float-right ml-3"> <a href="javascript:void" class="RemoveR"><i class="fa fa-minus-circle text-danger" aria-hidden="true"></i></a> </span> </div></td>
</tr>
<?php
}

  if ($_REQUEST['part'] == 'Get_Customer_Discountamount_invoice'){

      $Csql = mysqli_query($con,"select discount from customer_details where id='".$_POST["customer"]."'");
      $Crow=mysqli_fetch_array($Csql);
      echo $Crow["discount"];

  }
  if ($_REQUEST['part'] == 'Get_Customer_Discounttype_invoice'){

      $html = "<option value='Rupees'>₹</option>";
      $html .= "<option value='Percent'>%</option>";
      echo $html;

  }

  if ($_REQUEST['part'] == 'Supplier_Invoice_Product'){

      $html = "<option value=''>Select Item</option>";

      $Csql = mysqli_query($con,"select a.product,a.hsn_code,a.id,b.oid,b.sid from product_details as a, order_product as b where a.id=b.pid and b.sid='".$_POST['supplierid']."' group by b.pid, b.sid");

      while ($Crow = mysqli_fetch_array($Csql))

      {
         $vendorcode=Get_Fetch_Data($con,$_POST['supplierid'],"id,Vendor_Code","vendor_details");
          $checkqty=invoiceproduct_stock($con,$Crow["id"],$_POST['supplierid']);
          if($checkqty > "0"){
          $html .= "<option value=" . $Crow['id'] . ">($vendorcode[Vendor_Code])  $Crow[product] - $Crow[hsn_code]</option>";
            }
              }

      echo $html;

  }
if ($_REQUEST['part'] == 'Get_catalogue_HSN_Item'){
$html = "<option value=''>All Design</option>";
$vendorcode=Get_Fetch_Data($con,$_POST['customer'],"id,Vendor_Code,department","vendor_details");
$Itmsqls=mysqli_query($con,"select id,product,hsn_code from product_details where supplier='".$_POST['customer']."' and hsn_code='".$_POST['hsn_code']."' order by id desc");
while($Itmrows=mysqli_fetch_array($Itmsqls)){
$hsncode=Get_Fetch_Data($con,$Itmrows[hsn_code],"hsncode","HsnList");
$html.="<option value=".$Itmrows['id']."> ($vendorcode[Vendor_Code])   $Itmrows[product] - $hsncode[hsncode]</option>"; 	
}
echo $html;
}

  if ($_REQUEST['part'] == 'Get_catalogue_Item'){

      $html = "<option value=''>All Item</option>";

      $Csql = mysqli_query($con,"select id,hsn_code from product_details where id='" . $_POST['catalogue'] . "' and status='Active'");

      while ($Crow = mysqli_fetch_array($Csql))

      {

          $html .= "<option value=" . $Crow['id'] . ">$Crow[hsn_code]</option>";

      }

      echo $html;

  }

  

  if ($_REQUEST['part'] == 'Get_catalogue_Qty')

  {

      $row = Get_Fetch_Data($con,$_POST['catalogue'], 'All', 'product_details');

      echo $row['tot_qty'];

  }

  

  if ($_REQUEST['part'] == 'Get_Catalogue_Rate')

  {
      $customer = Get_Fetch_Data($con,$_POST['customer'], 'ctpe', 'customer_details');
	  $row =Get_Challan_Voucher_Rate($con,$_POST['catalogue']);
      //$row = Get_Fetch_Data($con,$_POST['catalogue'], 'mrp,ws', 'challan_items');
      if($customer['ctpe']=="2"){
       $rate=$row['mrp'];
      }else{
        $rate=$row['ws'];
      }

      echo $rate;

  }

  if ($_REQUEST['part'] == 'Get_OutstandingAmount')
  {
      $customer = Get_Fetch_Data($con,$_POST['customer'], 'TallyLedger,CreditLimits', 'customer_details');
      //$amount=Get_Order_Amounts_Customer($con,$_POST['customer']);
	  $OutStanding=Get_Ledger_OutStanding($customer['TallyLedger']);
      echo "<span style='float: left;padding-right: 3px;'>₹ ".$OutStanding.'</span> Limit ₹ '.$customer[CreditLimits];
  }

  if ($_REQUEST['part'] == 'Customerformsubmit')

  {
      $Check=Get_Count_Data($con,$_POST['primaryno'],'ccn','customer_details_temp');
      if($Check==0){
      $sqls=mysqli_query($con,"insert into  customer_details_temp(Vendor_Code,FName,LName,Cname,VDN,Email,TLC,DOB,TallyLedger,GstTreatment,SSupply,Address,State,City,Pincode,UserName,Password,BankName,AccountNo,Branch,IFSC,Add_Time,gstno,cwn,ccn,ctpe) values('".mysqli_real_escape_string($con,$_POST['SupplierCode'])."','".mysqli_real_escape_string($con,$_POST['FName'])."','".mysqli_real_escape_string($con,$_POST['LName'])."','".mysqli_real_escape_string($con,$_POST['Cname'])."','".mysqli_real_escape_string($con,$_POST['VDN'])."','".mysqli_real_escape_string($con,$_POST['Email'])."','".mysqli_real_escape_string($con,$_POST['TLC'])."','".$_POST['DOB']."','".mysqli_real_escape_string($con,$_POST['TallyLedger'])."','".$_POST['gsttype']."','".$_POST['SSupply']."','".mysqli_real_escape_string($con,$_POST['Address'])."','".$_POST['state']."','".$_POST['city']."','".$_POST['Pincode']."','".$_POST['UserName']."','".$_POST['Password']."','".mysqli_real_escape_string($con,$_POST['BankName'])."','".$_POST['AccountNo']."','".mysqli_real_escape_string($con,$_POST['Branch'])."','".$_POST['IFSC']."','".date('d/m/Y H:i:s')."','".$_POST['gstno']."','".$_POST['cwn']."','".$_POST['primaryno']."','".$_POST['ctype']."')");
      $cid=mysqli_insert_id($con);
      $_SESSION['customerid']=$cid;

  }else{
    $upd=mysqli_query($con,"update customer_details_temp set Vendor_Code='".mysqli_real_escape_string($con,$_POST['SupplierCode'])."',FName='".mysqli_real_escape_string($con,$_POST['FName'])."',LName='".mysqli_real_escape_string($con,$_POST['LName'])."',Cname='".mysqli_real_escape_string($con,$_POST['Cname'])."',VDN='".mysqli_real_escape_string($con,$_POST['VDN'])."',Email='".mysqli_real_escape_string($con,$_POST['Email'])."',TLC='".mysqli_real_escape_string($con,$_POST['TLC'])."',DOB='".$_POST['DOB']."',TallyLedger='".mysqli_real_escape_string($con,$_POST['TallyLedger'])."',GstTreatment='".$_POST['gsttype']."',SSupply='".$_POST['SSupply']."',Address='".mysqli_real_escape_string($con,$_POST['Address'])."',State='".$_POST['state']."',City='".$_POST['city']."',Pincode='".$_POST['Pincode']."',Password='".mysqli_real_escape_string($con,$_POST['Password'])."',BankName='".mysqli_real_escape_string($con,$_POST['BankName'])."',AccountNo='".$_POST['AccountNo']."',Branch='".mysqli_real_escape_string($con,$_POST['Branch'])."',IFSC='".$_POST['IFSC']."',cwn='".$_POST['cwn']."',ccn='".$_POST['primaryno']."',ctpe='".$_POST['ctype']."',gstno='".$_POST['gstno']."' where id='".$_POST["editid"]."'");
    $cid=$_POST["editid"];
  }
echo $cid;
  }

  if ($_REQUEST['part'] == 'Supplierformsubmit')

  {
      $Check=Get_Count_Data($con,$_POST['primaryno'],'scn','vendor_details_temp');
      if($Check==0){
        $department=implode(',',$_POST["department"]);
      $sqls=mysqli_query($con,"insert into  vendor_details_temp(Vendor_Code,FName,LName,Cname,VDN,Email,TLC,DOB,TallyLedger,GstTreatment,SSupply,Address,State,City,Pincode,UserName,Password,BankName,AccountNo,Branch,IFSC,Add_Time,gstno,swn,scn,address2,department) values('".mysqli_real_escape_string($con,$_POST['SupplierCode'])."','".mysqli_real_escape_string($con,$_POST['FName'])."','".mysqli_real_escape_string($con,$_POST['LName'])."','".mysqli_real_escape_string($con,$_POST['Cname'])."','".mysqli_real_escape_string($con,$_POST['VDN'])."','".mysqli_real_escape_string($con,$_POST['Email'])."','".mysqli_real_escape_string($con,$_POST['TLC'])."','".$_POST['DOB']."','".mysqli_real_escape_string($con,$_POST['TallyLedger'])."','".$_POST['gsttype']."','".$_POST['SSupply']."','".mysqli_real_escape_string($con,$_POST['Address'])."','".$_POST['state']."','".$_POST['city']."','".$_POST['Pincode']."','".$_POST['UserName']."','".$_POST['Password']."','".mysqli_real_escape_string($con,$_POST['BankName'])."','".$_POST['AccountNo']."','".mysqli_real_escape_string($con,$_POST['Branch'])."','".$_POST['IFSC']."','".date('d/m/Y H:i:s')."','".$_POST['gsttno']."','".$_POST['cwn']."','".$_POST['primaryno']."','".mysqli_real_escape_string($con,$_POST['Address2'])."','".$department."')");
      $cid=mysqli_insert_id($con);
      $_SESSION['supplierid']=$cid;

  }else{
    $department=implode(',',$_POST["department"]);
        $upd=mysqli_query($con,"update vendor_details_temp set Vendor_Code='".mysqli_real_escape_string($con,$_POST['SupplierCode'])."',FName='".mysqli_real_escape_string($con,$_POST['FName'])."',LName='".mysqli_real_escape_string($con,$_POST['LName'])."',Cname='".mysqli_real_escape_string($con,$_POST['Cname'])."',VDN='".mysqli_real_escape_string($con,$_POST['VDN'])."',Email='".mysqli_real_escape_string($con,$_POST['Email'])."',TLC='".mysqli_real_escape_string($con,$_POST['TLC'])."',DOB='".$_POST['DOB']."',TallyLedger='".mysqli_real_escape_string($con,$_POST['TallyLedger'])."',GstTreatment='".$_POST['gsttype']."',SSupply='".$_POST['SSupply']."',Address='".mysqli_real_escape_string($con,$_POST['Address'])."',State='".$_POST['state']."',City='".$_POST['city']."',Pincode='".$_POST['Pincode']."',Password='".mysqli_real_escape_string($con,$_POST['Password'])."',BankName='".mysqli_real_escape_string($con,$_POST['BankName'])."',AccountNo='".$_POST['AccountNo']."',Branch='".mysqli_real_escape_string($con,$_POST['Branch'])."',IFSC='".$_POST['IFSC']."',swn='".$_POST['cwn']."',scn='".$_POST['primaryno']."',address2='".mysqli_real_escape_string($con,$_POST['Address2'])."',gstno='".$_POST['gsttno']."',department='".$department."',mrp='".$_POST['mrp']."',ws='".$_POST['ws']."',nearst='".$_POST['nearst']."' where id='".$_POST["editid"]."'");
    $cid=$_POST["editid"];
  }
echo $cid;
  }

  if ($_REQUEST['part'] == 'Get_Catalogue_Amount')

  {

      $row = Get_Fetch_Data($con,$_POST['catalogue'], 'All', 'product_details');

      $customer = Get_Fetch_Data($con,$_POST['customer'], 'id,user_type', 'user_details');

      if ($customer['user_type'] == 'Distributor')

      {

          $MRP = $row['dist_catl'];

      }

      else if ($customer['user_type'] == 'Wholesaler')

      {

          $MRP = $row['whol_catl'];

      }

      else if ($customer['user_type'] == 'Retailer')

      {

          $MRP = $row['ret_catl'];

      }

      else if ($customer['user_type'] == 'Sub-Retailer')

      {

          $MRP = $row['subret_catl'];

      }

      else

      {

          $MRP = $row['mrp_catl'];

      }

      echo $MRP * $row['tot_qty'];

  }
  
  if ($_REQUEST['part'] == 'Get_Catalogue_Indv_Rate'){

      $customer = Get_Fetch_Data($con,$_POST['customer'], 'id,user_type', 'user_details');

      if ($_POST['item'] == '')

      {

          $row = Get_Fetch_Data($con,$_POST['catalogue'], 'All', 'product_details');

          if ($customer['user_type'] == 'Distributor')

          {

              $MRP = $row['dist_catl'];

          }

          else if ($customer['user_type'] == 'Wholesaler')

          {

              $MRP = $row['whol_catl'];

          }

          else if ($customer['user_type'] == 'Retailer')

          {

              $MRP = $row['ret_catl'];

          }

          else if ($customer['user_type'] == 'Sub-Retailer')

          {

              $MRP = $row['subret_catl'];

          }

          else

          {

              $MRP = $row['mrp_indv'];

          }

          echo $MRP;

      }

      else

      {

          $item = Get_Fetch_Data($con,$_POST['item'], 'All', 'product_catalogue');

          $row = Get_Fetch_Data($con,$item['pid'], 'All', 'product_details');

          if ($customer['user_type'] == 'Distributor')

          {

              $MRP = $row['dist_indv'];

          }

          else if ($customer['user_type'] == 'Wholesaler')

          {

              $MRP = $row['whol_indv'];

          }

          else if ($customer['user_type'] == 'Retailer')

          {

              $MRP = $row['ret_indv'];

          }

          else if ($customer['user_type'] == 'Sub-Retailer')

          {

              $MRP = $row['subret_indv'];

          }

          else

          {

              $MRP = $row['mrp_indv'];

          }

          echo $MRP;

      }

  }

  

  if ($_REQUEST['part'] == 'Get_Catalogue_Indv_Amount')

  {

      $row = Get_Fetch_Data($con,$_POST['catalogue'], 'All', 'product_details');

      $customer = Get_Fetch_Data($con,$_POST['customer'], 'id,user_type', 'user_details');

      if ($customer['user_type'] == 'Distributor')

      {

          $MRP = $row['dist_indv'];

      }

      else if ($customer['user_type'] == 'Wholesaler')

      {

          $MRP = $row['whol_indv'];

      }

      else if ($customer['user_type'] == 'Retailer')

      {

          $MRP = $row['ret_indv'];

      }

      else if ($customer['user_type'] == 'Sub-Retailer')

      {

          $MRP = $row['subret_indv'];

      }

      else

      {

          $MRP = $row['mrp_indv'];

      }

      echo $MRP * $row['tot_qty'];

  }


if ($_REQUEST['part'] == 'Get_Invoice_User_Parts'){
$Row=Get_Fetch_Data($con,$_POST["customer"],"All","customer_details");
$state_name=Get_Fetch_Data($con,$Row["State"],"state_name","state_details");
$city_name=Get_Fetch_Data($con,$Row["City"],"city_name","city_details");
?>
<div class="col-sm-1">
<label for="inputPassword" class="col-sm-12 col-form-label pl-0 d-flex  " style="background: #fff;    padding: 6px;
    border-radius: 4px;color: #b3b3b3;">  <i class="fas fa-map-marker-alt"></i> Address</label>
</div>
<div class="col-sm-5"><label>
<span style="float: left;    font-size: 12px;    text-transform: capitalize;    color: #938d8d;"><?="$Row[Address] $state_name[state_name]".'<br>'." $city_name[city_name] - $Row[Pincode]";?></span></label>
 
</div>
<div class="col-sm-3 px-2">
<p class="text-left-40"><i class="fas fa-mobile-alt"></i> <?="$Row[ccn]";?></p>
<p class="text-left-40"><i class="fab fa-whatsapp"></i> <?="$Row[cwn]";?></p>

</div>
<div class="col-sm-3 px-2">
<p class="text-left-40"><i class="fa fa-envelope"></i> <?="$Row[Email]";?></p>
<p class="text-left-40"><b><i class="fa fa-percent" aria-hidden="true"></i>
GSTIN NO</b> <?="$Row[gstno]";?></p>
 
</div>
 
 
<div class="col-sm-12">
<input type="checkbox" name="CalcType" value="AutoSubmit" id="AutoSubmit" checked><label for="AutoSubmit">&nbsp;Auto Submit</label>
<div class=" ">
<table class="table   table-center mb-0" id="myTableF">
<thead>
<tr>
<th style="width:200px">Item</th>
<th style="width: 100px;">Quantity </th>
<th style="width: 100px;">Rate </th>
<th style="width: 120px;">Discount </th>
<th style="width: 120px;">Tax </th>
<th style="width: 100px;
text-align: right;
padding-right: 5px !important;">Amount </th>
</tr>
</thead>
<tbody>
<tr>
<td>
<input type="hidden" class="catalogue" name="catalogue[]" id="itemr">
<input type="text" class="form-control" id="search_catl" placeholder="Item" />
<div id="Stock_Show"></div>
</td>
<td> <input type="text" class="form-control qty" name="qty[]"  placeholder="Quantity" id="Quantity" readonly></td>
<td><input type="text" class="form-control rate" name="rate[]"  placeholder="Rate" id="Rates" readonly> </td>
<td>
<div class="d-flex w-50 ">
<input type="hidden" class="Discountamt" name="Discountamt[]">
<input type="text" class="form-control p-2 h-30 DiscountVal" name="DiscountVal[]" id="DiscountVal" value="<?=$Row['discount'];?>" readonly style="width: 50px;border-top-right-radius:0px;border-bottom-right-radius:0px;">
<select name="DiscountType[]" class="form-control p-2 h-30 border-left-0 DiscountType" name="DiscountType[]" id="DiscountType" style="width: 50px;">
<option value="Percent">%</option>
<option value="Rupees">₹</option>
</select>
</div>
</td>
<td style="padding:0px;"><span class="Taxs">00</span>
<input type="hidden" class="cgst" name="cgst[]"><input type="hidden" class="cgst_amt" name="cgst_amt[]">
<input type="hidden" class="sgst" name="sgst[]"><input type="hidden" class="sgst_amt" name="sgst_amt[]">
<input type="hidden" class="igst" name="igst[]"><input type="hidden" class="igst_amt" name="igst_amt[]">
</td>

<td>
<div class="d-flex justify-content-end">
<input type="hidden" class="Subtotal" name="Subtotals[]">
<input type="text" class="form-control Amount" name="Amount[]" id="Amount"  placeholder="Amount" style="width:80px;" readonly><span class="float-right ml-2">
<a href="javascript:void" id="AddF"><i class="fa fa-plus-circle text-success" aria-hidden="true"></i></a>  
</span>
</div>
</td>
</tr>
</tbody>
</table>
<p class="border-bottom" style="border-color: #cccccc5e !important;"></p>
</div>
</div>
</div>

<div class="col-sm-3 table-left">
<table class="table ">
<tbody>
<tr style=" "><th style="width: 100%;">Total Qty</th><th><div id="TotalQty" style="text-align:right">00</div></th><th></th></tr>
</tbody>
</table>
<div class="row">
<div class="col-sm-12">
<label for="inputPassword" class="col-sm-12 col-form-label pl-0"> LR No. </label>
<input type="text" class="form-control" name="LR_No" placeholder=" LR No. ">
</div>
<div class="col-sm-12">
<label for="inputPassword" class="col-sm-12 col-form-label pl-0"> LR Date </label>
<input type="text" class="form-control datepickerss" name="LR_date" placeholder=" LR Date " readonly>
</div>
<div class="col-sm-12">
<label for="inputPassword" class="col-sm-12 col-form-label pl-0"> Box </label>
<select class="form-control" name="LR_box">
<option value="">Select Box</option>
<?php
for($i=1;$i<=10;$i++){
echo "<option value=".$i.">$i Box</option>";	
}
?>
</select>
</div>
</div>
</div>
<div class="col-sm-4"></div>
<div class="col-sm-5">
<table class="table   table-center mb-0 table-right  " id="myTableOT">
<tbody>
<tr>
<td><b>Sub Total</b></td>
<td colspan="4">&nbsp;</td>
<td class="text-right pr-3"><input type="hidden" name="Subtotal" id="Subtotal">
<b><span id="SubtotalShow">00.00</span></b></td>
</tr>
<tr>
<td class="text-grey">Discount(-)</td>
<td colspan="4"></td>
<td class="text-right pr-3"><input type="hidden" name="discountamt" id="discountamt">
<b><span id="discountshow" class=" ">00.00</span></b></td>
</tr>
<?php
if($Row["State"]=="7"){
?>
<tr>
<td class='text-grey'>CGST(+)</td>
<td colspan='4'><div class='d-flex w-50 '></td>
<td class='text-right pr-3'><input type='hidden' name='cgstamount' id='cgstamount'>
<b><span id='CGstchargeShow' class=' '>00.00</span></b></td>
</tr>
<tr>
<td class='text-grey'>SGST(+)</td>
<td colspan='4'></td>
<td class='text-right pr-3'><input type='hidden' name='sgstamount' id='sgstamount'>
<b><span id='SGstchargeShow' class=' '>00.00</span></b></td>
</tr>
<?php } else { ?>
<tr><td class='text-grey'>IGST(+)</td>
<td colspan='4'></td>
<td class='text-right pr-3'><input type='hidden' name='igstamount' id='igstamount'>
<b><span id='IGstchargeShow' class=' '>00.00</span></b></td>
</tr>
<?php } ?>
<tr>
<td colspan="6" class=" " style="font-size: 12px;padding: 0px;padding-left: 8px;">Other charges(+)</td></tr>
<tr>  
<td colspan="4"> <div class="d-flex w-50 ">
<select class="form-control p-2 h-40 Ocharge" name="Ocharge[]" style="width: 120px;">
<option value="">Select</option>
<?php
$Ochsql=mysqli_query($con,"select id,charge_name from charges_details where status='Active'");
while($Ochrow=mysqli_fetch_array($Ochsql)){
echo "<option value=".$Ochrow['id'].">$Ochrow[charge_name]</option>";
}
?>
</select>
</div></td>
<td class="text-right pr-3">
<input type="text" class="form-control p-2 h-30 Othercharge" name="Othercharge[]">
</td>
<td class="text-right pr-3">
<div class="d-flex w-60 ">
<input type="text" class="form-control p-2 h-30 Otherchargeval" name="Otherchargeval[]" readonly>
<span class="float-right ml-3"> <a href="javascript:void" id="AddOT"><i class="fa fa-plus-circle text-success" aria-hidden="true"></i></a> </span>
</div>
</td>
</tr>
<tr>
<td class=' ' style="font-size: 12px;">Round off (+/-)</td>
<td colspan='4'></td>
<td class='text-right pr-3'><input type='text' class="form-control p-2 h-30" name='roundoff' id='roundoff'></td>
</tr>
<tr>
<td><b>Total (₹)</b></td>
<td colspan="4">&nbsp;</td>
<td class="text-right pr-3"><b>
<input type="hidden" name="TotalAmount" id="TotalAmount">
<span id="TotalAmountShow">00.00</span></b></td>
</tr>
</tbody>

</table>
</div>
<?php

}

if ($_REQUEST['part'] == 'Get_Customer_Shipping'){
  ?>
  <div class="form-group row">
  <label for="inputPassword" class="col-sm-4 col-form-label">LR No. :  </label>
  <div class="col-sm-8"> 
  <input type="text" class="form-control" placeholder="LR No. :  " name="ledgerno"> 
  </div>
  </div>
  <div class="form-group row">
  <label for="inputPassword" class="col-sm-4 col-form-label">Transport Name : </label>                  
  <div class="col-sm-8">
  <input type="text" class="form-control" placeholder="Enter Trnasport Name" name="transport"> 
  </div>
  </div>

  <div class="form-group row">
  <label class="col-sm-4 col-form-label">Dispatch (In Days): </label>                  
  <div class="col-sm-8">
  <select class="form-control select2 dispatch_days" name="dispatch_days">
  <option value="">Select</option>                          
  <option value="7">7</option>
  <option value="15">15</option>
  <option value="30">30</option> 
  <option value="45">45</option>      
  <option value="60">60</option>
  <option value="90">90</option>
  </select> 
  </div>
  </div>

  
  <?php
}

  
   if ($_REQUEST['part'] == 'Get_Invoice_Remark'){
  ?>
<div class="form-group row">
                      <label for="inputPassword" class="col-sm-4 col-form-label">Remark :  </label>
                      <div class="col-sm-8"> 
                        <textarea class="form-control" name="remark" placeholder="Enter Something..."></textarea>
                      </div>
                    </div>
                    
<?php

  }
  if ($_REQUEST['part'] == 'Get_GstTaxGM'){
    $supplier=Get_Fetch_Data($con,$_POST['customer'],"id,State","supplier");
   
  ?>
  <tr>
                            <td>Sub Total</td>
                            <td colspan="4">&nbsp;</td>
                            <td class="text-right"><input type="hidden" name="Subtotal" id="Subtotal"><span id="SubtotalShow">00.00</span></td>
                            </tr>
                            <?php  if($supplier["State"]=="8"){?>
<tr>
                        <td class=''>CGST(+)</td>
      <td colspan='4'>
        <div class='d-flex w-50 '>
          <select class='form-control p-2 h-30 border-left-0 input-small' id='cgstcharge' name='cgsttax'>
            <option value=''>Select</option>
           <option value="2.5">2.5%</option>
           <option value="6">6%</option>
           <option value="9">9%</option>
          </select>
          </div></td>
      <td class='text-right '>
        <input type='hidden' name='cgstamount' id='cgstamount'>
        <span id='CGstchargeShow' class=''>00.00</span></td>

                      </tr>

                          <tr>
                        <td class=''>SGST(+)</td>
                    <td colspan='4'>
                      <div class='d-flex w-50 '>
                        <select class='form-control p-2  input-small border-left-0' id='sgstcharge' name='sgsttax'>
                          <option value=''>Select</option>
                         <option value="2.5">2.5%</option>
                         <option value="6">6%</option>
                         <option value="9">9%</option>
                        </select>
                        </div></td>
                    <td class='text-right'>
                      <input type='hidden' name='sgstamount' id='sgstamount'>
                      <span id='SGstchargeShow' class=''>00.00</span></td>

                      </tr>
                    <?php }else{ ?>
                       <tr>
    <td class='text-warning'>IGST(+)</td>
      <td colspan='4'>
        <div class='d-flex w-50 '>
          <select class='form-control p-2  border-left-0 input-small' id='Igstcharge' name='Igstcharge'>
            <option value=''>Select</option>
           <option value="5">5%</option>
           <option value="12">12%</option>
           <option value="18">18%</option>
          </select>
          </div></td>
      <td class='text-right '>
        <input type='hidden' name='igstamount' id='igstamount'>
        <span id='IGstchargeShow' class=''>00.00</span></td>

                      </tr>
                    <?php } ?>
                    <tr>
                            <td><b>Total (₹)</b></td>
                            <td colspan="4">&nbsp;</td>
                            <td class="text-right "><b>
                              <input type="hidden" name="TotalAmount" id="TotalAmount"><span id="TotalAmountShow">00.00</span></b>
                            </td>
                          </tr>

                    
<?php

  }

if ($_REQUEST['part'] == 'All_Area_Data')
{
$requestData = $_REQUEST;
$sqls = "SELECT * FROM area_details where id!='' $where";
$sql = "SELECT * FROM area_details where id!='' $where";
$querys = mysqli_query($con,$sqls);
$totalData = mysqli_num_rows($querys);
$totalFiltered = $totalData;
if (!empty($requestData['search']['value']))
{ // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql .= " AND ( area_name LIKE '%" . $requestData['search']['value'] . "%' ";
$sql .= " OR status LIKE '%" . $requestData['search']['value'] . "%' )";
}
$sql .= " ORDER BY area_name asc LIMIT " . $requestData['start'] . " ," . $requestData['length'] . " ";
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
$nestedData[] = "<div class='first'>$row[area_name]</div>";
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

if ($_POST['part'] == 'Area_data_Update')

  {

      $row = Get_Fetch_Data($con,$_POST['id'], 'All', 'area_details');

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
          <label> Area Name<span class="text-danger">*</span></label>
          <input type="text" class="form-control" value="<?php echo $row['area_name']; ?>" name="area_name" required>
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
    <button class="btn btn-success" name="UpdateArea">Update</button>
  </form>
</div>
<?php

  }
  //State Data

 
  if ($_REQUEST['part'] == 'All_Notification_Template_Data') {
$requestData = $_REQUEST;
if ($_REQUEST['from'] != '' && $_REQUEST['to'] != '')
{
$ff = explode('/', $_REQUEST['from']);
$from = $ff[2] . '-' . $ff[1] . '-' . $ff[0];
$tt = explode('/', $_REQUEST['to']);
$to = $tt[2] . '-' . $tt[1] . '-' . $tt[0];
$where .= " and STR_TO_DATE(`expiry`, '%d/%m/%Y') between '" . $from . "' and '" . $to . "'";
}
if ($_REQUEST['status'] != '')
{
$where .= " and status='" . $_REQUEST['status'] . "'";
}
$sqls = "SELECT * FROM notif_template where id!='' $where";
$sql = "SELECT * FROM notif_template where id!='' $where";
$querys = mysqli_query($con,$sqls);
$totalData = mysqli_num_rows($querys);
$totalFiltered = $totalData;
if (!empty($requestData['search']['value']))
{ // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql .= " AND ( template LIKE '%" . $requestData['search']['value'] . "%' ";
$sql .= " OR status LIKE '%" . $requestData['search']['value'] . "%' )";
}
$sql .= " ORDER BY id desc LIMIT " . $requestData['start'] . " ," . $requestData['length'] . " ";
//echo $sqls;
$query = mysqli_query($con,$sql);
//$totalFiltered = mysql_num_rows($query);
$data = array();
$i = 1;
while ($row = mysqli_fetch_array($query))
{ // preparing an array
$coupon = "<span class='badge badge-pill bg-primary inv-badge'>$row[coupon]</span><br>";

$action = "<input type='hidden' class='id' value=" . $row['id'] . ">
<span style='white-space:nowrap;float: right;'>
<a class='btn btn-sm bg-success-light mr-2 updateLinks' href='javascript:void'><i class='fe fe-pencil'></i></a>&nbsp;
<a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></i></a></span>";

if ($row[status] == 'Active')
{
$class = 'bg-success';
} else {
$class = 'bg-danger';
}

$nestedData = array();
$nestedData[] = "<div class=''>$row[template]</div>";
$nestedData[] = "<div class=''>$row[message]</div>";
$nestedData[] = "<div class='third'><span class='badge badge-pill $class inv-badge'>$row[status]</span>";
$nestedData[] = "<div class='third'>$row[add_time]</div>";
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

if ($_REQUEST['part'] == 'Get_wholesaleprice'){
$cprice=Get_Fetch_Data($con,$_POST['supplierid'],"mrp,ws,nearst","vendor_details");
$near=$cprice["nearst"];
$mrpPer=$_POST['ratea'] * $cprice["mrp"]/100;
$MRPSUBtract=$_POST['ratea']-$mrpPer;
$MRPMultiply=$_POST['ratea']*$mrpPer;
$MRP=$_POST['ratea']+($MRPMultiply/$MRPSUBtract);

$MRPMOd=round($MRP)%$cprice["nearst"];

$wsPer=$_POST['ratea']*$cprice["ws"]/100;
$WSSUBtract=$_POST['ratea']-$wsPer;
$WSMultiply=$_POST['ratea']*$wsPer;
$WS=$_POST['ratea']+($WSMultiply/$WSSUBtract);
$WSMOd=round($WS)%$cprice["nearst"];
if($MRPMOd>0){
$tmrp=round($MRP)-$MRPMOd;
} else { $tmrp=round($MRP); }
if($WSMOd>0){
$tws=round($WS)-$WSMOd;
} else {
$tws=round($WS);	
}
echo "$tmrp|$tws";
}

  if ($_REQUEST['part'] == 'check_agent_mobno'){

      $Csql = mysqli_query($con,"select mobile from agent_details where mobile='" . $_POST['mobno'] . "'");

      $Crow = mysqli_num_rows($Csql);

      if($Crow=="0"){
       $html .="Verify"; 
      }else{
        $html .= "Sorry Your Mobile No Already Exist In Our Database";
      }

      echo $html;

  }

  if ($_REQUEST['part'] == 'check_supplier_code'){

      $Csql = mysqli_query($con,"select Vendor_Code from vendor_details where Vendor_Code='" . $_POST['suppliecode'] . "'");

      $Crow = mysqli_num_rows($Csql);

      if($Crow=="0"){
       $html .="<span class='text-success'>Verify</span>"; 
      }else{
        $html .= "<span class='text-danger'>Sorry This Supplier Code Already Exist In Our Database</span>";
      }

      echo $html;

  }


  if ($_REQUEST['part'] == 'validatechallan'){

      $Csql = mysqli_query($con,"select id from order_details where uid='".$_POST['supplierid']."' and challanno='".$_POST["challanno"]."'");

      $Crow = mysqli_num_rows($Csql);

      if($Crow=="0"){
       $html .="Verify"; 
      }else{
        $html .= "Sorry This Challan Number Already Exist In Our Database";
      }

      echo $html;

  }

  if ($_REQUEST['part'] == 'check_customer_code'){

      $Csql = mysqli_query($con,"select Vendor_Code from customer_details where Vendor_Code='" . $_POST['suppliecode'] . "'");

      $Crow = mysqli_num_rows($Csql);

      if($Crow=="0"){
       $html .="Verify"; 
      }else{
        $html .= "Sorry This Customer Code Already Exist In Our Database";
      }

      echo $html;

  }


  if ($_REQUEST['part'] == 'check_agent_code'){

      $Csql = mysqli_query($con,"select BrokerCode from agent_details where BrokerCode='" . $_POST['suppliecode'] . "'");

      $Crow = mysqli_num_rows($Csql);

      if($Crow=="0"){
       $html .="Verify"; 
      }else{
        $html .= "Sorry This Agent Code Already Exist In Our Database";
      }

      echo $html;

  }

  if ($_REQUEST['part'] == 'check_supplier_mobno'){

      $Csql = mysqli_query($con,"select scn from vendor_details where scn='" . $_POST['mobno'] . "'");

      $Crow = mysqli_num_rows($Csql);

      if($Crow=="0"){
       $html .="<span class='text-success'>Verify</span>"; 
      }else{
        $html .= "<span class='text-danger'>Sorry Your Mobile No Already Exist In Our Database</span>";
      }

      echo $html;

  }
  if ($_REQUEST['part'] == 'check_transport_mobno'){

      $Csql = mysqli_query($con,"select mobile from transport_details where mobile='" . $_POST['mobno'] . "'");

      $Crow = mysqli_num_rows($Csql);

      if($Crow=="0"){
       $html .="Verify"; 
      }else{
        $html .= "Sorry Your Mobile No Already Exist In Our Database";
      }

      echo $html;

  }

if ($_REQUEST['part'] == 'check_customer_mobno'){

      $Csql = mysqli_query($con,"select ccn from customer_details where ccn='" . $_POST['mobno'] . "'");

      $Crow = mysqli_num_rows($Csql);

      if($Crow=="0"){
       $html .="Verify"; 
      }else{
        $html .= "Sorry Your Mobile No Already Exist In Our Database";
      }

      echo $html;

  }

  if ($_REQUEST['part'] == 'Get_Agent_Commission'){

      $Csql = mysqli_query($con,"select commsion from agent_details where id='" . $_POST['Agentid'] . "'");

      $Crow = mysqli_fetch_array($Csql);

      

          $html .= $Crow["commsion"];

      

      echo $html;

  }
  if ($_REQUEST['part'] == 'Get_invoiceno'){
$invoiceno=Get_AjaxInvoiceno($con,$_POST['dep']);
      echo $invoiceno;

  }

  if ($_REQUEST['part'] == 'Get_Category'){

      $html = "<option value=''>All Category</option>";

      $Csql = mysqli_query($con,"select * from subcategory_details where category='" . $_POST['dep'] . "'");

      while ($Crow = mysqli_fetch_array($Csql))

      {

          $html .= "<option value=" . $Crow['id'] . ">$Crow[subcategory]</option>";

      }

      echo $html;

  }

if ($_REQUEST['part'] == 'Get_Challan_List'){
$html = "<option value=''>Select Challan</option>";
$Csql = mysqli_query($con,"select * from challan_details where uid='".$_POST['supplierid']."' and status='Pending'");
while ($Crow = mysqli_fetch_array($Csql))
{
$html .= "<option value=" . $Crow['id'] . ">$Crow[challanno]</option>";
}
echo $html;
}

if ($_REQUEST['part'] == 'Get_Challan_List_Bill_Type'){
$html = "<option value=''>Select $_POST[bill_from]</option>";
if($_POST['bill_from']=='Challan'){ 
$Csql = mysqli_query($con,"select * from challan_details where uid='".$_POST['supplierid']."' and status='Pending'");
} if($_POST['bill_from']=='Voucher'){
$Csql = mysqli_query($con,"select * from voucher_details where uid='".$_POST['supplierid']."' and status!='Billed'");	
}
while ($Crow = mysqli_fetch_array($Csql))
{
$html .= "<option value=" . $Crow['id'] . ">$Crow[challanno]</option>";
}
echo $html;
}

if ($_REQUEST['part'] == 'Get_Invoice_List'){
      $html = "<option value=''>All Invoice</option>";
      $Csql = mysqli_query($con,"select id,invoiceno from invoice_details where uid='" . $_POST['customerid'] . "'");
      while ($Crow = mysqli_fetch_array($Csql))
      {
          $html .= "<option value=" . $Crow['id'] . ">$Crow[invoiceno]</option>";
      }
      echo $html;
  }


  if ($_REQUEST['part'] == 'Get_Bill_List'){
      $html = "<option value=''>All Bill</option>";
      $Csql = mysqli_query($con,"select id,invoice_no from bill_details where uid='" . $_POST['supplierid'] . "'");
      while ($Crow = mysqli_fetch_array($Csql))
      {
          $html .= "<option value=" . $Crow['id'] . ">$Crow[invoice_no]</option>";
      }
      echo $html;
  }

  if ($_REQUEST['part'] == 'Get_City_List_State'){

      $html = "<option value=''>All City</option>";

      $Csql = mysqli_query($con,"select * from city_details where state='" . $_POST['state'] . "' and status='Active'");

      while ($Crow = mysqli_fetch_array($Csql))

      {

          $html .= "<option value=" . $Crow['id'] . ">$Crow[city_name]</option>";

      }

      echo $html;

  }
  if ($_REQUEST['part'] == 'Get_deoartment_list'){
    $vendordep=Get_Fetch_Data($con,$_POST['supplier'],"id,Vendor_Code,department","vendor_details");
      $html = "<option value=''>Department</option>";
      $Csql = mysqli_query($con,"select id,category from category_details where status='Active' and id IN ($vendordep[department])");
      while ($Crow = mysqli_fetch_array($Csql))
      {
          $html .= "<option value=" . $Crow['id'] . ">$Crow[category]</option>";
      }
      echo $html;
  }

  if ($_REQUEST['part'] == 'Get_Tax_List'){
    $vendordep=Get_Fetch_Data($con,$_POST['supplier'],"id,State","vendor_details");
      if($vendordep["State"]=="7"){
       $html .="<tr><td class='text-warning'>CGST(+)</td>
      <td colspan='4'><div class='d-flex w-50 '>
          <select class='form-control p-2 h-30 border-left-0' id='cgstcharge' name='cgstcharge'>
            <option value=''>Select</option>";

            $dtax=mysqli_query($con,"select Pcgst from GstTax");
            while($dtax1=mysqli_fetch_array($dtax)){
            $html .="<option value='".$dtax1['Pcgst']."'>".$dtax1['Pcgst']."%</option>";
          }
            
           $html .="</select>
        </div></td>
      <td class='text-right pr-5'><input type='hidden' name='cgstamount' id='cgstamount'>
        <span id='CGstchargeShow' class='text-warning'>00.00</span></td></tr>";

        $html .="<tr><td class='text-warning'>SGST(+)</td>
      <td colspan='4'><div class='d-flex w-50 '>
          <select class='form-control p-2 h-30 border-left-0' id='sgstcharge' name='sgstcharge'>
            <option value=''>Select</option>";

            $dtax=mysqli_query($con,"select Psgst from GstTax");
            while($dtax1=mysqli_fetch_array($dtax)){
            $html .="<option value='".$dtax1['Psgst']."'>".$dtax1['Psgst']."%</option>";
          }
            
           $html .="</select>
        </div></td>
      <td class='text-right pr-5'><input type='hidden' name='sgstamount' id='sgstamount'>
        <span id='SGstchargeShow' class='text-warning'>00.00</span></td></tr>";


      }else{
         $html .="<tr><td class='text-warning'>IGST(+)</td>
      <td colspan='4'><div class='d-flex w-50 '>
          <select class='form-control p-2 h-30 border-left-0' id='igstcharge' name='igstcharge'>
            <option value=''>Select</option>";

            $dtax=mysqli_query($con,"select Pigst from GstTax");
            while($dtax1=mysqli_fetch_array($dtax)){
            $html .="<option value='".$dtax1['Pigst']."'>".$dtax1['Pigst']."%</option>";
          }
            
           $html .="</select>
        </div></td>
      <td class='text-right pr-5'><input type='hidden' name='igstamount' id='igstamount'>
        <span id='IGstchargeShow' class='text-warning'>00.00</span></td></tr>";
      }
echo $html;
  }

  if ($_REQUEST['part'] == 'Get_Tax_ListCustomer'){
    $vendordep=Get_Fetch_Data($con,$_POST['customer'],"id,State","customer_details");
      if($vendordep["State"]=="7"){
       $html .="<tr><td class=''>CGST(+)</td>
      <td colspan='4'><div class='d-flex w-50 '>
          <select class='form-control p-2 h-30 border-left-0' id='cgstcharge' name='cgstcharge'>
            <option value=''>Select</option>";

            $dtax=mysqli_query($con,"select Scgst from GstTax");
            while($dtax1=mysqli_fetch_array($dtax)){
            $html .="<option value='".$dtax1['Scgst']."'>".$dtax1['Scgst']."%</option>";
          }
            
           $html .="</select>
        </div></td>
      <td class='text-right '><input type='hidden' name='cgstamount' id='cgstamount'>
        <span id='CGstchargeShow' class=''>00.00</span></td></tr>";

        $html .="<tr><td class=''>SGST(+)</td>
      <td colspan='4'><div class='d-flex w-50 '>
          <select class='form-control p-2 h-30 border-left-0' id='sgstcharge' name='sgstcharge'>
            <option value=''>Select</option>";

            $dtax=mysqli_query($con,"select Ssgst from GstTax");
            while($dtax1=mysqli_fetch_array($dtax)){
            $html .="<option value='".$dtax1['Ssgst']."'>".$dtax1['Ssgst']."%</option>";
          }
            
           $html .="</select>
        </div></td>
      <td class='text-right '><input type='hidden' name='sgstamount' id='sgstamount'>
        <span id='SGstchargeShow' class=''>00.00</span></td></tr>";


      }else{
         $html .="<tr><td class=''>IGST(+)</td>
      <td colspan='4'><div class='d-flex w-50 '>
          <select class='form-control p-2 h-30 border-left-0' id='igstcharge' name='igstcharge'>
            <option value=''>Select</option>";

            $dtax=mysqli_query($con,"select Sigst from GstTax");
            while($dtax1=mysqli_fetch_array($dtax)){
            $html .="<option value='".$dtax1['Sigst']."'>".$dtax1['Sigst']."%</option>";
          }
            
           $html .="</select>
        </div></td>
      <td class='text-right '><input type='hidden' name='igstamount' id='igstamount'>
        <span id='IGstchargeShow' class=''>00.00</span></td></tr>";
      }
echo $html;
  }

  if ($_REQUEST['part'] == 'Add_Shipping_Address')

  {

      mysqli_query($con,"insert into address_details(uid,name,mobile,address,state,city,pincode,country,add_time) 

  values('" . $_REQUEST['customerId'] . "','" . ucwords($_REQUEST['name']) . "','" . $_REQUEST['mobile'] . "','" . mysqli_real_escape_string($con,$_REQUEST['address']) . "','" . $_REQUEST['state'] . "','" . $_REQUEST['city'] . "','" . $_REQUEST['pincode'] . "','India','" . date('d/m/Y H:i:s') . "')");

  }

  

  if($_REQUEST['part'] == 'All_Attendacne_Data_Part'){ 

      $sql = "SELECT ass.name,ass.mobile, ass.email, ad.* FROM `attendence_details` ad LEFT JOIN admin_signup ass ON ad.uid=ass.id WHERE 1";

      $query = mysqli_query($con,$sql);

      $totalData = mysqli_num_rows($querys);

      $totalFiltered = $totalData;

      $data = array();

      $i = 1;

      while ($row = mysqli_fetch_array($query))

      { // preparing an array

          $action = "<input type='hidden' class='id' value=" . $row['id'] . "> <span style='white-space:nowrap;float: right;'><a class='btn btn-sm bg-success-light updateLinks' href='javascript:void;'><i class='fe fe-pencil'></i></a>&nbsp;<a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></a></span>";

          $checkinPhoto = ($row['in_photo'] != ''?$row['in_photo']:"noproducts.png");

          $checkoutPhoto = ($row['out_photo'] != ''?$row['out_photo']:"noproducts.png");

          $nestedData = array();

          $nestedData[] = "<div class='first'>$row[name]</div>";

          $nestedData[] = "<div class='first'>$row[checkin]</div>";

          $nestedData[] = "<div class='first'>Address</div>";

          $nestedData[] = "<a href='Attendence/$checkinPhoto' data-lightbox='photos'><img src='Attendence/$checkinPhoto' style='height:70px;width:70px;border-color: aliceblue !important;;padding: 1px;border: 1px solid;border-radius: 50%;box-shadow: 0px 0px 5px #ccc;'></a>";

          $nestedData[] = "<div class='first'>$row[checkout]</div>";

          $nestedData[] = "<div class='first'>Checkout Address</div>";

          $nestedData[] = "<a href='Attendence/$checkoutPhoto' data-lightbox='photos'><img src='Attendence/$checkoutPhoto' style='height:70px;width:70px;border-color: aliceblue !important;;padding: 1px;border: 1px solid;border-radius: 50%;box-shadow: 0px 0px 5px #ccc;'></a>";

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

  if($_POST['part']=='Notification_Template_Update') {
$row=Get_Fetch_Data($con,$_POST['id'],'All','notif_template');
?>
<div class="modal-header bg-success">
<h5 class="modal-title">Update Notification Template</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
</div>
<div class="modal-body">
<form  action="" method="post" enctype="multipart/form-data">
<div class="row form-row">
<div class="col-12">
<div class="form-group">
<label> Template Name</label>
<input type="text" class="form-control" value="<?php echo $row['template']; ?>" name="template" required>
</div>
</div>
<div class="col-12">
<div class="form-group">
<label> Message</label>
<textarea class="form-control" name="message" required><?php echo $row['message']; ?></textarea>
</div>
</div>
<div class="col-12">
<div class="form-group">
<label>Status</label>
<select class="form-control" name="status">
<?php
$arr=array('Active','Inactive');
foreach($arr as $status){
if($status==$row['status']){
echo "<option value=".$status." selected>$status</option>";
} else {
echo "<option value=".$status.">$status</option>";  
}
}
?>
</select>
</div>
</div>
</div>
<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
<input type="hidden" name="random_move" value="<?php echo $_SESSION['random_move']; ?>"> 
<button class="btn btn-success" name="UpdateTemplate">Update</button>
</form>
</div>
<?php } 

  if($_POST['sku_code'] && $_POST['action'] == 'check'){

      if(isset($_POST['pid']) && $_POST['pid'] > 0){

          $sql = "SELECT * from product_catalogue WHERE sku_code = '".$_POST['sku_code']."' AND id != '".$_POST['pid']."'";

      }else {

          $sql = "SELECT * from product_catalogue WHERE sku_code = '".$_POST['sku_code']."'";    

      }
      $query = mysqli_query($con,$sql);

      $row = mysqli_fetch_row($query);

      if(is_array($row)){

          $result['success'] = 0;

      }else {

          $result['success'] = 1;

      }

      echo json_encode($result); exit;

  }

if($_REQUEST['part']=='Get_Challan_Part_Table'){
?>
<div class="col-sm-12">
<table class="table table-hover  table-center mb-0" id="myTableF">
<thead>
<tr>
<th >Product Name</th>
<th >Quantity </th>
<th >Amount </th>
</tr>
</thead>
<tbody>
<tr>
<td class="position-relative">

    <select class="form-control" name="productid[]">
      <option>Select</option>
      <?php
          
                         $Asql=mysqli_query($con,"select * from product_details where status='Active'");
                              while($Asql1=mysqli_fetch_array($Asql)){
                                echo "<option value=".$Asql1['id']." >$Asql1[product]</option>"; 
                            }
          ?> 
    </select>

</td>

<td><input type="text" class="form-control qty" name="qty[]" id="Quantity" ></td>
<td><input type="text" class="form-control rate" name="amount[]" id="Rates"  placeholder="Enter Amount"  >
</td>
<td><div class="d-flex justify-content-end align-items-center">
<span class="float-right ml-2"> <a href="javascript:void" id="AddR"><i class="fa fa-plus-circle text-success" aria-hidden="true"></i></a> </span>
</div>
</td>
</tr>
</tbody>
</table>
<p class="border-bottom" style="border-color: #cccccc5e !important;"></p>
</div>
<div class="col-sm-5">
<table class="table table-hover table-striped table-center mb-0 table-left">
<tr>
<td style="padding: 8px;"><!--<b>Challan Note</b> --->
<textarea name="billnote"  class="form-control" placeholder="Challan Note"></textarea></td>
</tr>

</table>
 <b>Upload Attachment</b>
<div class="upload-cover">

      <label for="inputTag">
        <i class="fa fa-2x fa fa-upload"></i>  <span>Upload Files <span>jpg,png,pdf</span></span>
      
        <input id="inputTag" name="attachment" type="file"/>
        <br/>
        <span id="imageName"></span>
      </label>
     
</div>
</div>
<div class="col-sm-2"></div>
<div class="col-sm-5">
<table class="table   table-center mb-0 table-right  " id="myTableOT">
<tbody>
<tr>
<td><b> Total</b></td>
<td colspan="4">&nbsp;</td>
<td class="text-right pr-3 Subtotal"><input type="hidden" name="Subtotal" id="Subtotal">
<b><span id="SubtotalShow" class="Subtotal">00.00</span></b></td>
</tr>






</tbody>

</table>
</div>
<hr style="float: left;    width: 100%;">


<?php } 
if($_REQUEST['part'] == 'Add_New_Products'){ 
//$Check=Get_Count_TwoData($con,mysqli_real_escape_string($con,$_POST['product']),'product',$_POST['customerId'],'supplier','product_details');
$Sqls=mysqli_query($con,"select count(id) as countss from product_details where supplier='".$_POST['customerId']."' and product='".$_POST['product']."'");
$Check=mysqli_fetch_array($Sqls);
  if($Check['countss']==0){
  $folder='Product/';
  if($_FILES["img"]["name"]!=''){
  $temp = explode(".", $_FILES["img"]["name"]);
  $img = round(microtime(true)).'.'.end($temp);
  move_uploaded_file($_FILES["img"]["tmp_name"],$folder."/".$img);
  } else { $img =""; }
  $barcode=Get_Product_Barcode($con);
  $sqls="insert into  product_details(supplier,category,subcategory,product,hsn_code,barcode,cover_img,add_time,description,sprice,utpe,status) values('".$_POST['customerId']."','".mysqli_real_escape_string($con,$_POST['dep'])."','".mysqli_real_escape_string($con,$_POST['category'])."','".mysqli_real_escape_string($con,$_POST['product'])."','".mysqli_real_escape_string($con,$_POST['hsncode'])."','".$barcode."','".$img."','".date('d/m/Y H:i:s')."','".mysqli_real_escape_string($con,$_POST['description'])."','".$_POST['sprice']."','".mysqli_real_escape_string($con,$_POST['utpe'])."','".$_POST['status']."')";
   $sqls;
  $query=mysqli_query($con,$sqls);
  $Lid=mysqli_insert_id($con);
  $rowid=$_REQUEST["Selectedcatalogueid"];
  $vendorcode=Get_Fetch_Data($con,$_POST['customerId'],"Vendor_Code,department","vendor_details");
  if($query) {
  $msss="<div class='alert alert-success alert-dismissible'><strong>Success!</strong> Product Added Successfully.</div>";  
  }
  } else {
  $msss="<div class='alert alert-danger alert-dismissible'><strong>Sorry!</strong> This Product already exists in your account.</div>";  
  }
  $html = "<option value=''>Select Item</option>";
  $Csql = mysqli_query($con,"select id,product,hsn_code from product_details where supplier='".$_POST['customerId']."' order by id desc");
  while ($Crow = mysqli_fetch_array($Csql)){
    $hsncode=Get_Fetch_Data($con,$Crow[hsn_code],"hsncode","HsnList");
  if($Lid==$Crow['id']){
  $html .= "<option value=".$Crow['id']." selected> ($vendorcode[Vendor_Code])  $Crow[product] - $hsncode[hsncode]</option>";
  } else {
  $html .= "<option value=".$Crow['id']."> ($vendorcode[Vendor_Code])  $Crow[product] - $hsncode[hsncode]</option>";  
  }
  } 
 
  echo $msss."|".$html."|".$Lid."|".$rowid."|".$Check['countss'];
  
}

if ($_REQUEST['part'] == 'All_Bill_Data_Part'){
      $requestData = $_REQUEST;
      if ($_REQUEST['from'] != '' && $_REQUEST['to'] != '')
      {
          $ff = explode('/', $_REQUEST['from']);
          $from = $ff[2] . '-' . $ff[1] . '-' . $ff[0];
          $tt = explode('/', $_REQUEST['to']);
          $to = $tt[2] . '-' . $tt[1] . '-' . $tt[0];
          $where .= " and STR_TO_DATE(`invoice_date`, '%d/%m/%Y') between '" . $from . "' and '" . $to . "'";
      }
      if ($_REQUEST['company'] != '')
      {
          $where .= " and uid='" . $_REQUEST['company'] . "'";
      }
      $sqls = "SELECT * FROM bill_details where id!='' $where";
      $sql = "SELECT * FROM bill_details where id!='' $where";
      $querys = mysqli_query($con,$sqls);

      $totalData = mysqli_num_rows($querys);

      $totalFiltered = $totalData;

      if (!empty($requestData['search']['value']))

      { // if there is a search parameter, $requestData['search']['value'] contains search parameter

          $sql .= " AND ( bill_no LIKE '%" . $requestData['search']['value'] . "%' ";

          $sql .= " OR invoice_no LIKE '%" . $requestData['search']['value'] . "%'";
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

          $action = "<input type='hidden' class='id' value=" . $row['id'] . ">
  <span style='white-space:nowrap;'>
  <a class='btn btn-sm bg-success-light' href='UpdateBill.php?id=$row[id]'><i class='fe fe-edit'></i></a>&nbsp;
  <a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></i></a></span>";
          $Orders = Get_Bill_Amounts($con,$row['id']);
		  $Get_Return_Bill_Qty=Get_Return_Bill_Qty($con,$row['id']);
          $User = Get_Fetch_Data($con,$row['uid'], 'id,FName,Cname', 'vendor_details');
		  if($row['bill_from']=='Challan'){
		  $Challan = Get_Fetch_Data($con,$row['challan_id'], 'id,challanno', 'challan_details');
		  } if($row['bill_from']=='Voucher'){
		  $Challan = Get_Fetch_Data($con,$row['challan_id'], 'id,challanno', 'voucher_details');
		  }
              $Company = "<span style=''>" . strtoupper($User[Cname]) . "</span>";
          if($Get_Return_Bill_Qty[quantity]>0){ 
		  $ReturnQty="/ <a href='returnpurchase.php?company=$row[uid]&bill_no=$row[id]' class='text-danger'>$Get_Return_Bill_Qty[quantity]</a>"; 
		  $ReturnAmount="/ <span class='text-danger'>$Get_Return_Bill_Qty[amounts]</span>"; 
		  } else { $ReturnQty=""; $ReturnAmount=""; }
          $PrintInvoice = "<br><a class='badge badge-pill bg-success inv-badge' href='javascript:void'>Print</a>";
          $nestedData = array();
          $nestedData[] = "<div class='first'><input type='checkbox' name='print[]' value='$row[id]'></div>";
		  $nestedData[] = "<div class='first'>$row[invoice_date]</div>";
		  
		  $nestedData[] = "<div class='first'><a href='javascript:void' class='viewLinks'>$row[invoice_no]</a></div>";
		  $nestedData[] = "<div class='first'>$row[bill_from]</div>";
		  $nestedData[] = "<div class='first'>$Challan[challanno]</div>";
          $nestedData[] = "<div class='first'>$Company<br>$row[name]</div>";
		  $nestedData[] = "<div class='first'>$Orders[items]</div>";
          $nestedData[] = "<div class='first'>$Orders[quantity] $ReturnQty</div>";
          $nestedData[] = "<div class='first' >" . number_format((float)$row['final_amount'], 2, '.', '') . "</div>";
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
if($_REQUEST['part']=='Remove_Challan_Item'){
mysqli_query($con,"delete from challan_items where id='".$_POST['id']."'");	
}
if($_REQUEST['part']=='Remove_Invoice_Item'){
mysqli_query($con,"delete from invoice_item_list where id='".$_POST['id']."'");	
}
if($_REQUEST['part']=='Remove_Invoice_Other_Charges'){
mysqli_query($con,"delete from invoice_other_charges where id='".$_POST['id']."'");	
}
if($_REQUEST['part']=='Remove_Challan_Other_Charges'){
mysqli_query($con,"delete from challan_other_charges where id='".$_POST['id']."'");	
}
if($_REQUEST['part']=='Remove_Bill_Item'){
mysqli_query($con,"delete from bill_items where id='".$_POST['id']."'");	
}

if($_REQUEST['part']=='Remove_Bill_Other_Charges'){
mysqli_query($con,"delete from bill_other_charges where id='".$_POST['id']."'");	
}
if ($_REQUEST['part'] == 'All_Return_Data_Part'){
      $requestData = $_REQUEST;
      if ($_REQUEST['return_time'] != '')
      {
          $ff = explode('/', $_REQUEST['return_time']);
          $return_time = $ff[2] . '-' . $ff[1] . '-' . $ff[0];
          $where .= " and STR_TO_DATE(`return_date`, '%d/%m/%Y')='" . $from . "'";
      }
      if ($_REQUEST['company'] != '')
      {
          $where .= " and supplier='" . $_REQUEST['company'] . "'";
      }
	  if ($_REQUEST['bill_no'] != '')
      {
          $where .= " and bill_no='" . $_REQUEST['bill_no'] . "'";
      }
      $sqls = "SELECT * FROM `return_purchase_details`  where id!='' $where";
      $sql = "SELECT * FROM `return_purchase_details` where id!='' $where";
      $querys = mysqli_query($con,$sqls);

      $totalData = mysqli_num_rows($querys);

      $totalFiltered = $totalData;

      if (!empty($requestData['search']['value']))

      { // if there is a search parameter, $requestData['search']['value'] contains search parameter

          $sql .= " AND ( challan_no LIKE '%" . $requestData['search']['value'] . "%' ";

          $sql .= " OR return_date LIKE '%" . $requestData['search']['value'] . "%'";
          $sql .= " OR add_time LIKE '%" . $requestData['search']['value'] . "%' )";

      }

      $sql .= "  ORDER BY id desc  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";

      //echo $sqls;

      $query = mysqli_query($con,$sql);

      //$totalFiltered = mysql_num_rows($query);

      $data = array();

      $i = 1;

      while ($row = mysqli_fetch_array($query))

      { // preparing an array
	  $action = "<input type='hidden' class='id' value=" . $row['id'] . "><span style='white-space:nowrap;float: right;'> 
	  <a href='javascript:void' class='btn btn-sm bg-success-light viewLinks'><i class='fe fe-search'></i></a>&nbsp;<a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></a></span>";

        $Bill = Get_Fetch_Data($con,$row['bill_no'], 'All', 'bill_details');
          $User = Get_Fetch_Data($con,$row['supplier'], 'id,FName,Cname', 'vendor_details');
		  
         $Company = "<span style=''>" . strtoupper($User[Cname]) . "</span>";
		 $Quantity=Return_Purchase_Qty($con,$row['id']);
		
          $nestedData = array();
		  $nestedData[] = "<div class='first'>$row[challan_no]</div>";
		  $nestedData[] = "<div class='first'>$row[return_date]</div>";
          $nestedData[] = "<div class='first'>$Bill[invoice_date]</div>";
          $nestedData[] = "<div class='first'>$Bill[invoice_no]</div>";
          $nestedData[] = "<div class='first'>$Company</div>";
		  $nestedData[] = "<div class='first'>$Quantity</div>";
		  $nestedData[] = "<div class='first'>$row[TotalAmount]</div>";
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


  if ($_REQUEST['part'] == 'All_ReturnSale_Data_Part'){
      $requestData = $_REQUEST;
      if ($_REQUEST['return_time'] != '')
      {
          $ff = explode('/', $_REQUEST['return_time']);
          $return_time = $ff[2] . '-' . $ff[1] . '-' . $ff[0];
          $where .= " and STR_TO_DATE(`return_time`, '%d/%m/%Y')='" . $from . "'";
      }
      if ($_REQUEST['company'] != '')
      {
          $where .= " and uid='" . $_REQUEST['company'] . "'";
      }
      $sqls = "SELECT * from return_invoice_details where id!='' $where";
      $sql = "SELECT * from return_invoice_details where id!='' $where";
      $querys = mysqli_query($con,$sqls);

      $totalData = mysqli_num_rows($querys);

      $totalFiltered = $totalData;

      if (!empty($requestData['search']['value']))

      { // if there is a search parameter, $requestData['search']['value'] contains search parameter

          $sql .= " AND ( orderid LIKE '%" . $requestData['search']['value'] . "%' ";
          $sql .= " OR order_date LIKE '%" . $requestData['search']['value'] . "%' )";

      }

      $sql .= "  ORDER BY id desc  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";

      //echo $sqls;

      $query = mysqli_query($con,$sql);

      //$totalFiltered = mysql_num_rows($query);

      $data = array();

      $i = 1;

      while ($row = mysqli_fetch_array($query))

      { // preparing an array

        //$Bill = Get_Fetch_Data($con,$row['oid'], 'All', 'bill_details');
		$action = "<input type='hidden' class='id' value=" . $row['id'] . "><span style='white-space:nowrap;float: right;'> 
	  <a href='javascript:void' class='btn btn-sm bg-success-light viewLinks'><i class='fe fe-search'></i></a>&nbsp;<a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></a></span>";
          $User = Get_Fetch_Data($con,$row['uid'], 'id,Cname,FName,LName,Vendor_Code', 'customer_details');
		  $invoiceno = Get_Fetch_Data($con,$row['invoiceno'], 'id,invoiceno', 'invoice_details');
         $retItem=Get_Return_Invoice_Data_Quantity($con,$row['id']);
              $Company = "<span style=''>" . strtoupper($User[Cname]) . "</span>";
          $nestedData = array();
          
          $nestedData[] = "<div class='first'>$row[order_date]</div>";
		  $nestedData[] = "<div class='first'>$row[orderid]</div>";
		  $nestedData[] = "<div class='first'>$invoiceno[invoiceno]</div>";
          $nestedData[] = "<div class='first'><u>$User[Cname]</u><br>$User[FName] $User[LName]</div>";
      $nestedData[] = "<div class='first'>$retItem[items]</div>";
          $nestedData[] = "<div class='first'>$retItem[Quantity]</div>";
      $nestedData[] = "<div class='first'>" . number_format((float)$row['final_amount'], 2, '.', '') . "</div>";
	  $nestedData[] =$action;
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

if ($_POST['part'] == 'Return_Purchase_data_View'){
$row = Get_Fetch_Data($con,$_POST['id'], 'All', 'return_purchase_details');
$bill = Get_Fetch_Data($con,$row['bill_no'], 'All', 'bill_details');
$user = Get_Fetch_Data($con,$row['supplier'], 'All', 'vendor_details');
?>
<div class="modal-header ">
  <h5 class="modal-title">Return Purchase Details</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
</div>
<div class="modal-body">
  <form method="post" action="" class="table-responsive">
    <h5 style="color:#000000"><i class="fa fa-file-text" aria-hidden="true"></i> Billing Details</h5>
    <div class="row form-row step_1">
      <div class="col-4">
        <div class="form-group">
          <label class="text-dark"><th>Challan No</th></label>
          <p class="c-detail">
            <?php echo $row['challan_no']; ?>
          </p>
        </div>
      </div>
      <div class="col-4">
        <div class="form-group">
          <label class="text-dark">Return Date</label>
          <p class="c-detail">
            <?php echo $row['return_date']; ?>
          </p>
        </div>
      </div>
       <div class="col-4">
        <div class="form-group">
          <label class="text-dark">Bill No</label>
          <p class="c-detail">
            <?php echo $bill['bill_no']; ?>
          </p>
        </div>
      </div>
      <div class="col-4">
        <div class="form-group">
          <label class="text-dark">Invoice No </label>
          <p class="c-detail">
            <?php echo $bill['invoice_no']; ?>
          </p>
        </div>
      </div>
      <div class="col-4">
        <div class="form-group">
          <label class="text-dark">Invoice Date</label>
          <p class="c-detail">
            <?php echo $bill['invoice_date']; ?>
          </p>
        </div>
      </div>
     
       <div class="col-4">
        <div class="form-group">
          <label class="text-dark">Note </label>
          <p class="c-detail">
            <?php echo $bill['bill_note']; ?>
          </p>
        </div>
      </div>
      <div class="col-4">
        <div class="form-group">
          <?php if($bill['attachmet']!=''){ ?>
          <a href="OAttachment/<?=$bill['attachmet'];?>" download class="btn btn-sm bg-success mr-2 float-right text-white font-weight-bold">Download Attachment</a>
          <?php } ?>
        </div>
      </div>
    </div>
    <h5 style="color:#000000"><i class="fa fa-file-text" aria-hidden="true"></i> Supplier Details</h5>
    <div class="row form-row step_1" style="background: #f3f1f1;">
      <div class="col-4">
        <div class="form-group">
          <label class="text-dark">Name</label>
          <p class="c-detail">
            <?php echo $user['FName']. $user['LName']; ?>
          </p>
        </div>
      </div>
       <div class="col-4">
        <div class="form-group">
          <label class="text-dark">Company Name</label>
          <p class="c-detail">
            <?php echo $user['Cname']; ?>
          </p>
        </div>
      </div>
      <div class="col-4">
        <div class="form-group">
          <label class="text-dark">Supplier Code</label>
          <p class="c-detail">
            <?php echo $user['Vendor_Code']; ?>
          </p>
        </div>
      </div>
      <div class="col-4">
        <div class="form-group">
          <label class="text-dark">Mobile</label>
          <p class="c-detail">
            <?php echo $user['scn']; ?>
          </p>
        </div>
      </div>
      <div class="col-4">
        <div class="form-group">
          <label class="text-dark">Address </label>
          <p class="c-detail">
              <?php 
              $state = Get_Fetch_Data($con,$user['State'], 'All', 'state_details');
		      $city = Get_Fetch_Data($con,$user['City'], 'All', 'city_details');
              ?>
            <?php echo $user['Address'] . " $city[city_name] $state[state_name] - $user[Pincode]"; ?>
          </p>
        </div>
      </div>
    </div>
    <h5 style="color:#000000"><i class="fa fa-file-text" aria-hidden="true"></i> Item Details</h5>
    <div class="row form-row step_1" style="    background: #ffffd0;">
      <div class="col-12">

        <table class="table table-bordered">

          <tr>

            <th>Item</th>

            <th>HSN Code</th>

            <th>Rate</th>

            <th>Qty</th>

            <th>Amount</th>

          </tr>

          <?php

            $Prdsql = mysqli_query($con,"select * from return_purchase_item where ret_pur_id='" . $row['id'] . "' order by id");

            while ($Prrow = mysqli_fetch_array($Prdsql))

            {

              
                $cProw = Get_Fetch_Data($con,$Prrow['catalogue'], 'All', 'product_details');
                $hsncode=Get_Fetch_Data($con,$cProw[hsn_code],"hsncode","HsnList");
                $vendorcode=Get_Fetch_Data($con,$cProw["supplier"],"id,Vendor_Code","vendor_details");

                echo "<tr><td>$cProw[product] - $vendorcode[Vendor_Code]<br><span style='font-size:12px;'>$cProw[description]</span></td><td>$hsncode[hsncode]</td><td>$Prrow[rate]</br></td><td>$Prrow[qty]</div></td><td>$Prrow[amount]</td></tr>";

            }

            ?>

          <tr>

            <td colspan="4">Subtotal</td>

            <td>

              <?php echo number_format((float)$row['Subtotal'], 2, '.', ''); ?>

            </td>

          </tr>

          <?php 
      if($row['DiscountType']=='Percent'){ $DisVal="$row[DiscountVal]%"; } else { $DisVal="Rs. $row[DiscountVal]"; }
      if ($row['discountamt'] > 0) {  ?>

          <tr>

            <td colspan="4" style="color:#0C3;">Discount [<?= $DisVal;?>] (-)</td>

            <td style="color:#0C3;">

              <?php echo number_format((float)$row['discountamt'], 2, '.', ''); ?>

            </td>

          </tr>

          <?php

            }
             if ($row['cgstamount'] > 0)

            { ?>

          <tr>

            <td colspan="4" style="color:#dc3545;">CGST[<?=$row['cgstcharge']."%";?>] (+)</td>

            <td style="color:#dc3545;">

              <?php echo number_format((float)intval($row['cgstamount']), 2, '.', ''); ?></td>

          </tr>

          <?php

            }
            if ($row['sgstcharge'] > 0)

            { ?>

          <tr>

            <td colspan="4" style="color:#dc3545;">SGST[<?=$row['sgstcharge']."%";?>] (+)</td>

            <td style="color:#dc3545;">

              <?php echo number_format((float)intval($row['sgstamount']), 2, '.', ''); ?>

            </td>

          </tr>

          <?php

            }
            if ($row['igstcharge'] > 0)

            { ?>

          <tr>

            <td colspan="4" style="color:#dc3545;">IGST[<?=$row['igstcharge']."%";?>] (+)</td>

            <td style="color:#dc3545;">

              <?php echo number_format((float)intval($row['igstamount']), 2, '.', ''); ?>

            </td>

          </tr>

          <?php

            }

            if ($row['Othercharge'] > 0)

            { ?>

          <tr>

            <td colspan="4" style="color:#dc3545;">Other Charge (+)</td>

            <td style="color:#dc3545;">

              <?php echo number_format((float)$row['Othercharge'], 2, '.', ''); ?>

            </td>

          </tr>

          <?php

            } ?>

          <tr>

            <td colspan="4"><strong>Final Amount</strong></td>

            <td><strong><?php echo $row['TotalAmount']; ?></strong></td>

          </tr>

        </table>

      </div>

    </div>
  </form>
</div>
<?php } 
if ($_POST['part'] == 'Challan_Item_Print_View'){
$row = Get_Fetch_Data($con,$_POST['id'], 'All', 'challan_details');
$user = Get_Fetch_Data($con,$row['uid'], 'All', 'vendor_details');
?>
<div class="modal-header ">
  <h5 class="modal-title">Challan Details</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
</div>
<div class="modal-body">
  <form method="post" action="" class="table-responsive">
    <h5 style="color:#000000"><i class="fa fa-file-text" aria-hidden="true"></i> Item Details 
    <a href="javascript:void" class="btn btn-sm bg-success mr-2 float-right text-white font-weight-bold " id="PrintItems">Print</a>
    </h5>

    <div class="row form-row step_1"  >
      <div class="col-12">

        <table class="table table-bordered">

          <tr>
			<th><input type="checkbox" id="ckbCheckAll">&nbsp;All</th>
            <th>Item</th>
            <th>HSN Code</th>
            <th>Qty</th>
            <th>Rate</th>
            <th>MRP</th>
            <th>WS</th>
			<th>Discount</th>
            <th>Tax</th>
            <th>Amount</th>

          </tr>

          <?php

            $Prdsql = mysqli_query($con,"select * from challan_items where oid='" . $row['id'] . "' order by id");

            while ($Prrow = mysqli_fetch_array($Prdsql))

            {

              $vendorcode=Get_Fetch_Data($con,$Prrow["sid"],"id,Vendor_Code","vendor_details");
                $cProw = Get_Fetch_Data($con,$Prrow['pid'], 'All', 'product_details');
                $hsncode=Get_Fetch_Data($con,$cProw[hsn_code],"hsncode","HsnList");
                $Item = Get_Fetch_Data($con,$Prrow['item'], 'id,cat_code', 'product_catalogue');
if($Prrow["cgst_amt"]>0){
$Tax="<div style='font-size:12px;color:green;'>CGST: $Prrow[cgst_amt] @$Prrow[cgst]%</div><div style='font-size:12px;color:green;'>SGST: $Prrow[sgst_amt] @$Prrow[sgst]%</div>";
} else {
$Tax="<span style='font-size:12px;color:green;'>IGST: $Prrow[igst_amt] @$Prrow[igst]%</span>"; 
}
if($Prrow['DiscountType']=='Percent'){
$DiscountType="$Prrow[DiscountVal]%";	
} else {
$DiscountType="₹ $Prrow[DiscountVal]";	
}
if($Prrow['Discountamt']>0){
$Discountamt="<div style='font-size:11px;color:red;white-space: nowrap;'>$Prrow[Discountamt] @$DiscountType</div>";	
} else {
$Discountamt="";	
}
echo "<tr><td><input type='checkbox' class='checkBoxClass' name='ChalItemId[]' value=".$Prrow['id']." ></td><td>$cProw[product]</td><td>$hsncode[hsncode]</td><td>$Prrow[qty]</td><td>$Prrow[price]</td><td>$Prrow[mrp] </td><td>$Prrow[ws]</td><td>$Discountamt</td><td>$Tax</td><td>$Prrow[amount]</td></tr>";

            }

            ?>

          <tr>

            <td colspan="9">Subtotal</td>

            <td>

              <?php echo number_format((float)$row['subtotal'], 2, '.', ''); ?>

            </td>

          </tr>

          <?php 
		  if($row['discount_tpe']=='Percent'){ $DisVal="$row[DiscountVal]%"; } else { $DisVal="Rs. $row[DiscountVal]"; }
		  if ($row['discount'] > 0) {  ?>

          <tr>

            <td colspan="9" style="color:#0C3;">Discount (-)</td>

            <td style="color:#0C3;">

              <?php echo number_format((float)$row['discount'], 2, '.', ''); ?>

            </td>

          </tr>

          <?php } if ($row['cgstamount'] > 0){ ?>
          <tr>

            <td colspan="9" style="color:#dc3545;">CGST (+)</td>

            <td style="color:#dc3545;">

              <?php echo number_format((float)intval($row['cgstamount']), 2, '.', ''); ?></td>

          </tr>

          <?php } if ($row['sgstamount'] > 0) { ?>

          <tr>

            <td colspan="9" style="color:#dc3545;">SGST (+)</td>

            <td style="color:#dc3545;">

              <?php echo number_format((float)intval($row['sgstamount']), 2, '.', ''); ?>

            </td>

          </tr>

          <?php } if ($row['igstamount'] > 0)  { ?>
          <tr>
            <td colspan="9" style="color:#dc3545;">IGST (+)</td>
            <td style="color:#dc3545;">
              <?php echo number_format((float)intval($row['igstamount']), 2, '.', ''); ?>
            </td>
          </tr>
          <?php } 
$OTsql=mysqli_query($con,"select * from challan_other_charges where oid='".$row["id"]."'");
$Otnums=mysqli_num_rows($OTsql);
		  if($Otnums>0) { ?>
          
          <tr><td colspan="5">Other Charges</td><td colspan="5">
          <table class="table table-bordered">
<?php
while($OTrow=mysqli_fetch_array($OTsql)){
$Ochrow = Get_Fetch_Data($con,$OTrow['Ocharge'], 'All', 'charges_details');
if($Ochrow['charge_type']=='Plus'){ $Otherchargeval=" (+)"; } else { $Otherchargeval=" (-)"; }
?>
<tr>
<td style="color:#dc3545;"><?=$Ochrow[charge_name];?></td>
<td class="text-right pr-3" style="color:#dc3545;"><?=$OTrow[Otherchargeval];?></td>
</tr>
<?php
}
?>
          </table>
          </td></tr>
          <?php } if ($row['roundoff']!='')  { ?>
          <tr>
            <td colspan="9" style="color:#dc3545;">Round off (+/-)</td>
            <td style="color:#dc3545;">
              <?php echo number_format((float)$row['roundoff'], 2, '.', ''); ?>
            </td>
          </tr>
          <?php }  ?>
          <tr>
            <td colspan="9"><strong>Final Amount</strong></td>
            <td><strong><?php echo $row['final_amount']; ?></strong></td>
          </tr>
        </table>

      </div>

    </div>

    
  </form>
</div>
<?php
}
if ($_POST['part'] == 'Invoice_Return_data_View'){


      $row = Get_Fetch_Data($con,$_POST['id'], 'All', 'return_invoice_details');
     $invoiceno = Get_Fetch_Data($con,$row['invoiceno'], 'invoiceno', 'invoice_details');
      $user = Get_Fetch_Data($con,$row['uid'], 'All', 'customer_details');

  ?>

<div class="modal-header ">

  <h5 class="modal-title">Invoice Details</h5>

  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>

</div>

<div class="modal-body">

  <form method="post" action="" class="table-responsive">

    <h5 style="color:#000000"><i class="fa fa-file-text" aria-hidden="true"></i> Invoice Details</h5>

    <div class="row form-row step_1">

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark"><th>Return Invoice No</th></label>

          <p class="c-detail">

            <?php echo $row['orderid']; ?>

          </p>

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Return Date</label>

          <p class="c-detail">

            <?php echo $row['order_date']; ?>

          </p>

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Invoice No </label>

          <p class="c-detail">

            <?php echo $invoiceno['invoiceno']; ?>

          </p>

        </div>

      </div>
    </div>

    <h5 style="color:#000000"><i class="fa fa-file-text" aria-hidden="true"></i> Billing Address</h5>

    <div class="row form-row step_1" style="background: #f3f1f1;">

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Name</label>

          <p class="c-detail">

            <?php echo $user['FName']. $user['LName']; ?>

          </p>

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Mobile</label>

          <p class="c-detail">

            <?php echo $user['ccn']; ?>

          </p>

        </div>

      </div>

      <div class="col-4">

        <div class="form-group">

          <label class="text-dark">Address </label>

          <p class="c-detail">

              <?php 

              

              $state = Get_Fetch_Data($con,$user['State'], 'All', 'state_details');

      $city = Get_Fetch_Data($con,$user['City'], 'All', 'city_details');

              ?>

            <?php echo $user['Address'] . " $city[city_name] $state[state_name] - $user[Pincode]"; ?>

          </p>

        </div>

      </div>

    </div>

    

    <h5 style="color:#000000"><i class="fa fa-file-text" aria-hidden="true"></i> Bill Details</h5>

    <div class="row form-row step_1" style="    background: #ffffd0;">

      <div class="col-12">

        <table class="table table-bordered">

          <tr>

            <th>Item</th>

            <th>HSN Code</th>

            <th>Rate</th>

            <th>Qty</th>

            <th>Amount</th>

          </tr>

          <?php

            $Prdsql = mysqli_query($con,"select * from return_invoice_item where oid='" . $row['id'] . "' order by id");

            while ($Prrow = mysqli_fetch_array($Prdsql))

            {
              $challnitem = Get_Fetch_Data($con,$Prrow['pid'], 'pid', 'challan_items');

                $cProw = Get_Fetch_Data($con,$challnitem['pid'], 'All', 'product_details');

                $Item = Get_Fetch_Data($con,$Prrow['item'], 'id,cat_code', 'product_catalogue');
                $hsncode=Get_Fetch_Data($con,$cProw[hsn_code],"hsncode","HsnList");

                echo "<tr><td>$cProw[product]</td><td>$hsncode[hsncode]</td><td>$Prrow[price]</td><td>

            $Prrow[qty]</div></td><td>$Prrow[amount]</td></tr>";

            }

            ?>

          <tr>

            <td colspan="4">Subtotal</td>

            <td>

              <?php echo number_format((float)$row['subtotal'], 2, '.', ''); ?>

            </td>

          </tr>

          <?php 
          if ($row['discount'] > 0)

            { ?>

          <tr>

            <td colspan="4" style="color:#0C3;">Discount (-)</td>

            <td>

              <?php echo number_format((float)$row['discount'], 2, '.', ''); ?>

            </td>

          </tr>

          <?php

            }

          if ($row['cgstamount'] > 0)

            { ?>

          <tr>

            <td colspan="4" style="color:#dc3545;">CGST Charge(+)</td>

            <td>

              
              <?php echo number_format((float)intval($row['cgstamount']), 2, '.', ''); ?>&nbsp;
              &nbsp;<?php echo "(".$row['cgstax']."%".")"; ?>

            </td>

          </tr>

          <?php

            }


if ($row['sgstamount'] > 0)

            { ?>

          <tr>

            <td colspan="4" style="color:#dc3545;">SGST Charge (+)</td>

            <td>

              <?php echo number_format((float)intval($row['sgstamount']), 2, '.', ''); ?>&nbsp;
              &nbsp;<?php echo "(".$row['sgstax']."%".")"; ?>

            </td>

          </tr>

          <?php

            }
            if ($row['igstamount'] > 0)

            { ?>

          <tr>

            <td colspan="4" style="color:#dc3545;">IGST Charge (+)</td>

            <td>

              <?php echo number_format((float)intval($row['igstamount']), 2, '.', ''); ?>&nbsp;
              &nbsp;<?php echo "(".$row['igstax']."%".")"; ?>

            </td>

          </tr>

          <?php

            } 

            if ($row['othercharge'] > 0)

            { ?>

          <tr>

            <td colspan="4" style="color:#dc3545;">Other Charge (+)</td>

            <td>

              <?php echo number_format((float)$row['othercharge'], 2, '.', ''); ?>

            </td>

          </tr>

          <?php

            } ?>

          <tr>

            <td colspan="4"><strong>Final Amount</strong></td>

            <td><strong><?php echo number_format((float)$row['final_amount'], 2, '.', '') ?></strong></td>

          </tr>
          <?php 
          if($row['vnote']!=''){
          ?>
           <tr>

            <td colspan="5"><strong>Order Note</strong></td>

            <td><strong><?php echo $row['vnote']; ?></strong></td>

          </tr>
<?php } ?>
        </table>

      </div>

    </div>

    

  </form>

</div>

<?php
} if($_POST['part'] == 'Add_HSN_Code_Table_Part'){
?>
<tr>
<td><input type="number" class="form-control range_from" name="range_from[]"  placeholder="Range From"></td>
<td><input type="number" class="form-control range_to" name="range_to[]"  placeholder="Range To"></td>
<td>
<div class="d-flex justify-content-end">
<select   class="form-control select3 tax" name="tax[]">
<option value="">Tax</option>
<?php
$Gsql=mysqli_query($con,"select * from GstTax order by cast(Pigst as SIGNED) asc");
while($Grows=mysqli_fetch_array($Gsql)){
echo "<option value=".$Grows['id'].">$Grows[Pigst]%</option>";	
}
?>
</select>
<span class="float-right ml-2">
<a href="javascript:void" class="RemoveR"><i class="fe fe-trash text-danger" aria-hidden="true"></i></a>  
</span>
</div>
</td>
</tr>
<?php } 
if($_POST['part'] == 'Get_catalogue_Tax'){
if($_POST['qty']>0){ $qty=$_POST['qty']; } else { $qty=1; }
//$product = Get_Fetch_Data($con,$_POST['catalogue'], 'hsn_code', 'product_details');
$tax=Get_Hsn_range_tax($con,$_POST['ratee'],$_POST['hsn_code']);
$GstTax = Get_Fetch_Data($con,$tax['tax'], 'All', 'GstTax');
$vendor = Get_Fetch_Data($con,$_POST['customer'], 'State', 'vendor_details');
if($vendor['State']==7){
$CGST=$_POST['Amounts']*$GstTax['Pcgst']/100;	 $SGST=$_POST['Amounts']*$GstTax['Psgst']/100; $IGST=0;
$CGSTPer=$GstTax['Pcgst']; $SGSTPer=$GstTax['Psgst']; $IGSTPer=0; $totalTax=$CGST+$SGST;
$Taxable="<div style='font-size:11px;color:red;white-space: nowrap;'>CGST: $CGST @$GstTax[Pcgst]%</div><div style='font-size:11px;color:red;white-space: nowrap;'>SGST: $SGST @$GstTax[Psgst]%</div>";	
} else {
$IGST=$_POST['Amounts']*$GstTax['Pigst']/100; $CGST=0; $SGST=0; $totalTax=$IGST;	
$Taxable="<span style='font-size:11px;color:red;white-space: nowrap;'>IGST: $IGST @$GstTax[Pigst]%</span>";
$CGSTPer=0; $SGSTPer=0; $IGSTPer=$GstTax['Pigst'];
}

$totalamt=$_POST['Amounts']+$totalTax;
echo "$Taxable|$totalamt|$CGSTPer|$CGST|$SGSTPer|$SGST|$IGSTPer|$IGST";
}
if ($_REQUEST['part'] == 'All_Other_Charges_Data'){
$requestData = $_REQUEST;
$sqls = "SELECT * FROM charges_details where id!='' $where";
$sql = "SELECT * FROM charges_details where id!='' $where";
$querys = mysqli_query($con,$sqls);
$totalData = mysqli_num_rows($querys);
$totalFiltered = $totalData;
if (!empty($requestData['search']['value']))
{ // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql .= " AND ( charge_name LIKE '%" . $requestData['search']['value'] . "%' ";
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
$category = Get_Fetch_Data($con,$row['category'], 'All', 'category_details');
$action = "<input type='hidden' class='id' value=" . $row['id'] . "> <span style='white-space:nowrap;float: right;'> <a class='btn btn-sm bg-success-light mr-2 updateLinks' href='javascript:void'><i class='fe fe-pencil'></i></a>&nbsp; <a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></a></span>";
if ($row[status] == 'Active')
{
$class = 'bg-success';
} else {
$class = 'bg-danger';
}
$nestedData = array();
$nestedData[] = "<div class='first'>$row[charge_name]</div>";
$nestedData[] = "<div class='first'>$row[charge_type]</div>";
$nestedData[] = "<div class='first'>$row[tax]</div>";
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
if ($_POST['part'] == 'Other_Charges_data_Update') {
$row = Get_Fetch_Data($con,$_POST['id'], 'All', 'charges_details'); 
?>
<div class="modal-header ">
  <h5 class="modal-title">Update Charges Detail</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
</div>
<div class="modal-body">
  <form action="" method="post" enctype="multipart/form-data">
    <div class="row form-row">
      <div class="col-6">
        <div class="form-group">
          <label> Charges Name<span class="text-danger">*</span></label>
          <input type="text" class="form-control" value="<?php echo $row['charge_name']; ?>" name="charge_name" required>
        </div>
      </div>
      <div class="col-6">
        <div class="form-group">
          <label>Charges Type<span class="text-danger">*</span></label>
          <select class="form-control" name="charge_type">
            <?php $arr = array('Plus','Minus');
            foreach ($arr as $charge_type){
                if ($charge_type == $row['charge_type']){
                    echo "<option value=".$charge_type." selected>$charge_type</option>";
                } else {
                    echo "<option value=".$charge_type.">$charge_type</option>";
                }
            }
            ?>
          </select>
        </div>
      </div>
       <div class="col-6">
        <div class="form-group">
          <label> Tax (%)<span class="text-danger">*</span></label>
          <input type="number" class="form-control" value="<?php echo $row['tax']; ?>" name="tax" required>
        </div>
      </div>
      <div class="col-6">
        <div class="form-group">
          <label>Status<span class="text-danger">*</span></label>
          <select class="form-control" name="status">
            <?php $arr = array('Active', 'Inactive');
            foreach ($arr as $status){
                if ($status == $row['status']){
                    echo "<option value=" . $status . " selected>$status</option>";
                } else {
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
    <button class="btn btn-success" name="UpdateCharges">Update</button>
  </form>
</div>
<?php } if($_POST['part']=='Add_Other_Charges_Table_Part') { ?>
<tr>
<td colspan="4"><div class="d-flex w-100 ">
<select class="form-control p-2 h-40 Ocharge" name="Ocharge[]">
<option value="">Select</option>
<?php
$Ochsql=mysqli_query($con,"select id,charge_name from charges_details where status='Active'");
while($Ochrow=mysqli_fetch_array($Ochsql)){
echo "<option value=".$Ochrow['id'].">$Ochrow[charge_name]</option>";
}
?>
</select>
</div></td>
<td class="text-right pr-3">
<input type="text" class="form-control p-2 h-30 Othercharge" name="Othercharge[]">
</td>
<td class="text-right pr-3">
<div class="d-flex w-60 ">
<input type="text" class="form-control p-2 h-30 Otherchargeval" name="Otherchargeval[]" readonly>
<span class="float-right ml-3"> <a href="javascript:void" class="RemoveOT"><i class="fe fe-trash text-danger" aria-hidden="true"></i></a> </span>
</div>
</td>
</tr>
<?php } 
if($_POST['part']=='Set_Other_Charges') {
$row = Get_Fetch_Data($con,$_POST['Ocharge'], 'All', 'charges_details');
if($row['tax']>0){
$Taxs=$_POST[Othercharge]*$row[tax]/100;	
} else {
$Taxs=0;	
}
$Othercharges=$_POST[Othercharge]+$Taxs;
if($row['charge_type']=='Minus'){
$vals="-$Othercharges";	
} else {
$vals="$Othercharges";	
}
echo $vals;
}
if($_REQUEST['part']=='Search_HSN') {
$skillData = array(); 
$Itmsqls=mysqli_query($con,"select id,hsncode,hsn_codes,description from HsnList where status='Active' and (hsncode like '%".$_REQUEST['term']."%' or hsn_codes like '%".$_REQUEST['term']."%') order by id desc");
while($Itmrows=mysqli_fetch_array($Itmsqls)){
$data['id'] = $Itmrows['id']; 
$data['value'] = $Itmrows['hsncode'];
array_push($skillData, $data);  
}
echo json_encode($skillData); 
}

if($_REQUEST['part']=='Search_Catalogue') {
$skillData = array(); 
if($_REQUEST['term']!=''){
$where="and (product like '%".$_REQUEST['term']."%' or barcode like '%".$_REQUEST['term']."%')";	
}
$vendorcode=Get_Fetch_Data($con,$_REQUEST['customer'],"id,Vendor_Code,department","vendor_details");
$Itmsqls=mysqli_query($con,"select id,product,barcode,description from product_details where supplier='".$_REQUEST['customer']."' and hsn_code='".$_REQUEST['hsn_code']."' $where order by id desc");
while($Itmrows=mysqli_fetch_array($Itmsqls)){
$data['id'] = $Itmrows['id']; 
$data['value'] = "$Itmrows[product]";
array_push($skillData, $data);
}
echo json_encode($skillData);
}
if($_POST['part']=='Get_HSN_Details_Data') {
$Itmsqls=mysqli_query($con,"select id,hsncode from HsnList where status='Active' and (hsncode like '%".$_POST['keyword']."%' or hsn_codes like '%".$_POST['keyword']."%') order by id desc");
$Itmrows=mysqli_fetch_array($Itmsqls);
echo "$Itmrows[id]|$Itmrows[hsncode]";	
}

if($_POST['part']=='Get_Product_Details_Data') {
$vendorcode=Get_Fetch_Data($con,$_POST['customer'],"id,Vendor_Code,department","vendor_details");
$Itmsqls=mysqli_query($con,"select id,product,barcode,description from product_details where supplier='".$_POST['customer']."' and hsn_code='".$_POST['hsn_code']."' and (product='".$_POST['keyword']."' or barcode='".$_POST['keyword']."') order by id desc");
$ItemsNums=mysqli_num_rows($Itmsqls);
if($ItemsNums>0){
$Itmrows=mysqli_fetch_array($Itmsqls);
//$item_Rate=Get_Last_Challan_Rate($con,$Itmrows[id]);
$productamount=Get_Challan_Voucher_Rate($con,$Itmrows["id"]);
 $totalstock=product_stock($con,$Itmrows["id"]);
echo "$Itmrows[id]|$Itmrows[product]|$productamount[price]|$totalstock";
} else {
echo "0|$_POST[keyword]|0|0";	
}
}

if($_REQUEST['part']=='Search_Catalogue_Lists') {
$html="<table class='table table-bordered'>";
$vendorcode=Get_Fetch_Data($con,$_REQUEST['customer'],"id,Vendor_Code,department","vendor_details");
$Itmsqls=mysqli_query($con,"select id,product,barcode,description from product_details where supplier='".$_REQUEST['customer']."' and hsn_code='".$_REQUEST['hsn_code']."' order by id desc");
while($Itmrows=mysqli_fetch_array($Itmsqls)){
$html.="<tr><td>$Itmrows[product]</td></tr>";
}
$html.="</table>";
echo $html;
}

/*if($_REQUEST['part']=='Check_Supplier_GST_Details') {
$GSTIN=Get_GST_Details_From_GSTIN($_REQUEST['gstin']);
$Cityname=Get_City_Details($con,$GSTIN->result->AddrLoc);
echo  $GSTIN->result->StateCode.'|'.$GSTIN->result->Status.'|'.$GSTIN->result->AddrPncd.'|'.$GSTIN->result->AddrBnm.' '.$GSTIN->result->AddrBno.' '.$GSTIN->result->AddrFlno.' '.$GSTIN->result->AddrSt.' '.$GSTIN->result->AddrLoc.'|'.$GSTIN->result->AddrLoc.'|'.$GSTIN->result->LegalName.'|'.$GSTIN->result->BlkStatus.'|'.$GSTIN->result->Status.'|'.$GSTIN->success.'|'.$Cityname;
}*/

if($_REQUEST['part']=='Check_Supplier_GST_Details') {
  if(!empty($_REQUEST['checktype'])) {
    if($_REQUEST['checktype']=='Buyer') {
      $checkQry = mysqli_query($con,"SELECT * FROM buyer_details WHERE GST='".$_REQUEST['gstin']."' ");
    }
    else {
      $checkQry = mysqli_query($con,"SELECT * FROM supplier WHERE GST='".$_REQUEST['gstin']."' ");
    }
    if(($checkQry)==0) {
      $GSTIN=Search_GST_Details_From_GSTIN($_REQUEST['gstin']);
      $Cityname=Get_City_Details($con,$GSTIN->result->pradr->addr->loc);
      $Txptypes=strtoupper($GSTIN->result->dty);
      $StateCode=substr($GSTIN->result->gstin,0,2);
      echo  $StateCode.'|'.$GSTIN->result->sts.'|'.$GSTIN->result->pradr->addr->pncd.'|'.$GSTIN->result->pradr->addr->bnm.' '.$GSTIN->result->pradr->addr->bno.' '.$GSTIN->result->pradr->addr->flno.' '.$GSTIN->result->pradr->addr->st.' '.$GSTIN->result->pradr->addr->loc.'|'.$GSTIN->result->AddrLoc.'|'.$GSTIN->result->lgnm.'|'.$GSTIN->result->BlkStatus.'|'.$GSTIN->result->Status.'|'.$GSTIN->success.'|'.$Cityname.'|'.$Txptypes.'|'.$GSTIN->result->tradeNam.'|0';
    }
    else {
      echo "1";
    }
  }
  else {
    $GSTIN=Search_GST_Details_From_GSTIN($_REQUEST['gstin']);
    $Cityname=Get_City_Details($con,$GSTIN->result->pradr->addr->loc);
    $Txptypes=strtoupper($GSTIN->result->dty);
    $StateCode=substr($GSTIN->result->gstin,0,2);
    echo  $StateCode.'|'.$GSTIN->result->sts.'|'.$GSTIN->result->pradr->addr->pncd.'|'.$GSTIN->result->pradr->addr->bnm.' '.$GSTIN->result->pradr->addr->bno.' '.$GSTIN->result->pradr->addr->flno.' '.$GSTIN->result->pradr->addr->st.' '.$GSTIN->result->pradr->addr->loc.'|'.$GSTIN->result->AddrLoc.'|'.$GSTIN->result->lgnm.'|'.$GSTIN->result->BlkStatus.'|'.$GSTIN->result->Status.'|'.$GSTIN->success.'|'.$Cityname.'|'.$Txptypes.'|'.$GSTIN->result->tradeNam;
  }
}

if($_POST['part'] == 'Get_Invoice_catalogue_Tax'){
if($_POST['qty']>0){ $qty=$_POST['qty']; } else { $qty=1; }
//$challan = Get_Fetch_Data($con,$_POST['catalogue'], 'pid', 'challan_items');
$product = Get_Fetch_Data($con,$_POST['catalogue'], 'hsn_code', 'product_details');
$tax=Get_Hsn_range_tax($con,$_POST['ratee'],$product['hsn_code']);
$GstTax = Get_Fetch_Data($con,$tax['tax'], 'All', 'GstTax');
$vendor = Get_Fetch_Data($con,$_POST['customer'], 'State', 'customer_details');
if($vendor['State']==7){
$CGST=$_POST['Amounts']*$GstTax['Pcgst']/100;	 $SGST=$_POST['Amounts']*$GstTax['Psgst']/100; $IGST=0;
$CGSTPer=$GstTax['Pcgst']; $SGSTPer=$GstTax['Psgst']; $IGSTPer=0; $totalTax=$CGST+$SGST;
$Taxable="<div style='font-size:11px;color:red;white-space: nowrap;'>CGST: $CGST @$GstTax[Pcgst]%</div><div style='font-size:11px;color:red;white-space: nowrap;'>SGST: $SGST @$GstTax[Psgst]%</div>";	
} else {
$IGST=$_POST['Amounts']*$GstTax['Pigst']/100; $CGST=0; $SGST=0; $totalTax=$IGST;	
$Taxable="<span style='font-size:11px;color:red;white-space: nowrap;'>IGST: $IGST @$GstTax[Pigst]%</span>";
$CGSTPer=0; $SGSTPer=0; $IGSTPer=$GstTax['Pigst'];
}

$totalamt=$_POST['Amounts']+$totalTax;
echo "$Taxable|$totalamt|$CGSTPer|$CGST|$SGSTPer|$SGST|$IGSTPer|$IGST";
}


if($_POST['part'] == 'Get_Invoice_Product_Tax'){
if($_POST['qty']>0){ $qty=$_POST['qty']; } else { $qty=1; }
//$challan = Get_Fetch_Data($con,$_POST['catalogue'], 'pid', 'challan_items');
$product = Get_Fetch_Data($con,$_POST['catalogue'], 'hsn_code', 'product_details');
$tax=Get_Hsn_range_tax($con,$_POST['ratee'],$product['hsn_code']);
$GstTax = Get_Fetch_Data($con,$tax['tax'], 'All', 'GstTax');
$vendor = Get_Fetch_Data($con,$_POST['customer'], 'State', 'customer_details');
if($vendor['State']==7){
$CGST=$_POST['Amounts']*$GstTax['Pcgst']/100;	 $SGST=$_POST['Amounts']*$GstTax['Psgst']/100; $IGST=0;
$CGSTPer=$GstTax['Pcgst']; $SGSTPer=$GstTax['Psgst']; $IGSTPer=0; $totalTax=$CGST+$SGST;
$Taxable="<div style='font-size:11px;color:red;white-space: nowrap;'>CGST: $CGST @$GstTax[Pcgst]%</div><div style='font-size:11px;color:red;white-space: nowrap;'>SGST: $SGST @$GstTax[Psgst]%</div>";	
} else {
$IGST=$_POST['Amounts']*$GstTax['Pigst']/100; $CGST=0; $SGST=0; $totalTax=$IGST;	
$Taxable="<span style='font-size:11px;color:red;white-space: nowrap;'>IGST: $IGST @$GstTax[Pigst]%</span>";
$CGSTPer=0; $SGSTPer=0; $IGSTPer=$GstTax['Pigst'];
}

$totalamt=$_POST['Amounts']+$totalTax;
echo "$Taxable|$totalamt|$CGSTPer|$CGST|$SGSTPer|$SGST|$IGSTPer|$IGST";
}

if ($_REQUEST['part'] == 'Get_Invoice_Challan_Items'){
//$sql="SELECT id,pid FROM `challan_items` GROUP BY pid";
$skillData = array();
//$sql="SELECT ci.id,product,pd.hsn_code FROM `challan_items` ci LEFT JOIN product_details pd on ci.pid=pd.id where (product like '%".$_REQUEST['term']."%' or barcode like '%".$_REQUEST['term']."%')  group by pid";

$sql="SELECT ci.pid,product,pd.hsn_code FROM `challan_items` ci LEFT JOIN product_details pd on ci.pid=pd.id where (product like '%".$_REQUEST['term']."%' or barcode like '%".$_REQUEST['term']."%') UNION SELECT vi.pid,product,pds.hsn_code FROM `voucher_items` vi LEFT JOIN product_details pds on vi.pid=pds.id where vi.vstatus='Open' and (product like '%".$_REQUEST['term']."%' or barcode like '%".$_REQUEST['term']."%') group by pid";
$Itmsqlss=mysqli_query($con,$sql);
while($Itmrows=mysqli_fetch_array($Itmsqlss)){
$hsncode=Get_Fetch_Data($con,$Itmrows[hsn_code],"hsncode","HsnList");
$data['id'] = $Itmrows['pid']; 
$data['value'] = "$Itmrows[product]";
array_push($skillData, $data);
}
echo json_encode($skillData);
}

if($_POST['part']=='Get_Invoice_Challan_Items_Data') {
$customer = Get_Fetch_Data($con,$_POST['customer'], 'ctpe', 'customer_details');
//$Itmsqls=mysqli_query($con,"SELECT ci.id,ci.pid,product,pd.hsn_code,ci.mrp,ci.ws FROM `challan_items` ci LEFT JOIN product_details pd on ci.pid=pd.id where (product like '".$_REQUEST['catalogue']."%' or barcode like '".$_REQUEST['catalogue']."')  group by pid");

$Itmsqls=mysqli_query($con,"SELECT ci.id,ci.pid,product,pd.hsn_code,ci.mrp,ci.ws FROM `challan_items` ci LEFT JOIN product_details pd on ci.pid=pd.id where (product like '".$_REQUEST['catalogue']."%' or barcode like '".$_REQUEST['catalogue']."') UNION SELECT vi.id,vi.pid,product,pds.hsn_code,vi.mrp,vi.ws FROM `voucher_items` vi LEFT JOIN product_details pds on vi.pid=pds.id where (product like '".$_REQUEST['catalogue']."%' or barcode like '".$_REQUEST['catalogue']."') group by pid");

$ItemsNums=mysqli_num_rows($Itmsqls);
if($ItemsNums>0){
$Itmrows=mysqli_fetch_array($Itmsqls);
$hsncode=Get_Fetch_Data($con,$Itmrows[hsn_code],"hsncode","HsnList");
if($customer['ctpe']=="2"){
       $rate=$Itmrows['mrp'];
      }else{
        $rate=$Itmrows['ws'];
      }
 $totalstock=product_stock($con,$Itmrows["pid"]);
 if($totalstock>0){ $Stocks="<div class='text-success'>$totalstock</div>"; } else { $Stocks="<div class='text-danger'>$totalstock</div>"; }
 
echo "$Itmrows[pid]|$Itmrows[product]|$rate|$Stocks";
} else {
echo "0|0|0|0";	
}
}
if($_REQUEST['part']=='Get_Sale_Voucher_Part_Table'){
$vendordep=Get_Fetch_Data($con,$_POST['customer'],"id,State,discount,Address,State,City,Pincode,scn,swn,gstno,Email,department","vendor_details");
$state_name=Get_Fetch_Data($con,$vendordep['State'],"id,state_name","state_details");
$city_name=Get_Fetch_Data($con,$vendordep['City'],"id,city_name","city_details");  
?>
<div class="col-sm-3">
<label for="inputPassword" class="col-sm-12 col-form-label  " style="background: #fff;
    padding: 6px;    border-radius: 4px;color: #b3b3b3;">  <i class="fas fa-map-marker-alt"></i> Address<br><span style="float: left;    font-size: 12px;    text-transform: capitalize;    color: #938d8d;"><?="$vendordep[Address] $state_name[state_name] $city_name[city_name] - $vendordep[Pincode]";?></span></label>
 
</div>
<div class="col-sm-3 px-2">
 
<p class="text-left-40"><i class="fas fa-mobile-alt"></i> <?="$vendordep[scn]";?></p>
<p class="text-left-40"><i class="fab fa-whatsapp"></i> <?="$vendordep[swn]";?></p>
 
</div>
 
 
<div class="col-sm-3 px-2">
<p class="text-left-40"><i class="fa fa-envelope"></i> <?="$vendordep[Email]";?></p>
<p class="text-left-40"><b><i class="fa fa-percent" aria-hidden="true"></i>
GSTIN NO</b> <?="$vendordep[gstno]";?></p>
 
</div>
<div class="col-sm-3 px-2">
 
<p class="text-left-40"><b>Voucher No</b> <?=Get_Sale_Voucher_No($con);?></p>
 
</div>
<div class="col-sm-12">
<table class="table table-hover  table-center mb-0" id="myTableF">
<thead>
<tr>
<th style="width:65px">Department</th>
<th style="width:65px">HSN</th>
<th style="width:250px">Design</th>
<th style="width: 50px;">Quantity </th>
<th style="width: 70px;">Rate </th>
<th style="width: 70px;">MRP </th>
<th style="width: 70px;">WS </th>
<th style="width: 100px;">Discount </th>
<th style="width: 80px;">Tax </th>
<th style="width: 90px;text-align: right;padding-right: 5px !important;">Amount </th>
</tr>
</thead>
<tbody>
<tr>
<td>
<select class="form-control select2 Dept" id="department" style="min-width: 95px;">
<?php
$Depts=explode(',',$vendordep['department']);
foreach($Depts as $depar){
$department=Get_Fetch_Data($con,$depar,"id,category","category_details");
echo "<option value=".$department['id'].">$department[category]</option>";	
}
?>
</select>
</td>
<td class="position-relative">
<input type="hidden" class="hsn_code" id="hsn_code">
<input type="text" class="form-control" id="search_hsn" placeholder="HSN Code" style="font-weight: 600;
    color: #000;min-width: 70px;" />

</td>
<td>
<input type="hidden" class="catalogue" id="catalogueS">
<input type="text" class="form-control" id="search_catl" placeholder="Design" />
<div id="Stock_Show" class="text-success"></div>
</td>
<td><input type="text" class="form-control qty" id="Quantity" style="min-width: 50px;"></td>
<td><input type="text" class="form-control rate" id="Rates"  placeholder="Enter Rate" style="min-width: 90px;" >
</td>
<td><input type="text" class="form-control MRP" id="MRP"></td>
<td><input type="text" class="form-control WS" id="WS"></td>
<td>
<div class="d-flex w-50 ">
<input type="hidden" class="Discountamt">
<input type="number" class="form-control p-2 h-30 DiscountVal" id="DiscountVal" value="<?=$vendordep['discount'];?>" style="width: 50px;border-top-right-radius:0px;border-bottom-right-radius:0px;">
<select name="DiscountType[]" class="form-control p-2 h-30 border-left-0 DiscountType" id="DiscountType" style="width: 50px;">
<option value="Percent">%</option>
<option value="Rupees">₹</option>
</select>
</div>
</td>
<td style="padding:0px;"><span class="Taxs">00</span>
<input type="hidden" class="cgst" name="cgst[]"><input type="hidden" class="cgst_amt">
<input type="hidden" class="sgst" name="sgst[]"><input type="hidden" class="sgst_amt">
<input type="hidden" class="igst" name="igst[]"><input type="hidden" class="igst_amt">
</td>
<td><div class="d-flex justify-content-end align-items-center">
<input type="hidden" class="Subtotal">
<input type="text" class="form-control Amount" id="Amount"  placeholder="Amount" readonly style="width:80px;">
<span class="float-right ml-2"> <a href="javascript:void" id="AddR"><i class="fa fa-plus-circle text-success" aria-hidden="true"></i></a> </span>
</div>
</td>
</tr>
</tbody>
</table>
<p class="border-bottom" style="border-color: #cccccc5e !important;"></p>
</div>
<div class="col-sm-5">
<table class="table table-hover table-striped table-center mb-0 table-left">
<tr>
<td style="padding: 8px;">
<textarea name="billnote"  class="form-control" placeholder="Voucher Note"></textarea></td>
</tr>
</table>
 <b>Upload Invoice</b>
<div class="upload-cover">

      <label for="inputTag">
        <i class="fa fa-2x fa fa-upload"></i>  <span>Upload Files <span>jpg,png,pdf</span></span>
      
        <input id="inputTag" name="attachment" type="file"/>
        <br/>
        <span id="imageName"></span>
      </label>
     
</div>
</div>
<div class="col-sm-2"></div>
<div class="col-sm-5">
<table class="table   table-center mb-0 table-right  " id="myTableOT">
<tbody>
<tr>
<td><b>Sub Total</b></td>
<td colspan="4">&nbsp;</td>
<td class="text-right pr-3"><input type="hidden" name="Subtotal" id="Subtotal">
<b><span id="SubtotalShow">00.00</span></b></td>
</tr>
<tr>
<td class="text-grey">Discount(-)</td>
<td colspan="4"></td>
<td class="text-right pr-3"><input type="hidden" name="discountamt" id="discountamt">
<b><span id="discountshow" class=" ">00.00</span></b></td>
</tr>
<?php
if($vendordep["State"]=="7"){
?>
<tr>
<td class='text-grey'>CGST(+)</td>
<td colspan='4'><div class='d-flex w-50 '></td>
<td class='text-right pr-3'><input type='hidden' name='cgstamount' id='cgstamount'>
<b><span id='CGstchargeShow' class=' '>00.00</span></b></td>
</tr>
<tr>
<td class='text-grey'>SGST(+)</td>
<td colspan='4'></td>
<td class='text-right pr-3'><input type='hidden' name='sgstamount' id='sgstamount'>
<b><span id='SGstchargeShow' class=' '>00.00</span></b></td>
</tr>
<?php } else { ?>
<tr><td class='text-grey'>IGST(+)</td>
<td colspan='4'></td>
<td class='text-right pr-3'><input type='hidden' name='igstamount' id='igstamount'>
<b><span id='IGstchargeShow' class=' '>00.00</span></b></td>
</tr>
<?php } ?>
<tr>
<td colspan="6" class=" " style="font-size: 12px;padding: 0px;padding-left: 8px;">Other charges(+)</td></tr>
<tr>  
<td colspan="4"> <div class="d-flex w-50 ">
<select class="form-control p-2 h-40 Ocharge" name="Ocharge[]" style="width: 120px;">
<option value="">Select</option>
<?php
$Ochsql=mysqli_query($con,"select id,charge_name from charges_details where status='Active'");
while($Ochrow=mysqli_fetch_array($Ochsql)){
echo "<option value=".$Ochrow['id'].">$Ochrow[charge_name]</option>";
}
?>
</select>
</div></td>
<td class="text-right pr-3">
<input type="text" class="form-control p-2 h-30 Othercharge" name="Othercharge[]">
</td>
<td class="text-right pr-3">
<div class="d-flex w-60 ">
<input type="text" class="form-control p-2 h-30 Otherchargeval" name="Otherchargeval[]" readonly>
<span class="float-right ml-3"> <a href="javascript:void" id="AddOT"><i class="fa fa-plus-circle text-success" aria-hidden="true"></i></a> </span>
</div>
</td>
</tr>
<tr>
<td class=' ' style="font-size: 12px;">Round off (+/-)</td>
<td colspan='4'></td>
<td class='text-right pr-3'><input type='text' class="form-control p-2 h-30" name='roundoff' id='roundoff'></td>
</tr>
<tr>
<td><b>Total (₹)</b></td>
<td colspan="4">&nbsp;</td>
<td class="text-right pr-3"><b>
<input type="hidden" name="TotalAmount" id="TotalAmount">
<span id="TotalAmountShow">00.00</span></b></td>
</tr>
</tbody>

</table>
</div>
<div class="col-sm-12">
<input type="hidden" name="random_move" value="<?php echo $_SESSION['random_move']; ?>">
<button type="submit" class="btn btn-dark ml-3" name="GenerateVoucher" id="GenerateVoucher">Generate Voucher</button>
<p>Shortcut:  <span style="font-size:12px; color:#6c757d;"><b>Shift + Enter</b> to generate voucher</span></p>
</div>          
<?php 	
}
if ($_POST['part'] == 'Add_Sale_Voucher_Item_Table_Part'){
if($_POST['catalogue']>0){
$catalogue=$_POST['catalogue'];	
} else {
$Check=Get_Count_Data($con,mysql_real_escape_string($con,$_POST['keyword']),'product','product_details');
if($Check==0){
$barcode=Get_Product_Barcode($con);
$vendordep=Get_Fetch_Data($con,$_POST['customer'],"id,Vendor_Code","vendor_details");
$Product="$vendordep[Vendor_Code]-".strtoupper($_POST['keyword']);
$Insert=mysqli_query($con,"insert into product_details(supplier,category,product,hsn_code,barcode,add_time,utpe,status) values('".$_POST['customer']."','".$_POST['category']."','".mysqli_real_escape_string($con,$Product)."','".$_POST['hsn_code']."','".$barcode."','".date('d/m/Y H:i:s')."','Pcs','Active')");
$catalogue=mysqli_insert_id($con);
}
}
$product=Get_Fetch_Data($con,$catalogue,"id,product,barcode,hsn_code","product_details");
$totalstock=product_stock($con,$product["id"]);
$department=Get_Fetch_Data($con,$_POST['category'],"id,category","category_details");
?>
<tr>
<td>
<select class="form-control select3 Dept" name="department[]">
<?php
echo "<option value=".$department['id']." selected>$department[category]</option>";
?>
</select>
</td>
<td>
<select class="form-control select3 hsn_code" name="hsn_code[]">
<?php
$hsncode=Get_Fetch_Data($con,$_POST['hsn_code'],"id,hsncode","HsnList");
echo "<option value=".$hsncode['id']." selected>$hsncode[hsncode]</option>";
?>
</select>
</td>
<td>
<select class="form-control select3 catalogue" name="catalogue[]">
<?php
echo "<option value=".$product['id']." selected>$product[product]</option>";
?>
</select>
<div class="text-danger barcode"><?=$product[barcode];?></div>
<div class="text-success Stockshow">Stock: <?=$totalstock;?></div>
</td>
<td><input type="text" class="form-control qty" name="qty[]" value="<?=$_POST['qty'];?>"></td>
<td><input type="text" class="form-control rate" name="rate[]" value="<?=$_POST['rate'];?>">
</td>
<td><input type="text" class="form-control MRP" name="MRP[]"  value="<?=$_POST['MRP'];?>" required></td>
<td><input type="text" class="form-control WS" name="WS[]"  value="<?=$_POST['WS'];?>" required></td>
<td>
<div class="d-flex w-50 ">
<input type="hidden" class="Discountamt" name="Discountamt[]" value="<?=$_POST['Discountamt'];?>">
<input type="number" class="form-control p-2 h-30 DiscountVal" name="DiscountVal[]" value="<?=$_POST['DiscountVal'];?>" style="width: 50px;">
<select name="DiscountType[]" class="form-control p-2 h-30 border-left-0 DiscountType" style="width: 50px;">
<?php
$arrs=array('Percent'=>'%','Rupees'=>'₹');
foreach($arrs as $key=>$DiscountType){
if($key==$_POST['DiscountType']){
echo "<option value=".$key." selected>$DiscountType</option>";
} else {
echo "<option value=".$key.">$DiscountType</option>";	
}
}
?>
</select>
</div>
</td>
  <td style="padding:0px;"><span class="Taxs">
<?php
if($_POST['sgst']>0){
echo "<div style='font-size:11px;color:red;    white-space: nowrap;'>CGST: $_POST[cgst_amt] @$_POST[cgst]%</div><div style='font-size:11px;color:red;    white-space: nowrap;'>SGST: $_POST[sgst_amt] @$_POST[sgst]%</div>";	
} else {
echo "<span style='font-size:11px;color:red;white-space: nowrap;'>IGST: $_POST[igst_amt] @$_POST[igst]%</span>";
}
?>
  </span>
  <input type="hidden" class="cgst" name="cgst[]" value="<?=$_POST['cgst'];?>"><input type="hidden" class="cgst_amt" name="cgst_amt[]" value="<?=$_POST['cgst_amt'];?>">
  <input type="hidden" class="sgst" name="sgst[]" value="<?=$_POST['sgst'];?>"><input type="hidden" class="sgst_amt" name="sgst_amt[]" value="<?=$_POST['sgst_amt'];?>">
  <input type="hidden" class="igst" name="igst[]" value="<?=$_POST['igst'];?>"><input type="hidden" class="igst_amt" name="igst_amt[]" value="<?=$_POST['igst_amt'];?>">
  </td>
  <td><div class="d-flex justify-content-end">
  <input type="hidden" class="Subtotal" name="Subtotals[]" value="<?=$_POST['Subtotal'];?>">
      <input type="text" class="form-control Amount" name="Amount[]" style="    width: 80px;" placeholder="Amount" value="<?=$_POST['Amount'];?>" readonly>
      <span class="float-right ml-2"> <a href="javascript:void" class="RemoveR"><i class="fe fe-trash text-danger" aria-hidden="true"></i></a> </span> </div></td>
</tr>
<?php	
}
if ($_REQUEST['part'] == 'Get_dePartment_list'){
$vendordep=Get_Fetch_Data($con,$_POST['supplier'],"id,Vendor_Code,department","vendor_details");
$Csql = mysqli_query($con,"select id,category from category_details where status='Active' and id IN ($vendordep[department])");
while ($Crow = mysqli_fetch_array($Csql))
{
$html .= "<option value=" . $Crow['id'] . ">$Crow[category]</option>";
}
echo $html;
}
//Sale Voucher List
if ($_REQUEST['part'] == 'All_Sale_Voucher_Data_Part'){
$requestData = $_REQUEST;
if ($_REQUEST['from'] != '' && $_REQUEST['to'] != '')
{
$ff = explode('/', $_REQUEST['from']);
$from = $ff[2] . '-' . $ff[1] . '-' . $ff[0];
$tt = explode('/', $_REQUEST['to']);
$to = $tt[2] . '-' . $tt[1] . '-' . $tt[0];
$where .= " and STR_TO_DATE(`challandte`, '%d/%m/%Y') between '" . $from . "' and '" . $to . "'";
}
if ($_REQUEST['company'] != '')
{
$where .= " and uid='" . $_REQUEST['company'] . "'";
}
if($_REQUEST['status']!=''){
$where .= " and status='".$_REQUEST['status']."'";
} if($_REQUEST['status']==''){
$where .= " and status!='Billed'";
}
$sqls = "SELECT * FROM voucher_details where id!='' $where";
$sql = "SELECT * FROM voucher_details where id!='' $where";
$querys = mysqli_query($con,$sqls);
$totalData = mysqli_num_rows($querys);
$totalFiltered = $totalData;
if (!empty($requestData['search']['value']))
{ // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql .= " AND ( orderid LIKE '%" . $requestData['search']['value'] . "%' ";
$sql .= " OR challanno LIKE '%" . $requestData['search']['value'] . "%'";
$sql .= " OR challandte LIKE '%" . $requestData['search']['value'] . "%'";
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
$coupon = "<span class='badge badge-pill bg-primary inv-badge'>$row[coupon]</span><br>";
if ($row[status] == 'Billed'){
$class = 'bg-success';
$action = "<input type='hidden' class='id' value=" . $row['id'] . ">";
} else if ($row[status] == 'Open'){
$class = 'bg-warning';
$action = "<input type='hidden' class='id' value=" . $row['id'] . ">
<span style='white-space:nowrap;float: right;'>
<a class='btn btn-sm bg-success-light ' href='SaleDispatchVoucher.php?id=$row[id]'><i class='fe fe fe-search'></i></a>&nbsp;
<a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></a></span>";
} else {
$class = 'bg-primary';
$action = "<input type='hidden' class='id' value=" . $row['id'] . ">
<span style='white-space:nowrap;float: right;'>
<a class='btn btn-sm bg-success-light ' href='SaleDispatchVoucher.php?id=$row[id]'><i class='fe fe fe-search'></i></a>&nbsp;
<a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></a></span>";
}
if($row[open_at]!=''){ $open_at="<div class='create_time'>$row[open_at]</div>"; } else { $open_at=""; }
$Orders = Get_Voucher_Amounts($con,$row['id']);
$User = Get_Fetch_Data($con,$row['uid'], 'id,FName,Cname', 'vendor_details');
$transport = Get_Fetch_Data($con,$row['transport'], 'id,transport', 'transport_details');
$nestedData = array();
$nestedData[] = "<div class='first' $OrderColor><a href='SaleDispatchVoucher.php?id=$row[id]'>$row[orderid]</a>
<div class='create_time'>$row[add_time]</div></div>";
$nestedData[] = "<div class='first' $OrderColor>$row[challandte]</div>";
$nestedData[] = "<div class='first' $OrderColor>$row[challanno]</div>";
$nestedData[] = "<div class='first' $OrderColor>".strtoupper($User[Cname])."</div>";
$nestedData[] = "<div class='first' $OrderColor>$transport[transport]</div>";
$nestedData[] = "$Orders[items]";
$nestedData[] = "<div class='first' $OrderColor>$Orders[quantity]</div>";
$nestedData[] = "<div class='first' $OrderColor>" . number_format((float)$row['final_amount'], 2, '.', '') . "</div>";
$nestedData[] = "<div class='third' $OrderColor><span class='badge badge-pill $class inv-badge'>$row[status]</span>$open_at</div>";
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

if ($_REQUEST['part'] == 'Update_Sale_Voucher_Status'){
mysqli_query($con,"update voucher_details set status='Open',open_at='".date('d/m/Y H:i:s')."' where id='".$_POST['id']."'");	
mysqli_query($con,"update voucher_items set vstatus='Open' where oid='".$_POST['id']."'");
}
//Stock Report
if ($_REQUEST['part'] == 'All_Stock_Report_Data_Part'){
$requestData = $_REQUEST;
if ($_REQUEST['from'] != '' && $_REQUEST['to'] != '')
{
$ff = explode('/', $_REQUEST['from']);
$from = $ff[2] . '-' . $ff[1] . '-' . $ff[0];
$tt = explode('/', $_REQUEST['to']);
$to = $tt[2] . '-' . $tt[1] . '-' . $tt[0];
$where .= " and STR_TO_DATE(dates, '%d/%m/%Y') between '" . $from . "' and '" . $to . "'";
}


$sqls = "SELECT concat('ch-',id) as ids,'Challan' as types,qty,(select order_date from challan_details where id=ci.oid) as dates FROM `challan_items` ci WHERE pid='".$_REQUEST['pid']."' UNION SELECT concat('vo-',id) as ids,'Voucher' as types,qty,(select order_date from voucher_details where id=vi.oid) as dates FROM `voucher_items` vi WHERE pid='".$_REQUEST['pid']."' and vstatus='Open' UNION SELECT concat('in-',id) as ids,'Invoice' as types,qty,(select order_date from invoice_details where id=iil.oid) as dates FROM `invoice_item_list` iil WHERE pid='".$_REQUEST['pid']."' $where";

$sql = "SELECT concat('ch-',id) as ids,'Challan' as types,qty,(select order_date from challan_details where id=ci.oid) as dates FROM `challan_items` ci WHERE pid='".$_REQUEST['pid']."' UNION SELECT concat('vo-',id) as ids,'Voucher' as types,qty,(select order_date from voucher_details where id=vi.oid) as dates FROM `voucher_items` vi WHERE pid='".$_REQUEST['pid']."' and vstatus='Open' UNION SELECT concat('in-',id) as ids,'Invoice' as types,qty,(select order_date from invoice_details where id=iil.oid) as dates FROM `invoice_item_list` iil WHERE pid='".$_REQUEST['pid']."' $where";
$querys = mysqli_query($con,$sqls);
$totalData = mysqli_num_rows($querys);
$totalFiltered = $totalData;
if (!empty($requestData['search']['value']))
{ // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql .= " AND ( dates LIKE '%" . $requestData['search']['value'] . "%' ";
$sql .= " OR types LIKE '%" . $requestData['search']['value'] . "%'";
$sql .= " OR qty LIKE '%" . $requestData['search']['value'] . "%' )";
}
$sql .= "  order by str_to_date(dates,'%d/%m/%Y') asc  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
//echo $sqls;
$query = mysqli_query($con,$sql);
//$totalFiltered = mysql_num_rows($query);
$data = array();
$i = 1;
while ($row = mysqli_fetch_array($query))
{ // preparing an array
$Itid=explode('-',$row['ids']);
if($row[types]=='Challan'){
$chalitm = Get_Fetch_Data($con,$Itid[1], 'id,oid', 'challan_items');
$challan = Get_Fetch_Data($con,$chalitm['oid'], 'challanno,orderid', 'challan_details');
$RefNo="$challan[orderid]";	
$Values="+"; $colors='#309a31';
}
if($row[types]=='Voucher'){
$chalitm = Get_Fetch_Data($con,$Itid[1], 'id,oid', 'voucher_items');
$challan = Get_Fetch_Data($con,$chalitm['oid'], 'challanno,orderid', 'voucher_details');
$RefNo="$challan[orderid]";	
$Values="+"; $colors='#309a31';
}
if($row[types]=='Invoice'){
$chalitm = Get_Fetch_Data($con,$Itid[1], 'id,oid', 'invoice_item_list');
$challan = Get_Fetch_Data($con,$chalitm['oid'], 'invoiceno,orderid', 'invoice_details');
$RefNo="$challan[invoiceno]";
$Values="-"; $colors='#e63b3b';	
} 
$nestedData = array();
$nestedData[] = "<div style='color:$colors;'>$row[dates]</div>";
$nestedData[] = "<div style='color:$colors;'>$row[types]</div>";
$nestedData[] = "<div style='color:$colors;'>$RefNo</div>";
$nestedData[] = "<div style='color:$colors;'>$Values $row[qty]</div>";
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

if($_POST['part']=='Add_Team_Coordination_Table_Part') {
  ?>
  <tr>
    <td>
      <select name="role[]" class="form-control select3" required>
            <option value="">Select</option>
            <?php
              $Csql = mysqli_query($con,"select * from role");
              while ($Crow = mysqli_fetch_array($Csql))
              {
          echo "<option value=" . $Crow['id'] . ">$Crow[rname]</option>";
              }

              ?>
          </select> 
    </td>
  <td>      
  <input type="text" class="form-control contact_name" name="contact_name[]" style="text-align:left;width:350px;" value="<?php echo $_POST['contact_name']?>">      
  </td>

  <td><input type="text" class="form-control mobile_no" name="mobile_no[]" style="width: 300px;" value="<?php echo $_POST['mobile_no']?>"></td>

  <td>
  <span class="float-right ml-2"> <a href="javascript:void" class="RemoveItems"><i class="fa fa-minus-circle text-danger" aria-hidden="true"></i></a></span>  
  </td>  
  </tr>
  <?php
}

if($_POST['part']=='Add_SupplierBuyerCommission_Table_Part') {
  ?>
  <tr>
  <td>      
  <select name="buyer[]" class="form-control select3 buyer" required>
            <option value="">Select</option>
            <?php
              $Csql = mysqli_query($con,"select * from buyer_details");
              while ($Crow = mysqli_fetch_array($Csql))
              {
          echo "<option value=" . $Crow['id'] . ">$Crow[CName]</option>";
              }

              ?>
          </select>     
  </td>

  <td><input type="text" class="form-control commission" name="bcommission[]" placeholder="Enter Commission" style="width: 300px;" onkeypress="return /[0-9]/i.test(event.key)"></td>

  <td>
  <span class="float-right ml-2"> <a href="javascript:void" class="RemoveC"><i class="fa fa-minus-circle text-danger" aria-hidden="true"></i></a></span>  
  </td>  
  </tr>
  <?php
}
if($_POST['part']=='Add_Contact_Detail_Table_Part') {
  ?>
  <tr>
<td>
  <input type="text" class="form-control" name="department[]" style="text-align:left;" placeholder="Enter Designation">
</td>
  <td>      
  <input type="text" class="form-control your_name" name="your_name[]" style="text-align:left;" value="<?php echo $_POST['your_name']?>" placeholder="Contact Name">      
  </td>

  <td><input type="text" class="form-control mobile_num" name="mobile_num[]" value="<?php echo $_POST['mobile_num']?>" placeholder="Mobile No." style="" onkeypress="return /[0-9]/i.test(event.key)" maxlength="10" pattern="[0-9 ]+"></td>

  <td>
  <span class="float-right ml-2"> <a href="javascript:void" class="RemoveItemsC"><i class="fa fa-minus-circle text-danger" aria-hidden="true"></i></a></span>  
  </td>  
  </tr>
  <?php
}

if($_POST['part']=='Add_Accountant_Table_Part') {
  ?>
  <tr>
  <td>      
  <input type="text" class="form-control contact_name" name="ac_contact_name[]" style="text-align:left;width:350px;" value="<?php echo $_POST['ac_contact_name']?>">      
  </td>

  <td><input type="text" class="form-control mobile_no" name="ac_mobile_no[]" style="width: 300px;" value="<?php echo $_POST['ac_mobile_no']?>"></td>

  <td>
  <span class="float-right ml-2"> <a href="javascript:void" class="RemoveItemsAC"><i class="fa fa-minus-circle text-danger" aria-hidden="true"></i></a></span>  
  </td>  
  </tr>
  <?php
}

if($_POST['part']=='Add_Reference_Detail_Table_Part') {
  ?>
  <tr>
  <!-- <td>
  <select name="role[]" class="form-control select2" required>
  <option value="">Select</option>
  <?php
  $Csql = mysqli_query($con,"select * from role");
  while ($Crow = mysqli_fetch_array($Csql))
  {
  echo "<option value=" . $Crow['id'] . ">$Crow[rname]</option>";
  }

  ?>
  </select> 
  </td> -->
  <td>      
  <input type="text" class="form-control company_name" name="company_name[]" placeholder="Company Name">      
  </td>
        
  <td>      
  <input type="text" class="form-control contact_name" name="contact_name[]" value="<?php echo $_POST['contact_name']?>" placeholder="Contact Name">      
  </td>

  <td><input type="text" class="form-control mobile_no" name="mobile_no[]" value="<?php echo $_POST['mobile_no']?>" placeholder="Mobile No." onkeypress="return /[0-9]/i.test(event.key)" maxlength="10" pattern="[0-9 ]+"></td>

  <td>
  <span class="float-right ml-2"> <a href="javascript:void" class="RemoveItems"><i class="fa fa-minus-circle text-danger" aria-hidden="true"></i></a></span>  
  </td>  
  </tr>
  <?php
}
if($_POST['part']=='Remove_Supplier_Part_Contact_detail') {
    mysqli_query($con,"DELETE from supplier_contact_detail where ctype='".$_POST['ctype']."' && id='".$_POST['id']."'");
    echo 1;
}
if($_POST['part']=='Remove_BuyerCommision_Part_Contact_detail') {
    mysqli_query($con,"DELETE from Buyer_Commission where id='".$_POST['id']."'");
    echo 1;
}
if($_POST['part']=='Remove_Buyer_Part_Contact_detail') {
    mysqli_query($con,"DELETE from buyer_contact_detail where ctype='".$_POST['ctype']."' && id='".$_POST['id']."'");
    echo 1;
}
if($_REQUEST['part']=='All_Team_Data_Part'){
  $requestData= $_REQUEST;
  if($_REQUEST['status']!=''){$where.=" and status='".$_REQUEST['status']."'";}
  $sqls = "SELECT * FROM admin_signup where level!='1' $where";
  $sql = "SELECT * FROM admin_signup where level!='1' $where";  
  $querys=mysqli_query($con,$sqls);
  $totalData = mysqli_num_rows($querys);
  $totalFiltered = $totalData; 
  if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
    $sql.=" AND ( name LIKE '%".$requestData['search']['value']."%' "; 
    $sql.=" OR mobile LIKE '%".$requestData['search']['value']."%'";
    $sql.=" OR email LIKE '%".$requestData['search']['value']."%'";
    $sql.=" OR designation LIKE '%".$requestData['search']['value']."%'";
    $sql.=" OR status LIKE '%".$requestData['search']['value']."%' )";
  }
  $sql.="  ORDER BY id desc  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
  //echo $sqls;
  $query=mysqli_query($con,$sql);
  //$totalFiltered = mysqli_num_rows($query);
  $data = array();
  $i=1;
  while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  if($row['company']!=''){
  $company="<br><a class='badge badge-pill bg-primary inv-badge' href='dyer-company.php?id=$row[id]'>$row[company]</a>";
  } else { $company=""; }
  if($Userrow['role']==9){
  $Delete="&nbsp;<a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></i></a>";
  } else { $Delete=""; }
if(Get_Role_Features($con,$Userrow['role'],'Team','Updates')=='on'){
  $Update="<a class='btn btn-sm bg-success-light' href='UpdateTeam.php?id=$row[id]'><i class='fe fe-pencil'></i></a>";
}
  $action="<input type='hidden' class='id' value=".$row['id'].">
  <span style='white-space:nowrap;float: right;'>
  $Update$Delete</span>";
  if($row[status]=='Active'){ $class='bg-success'; } else { $class='bg-danger'; }
  $role=Get_Fetch_Data($con,$row['role'],'id,rname','role');
    $nestedData=array(); 
    $nestedData[] = "<div class='first'>$row[name]</div>";
    $nestedData[] = "<div class='first'>$row[mobile]</div>";
    $nestedData[] = "<div class='first'>$row[email]</div>";
    $nestedData[] = "<div class='first'>$row[designation]</div>";
    $nestedData[] = "<div class='first'>$role[rname]</div>";
    $nestedData[] = "<div class='third'><span class='badge badge-pill $class inv-badge'>$row[status]</span>
    <div class='create_time'>$row[create_time]</div></div>";
    $nestedData[] = "$action";
    $data[] = $nestedData;
    $i++;
  }
  $json_data = array(
        "draw"            => intval( $requestData['draw'] ),   
        "recordsTotal"    => intval( $totalData ),  
        "recordsFiltered" => intval( $totalFiltered ), 
        "data"            => $data  
        );
  echo json_encode($json_data); 
} 

if ($_REQUEST['part'] == 'All_Role_Data'){
  $arrs=array(1,2,3,4,6);
  $requestData = $_REQUEST;
  $sqls = "SELECT * FROM role where id!='' $where";
  $sql = "SELECT * FROM role where id!='' $where";
  $querys = mysqli_query($con,$sqls);
  $totalData = mysqli_num_rows($querys);
  $totalFiltered = $totalData;
  if (!empty($requestData['search']['value']))
  { // if there is a search parameter, $requestData['search']['value'] contains search parameter
  $sql .= " AND ( rname LIKE '%" . $requestData['search']['value'] . "%' ";
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

  if(Get_Role_Features($con,$Userrow['role'],'Team-Role','Deletes')=='on'){
  $Delete="&nbsp; <a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></a>";  
  } if(Get_Role_Features($con,$Userrow['role'],'Team-Role','Updates')=='on'){
  $Update="<a class='btn btn-sm bg-success-light mr-2 updateLinks' href='javascript:void'><i class='fe fe-pencil'></i></a>";  
  } 
  //if(!in_array($row[id],$arrs)){         
    $action = "<input type='hidden' class='id' value=" . $row['id'] . "> <span style='white-space:nowrap;float: right;'>$Update$Delete</span>";
  /*} else {
  $action = ""; 
  }*/
  if ($row['status'] == 'Active'){ $class = 'bg-success'; } else { $class = 'bg-danger'; }
  $nestedData = array();
  $nestedData[] = "<div class='first'>$row[rname]</div>";
  $nestedData[] = "<div class='first'>$row[web_login]</div>";
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

if($_POST['part'] == 'Role_data_Update') {
  $row = Get_Fetch_Data($con,$_POST['id'], 'All', 'role'); 
  ?>
  <div class="modal-header ">
  <h5 class="modal-title">Update Role Detail</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
  </div>
  <div class="modal-body">
  <form action="" method="post" enctype="multipart/form-data">
  <div class="row form-row">
  <div class="col-12 col-sm-12">
  <div class="form-group">
  <label> Role Name<span class="text-danger">*</span></label>
  <input type="text" class="form-control" value="<?php echo $row['rname']; ?>" name="rname" required>
  </div>
  </div>
  <div class="col-12">
  <table class="table table-hover table-striped table-center mb-0">
  <thead>
  <tr><th>Menu</th><th>All</th><th>Show</th><th>Save</th><th>Update</th><th>Search</th><th>Delete</th><th>Print</th></tr>
  </thead>
  <tbody>
  <?php
  $Gisql=mysqli_query($con,"select * from role_features where rid='".$row['id']."' order by id");
  while($Grorw=mysqli_fetch_array($Gisql)){
    if($Grorw['Alls']!=''){ $AllChecked='checked'; } else { $AllChecked=''; }
    if($Grorw['Shows']!=''){ $ShowsChecked='checked'; } else { $ShowsChecked=''; }
    if($Grorw['Saves']!=''){ $SavesChecked='checked'; } else { $SavesChecked=''; }
    if($Grorw['Updates']!=''){ $UpdatesChecked='checked'; } else { $UpdatesChecked=''; }
    if($Grorw['Searchs']!=''){ $SearchsChecked='checked'; } else { $SearchsChecked=''; }
    if($Grorw['Deletes']!=''){ $DeletesChecked='checked'; } else { $DeletesChecked=''; }
    if($Grorw['Prints']!=''){ $PrintsChecked='checked'; } else { $PrintsChecked=''; }
    echo "<tr><td>$Grorw[Menus]<input type='hidden' name='Menu_id[]' value='".$Grorw['id']."'></td>
    <td><input type='checkbox' class='Alls' name='".$Grorw[Menus]."_Allsu' $AllChecked></td>
    <td><input type='checkbox' name='".$Grorw[Menus]."_Showsu'  $ShowsChecked></td>
    <td><input type='checkbox' name='".$Grorw[Menus]."_Savesu'  $SavesChecked></td>
    <td><input type='checkbox' name='".$Grorw[Menus]."_Updatesu'  $UpdatesChecked></td>
    <td><input type='checkbox' name='".$Grorw[Menus]."_Searchsu'  $SearchsChecked></td>
    <td><input type='checkbox' name='".$Grorw[Menus]."_Deletesu'  $DeletesChecked></td>
    <td><input type='checkbox' name='".$Grorw[Menus]."_Printsu' $PrintsChecked></td>
    </tr>";
    } 
  ?>
  </tbody>
  </table>
  </div>
  <div class="col-6">
  <div class="form-group">
  <label>Web Login<span class="text-danger">*</span></label>
  <select class="form-control" name="web_login">
  <?php $arr = array('Enable','Disable');
  foreach ($arr as $web_login){
    if ($web_login == $row['web_login']){
    echo "<option value=" . $web_login . " selected>$web_login</option>";
    } else {
    echo "<option value=" . $web_login . ">$web_login</option>";
    }
  }
  ?>
  </select>
  </div>
  </div>

  <div class="col-6">
  <div class="form-group">
  <label>Status<span class="text-danger">*</span></label>
  <select class="form-control" name="status">
  <?php $arr = array('Active','Inactive');
  foreach ($arr as $status){
    if ($status == $row['status']){
    echo "<option value=" . $status . " selected>$status</option>";
    } else {
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
  <button class="btn btn-success" name="UpdateRole">Update</button>
  </form>
  </div>
  <?php
}  

if ($_REQUEST['part'] == 'Buyr_Saleorder_data_View'){
  $requestData = $_REQUEST;
  if ($_REQUEST['from'] != '' && $_REQUEST['to'] != '')
  {
  $ff = explode('/', $_REQUEST['from']);
  $from = $ff[2] . '-' . $ff[1] . '-' . $ff[0];
  $tt = explode('/', $_REQUEST['to']);
  $to = $tt[2] . '-' . $tt[1] . '-' . $tt[0];
  $where .= " and STR_TO_DATE(`add_time`, '%d/%m/%Y') between '" . $from . "' and '" . $to . "'";
  }
  // else{
  //   $where .= " and  STR_TO_DATE(`add_time`, '%d/%m/%Y') between '" . $ex . "' and '" . $ex1 . "'";
  // }

  if($SelYears['Year']!=$currnetyear){
  $where .= " and Year='".$SelYears['Year']."'";  
  }else{
  $where .= " and  STR_TO_DATE(`add_time`, '%d/%m/%Y') between '" . $ex . "' and '" . $ex1 . "'"; 
  }
  if ($_REQUEST['company'] != '')
  {
  $where .= " and uid='" . $_REQUEST['company'] . "'";
  }
  if ($_REQUEST['payment_status'] != '')
  {
  $where .= " and payment_status='" . $_REQUEST['payment_status'] . "'";
  }
  $sqls = "SELECT * FROM salesorder where id!='' && buyerid='".$_REQUEST['buyerid']."' $where";
  $sql = "SELECT * FROM salesorder where id!='' && buyerid='".$_REQUEST['buyerid']."' $where";
  $querys = mysqli_query($con,$sqls);
  $totalData = mysqli_num_rows($querys);
  $totalFiltered = $totalData;
  if (!empty($requestData['search']['value']))
  { // if there is a search parameter, $requestData['search']['value'] contains search parameter
  $sql .= " AND ( orderid LIKE '%" . $requestData['search']['value'] . "%' ";
  $sql .= " OR order_date LIKE '%" . $requestData['search']['value'] . "%'";
  //$sql .= " OR LRNo LIKE '%" . $requestData['search']['value'] . "%'";
  $sql .= " OR transport LIKE '%" . $requestData['search']['value'] . "%'";
  $sql .= " OR status LIKE '%" . $requestData['search']['value'] . "%' )";
  }
  $sql .= " ORDER BY id desc LIMIT " . $requestData['start'] . " ," . $requestData['length'] . " ";
  //echo $sqls;
  $query = mysqli_query($con,$sql);
  //$totalFiltered = mysql_num_rows($query);
  $data = array();
  $i = 1;
  while ($row = mysqli_fetch_array($query)) { // preparing an array

  $Update="";   
  if(Get_Role_Features($con,$Userrow['role'],'Sale-Order','Deletes')=='on'){  
    $Delete="&nbsp;<a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></a>";    
  }if(Get_Role_Features($con,$Userrow['role'],'Sale-Order','Updates')=='on'){
      $Update="&nbsp;<a class='btn btn-sm bg-success-light' href='update_ordersale.php?id=$row[id]'><i class='fe fe-pencil'></i></a>"; 
  }  

  if($row['status'] == 'Complete'){
      $class = 'bg-success';
      $action = "<input type='hidden' class='id' value=".$row['id'].">    
      <a class='btn btn-sm bg-success-light viewLinks' href='javascript:void'><i class='fe fe-search'></i></a> ";
    }
    else {
      $class = 'bg-warning';
      $action = "<input type='hidden' class='id' value=".$row['id'].">    
      <span style='white-space:nowrap;float: right;'><a class='btn btn-sm bg-success-light viewLinks' href='javascript:void'><i class='fe fe-search'></i></a></span>";
    }

  $Pendingqty = Get_SaleOrders_Qty($con,"qty","oid",$row['id']);
  $recqty = Get_SaleOrders_Qty($con,"Tot_qty","oid",$row['id']);
  //$buyername = Get_Fetch_Data($con,$row['buyerid'], 'id,CName', 'buyer_details');
  $suppliername = Get_Fetch_Data($con,$row['supplierid'], 'id,CName', 'supplier');

  $nestedData = array();
  $nestedData[] = "<div class='first' $OrderColor>$row[order_date]</div>";
  $nestedData[] = "<div class='first' $OrderColor style='white-space: nowrap;'>$row[orderid]</div>";
  $nestedData[] = "<div class='first' $OrderColor>$suppliername[CName]</div>";  
  $nestedData[] = "<div class='' $OrderColor>$Pendingqty</div>";
  $nestedData[] = "<div class='' $OrderColor>$recqty</div>";
  $nestedData[] = "<div class='first' $OrderColor>$row[final_amount]</div>";
  $nestedData[] = "<div class='third' $OrderColor><span class='badge badge-pill $class inv-badge $class'>$row[status]</span>";  
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

if ($_REQUEST['part'] == 'Supplier_Saleorder_data_View'){
  $requestData = $_REQUEST;
  if ($_REQUEST['from'] != '' && $_REQUEST['to'] != '')
  {
  $ff = explode('/', $_REQUEST['from']);
  $from = $ff[2] . '-' . $ff[1] . '-' . $ff[0];
  $tt = explode('/', $_REQUEST['to']);
  $to = $tt[2] . '-' . $tt[1] . '-' . $tt[0];
  $where .= " and STR_TO_DATE(`add_time`, '%d/%m/%Y') between '" . $from . "' and '" . $to . "'";
  }
  // else{
  //   $where .= " and  STR_TO_DATE(`add_time`, '%d/%m/%Y') between '" . $ex . "' and '" . $ex1 . "'";
  // }

  if($SelYears['Year']!=$currnetyear){
  $where .= " and Year='".$SelYears['Year']."'";  
  }else{
  $where .= " and  STR_TO_DATE(`add_time`, '%d/%m/%Y') between '" . $ex . "' and '" . $ex1 . "'"; 
  }
  if ($_REQUEST['company'] != '')
  {
  $where .= " and uid='" . $_REQUEST['company'] . "'";
  }
  if ($_REQUEST['payment_status'] != '')
  {
  $where .= " and payment_status='" . $_REQUEST['payment_status'] . "'";
  }
  $sqls = "SELECT * FROM salesorder where id!='' && supplierid='".$_REQUEST['supplierid']."' $where";
  $sql = "SELECT * FROM salesorder where id!='' && supplierid='".$_REQUEST['supplierid']."' $where";
  $querys = mysqli_query($con,$sqls);
  $totalData = mysqli_num_rows($querys);
  $totalFiltered = $totalData;
  if (!empty($requestData['search']['value']))
  { // if there is a search parameter, $requestData['search']['value'] contains search parameter
  $sql .= " AND ( orderid LIKE '%" . $requestData['search']['value'] . "%' ";
  $sql .= " OR order_date LIKE '%" . $requestData['search']['value'] . "%'";
  //$sql .= " OR LRNo LIKE '%" . $requestData['search']['value'] . "%'";
  $sql .= " OR transport LIKE '%" . $requestData['search']['value'] . "%'";
  $sql .= " OR status LIKE '%" . $requestData['search']['value'] . "%' )";
  }
  $sql .= " ORDER BY id desc LIMIT " . $requestData['start'] . " ," . $requestData['length'] . " ";
  //echo $sqls;
  $query = mysqli_query($con,$sql);
  //$totalFiltered = mysql_num_rows($query);
  $data = array();
  $i = 1;
  while ($row = mysqli_fetch_array($query)) { // preparing an array

  $Update="";   
  if(Get_Role_Features($con,$Userrow['role'],'Sale-Order','Deletes')=='on'){  
    $Delete="&nbsp;<a href='javascript:void' class='btn btn-sm bg-danger-light deleteLinks'><i class='fe fe-trash'></a>";    
  }if(Get_Role_Features($con,$Userrow['role'],'Sale-Order','Updates')=='on'){
      $Update="&nbsp;<a class='btn btn-sm bg-success-light' href='update_ordersale.php?id=$row[id]'><i class='fe fe-pencil'></i></a>"; 
  }  

  if($row['status'] == 'Complete'){
      $class = 'bg-success';
      $action = "<input type='hidden' class='id' value=".$row['id'].">    
      <a class='btn btn-sm bg-success-light viewLinks' href='javascript:void'><i class='fe fe-search'></i></a> ";
    }
    else {
      $class = 'bg-warning';
      $action = "<input type='hidden' class='id' value=".$row['id'].">    
      <span style='white-space:nowrap;float: right;'><a class='btn btn-sm bg-success-light viewLinks' href='javascript:void'><i class='fe fe-search'></i></a></span>";
    }

  $Pendingqty = Get_SaleOrders_Qty($con,"qty","oid",$row['id']);
  $recqty = Get_SaleOrders_Qty($con,"Tot_qty","oid",$row['id']);
  $buyername = Get_Fetch_Data($con,$row['buyerid'], 'id,CName', 'buyer_details');
  //$suppliername = Get_Fetch_Data($con,$row['supplierid'], 'id,CName', 'supplier');

  $nestedData = array();
  $nestedData[] = "<div class='first' $OrderColor>$row[order_date]</div>";
  $nestedData[] = "<div class='first' $OrderColor style='white-space: nowrap;'>$row[orderid]</div>";
  $nestedData[] = "<div class='first' $OrderColor>$buyername[CName]</div>";  
  $nestedData[] = "<div class='' $OrderColor>$Pendingqty</div>";
  $nestedData[] = "<div class='' $OrderColor>$recqty</div>";
  $nestedData[] = "<div class='first' $OrderColor>$row[final_amount]</div>";
  $nestedData[] = "<div class='third' $OrderColor><span class='badge badge-pill $class inv-badge $class'>$row[status]</span>";  
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


if($_REQUEST['part']=="Agent_Commission"){
  $agent=Get_Fetch_Data($con,$_POST['agent'],"commsion","agent_details");
  echo $agent['commsion'];
}
if ($_REQUEST['part'] == 'All_Supplier_Group_Data') {

  $requestData = $_REQUEST;
  $sqls = "SELECT * FROM Supplier_group where id!='' $where";
  $sql = "SELECT * FROM Supplier_group where id!='' $where";
  $querys = mysqli_query($con,$sqls);
  $totalData = mysqli_num_rows($querys);
  $totalFiltered = $totalData;
  if (!empty($requestData['search']['value']))
  { // if there is a search parameter, $requestData['search']['value'] contains search parameter
  $sql .= " AND ( name LIKE '%" . $requestData['search']['value'] . "%' ";
  $sql .= " OR status LIKE '%" . $requestData['search']['value'] . "%' )";
  }
  $sql .= " ORDER BY name asc LIMIT " . $requestData['start'] . " ," . $requestData['length'] . " ";
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
  $nestedData[] = "<div class=''>$row[name]</div>";
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
if ($_REQUEST['part'] == 'All_buyer_group_Data') {

  $requestData = $_REQUEST;
  $sqls = "SELECT * FROM buyer_group where id!='' $where";
  $sql = "SELECT * FROM buyer_group where id!='' $where";
  $querys = mysqli_query($con,$sqls);
  $totalData = mysqli_num_rows($querys);
  $totalFiltered = $totalData;
  if (!empty($requestData['search']['value']))
  { // if there is a search parameter, $requestData['search']['value'] contains search parameter
  $sql .= " AND ( name LIKE '%" . $requestData['search']['value'] . "%' ";
  $sql .= " OR status LIKE '%" . $requestData['search']['value'] . "%' )";
  }
  $sql .= " ORDER BY name asc LIMIT " . $requestData['start'] . " ," . $requestData['length'] . " ";
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
  $nestedData[] = "<div class=''>$row[name]</div>";
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

if ($_REQUEST['part'] == 'All_courier_Data') {

  $requestData = $_REQUEST;
  $sqls = "SELECT * FROM courier where id!='' $where";
  $sql = "SELECT * FROM courier where id!='' $where";
  $querys = mysqli_query($con,$sqls);
  $totalData = mysqli_num_rows($querys);
  $totalFiltered = $totalData;
  if (!empty($requestData['search']['value']))
  { // if there is a search parameter, $requestData['search']['value'] contains search parameter
  $sql .= " AND ( name LIKE '%" . $requestData['search']['value'] . "%' ";
  $sql .= " OR mobile LIKE '%" . $requestData['search']['value'] . "%' )";
  }
  $sql .= " ORDER BY name asc LIMIT " . $requestData['start'] . " ," . $requestData['length'] . " ";
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
  $nestedData[] = "<div class=''>$row[name]</div>";
  $nestedData[] = "<div class=''>$row[mobile]</div>";
  $nestedData[] = "<div class=''>$row[address]</div>";
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



if ($_POST['part'] == 'Supplier_Group_data_Update'){

  $row = Get_Fetch_Data($con,$_POST['id'], 'All', 'Supplier_group');

  ?>
  <div class="modal-header ">
  <h5 class="modal-title">Update Supplier Group Detail</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
  </div>
  <div class="modal-body">
  <form action="" method="post" enctype="multipart/form-data">
  <div class="row form-row">
  <div class="col-6">
  <div class="form-group">
  <label> Group Name<span class="text-danger">*</span></label>
  <input type="text" class="form-control" value="<?php echo $row['name']; ?>" name="level_name" required>
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
if ($_POST['part'] == 'buyer_group_data_Update'){

  $row = Get_Fetch_Data($con,$_POST['id'], 'All', 'buyer_group');

  ?>
  <div class="modal-header ">
  <h5 class="modal-title">Update Buyer Group Detail</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
  </div>
  <div class="modal-body">
  <form action="" method="post" enctype="multipart/form-data">
  <div class="row form-row">
  <div class="col-6">
  <div class="form-group">
  <label> Group Name<span class="text-danger">*</span></label>
  <input type="text" class="form-control" value="<?php echo $row['name']; ?>" name="level_name" required>
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

if ($_POST['part'] == 'Courier_data_Update'){

  $row = Get_Fetch_Data($con,$_POST['id'], 'All', 'courier');

  ?>
  <div class="modal-header ">
  <h5 class="modal-title">Update Courier Detail</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
  </div>
  <div class="modal-body">
  <form action="" method="post" enctype="multipart/form-data">
  <div class="row form-row">
  <div class="col-6">
  <div class="form-group">
  <label> Name<span class="text-danger">*</span></label>
  <input type="text" class="form-control" value="<?php echo $row['name']; ?>" name="name" required>
  </div>
  </div>
  <div class="col-6">
  <div class="form-group">
  <label> Address<span class="text-danger">*</span></label>
  <textarea type="text" class="form-control address" name="address" placeholder="Address" ><?php echo $row['address']; ?></textarea>
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

if($_POST['part']=='Get_Buyer_Discount') {
  //echo "SELECT dcommission from buyer_details where id='".$_POST["customer"]."' ";
  $Vsqls=mysqli_query($con,"SELECT DCommision from buyer_details where id='".$_POST["customer"]."' ");
  $Vrows=mysqli_fetch_array($Vsqls);
  echo $Vrows['DCommision'];
}
if($_POST['part']=='Get_Supplier_Discount') {  
  $Vsqls=mysqli_query($con,"SELECT DCommision,credit_days from supplier where id='".$_POST["customer"]."' ");
  $Vrows=mysqli_fetch_array($Vsqls);
  $Lastdiscount=LastDiscount_Buyer_Supplier($con,$_POST['buyer'],$_POST["customer"]);
  if($Lastdiscount['buyer_discount'] > 0 || $Lastdiscount['payment_days']!=''){
$commission=$Lastdiscount['special_discount'];
$paymentdays=$Lastdiscount['payment_days'];
  }else{
    $commission=$Vrows['DCommision'];
    $paymentdays=$Vrows['credit_days'];
  }
  echo "$commission|$paymentdays|$Lastdiscount";
}

if($_POST['part']=='Get_Supplier_Payment_Days') { 
  $html="<option value=''>Select One</option>";
  $credit_days_arr = array('1'=>'1','7'=>'7','15'=>'15','30'=>'30','60'=>'60','90'=>'90');
  $Vsqls=mysqli_query($con,"SELECT credit_days from supplier where id='".$_POST["customer"]."' ");
  $row=mysqli_fetch_array($Vsqls);
  //$html ="<option value="">Select</option>";
  foreach ($credit_days_arr as $key => $value) {
    if ($row['credit_days']==$value) {
      $html.="<option value=".$value." selected>$value</option>"; 
    }
    else {    
      $html.="<option value=".$value.">$value</option>"; 
    }   
  }
  echo $html;
}

if($_POST['part']=='Get_Supplier_Buyer_City_Other') { 
  $html="<option value=''>Select One</option>";
  $buyerdetails=Get_Fetch_Data($con,$_POST['customer'], 'State,City', 'supplier');
  $Vsqls=mysqli_query($con,"SELECT * from city_details where state='".$buyerdetails["State"]."' ");
  while($row=mysqli_fetch_array($Vsqls)){  
  
    if ($row['id']==$buyerdetails['City']) {
      
      $html.="<option value=".$row['id']." selected>$row[city_name]</option>"; 
    }
    else {    
       $html.="<option value=".$row['id'].">$row[city_name]</option>"; 
    }   
  }
  echo $html;
}

if($_POST['part']=='Get_Buyer_City_Other') { 
  $html="<option value=''>Select One</option>";
  $buyerdetails=Get_Fetch_Data($con,$_POST['buyer'], 'State,City', 'buyer_details');
  $Vsqls=mysqli_query($con,"SELECT * from city_details where state='".$buyerdetails["State"]."' ");
  while($row=mysqli_fetch_array($Vsqls)){  
  
    if ($row['id']==$buyerdetails['City']) {
      
      $html.="<option value=".$row['id']." selected>$row[city_name]</option>"; 
    }
    else {    
       $html.="<option value=".$row['id'].">$row[city_name]</option>"; 
    }   
  }
  echo $html;
}


if($_POST['part']=='Get_Buyers') { 
  $html="<option value=''>Select Buyer</option>";
  $Vsqls=mysqli_query($con,"SELECT id,CName from buyer_details where Buyer_Type='".$_POST['buyertype']."' ");
  while($row=mysqli_fetch_array($Vsqls)){  
    $html.="<option value=".$row['id'].">$row[CName]</option>";   
  }
  echo $html;
}
if($_POST['part']=='Get_Suppliers') { 
  $html="<option value=''>Select Supplier</option>";
  $Vsqls=mysqli_query($con,"SELECT id,CName from supplier where SupplierType='".$_POST['suppliertype']."' ");
  while($row=mysqli_fetch_array($Vsqls)){  
    $html.="<option value=".$row['id'].">$row[CName]</option>";   
  }
  echo $html;
}
if($_POST['part']=='Remove_Sales_Order') {
  mysqli_query($con,"DELETE from salesorder_items where id='".$_POST["id"]."' ");
  echo 1;
}
/*-----------------------Product Unit Module START-----------------------------*/
if ($_REQUEST['part'] == 'All_Product_unit_Data') {
    $requestData = $_REQUEST;
    $sqls = "SELECT * FROM unit_details where id!='' $where";
    $sql = "SELECT * FROM unit_details where id!='' $where";
    $querys = mysqli_query($con,$sqls);
    $totalData = mysqli_num_rows($querys);
    $totalFiltered = $totalData;
    if (!empty($requestData['search']['value']))
    { // if there is a search parameter, $requestData['search']['value'] contains search parameter
        $sql .= " AND ( unit_name LIKE '%" . $requestData['search']['value'] . "%' ";
        $sql .= " OR id LIKE '%" . $requestData['search']['value'] . "%' )";
    }
    $sql .= "  ORDER BY unit_name asc  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
    //echo $sqls;
    $query = mysqli_query($con,$sql);
    //$totalFiltered = mysql_num_rows($query);
    $data = array();
    $i = 1;
    while ($row = mysqli_fetch_array($query))
    { // preparing an array
    if($Userrow['role']!=5){
      $Delete="&nbsp; <a href='javascript:void' class='btn bg-light text-danger deleteLinks'><i class='fe fe-trash'></a>";  
    }
    $action = "<input type='hidden' class='id' value=" . $row['id'] . ">
    <span style='white-space:nowrap;float: right;'>
    <a class='btn bg-light text-info mr-2 updateLinks' href='javascript:void'><i class='fe fe-pencil'></i></a>$Delete</span>";

    if ($row['status'] == 'Active'){
    $class = 'bg-success';
    } else {
    $class = 'bg-danger';
    }
        
      $nestedData = array();
      $nestedData[] = "<div class='first'>$i</div>";
      $nestedData[] = "<div class='first'>$row[unit_name]</div>";
      $nestedData[] = "<div class='third'><span class='badge badge-pill $class inv-badge'>$row[status]</span>";
      $nestedData[] = "<div class='fourth'><i class='fe fe-clock text-warning mr-1'></i> $row[add_time]";
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
if($_POST['part'] == 'Product_unit_data_Add'){
  //$row = Get_Fetch_Data($con,$_POST['id'], 'All', 'ledger_groups');
  ?>
  <div class="modal-header">
    <h5 class="modal-title">Add Product Unit Detail</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
  </div>
  <div class="modal-body">
    <form action="" method="post" enctype="multipart/form-data">
      <div class="row form-row">
        <div class="col-12">
          <div class="form-group">
            <label> Unit Name<span class="text-danger">*</span></label>
            <input type="text" class="form-control" value="<?php echo $_POST['unit_name'];?>" name="unit_name" required>
          </div>
        </div>       
      </div> 

       <div class="row form-row">
      <div class="col-12">
        <div class="form-group">
          <select name="status" id="status" class="form-control Capitalize select2" required="">
            <option value="">--Select One--</option>
            <option value="Active" <?php echo ($_POST['status']=='Active')?('selected'):('')?>>Active</option>
            <option value="Inactive" <?php echo ($_POST['status']=='Inactive')?('selected'):('')?>>Inactive</option>
          </select>
        </div>
      </div>       
    </div> 

      <input type="hidden" name="random_move" value="<?php echo $_SESSION['random_move']; ?>">
      <button class="btn btn-success" name="AddGroup">Add</button>
    </form>
  </div>
  <?php 
} 

if($_POST['part'] == 'Product_unit_data_Update'){
  $row = Get_Fetch_Data($con,$_POST['id'], 'All', 'unit_details');
  ?>
  <div class="modal-header">
    <h5 class="modal-title">Update Product Unit Detail</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
  </div>
  <div class="modal-body">
    <form action="" method="post" enctype="multipart/form-data">
      <div class="row form-row">
        <div class="col-12">
          <div class="form-group">
            <label> Unit Name<span class="text-danger">*</span></label>
            <input type="text" class="form-control" value="<?php echo $row['unit_name']; ?>" name="unit_name" required>
          </div>
        </div>         
      </div>

      <div class="row form-row">
        <div class="col-12">
          <div class="form-group">
            <select name="status" id="status" class="form-control Capitalize select2">
              <option value="">--Select One--</option>
              <option value="Active" <?php echo ($row['status']=='Active')?('selected'):('')?>>Active</option>
              <option value="Inactive" <?php echo ($row['status']=='Inactive')?('selected'):('')?>>Inactive</option>
            </select>
          </div>
        </div>       
      </div> 
      <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
      <input type="hidden" name="random_move" value="<?php echo $_SESSION['random_move']; ?>">
      <button class="btn btn-success" name="UpdateGroup">Update</button>
    </form>
  </div>
  <?php 
}
/*-----------------------Product Unit Module END-----------------------------*/

if ($_REQUEST['part'] == 'Get_Product_Unit'){
  $html = "<option value=''>Select Unit</option>";
$PUnit=Get_Fetch_Data($con,$_POST['product'],"Unit","product_details");
// $Unit=Get_Fetch_Data($con,$PUnit['Unit'],"id,unit_name","unit_details");
// $html .= "<option value=" . $Unit['id'] . " selected>$Unit[unit_name]</option>";
//       echo $html;
$html="";
      $Msql=mysqli_query($con,"SELECT * FROM unit_details where status='Active'");
            while($Brows=mysqli_fetch_array($Msql)){
              if($PUnit['Unit']==$Brows['id']){
              $html.="<option value=" .$Brows['id']. " selected>$Brows[unit_name]</option>";
            }else{
               $html.="<option value=" .$Brows['id']. ">$Brows[unit_name]</option>";
            }
            }
echo $html;
  }
  if($_REQUEST['part']=="New_AddArea"){
  $Check=Get_Count_Data($con,$_POST['area_name'],'area_name','area_details');
if($Check==0){
    $query=mysqli_query($con,"insert into area_details(area_name,status,add_time) values('".$_POST['area_name']."','".$_POST['status']."','".date('d/m/Y H:i:s')."')");
      $id=mysqli_insert_id($con);
  }
  $html = "<option value=''>Select Area</option>";
      $Csql = mysqli_query($con,"select * from area_details order by id desc");
      while ($Crow = mysqli_fetch_array($Csql))
      {
        if($Crow['id']==$id){
          $html .= "<option value=" . $Crow['id'] . " selected>$Crow[area_name]</option>";
        }else{
          $html .= "<option value=" . $Crow['id'] . ">$Crow[area_name]</option>";
        }
      }
    

      echo $html;
}

if($_REQUEST['part']=="New_Suppliergroup"){
  $Check=Get_Count_Data($con,$_POST['level_name'],'name','Supplier_group');
if($Check==0){
   mysqli_query($con,"INSERT INTO Supplier_group(name,status,add_time)values('".$_POST['level_name']."','".$_POST['status']."','".date('d/m/Y H:i:s')."')");
      $id=mysqli_insert_id($con);
  }
  $html = "<option value=''>Select Group</option>";
      $Csql = mysqli_query($con,"select * from Supplier_group order by id desc");
      while ($Crow = mysqli_fetch_array($Csql))
      {
        if($Crow['id']==$id){
          $html .= "<option value=" . $Crow['id'] . " selected>$Crow[name]</option>";
        }else{
          $html .= "<option value=" . $Crow['id'] . ">$Crow[name]</option>";
        }
      }
    

      echo $html;
}

if($_REQUEST['part']=="New_Buyergroup"){

  $Check=Get_Count_Data($con,$_POST['level_name'],'name','buyer_group');
  if($Check==0){
    mysqli_query($con,"INSERT INTO buyer_group(name,status,add_time)values('".$_POST['level_name']."','".$_POST['status']."','".date('d/m/Y H:i:s')."')");
    $id=mysqli_insert_id($con);
  }

  $html = "<option value=''>Select Group</option>";
  $Csql = mysqli_query($con,"SELECT * from buyer_group order by id desc");
  while ($Crow = mysqli_fetch_array($Csql)) {
    if($Crow['id']==$id){
      $html .= "<option value=".$Crow['id']." selected>$Crow[name]</option>";
    }else{
      $html .= "<option value=".$Crow['id'].">$Crow[name]</option>";
    }
  }
  echo $html;
}

if($_REQUEST['part']=="New_SupplierType"){
  $Check=Get_Count_Data($con,$_POST['type_name'],'Name','Supplier_Type');
if($Check==0){
   mysqli_query($con,"INSERT INTO Supplier_Type(Name,Status,add_time)values('".$_POST['type_name']."','".$_POST['status']."','".date('d/m/Y H:i:s')."')");
      $id=mysqli_insert_id($con);
  }
  $html = "<option value=''>Select One</option>";
      $Csql = mysqli_query($con,"select * from Supplier_Type order by id desc");
      while ($Crow = mysqli_fetch_array($Csql))
      {
        if($Crow['id']==$id){
          $html .= "<option value=" . $Crow['id'] . " selected>$Crow[Name]</option>";
        }else{
          $html .= "<option value=" . $Crow['id'] . ">$Crow[Name]</option>";
        }
      }
    

      echo $html;
}

if($_REQUEST['part']=="Add_NewCity"){  
  mysqli_query($con,"INSERT INTO city_details(state,city_name,status,add_time)values('".$_REQUEST['statename']."','".$_REQUEST['city_name']."','".$_REQUEST['status']."','".date('d/m/Y H:i:s')."')");
  $id=mysqli_insert_id($con);   

  $html = "<option value=''>Select City</option>";
  $Csql = mysqli_query($con,"SELECT * from city_details order by city_name ASC");
  while ($Crow = mysqli_fetch_array($Csql)) {
    if($Crow['id']==$id){
      $html .= "<option value=".$Crow['id']." selected>$Crow[city_name]</option>";
    }else{
      $html .= "<option value=".$Crow['id'].">$Crow[city_name]</option>";
    }
  }
  echo $html;
}

if($_POST['part']=="Add_NewTransport") {
  $Check=Get_Count_Data($con,$_POST['mobile'],'mobile','transport_details');
  if($Check==0){
    $sqls="INSERT into transport_details(transport,owner,mobile,address,status,add_time,mobile2,phone1,phone2,GST,State,City,Pincode,Bank,AccNo,Branch,IFSC) values('".mysqli_real_escape_string($con,$_REQUEST['name'])."','".$_REQUEST['oname']."','".$_REQUEST['mobile']."','".mysqli_real_escape_string($con,$_REQUEST['address'])."','".$_REQUEST['status']."','".date('d/m/Y H:i:s')."','".$_REQUEST["mobile1"]."','".$_REQUEST["phone1"]."','".$_REQUEST["phone2"]."','".$_REQUEST["gst"]."','".$_REQUEST["State"]."','".$_REQUEST["City"]."','".$_REQUEST["Pincode"]."','".$_REQUEST["bank"]."','".$_REQUEST["accno"]."','".$_REQUEST["branch"]."','".$_REQUEST["ifsc"]."')";
    $query=mysqli_query($con,$sqls);
    $id=mysqli_insert_id($con);
  } 

  $html = "<option value=''>Select Transport</option>";
  $Csql = mysqli_query($con,"SELECT * from transport_details order by id ASC");
  while ($Crow = mysqli_fetch_array($Csql)) {
    if($Crow['id']==$id){
      $html .= "<option value=".$Crow['id']." selected>$Crow[transport]</option>";
    }else{
      $html .= "<option value=".$Crow['id'].">$Crow[transport]</option>";
    }
  }
  echo $html;
}

if($_REQUEST['part']=='Check_IfscDetails_Verify') {
  $result=verifyIFSC($_POST['ifsc']);
  if ($result) {
    echo "1|$result[BANK]|$result[BRANCH]";
    
} else {
    echo "0";
}
}

if($_REQUEST['part']=="Add_Transport_Details"){
  $Check=Get_Count_Data($con,$_POST['mobile'],'mobile','transport_details');
if($Check==0){
$sqls="insert into  transport_details(transport,owner,mobile,address,status,add_time,mobile2,phone1,phone2,GST,State,City,Pincode,Bank,AccNo,Branch,IFSC) values('".mysqli_real_escape_string($con,$_REQUEST['name'])."','".$_REQUEST['oname']."','".$_REQUEST['mobile']."','".mysqli_real_escape_string($con,$_REQUEST['address'])."','".$_REQUEST['status']."','".date('d/m/Y H:i:s')."','".$_REQUEST["mobile1"]."','".$_REQUEST["phone1"]."','".$_REQUEST["phone2"]."','".$_REQUEST["gst"]."','".$_REQUEST["State"]."','".$_REQUEST["City"]."','".$_REQUEST["Pincode"]."','".$_REQUEST["bank"]."','".$_REQUEST["accno"]."','".$_REQUEST["branch"]."','".$_REQUEST["ifsc"]."')";
$query=mysqli_query($con,$sqls);
$id=mysqli_insert_id($con);
mysqli_query($con,"update buyer_details set transport='".$id."' where id='".$_POST['buyer']."'");
}
  $html = "<option value=''>Select Transport</option>";
      $Csql = mysqli_query($con,"select * from transport_details order by id desc");
      while ($Crow = mysqli_fetch_array($Csql))
      {
        if($Crow['id']==$id){
          $html .= "<option value=" . $Crow['id'] . " selected>$Crow[transport]</option>";
        }else{
          $html .= "<option value=" . $Crow['id'] . ">$Crow[transport]</option>";
        }
      }
    

      echo $html;
}
if($_REQUEST['part']=="Supplier_Data_Draft"){
  $data = array('SGst' => $_POST['gst'],'Scompany' => $_POST['company'],'SName' => $_POST['Name'],'Ssupplier_city_other' => $_POST['supplier_city_other'],'Ssuppliergroup' => $_POST['suppliergroup'],'SEmail' => $_POST['Email'],'Stype_supplier' => $_POST['type_supplier'],'Saddress' => $_POST['address'],'Sstate' => $_POST['state'],'Scity' => $_POST['city'],'SArea' => $_POST['Area'],'SPincode' => $_POST['Pincode'],'SDeals' => $_POST['Deals'],'Slevel_name' => $_POST['level_name'],'Saccount_no' => $_POST['account_no'],'Sifsc' => $_POST['ifsc'],'Sbranch' => $_POST['branch'],'Sbankname' => $_POST['bankname'],'Scredit_days' => $_POST['credit_days'],'Sdcommission' => $_POST['dcommission'],'Scommission' => $_POST['commission'],'Sdcommission' => $_POST['dcommission'],'Sbuyer'=>$_POST['buyer'],'Sagent_id'=>$_POST['agent_id'],'Sacommission'=>$_POST['acommission'],'SExecutive'=>$_POST['Executive'],'Scourier'=>$_POST['courier'],'Span'=>$_POST['panno']);
$serialized_data = serialize($data);

if($_POST['suppliertype']=="2"){
  setcookie("my_Gcookiesup", $serialized_data, time() + 86400);
//$suppliercookie=$_COOKIE['my_cookiesup'];
}else{
  setcookie("my_cookiesup", $serialized_data, time() + 86400);
}
}
if($_REQUEST['part']=="Buyer_Data_Draft"){
  $data = array('BGst' => $_POST['gst'],'Bcompany' => $_POST['company'],'BName' => $_POST['Name'],'Bbuyer_city_other' => $_POST['buyer_city_other'],'BEmail' => $_POST['Email'],'Btype_buyer' => $_POST['type_supplier'],'Baddress' => $_POST['address'],'Bstate' => $_POST['state'],'Bcity' => $_POST['city'],'BArea' => $_POST['Area'],'BPincode' => $_POST['Pincode'],'BDeals' => $_POST['Deals'],'Baccount_no' => $_POST['account_no'],'Bifsc' => $_POST['ifsc'],'Bbranch' => $_POST['branch'],'Bbankname' => $_POST['bankname'],'Bcredit_days' => $_POST['credit_days'],'Bdcommission' => $_POST['dcommission'],'Bcommission' => $_POST['commission'],'Bdcommission' => $_POST['dcommission'],'Bbuyer'=>$_POST['buyer'],'Bagent_id'=>$_POST['agent_id'],'Bacommission'=>$_POST['acommission'],'BExecutive'=>$_POST['Executive'],'Bpayment_mode'=>$_POST['payment_mode'],'Bcredit_limit'=>$_POST['credit_limit'],'Bbillty_address'=>$_POST['billty_address'],'Bpayment_mode'=>$_POST['payment_mode'],'Bransport'=>$_POST['transport'],'Bpan'=>$_POST['panno']);
$serialized_data = serialize($data);

if($_POST['suppliertype']=="2"){
 setcookie("my_Gcookiebuyer", $serialized_data, time() + 86400);
}else{
  setcookie("my_cookiebuyer", $serialized_data, time() + 86400);
}
}
if($_REQUEST['part']=="Get_Buyer_Transport"){
  $html="<option value=''>Select Transport</option>";
  $Vsqls=mysqli_query($con,"select id,transport from transport_details where id!='' ");
  $Bdetails=Get_Fetch_Data($con,$_POST['buyer'],"transport","buyer_details");
  while($row=mysqli_fetch_array($Vsqls)){  
  
    if ($row['id']==$Bdetails['transport']) {
      
      $html.="<option value=".$row['id']." selected>$row[transport]</option>"; 
    }
    else {    
       $html.="<option value=".$row['id'].">$row[transport]</option>"; 
    }   
  }
  echo $html;
}

if($_REQUEST['part']=="New_CourierAdd"){
  $Check=Get_Count_Data($con,$_POST['mobile'],'mobile','courier');
if($Check==0){
mysqli_query($con,"INSERT INTO courier(name,mobile,address,status,add_time) 
values('".$_POST['name']."','".$_POST['mobile']."','".mysqli_real_escape_string($con,$_POST['address'])."','".$_POST['status']."','".date('d/m/Y H:i:s')."')");
$id=mysqli_insert_id($con);

}
  $html = "<option value=''>Select</option>";
      $Csql = mysqli_query($con,"select * from courier Where status='Active'");
      while ($Crow = mysqli_fetch_array($Csql))
      {
        if($Crow['id']==$id){
          $html .= "<option value=" . $Crow['id'] . " selected>$Crow[name]</option>";
        }else{
          $html .= "<option value=" . $Crow['id'] . ">$Crow[name]</option>";
        }
      }
    

      echo $html;
}
if($_REQUEST['part']=='Get_Item_Images_Data') {
  $prodArr=Get_Fetch_Data($_POST['pid'],'All','product_details');
  if($prodArr['photo']!=''){
    echo "<a href='javascript:void' class='ShowImages'><img src='Item/$prodArr[photo]' class='img-fluid w-75 '></a>";
  } else {
    echo "<img src='img/img.png' class='img-fluid w-75 '>"; 
  }
}
if($_REQUEST['part']=='Supplier_DeleteRecord') {
  //print_r($_REQUEST['id']);
  $suppArr = array(); $delsuppArr = array();
  $getDeleteArr = explode(",",$_REQUEST['id']);  
  foreach ($getDeleteArr as $key => $val) {    
    //echo "SELECT * FROM sale_details where supplierid='".$val."' && GM_Payment_Status='UNBILLED'";
    $checkQry = mysqli_query($con,"SELECT * FROM sale_details where supplierid='".$val."' && GM_Payment_Status='UNBILLED' ");    
    if(mysqli_num_rows($checkQry)>0) {
      $suppArr[] = $val;
    }
    else {
     $delsuppArr[] = $val; 
    }
  }
  if(count($suppArr)>0) {
    echo '1|';
  }
  else {
    $senderId='GOBUZY';
    $message="Dear Admin,
    $otp - Use this OTP to Delete Supplier Detail.
    Do not share it with anyone
    Regards:
    Team MM Agency";

    send_sms('9119766665',$senderId,$message,'1207161755126060386');
    echo '0|'.implode(",",$delsuppArr);
  }
}
if($_REQUEST['part']=='Buyer_DeleteRecord') {
  //print_r($_REQUEST['id']);
  $suppArr = array(); $delsuppArr = array();
  $getDeleteArr = explode(",",$_REQUEST['id']);  
  foreach ($getDeleteArr as $key => $val) {    
    //echo "SELECT * FROM sale_details where supplierid='".$val."' && GM_Payment_Status='UNBILLED'";
    $checkQry = mysqli_query($con,"SELECT * FROM sale_details where buyerid='".$val."' && GM_Payment_Status='UNBILLED' ");    
    if(mysqli_num_rows($checkQry)>0) {
      $suppArr[] = $val;
    }
    else {
     $delsuppArr[] = $val; 
    }
  }
  if(count($suppArr)>0) {
    echo '1|';
  }
  else {
    $senderId='GOBUZY';
    $message="Dear Admin,
    $otp - Use this OTP to Delete Buyer Detail.
    Do not share it with anyone
    Regards:
    Team MM Agency";

    send_sms('9119766665',$senderId,$message,'1207161755126060386');
    echo '0|'.implode(",",$delsuppArr);
  }
}
?>
