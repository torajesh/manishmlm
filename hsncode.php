<?php
  $Page="Setting";
  $InnPage="hsncode";
  include('header.php'); 
  include('sidebar.php');
  $random=rand(0000000,9999999);
  if(isset($_POST['remove_lead']) && $_SESSION['random_move']==$_POST['random_move']) {
  $query=mysqli_query($con,"DELETE from HsnList where id='".$_POST['id']."'");
  if($query) {
  $msss="<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
  <strong>Success!</strong> This HSN Code Removed Successfully.</div>"; 
  }
  }

  if(isset($_POST['UpdateSubCategory']) && $_SESSION['random_move']==$_POST['random_move']) {
  $query=mysqli_query($con,"UPDATE HsnList set hsncode='".$_POST['hsncode']."', status='".$_POST['status']."'  where id='".$_POST['id']."'");
 
  if($query) {
  $msss="<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
  <strong>Success!</strong>HSN Details Updated Successfully.</div>";  
  }
  }
  if(isset($_POST['AddHSNCode']) && $_SESSION['random_move']==$_POST['random_move']) {
  $Check=Get_Count_Data($con,$_POST['hsncode'],'hsncode','HsnList');
  if($Check==0){   

  $query=mysqli_query($con,"INSERT into HsnList  SET hsncode = '".$_REQUEST['hsncode']."', status = '".$_REQUEST['status']."', add_time = '".date('d/m/Y H:i:s')."'");
  $hsnid=mysqli_insert_id($con);  
  if($query) {
  $msss="<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
  <strong>Success!</strong>HSN Code Added Successfully.</div>"; 
  }
  } else {
  $msss="<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
  <strong>Success!</strong>This HSN Code  already exists in Our Database.</div>"; 
  }
  }
  $_SESSION['random_move']=$random; 

  ?>
<!-- Page Wrapper -->
<div class="page-wrapper">
  <div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header" style="margin-bottom:0px;">
      <div class="row">
        <div class="col">
          <h3 class="page-title">HSN Code  
            <a class="btn btn-sm bg-primary mr-2 float-right text-white font-weight-bold" data-toggle="modal" href="#Filter_Part" style="display: none;"> <i class="fe fe-filter"></i> Filter </a>
            <a class="btn btn-sm bg-success mr-2 float-right text-white font-weight-bold" data-toggle="modal" href="#edit_details"> <i class="fe fe-plus"></i> Add </a> 
          </h3>
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="Dashboard.php">Settings</a></li>
            <li class="breadcrumb-item active">All HSN Code</li>
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
            <div class="table-responsive">
              <table class="table table-hover table-center mb-0" id="employee-grid">
                <thead>
                  <tr>
                   <!--  <th>Code</th>
                    <th>Description</th> -->
                    <th>HSN Code</th>
                    <th>Status</th>
                    <th>Created at</th>
                    <th class="text-right">Action</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /Page Wrapper -->
</div>
<!-- Filter Part --> 


<!-- Edit Details Modal -->
<div class="modal fade" id="edit_details" aria-hidden="true" role="dialog">
  <div class="modal-dialog modal-dialog-centered  modal-lg" role="document" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Create HSN Code</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body">
        <form method="post" action="" enctype="multipart/form-data">
          <div class="row form-row">
            <div class="col-6 col-sm-6">
              <div class="form-group">
                <label> HSN/SAC Code<span class="text-danger">*</span></label>
                <input type="number" class="form-control" placeholder="Enter HSN/SAC Code" name="hsncode"  required>
              </div>
            </div>
            
            <div class="col-6">
              <div class="form-group">
                <label>Status<span class="text-danger">*</span></label>
                <select class="form-control" name="status">
                  <option value="Active">Active</option>
                  <option value="Inactive">Inactive</option>
                </select>
              </div>
            </div>
            
          <input type="hidden" name="random_move" value="<?php echo $_SESSION['random_move']; ?>">
          <button type="submit" class="btn btn-success " name="AddHSNCode">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- /Edit Details Modal -->
<!-- delete Details Modal -->
<div class="modal fade" id="Modalss" aria-hidden="true" role="dialog">
  <div class="modal-dialog modal-dialog-centered  " role="document" >
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
  var status=$('#status').val();
  var dataTable = $('#employee-grid').DataTable( {
  "processing": true,
  "serverSide": true,
  "stateSave": true,
  columnDefs: [ { orderable: false, targets: [0] }],
  "aLengthMenu": [10],
  "aLengthMenu": [10,20,30,50,100,200],
  "ajax":{
  url :"return_func.php?part=All_HSN_Data", 
  type: "post",  // method  , by default get
  error: function(){  // error handling
  $(".employee-grid-error").html("");
  $("#employee-grid").append('<tbody class="employee-grid-error"><tr><th colspan="10">No data found in the server</th></tr></tbody>');
  $("#employee-grid_processing").css("display","none");
  }
  }
  });
  $(document).on("change", ".UploaderFile", function(e) {
  var fileExtension = ['jpeg', 'jpg', 'png'];
  if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
  $(this).val(''); 
  alert("Only formats are allowed : "+fileExtension.join(', '));
  }
  });
  $('.alert-success').fadeOut(2000); $('.alert-danger').fadeOut(2000);
  $(document).on("click", ".updateLinks", function(e) {
  //modalss.show();
  $('#Modalss').modal('show');
  var id=$(this).closest('tr').find('.id').val();
  jQuery.ajax({
  type:'POST',
  url:'return_func.php',
  data:'id='+id+'&part=hsncode_data_Update',
  dataType:'html',
  beforeSend: function(){
  $('.load_datas').html('Please Wait...');
  },
  success : function (responseData, status, XMLHttpRequest) {
  $('.load_datas').html(responseData);
  }
  });
  });
  $(document).on("click", ".deleteLinks", function(e) {
  $('#Modalss').modal('show');
  var id=$(this).closest('tr').find('.id').val();
  jQuery.ajax({
  type:'POST',
  url:'return_func.php',
  data:'id='+id+'&part=Delete_Lead_Data',
  dataType:'html',
  beforeSend: function(){
  $('.load_datas').html('Please Wait...');
  },
  success : function (responseData, status, XMLHttpRequest) {
  $('.load_datas').html(responseData);
  }
  });
  });
$(document).on("click", "#AddF", function(e) {
jQuery.ajax({
type:'POST',
url:'return_func.php',
data:'&part=Add_HSN_Code_Table_Part',
dataType:'html',
success : function (responseData, status, XMLHttpRequest) {
$('#myTableF').append(responseData);
}
});
});
$(document).on("click", "#AddFF", function(e) {
jQuery.ajax({
type:'POST',
url:'return_func.php',
data:'&part=Add_HSN_Code_Table_Part',
dataType:'html',
success : function (responseData, status, XMLHttpRequest) {
$('#myTableFD').append(responseData);
}
});
});
$(document).on("click", ".RemoveR", function(e) {
$(this).parents("tr").remove();
});
$(document).on("click", ".RemoveF", function(e) {
 var id=$(this).closest('tr').find('.hsnid').val();
 var $this=$(this);
  jQuery.ajax({
  type:'POST',
  url:'return_func.php',
  data:'id='+id+'&part=Remove_Hsn_Tax_item',
  dataType:'html',
  
  success : function (responseData, status, XMLHttpRequest) {
  $this.parents("tr").remove();
  }
  });	


});
</script>