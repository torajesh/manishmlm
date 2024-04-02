<?php
$Page="OurProduct";
$InnPage="ProductCategory";
include('header.php'); 
include('sidebar.php');
$random=rand(0000000,9999999);
if(isset($_POST['remove_lead']) && $_SESSION['random_move']==$_POST['random_move']) {
  $query=mysqli_query($con,"DELETE from category_details where id='".$_POST['id']."'");
  if($query) {
    $msss="<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
    <strong>Success!</strong> This Category Removed Successfully.</div>";	
  }
}

if(isset($_POST['AddCategory']) && $_SESSION['random_move']==$_POST['random_move']) {
$query=mysqli_query($con,"INSERT INTO category_details(catg_name,status,add_time) 
values('".$_REQUEST['catg_name']."','".$_REQUEST['status']."','".date('d/m/Y H:i:s')."')");
if($query) {
$msss="<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
<strong>Success!</strong> Category Added Successfully.</div>";	
}
}
if(isset($_POST['UpdateCategory']) && $_SESSION['random_move']==$_POST['random_move']) {
$query=mysqli_query($con,"UPDATE category_details set catg_name='".$_POST['catg_name']."', status='".$_POST['status']."' where id='".$_POST['id']."' ");
if($query) {
$msss="<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
<strong>Success!</strong> Category Updated Successfully.</div>";	
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
          <h5 class="page-title">Product Category 
          <!-- <a class="btn btn-sm bg-primary mr-2 float-right text-white font-weight-bold" data-toggle="modal" href="#Filter_Part"> <i class="fe fe-filter"></i> Filter </a> -->
          <a class="btn btn-sm bg-success mr-2 float-right text-white font-weight-bold" data-toggle="modal" href="#edit_details"> <i class="fe fe-plus"></i> Add Category </a> 
          </h5>
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="Dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active">All Product Category </li>
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
                    <th>Category Name</th>
                    <th>No of Products</th> 
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
<!-- Edit Details Modal -->
<!-- /Edit Details Modal -->

<div class="modal fade" id="edit_details" aria-hidden="true" role="dialog">
  <div class="modal-dialog modal-dialog-centered  " role="document" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Create New Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body">
        <form method="post" action="" enctype="multipart/form-data">
          <div class="row form-row">
          
            <div class="col-6 col-sm-6">
              <div class="form-group">
                <label> Category Name<span class="text-danger">*</span></label>
                <input type="text" class="form-control" placeholder="Enter Category Name" name="catg_name" required>
              </div>
            </div>
            
              <div class="col-6 col-sm-6">
              <div class="form-group">
              <label>Status<span class="text-danger">*</span></label>
              <select class="form-control" name="status">
              <option value="Active">Active</option>
              <option value="Inactive">Inactive</option>
              </select>
              </div>
              </div>
          </div>
          <input type="hidden" name="random_move" value="<?php echo $_SESSION['random_move']; ?>">
          <button type="submit" class="btn btn-success " name="AddCategory">Add Category</button>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- delete Details Modal -->
<div class="modal fade" id="ViewModals" aria-hidden="true" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document" >
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
/*var state=$('#state').val();
var status=$('#status').val();*/
var dataTable = $('#employee-grid').DataTable( {
"processing": true,
"serverSide": true,
"stateSave": true,
columnDefs: [ { orderable: false, targets: [0] }],
"aLengthMenu": [10],
"aLengthMenu": [10,20,30,50,100,200],
"ajax":{
url :"return_func.php?part=All_Category_List", 
type: "post",  // method  , by default get
error: function(){  // error handling
$(".employee-grid-error").html("");
$("#employee-grid").append('<tbody class="employee-grid-error"><tr><th colspan="10">No data found in the server</th></tr></tbody>');
$("#employee-grid_processing").css("display","none");
}
}
});

$(document).on("click", ".ViewDataLinks", function(e) {
  $('#ViewModals').modal('show');
  var id=$(this).closest('tr').find('.id').val();
  jQuery.ajax({
  type:'POST',
  url:'return_func.php',
  data:'id='+id+'&part=Member_Data_View',
  dataType:'html',
  beforeSend: function(){
  $('.load_datas').html('Please Wait...');
  },
  success : function (responseData, status, XMLHttpRequest) {
  $('.load_datas').html(responseData);
  }
  });
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
$('#ViewModals').modal('show');
var id=$(this).closest('tr').find('.id').val();
jQuery.ajax({
type:'POST',
url:'return_func.php',
data:'id='+id+'&part=Category_data_Update',
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
$('#ViewModals').modal('show');
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
</script>
