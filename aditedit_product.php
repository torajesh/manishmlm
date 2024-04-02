<?php
$Page="OurProduct";
$InnPage="AddEditProduct";
include('header.php'); 
include('sidebar.php');

$random=rand(0000000,9999999);
if(isset($_POST['AddEditProduct']) && $_SESSION['random_move']==$_POST['random_move']) {
$errorMsg ='';

if(empty($_POST['slno'])) {
	$querys = mysqli_query($con, "SELECT count(id) as countss FROM product_details where catg_slno='".$_POST['catg_slno']."' and product_name='".mysqli_real_escape_string($con,$_POST['product_name'])."' ");
	$row=mysqli_fetch_array($query); 
	$Check = $row['countss'];
	if($Check==0) {
		$ProductCode = ProductCode($con);
		$sqls="INSERT INTO product_details SET ProductCode = '".$ProductCode."', catg_slno='".$_POST['catg_slno']."', product_name = '".mysqli_real_escape_string($con,$_POST['product_name'])."', hsncode = '".$_POST['hsncode']."',  mrp = '".$_POST['mrp']."', ws_rate = '".$_POST['ws_rate']."', stock_qty = '".$_POST['stock_qty']."', status = '".$_POST['status']."', Add_time='".date("d/m/Y h:i:s")."' ";
		//echo $sqls."@@";
		$query=mysqli_query($con, $sqls);
		$slno = mysqli_insert_id($con);
	}
}
else {
	$querys = mysqli_query($con, "SELECT count(id) as countss FROM product_details where catg_slno='".$_POST['catg_slno']."' and product_name='".mysqli_real_escape_string($con,$_POST['product_name'])."' and  id!='".$_POST['slno']."' ");
	$row=mysqli_fetch_array($query); 
	$Check = $row['countss'];     	
	if($Check==0) {
		
		$sqls="UPDATE product_details SET catg_slno='".$_POST['catg_slno']."', product_name = '".mysqli_real_escape_string($con,$_POST['product_name'])."', hsncode = '".$_POST['hsncode']."',  mrp = '".$_POST['mrp']."', ws_rate = '".$_POST['ws_rate']."', stock_qty = '".$_POST['stock_qty']."', status = '".$_POST['status']."', Upd_time='".date("d/m/Y h:i:s")."' WHERE id='".$_POST['slno']."' ";
		echo $sqls."@@";
		$query=mysqli_query($con, $sqls);
		$slno = $_POST['slno'];
	}
}

if(!empty($slno)) {

	$errorMsg='';
	$extension_allow = array('jpeg','jpg','png');

	if(!empty($_FILES['prodImg']['name'])) {
		$ext = strtolower(pathinfo($_FILES['prodImg']['name'],PATHINFO_EXTENSION));
		if(!in_array($ext, $extension_allow)) {
			$errorMsg .='<br>Only Upload JPEG, JPG, PNG Format in Photo<br>';
		}

		if(empty($errorMsg)) {
			$ext = pathinfo($_FILES['prodImg']['name'],PATHINFO_EXTENSION); 
			$attachfile = round(microtime(true)).'_prod.'.$ext;            
			$image_upload_path = BASEDIR."/product/".$attachfile;
			move_uploaded_file($_FILES['prodImg']['tmp_name'], $image_upload_path);
			mysqli_query($con, "UPDATE product_details SET product_img='".$attachfile."' WHERE id='".$slno."'");
		}
		else {
			$msss="<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<strong>Error!</strong> Showing Error ".$errorMsg.".</div>"; 
		}
	}
	$msss="<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
	<strong>Success!</strong>Product Detail has updated successfully</div>";
}
}
$_SESSION['random_move']=$random; 
$prodArr = Get_Fetch_Data($con,$_GET['slno'], 'All', 'product_details');
?>
<div class="page-wrapper">
  <div class="content container-fluid"> 
    
    <!-- Page Header -->
    <div class="page-header" style="margin-bottom:0px;">
      <div class="row">
        <div class="col">
          <h4 class="page-title">Add | Edit Product Product</h4>
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="Dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="ProductList.php">Product List</a></li>
            <li class="breadcrumb-item active">Add Product Product</li>
          </ul>
		  <?php if(isset($msss)){ echo $msss; }?>
        </div>
      </div>
    </div>
    <!-- /Page Header -->
   
	<form method="post" action="" enctype="multipart/form-data">
	
	<div class="p-4">
	<div class="row form-row">
	<div class="col-4 col-sm-4">
	<div class="form-group">
	<label> Product Category<span class="text-danger">*</span></label>
	<select class="form-control select2" name="catg_slno">
	<option value="">Select Category</option>
	<?php
	$CatgSqls=mysqli_query($con,"SELECT * from category_details where status='Active'");
	while($Crows=mysqli_fetch_array($CatgSqls)){
		if($prodArr['catg_slno']==$Crows['id']) {
			echo "<option value='".$Crows['id']."' selected>$Crows[catg_name]</option>";
		}
		else {
			echo "<option value='".$Crows['id']."'>$Crows[catg_name]</option>";
		}   
	}
	?>
	</select>
	</div>
	</div>
	
	<div class="col-4 col-sm-4">
	<div class="form-group">
	<label> Product Name<span class="text-danger">*</span></label>
	<input type="text" class="form-control" placeholder="Enter Product Name" name="product_name" value="<?php echo $prodArr['product_name'];?>" required>
	</div>
	</div>

	<div class="col-4 col-sm-4">
	<div class="form-group">
	<label> HSN Code<span class="text-danger">*</span></label>
	<select class="form-control select2" name="hsncode">
	<option value="">Select HSN</option>
	<?php
	$hsnSqls=mysqli_query($con,"SELECT * from hsnlist where status='Active'");
	while($hsnrows=mysqli_fetch_array($hsnSqls)){
		if($prodArr['hsncode']==$hsnrows['id']) {
			echo "<option value='".$hsnrows['id']."' selected>$hsnrows[hsncode]</option>";
		}
		else {
			echo "<option value='".$hsnrows['id']."'>$hsnrows[hsncode]</option>";
		}   
	}
	?>
	</select>	
	</div>
	</div>

	<div class="col-4 col-sm-4">
	<div class="form-group">
	<label> MRP<span class="text-danger">*</span></label>
	<input type="number" class="form-control numval" placeholder="Enter MRP" name="mrp" value="<?php echo $prodArr['mrp'];?>" required>
	</div>
	</div>

	<div class="col-4 col-sm-4">
	<div class="form-group">
	<label> Wholesale Price<span class="text-danger">*</span></label>
	<input type="number" class="form-control numval" placeholder="Enter Wholesale Price" name="ws_rate" value="<?php echo $prodArr['ws_rate'];?>" required>
	</div>
	</div>

	<div class="col-4 col-sm-4">
	<div class="form-group">
	<label> In Stock<span class="text-danger">*</span></label>
	<input type="number" class="form-control numval" placeholder="Enter In Stock" name="stock_qty" value="<?php echo $prodArr['stock_qty'];?>" required>
	</div>
	</div>

	<div class="col-4 col-sm-4">
	<div class="form-group">
	<label> Upload Product Images (W:270px H:220px)</label>
	<input type="file" class="form-control" name="prodImg">
	</div>
	</div>

	<div class="col-4 col-sm-4">
	<div class="form-group">
	<label> Display Status<span class="text-danger">*</span></label>
	<select class="form-control" name="status" required>      
      <option value="Active" <?php echo ($_POST['status']=='Active')?('selected'):('')?>>Active</option>
      <option value="InActive" <?php echo ($_POST['status']=='InActive')?('selected'):('')?>>InActive</option>
      </select>
	</div>
	</div>

	
	<?php
	if(!empty($prodArr['product_img'])) {
		?>
		<div class="col-4 col-sm-6">
		<div class="form-group">
		<img src="product/<?php echo $prodArr['product_img'];?>" style="width:270px;height:220px;">
		</div>
		<label> Product Image</label>
		</div>
		<?php
	}
	/*else {
		?>
		<img src="product/<?php echo $prodArr['product_img'];?>" style="width:270px;height:220px;">
		<?php
	}*/
	?>
	</div>

	<hr>
	<input type="hidden" name="random_move" value="<?php echo $_SESSION['random_move']; ?>">
	<input type="hidden" name="slno" value="<?php echo $_REQUEST['slno']; ?>">      
	<input type="hidden" name="AddEditProduct" value="Y">
	<button type="submit" class="btn btn-success" name="Submit">SUBMIT</button>

	</div>
	</form>    

</div>
</div>

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
</script>
<?php