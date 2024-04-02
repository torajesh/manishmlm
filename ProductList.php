<?php
$Page="Setting";
$InnPage="City";
include('header.php'); 
include('sidebar.php');

$random=rand(0000000,9999999);
if(isset($_POST['remove_lead']) && $_SESSION['random_move']==$_POST['random_move']) {
$query=mysqli_query($con,"delete from city_details where id='".$_POST['id']."'");
if($query) {
$msss="<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
<strong>Success!</strong> This City Removed Successfully.</div>";	
}
}

if(isset($_POST['AddCity']) && $_SESSION['random_move']==$_POST['random_move']) {
$query=mysqli_query($con,"insert into  city_details(state,city_name,status,add_time) 
values('".$_REQUEST['state']."','".$_REQUEST['city_name']."','".$_REQUEST['status']."','".date('d/m/Y H:i:s')."')");
if($query) {
$msss="<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
<strong>Success!</strong> City Added Successfully.</div>";	
}
}
if(isset($_POST['UpdateCity']) && $_SESSION['random_move']==$_POST['random_move']) {
$query=mysqli_query($con,"update city_details set state='".$_POST['state']."',city_name='".$_POST['city_name']."',status='".$_POST['status']."'  where id='".$_POST['id']."'");
if($query) {
$msss="<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
<strong>Success!</strong> City Updated Successfully.</div>";	
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
          <h3 class="page-title">Product List  
          <!-- <a class="btn btn-sm bg-primary mr-2 float-right text-white font-weight-bold" data-toggle="modal" href="#Filter_Part"> <i class="fe fe-filter"></i> Filter </a> -->
          <a class="btn btn-sm bg-success mr-2 float-right text-white font-weight-bold" href="aditedit_product.php"> <i class="fe fe-plus"></i> Add Product</a> 
          </h3>
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="Dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active">All Product List</li>
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
                  <th>Sr No</th>
                    <th>Product Code</th>
                    <th>Product Name</th>
                    <th>Product Category</th>
                    <th>MRP</th>
                    <th>WH Price</th>
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
<!-- /Main Wrapper --> 

<!-- /Edit Details Modal -->
<div class="modal fade" id="Filter_Part" aria-hidden="true" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-lg " role="document" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fe fe-filter"></i> Select to Apply Filter Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body">
        <form method="get" action="">
          <div class="row form-row">
            <!-- <div class="col-6">
              <div class="form-group">
                <label>State</label>
               <select class="form-control" name="state" id="state">
               <option value="">All State</option>
      				<?php
      				 $Bsqls=mysqli_query($con,"SELECT * from state_details where status='Y'");
      				  while($Brows=mysqli_fetch_array($Bsqls)){
      				  if($Brows['id']==$_GET['state']){ 
      				  echo "<option value='".$Brows['id']."' selected>$Brows[state_name]</option>"; 
      				  } else {
      				  echo "<option value='".$Brows['id']."'>$Brows[state_name]</option>";   
      				  }
      				  }
      				  ?>
                </select>
              </div>
            </div> -->
             <div class="col-6">
              <div class="form-group">
                <label>Status</label>
               <select class="form-control" name="status" id="status">
               <option value="">All Status</option>
        				<?php
        					$arr=array('Active','Inactive');
        					foreach($arr as $status){
        					if($status==$_GET['status']){
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
          <button type="submit" class="btn btn-success btn-block" name="Search">Apply Filter</button>
        </form>
      </div>
    </div>
  </div>
</div>
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
/*var state=$('#state').val();*/
var status=$('#status').val();
var dataTable = $('#employee-grid').DataTable( {
"processing": true,
"serverSide": true,
"stateSave": true,
columnDefs: [ { orderable: false, targets: [0] }],
"aLengthMenu": [10],
"aLengthMenu": [10,20,30,50,100,200],
"ajax":{
url :"return_func.php?status="+status+"&part=All_Product_List", 
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
url:'return.php',
data:'id='+id+'&part=City_data_Update',
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
</script>
