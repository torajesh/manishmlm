<?php
$Page="Setting";
$InnPage="Area";
include('header.php'); 
include('sidebar.php');

$random=rand(0000000,9999999);
if(isset($_POST['remove_lead']) && $_SESSION['random_move']==$_POST['random_move']) {
$query=mysqli_query($con,"DELETE from membership_level where id='".$_POST['id']."'");
if($query) {
$msss="<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
<strong>Success!</strong> This Area Removed Successfully.</div>";	
}
}
if(isset($_POST['UpdateArea']) && $_SESSION['random_move']==$_POST['random_move']) {
$query=mysqli_query($con,"UPDATE membership_level set level_name='".$_POST['level_name']."', status='".$_POST['status']."'  where id='".$_POST['id']."'");
if($query) {
$msss="<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
<strong>Success!</strong> Area Updated Successfully.</div>";	
}
}
if(isset($_POST['AddArea']) && $_SESSION['random_move']==$_POST['random_move']) {
$Check=Get_Count_Data($con,$_POST['level_name'],'level_name','membership_level');
if($Check==0){
$query=mysqli_query($con,"INSERT INTO membership_level(level_name,status,add_time) 
values('".$_POST['level_name']."','".$_POST['status']."','".date('d/m/Y H:i:s')."')");

if($query) {
$msss="<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
<strong>Success!</strong> MemberShip Level Added Successfully.</div>";	
}
} else {
$msss="<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
<strong>Success!</strong> This MemberShip Level already exists.</div>";	
}
}
$_SESSION['random_move']=$random; 
?>
<!-- Page Wrapper -->
<style>
.Capitalize{ text-transform:uppercase; }
.first{ text-transform:uppercase; } .create_time{ font-size:11px;    white-space: nowrap; } 
.required{ color:#F00; font-weight:bold; }
</style>
<div class="page-wrapper">
  <div class="content container-fluid"> 
    
    <!-- Page Header -->
    <div class="page-header" style="margin-bottom:0px;">
      <div class="row">
        <div class="col">
          <h3 class="page-title">MemberShip Level
          <a class="btn btn-sm bg-success mr-2 float-right text-white font-weight-bold" data-toggle="modal" href="#AddBox"> <i class="fe fe-plus"></i> Add MemberShip Level </a> 
          </h3>
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="Dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active">All MemberShip Level List</li>
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
                   <th>Sr. No</th>
                    <th>MemberShip</th>
                    <th>Status</th>
                    <th>Add Time</th>
                    <th>Action</th>
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



<div class="modal fade" id="AddBox" aria-hidden="true" role="dialog">
  <div class="modal-dialog modal-dialog-centered  " role="document" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fe fe-plus"></i> Create New MemberShip Level</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body">
        <form method="post" action="">
          <div class="row form-row">
            <div class="col-6">
              <div class="form-group">
                <label> MemberShip Name</label>
                <input type="text" class="form-control" required name="level_name" placeholder="Enter Level Name" autocomplete="off">
              </div>
            </div>
            
            <div class="col-6">
              <div class="form-group">
                <label>Status</label>
               <select class="form-control" name="status">
      				<?php
                       $arr=array('Active','Inactive');
      					foreach($arr as $status){
      					echo "<option value=".$status.">$status</option>";  
      					}
                ?>
                </select>
              </div>
            </div>
          </div>
          <input type="hidden" name="random_move" value="<?php echo $_SESSION['random_move']; ?>">
          <button type="submit" class="btn btn-success " name="AddArea">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Edit Details Modal -->


<!-- /Edit Details Modal -->

<!-- delete Details Modal -->
<div class="modal fade" id="Modalss" aria-hidden="true" role="dialog">
  <div class="modal-dialog modal-dialog-centered  modal-lg" role="document" >
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
/*var from=$('#from').val();
var to=$('#to').val();
var status=$('#status').val();*/
var dataTable = $('#employee-grid').DataTable( {
"processing": true,
"serverSide": true,
"stateSave": true,
columnDefs: [ { orderable: false, targets: [0] }],
"aLengthMenu": [10],
"aLengthMenu": [10,20,30,50,100,200],
"ajax":{
url :"return_func.php?part=All_membership_level_Data",  
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
  $('#Modalss').modal('show');
  var id=$(this).closest('tr').find('.id').val();
  jQuery.ajax({
  type:'POST',
  url:'return.php',
  data:'id='+id+'&part=membership_level_data_Update',
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
  url:'return.php',
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
$(document).on("change", "#state", function(e) {
  var state=$(this).val();
  jQuery.ajax({
  type:'POST',
  url:'return.php',
  data:'state='+state+'&part=Get_state_plan',
  dataType:'html',
  beforeSend: function(){
  $('#price_plan').html('<option>Please Wait...</option>');
  },
  success : function (responseData, status, XMLHttpRequest) {
  $('#price_plan').html(responseData);
  }
  });
});
$(document).on("change", "#stateS", function(e) {
  var state=$(this).val();
  jQuery.ajax({
  type:'POST',
  url:'return.php',
  data:'state='+state+'&part=Get_state_plan',
  dataType:'html',
  beforeSend: function(){
  $('#price_planS').html('<option>Please Wait...</option>');
  },
  success : function (responseData, status, XMLHttpRequest) {
  $('#price_planS').html(responseData);
  }
  });
});

$('.Business').hide();
$('#Customer').on('click', function() {
var user_type=$(this).val();
$(".Businessfld").attr("required", false);
$('.Business').hide();
});
$('#Business').on('click', function() {
var user_type=$(this).val();
$('.Business').show();
$(".Businessfld").attr("required", true);
});
$(document).on("click", "#Customers", function(e) {
var user_type=$(this).val();
$(".BusinessfldS").attr("required", false);
$('.BusinessS').hide();
});
$(document).on("click", "#Businesss", function(e) {
var user_type=$(this).val();
$('.BusinessS').show();
$(".BusinessfldS").attr("required", true);
});
$('.datepickers').datetimepicker({
//language:  'fr',
weekStart: 1,
todayBtn:  1,
autoclose: 1,
todayHighlight: 1,
startView: 2,
minView: 2,
forceParse: 0,
format: "dd/mm/yyyy"
});
</script>
