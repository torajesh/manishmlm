<?php
include("config.php");
if($_SESSION['MANMID']==''){ header("location:index.php"); }
$UserArr=Get_Fetch_Data($con,$_SESSION['MANMID'],'All','admin_login');
if($UserArr['photo']!=''){ $Photos="user/$UserArr[photo]"; } else { $Photos="images/noimg.png"; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<title>Manmesh MLM Work</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/css/lightbox.min.css">
<!-- Favicon -->
<link rel="shortcut icon" type="image/x-icon" href="img/fav.png">
 <!-- Bootstrap CSS -->
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
 <!-- Fontawesome CSS -->
<link rel="stylesheet" href="assets/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
 <!-- Feathericon CSS -->
<link rel="stylesheet" href="assets/css/feathericon.min.css">
<link rel="stylesheet" href="assets/plugins/morris/morris.css">
 <!-- Main CSS -->
 <link rel="stylesheet" href="assets/css/select2.min.css">
<link rel="stylesheet" href="assets/css/style.css">
 <!--[if lt IE 9]>
			<script src="assets/js/html5shiv.min.js"></script>
			<script src="assets/js/respond.min.js"></script>
 <![endif]-->
<style>
body{background-color: #f9f9f9;}
 
.table-striped tbody tr:nth-of-type(odd) {
    background-color: rgb(235 235 235 / 24%);
}
 .table thead th{  background: #556d7e !important;white-space: nowrap;padding: 4px 6px !important;}
.table thead tr th {
    background: unset;
    color: #fff;
    font-weight: normal !important;
}

.table thead th:nth-child(1) {
  -webkit-border-top-left-radius: 4px;
-moz-border-radius-topleft: 4px;
border-top-left-radius: 4px;
text-align:left;
}
.table thead th:nth-last-child(1) {
-webkit-border-top-right-radius: 4px;
-moz-border-radius-topright: 4px;
border-top-right-radius: 4px;
text-align:right;
}
#DataTables_Table_0_length {
    display: none;
}
.modal-content{border-radius: .5rem !important;width: 720px;}
.modal-body .table td,.modal-body .table th {
    padding: 5px 6px !important;    
}
.modal-header {
    background: #7fd181 !important;
    color: #fff;
    width: 720px;
}
.table.table-center td{box-shadow: 0px 5px 0px #f1efef;}
.page-link{line-height: 1;}
.page-item.active .page-link {
    background-color: #8c8c91;
    border-color: #224d24;
	    line-height: 16px;
}
.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    color: white !important;
    border: 1px solid #fff;
    background-color: #fff;
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #fff), color-stop(100%, #fff));
    background: -webkit-linear-gradient(top, #fff 0%, #fff 100%);
    background: -moz-linear-gradient(top, #fff 0%, #fff 100%);
    background: -ms-linear-gradient(top, #fff 0%, #fff 100%);
    background: -o-linear-gradient(top, #fff 0%, #fff 100%);
    background: linear-gradient(to bottom, #fff 0%, #fff 100%);
}
.dataTables_wrapper .dataTables_paginate .paginate_button {
    padding: 0px !important;
}
a.page-link:hover {
    background-color: #8c8c91 !important;
    border-color: #8c8c91 !important;
}
.page-item.disabled .page-link {
    color: #8c8c91 !important;
    pointer-events: none;
    cursor: auto;
    background-color: #fff;
    border-color: #8c8c91 !important;
}
.row{margin-right: 0px !important;    margin-left:  0px !important;}
#employee-grid_wrapper .row{margin-right: 0px !important;    margin-left:  0px !important;}
#employee-grid_wrapper .form-control { border: 1px solid #bcbfc1;}
#employee-grid_length label,div#employee-grid_filter label{visibility: hidden;    line-height: 0;}
select.custom-select.custom-select-sm.form-control.form-control-sm {    visibility: visible;}
input.form-control.form-control-sm {    visibility: visible;}
input.form-control.form-control-sm:after {
  content: 'Enter your number';
  position: absolute;
  left: 5px;
  top: 0;
  color: #bbb;
}

#employee-grid_filter label {
  position: relative;
}

#employee-grid_filter label:after {
  content: 'Enter your number';
  position: absolute;
  left: 5px;
  top: 0;
  color: #bbb;
}
label {
    font-weight: 600;
    color: #000;
}
.form-control,.select2-container .select2-selection--single{    border: 1px solid #a5a9a463;}
</style>
<style>

.header {
        background:#7fd181;
    border-bottom: 1px solid #7fd181;
}
.sidebar {
    background: #0a0909;
	box-shadow: 0px 8px 10px rgba(0, 0, 0, 0.1);
    bottom: 0;
}

.sidebar-menu > ul > li > a{    border-radius: 0px;}
.sidebar-menu li.active a {
	 background-image: linear-gradient(to left,#9f9595,#7fd181);
    color: #fff; border-radius: 6px;
}
.slimScrollDiv, .sidebar {
    background: #fff;
}
.sidebar-menu li a {
    color:#6b6464;
    font-size: 16px;
    font-weight: 400;
}
.sidebar-menu ul li a i {
    color: #636262;
}
.sidebar-menu ul li a i img{
    width:100%;
	filter: contrast(10%);
}
.sidebar-menu li.active a {
   background-image: linear-gradient(to left,#9f9595,#7fd181);
    color: #fff;
}
.sidebar-menu ul li.active a i {
    color: #fff;
}
.sidebar-menu > ul > li > a:hover {
   background-image: linear-gradient(to left,#9f9595,#7fd181);
    color: #fff;
    border-radius: 6px;
}
.page-wrapper:after {
    content: "";
    height: 191px;
   
    position: absolute;
    z-index: -1;
    width: 100%;
    top: 0;
    background:transparent;
}
.page-title{    color: #000;}
.page-wrapper > .content {
    padding: 1.875rem 1rem 0;
}
.page-header .breadcrumb{display: flex;    align-items: center;}
.breadcrumb-item.active {
       color:#272829!important;
    font-weight: 200;
    font-size: 14px;
    line-height: 2;
}
.breadcrumb-item+.breadcrumb-item::before{    color:#000000b0;}
.breadcrumb-item li{color: #fff;
    font-weight: 200;
    font-size: 14px;
    line-height: 2;}
.card .card-header {
    background-color: #fff0;
    border-bottom: 1px solid #eaeaea;
}	
.card{border-radius: 7px;}
.card .card-header .card-title {
    margin-bottom: 0;
    font-size: 1.125rem;
    line-height: 1.2;
    font-weight: 500;
}
.dash-icon .card-body {
    padding: .7rem;
}
 
.dash-widget-icon {
    align-items: center;
    border-radius: 4px;
    color: #fff;
    display: inline-flex;
    font-size: 1.875rem;
    height: 70px;
    justify-content: center;
    line-height: 48px;
    text-align: center;
    width: 70px;
    background: #2b4f32;
    position: relative;
    box-shadow: 0 2px 10px rgba(26, 122, 16, 0.50)!important;
}
.icon {
    position: absolute;
    width: 70px;
	    opacity: .5;
}

.dash-widget-icon i.fe{
    font-size: 3.5rem;
    color: #afcb16;
    z-index: 999;
}
h6.text-muted {
    font-size: 1.1rem;
    font-weight: 500;
    font-family: 'Roboto', sans-serif;
    padding-top: 15px;
    color: #383838 !important;
	padding-left: 10px;
}

h6.text-muted a{ color: #383838 !important;} 
.dash-count {
    font-size: 18px;
    margin-left: auto;
    position: absolute;
    right: 11px;
    top: 6px;
}
.dash-widget-header {
    
    justify-content: space-between;
}
.dash-widget-info h3 {
    margin-bottom: 0px;
    font-family: 'Roboto', sans-serif;
    font-weight: 400;
    display: flex;
    justify-content: space-between;
    
    font-size: 1.2rem;
    text-align: center;
}
.dash-widget-info h3 span {
    flex-basis: 100%;
	text-align:left;
	
}
.dash-widget-info h3 > span{padding:0px 10px;}
.dash-widget-info h3 > span:nth-last-child(2) {
  flex-basis: 165px;
  border-right:1px solid #9f9f9f;
}

 
 
.active {
    font-size: 14px;
    font-weight: 300;
    color: #7b7373 !important;
    line-height: 2;
}
 .card-table .table th{padding: .5rem 0.75rem;}
 .page-header .breadcrumb a {
    color:#0b0c0c;
}
.table.table-center td::after {
    position: absolute;
    content: "";
    width: 1px;
    height: 70%;
    background: #ccc;
    right: 0px;
	opacity: .5;
   /*  box-shadow: 2px 1px 1px #201313; */
    top: 20%;
}

.table.table-center td::after{}
.table.table-center td{position: relative;}
.card-table .card-body .table tr td:last-child::after,.table.table-center td:last-child::after{content: none;}
.card-table .card-body .table tr td:first-child, .card-table .card-body .table tr th:first-child {
    padding-left: 1rem;
}
.card-table .card-body .table tr td:first-child,.table.table-center td:first-child{    border-left: 4px solid #f3f3f3;}
.card-table .card-body .table tr td:last-child,.table.table-center td:last-child{    border-right: 2px solid #f3f3f3;}

.modal-header  .close {
    float: right;
    font-size: 2.5rem;
    font-weight: 300;
    line-height: 1;
    color: #fff;
    text-shadow: 0 1px 0 #fff;
    opacity: .7;
	 padding: .5rem;
    margin: -1rem -1rem -1rem auto;
}
.modal-body .form-group {
    margin-bottom: 1rem;
} 
.table.table-center td {
    
    padding: 4px 5px;
}
.pend {
    font-size: 11px;
    padding: 0px 4px;
    margin-right: 5px;
}
 
a.logo.logo-small img{filter:unset !important;}
.title {
    float: left;
    white-space: nowrap;
    line-height: 1;
    font-weight: 600;
    font-size: 14px;
    clear: both;
    width: 100%;
    color: #263467;
    text-transform: uppercase;
}
span.sub-title {
    font-size: 12px;
    float: left;
    line-height: 1.5;
	width:100%;
}
.fs-14{font-size:14px;}
.fs-13{font-size:13px;}
.fs-12 {
    font-size: 14px;
    color: #1f1c1c;
    font-family: arial;
    line-height: 1.5;
    letter-spacing: 1px;
    font-weight: 500;
}
.input-small{background: #fff !important;}
.fs-11{font-size:11px;}
.fs-10{font-size:10px;}
table#employee-grid {
    width: 100% !important;
}
.pro-img{height: 40px; width: 40px;
border-color: aliceblue !important; padding: 1px; border: 1px solid;  border-radius: 50%; box-shadow: 0px 0px 5px #ccc;}
 
.created_by{line-height: 1.1;}
img.pro-img {
    margin-right: 5px;
}
.col-form-label{font-weight: 600;    color: #000;}
.table-hover tbody tr:hover{background-color: #f7f7f7 !important;}

.col-sm-12 .card .card-body {
    padding: 1.5rem 0.5rem;
}
.sidebar-menu li a:hover {
    color: #6b6464;
}
#toggle_btn {
    color: #f3f3f3;
    height: 54px;
    background: #ffffff30;
    border-radius: 50%;
    width: 54px;
}

@media only screen and (max-width: 1024px) {
.table.table-center td{white-space: nowrap;}
.active {
    font-size: 12px;
    font-weight: 300;
    color: #7b7373 !important;
    line-height: 1.5;
}
h6.text-muted a {
    color: #383838 !important;
    font-size: 16px;
    line-height: 1;
}
}
@media only screen and (max-width: 600px) {
.page-wrapper > .content {
    padding: 1.875rem 0rem 0;
}
table[class^="dataTable"] td{
 white-space:nowrap;
}
.table.table-center td {
    padding: 4px 5px;
    white-space: nowrap;
}
.third,.first{    white-space: nowrap;} 
h3.page-title {
    font-size: 1rem;
    float: left;
    width: 100%;
}
.card-body >.row .col-md-12{padding:0px;}
.page-header .breadcrumb{display: none;}
h3.page-title{font-size: 1rem;}
}
.form-control {
   border: 1px solid #ccc !important;
}
.header .header-left{background:#7fd181;border-bottom: 1px solid #7fd181;}

.modal-body fieldset {
    font-family: sans-serif;
    border-top: 1px solid #00489c;
    background: #fff;
    border-radius: 0;
    padding: 9px;
}

.modal-body fieldset legend {
    background: #e4e4e4 !important;
    box-shadow: unset !important;
    color: #000 !important;
    padding: 5px 10px;
    font-size: 16px;
    border-radius: 5px;
    box-shadow:unset;
    margin-left: 20px;
    width: auto;
}
.input-small {
    border: 1px solid #dbdbdb !important;
	font-size: 14px;
    height: 24px;
    padding: 0px 4px;
    border: 0px;
    margin: 2px;
}
.nowrap{white-space: nowrap;}
.sidebar-menu > ul > li.active > a:hover {
    background-color: #7fd181;
    color: #fff;
}
.modal-content{border: 0px;}
fieldset legend {
    background: #e4e4e4 !important;
    box-shadow: unset !important;
    color: #000 !important;
}

</style> 
</head>
<body>

<!-- Main Wrapper -->
<div class="main-wrapper"> 
  
  <!-- Header -->
  <div class="header"> 
    
    <!-- Logo -->
    <div class="header-left"> <a href="index.php" class="logo"> <img src="images/manmesh_logo.jpeg" alt="Logo">    </a> <a href="Dashboard.php" class="logo logo-small"> <img src="images/manmesh_logo.jpeg" alt="Logo" width="30" height="30"> </a> </div>
    <!-- /Logo --> 
    
    <a href="javascript:void(0);" id="toggle_btn"> <i class="fe fe-text-align-left"></i> </a>
    <div class="top-nav-search">
     <!-- <form>
        <input type="text" class="form-control" placeholder="Search here">
        <button class="btn" type="submit"><i class="fa fa-search"></i></button>
      </form>-->
    </div>
    
    <!-- Mobile Menu Toggle --> 
    <a class="mobile_btn" id="mobile_btn"> <i class="fa fa-bars"></i> </a> 
    <!-- /Mobile Menu Toggle --> 
    
    <!-- Header Right Menu -->
    <ul class="nav user-menu d-flex align-items-center">
      <!-- Notifications -->
      <?php
	 /* $ANsql=mysqli_query($con,"select count(id) as countss from team_notification where user_type='Admin' and status=''");
	  $ANcount=mysqli_fetch_array($ANsql);*/
	  ?>
      <li class="nav-item dropdown noti-dropdown"> <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown"> <i class="fe fe-bell"></i> <span class="badge badge-pill">0</span> </a>
        <div class="dropdown-menu notifications">
          <div class="topnav-dropdown-header"> <span class="notification-title">Notifications</span> <a href="Notification.php" class="clear-noti"> View All </a> </div>
          
          <div class="noti-content">
            <ul class="notification-list">
      <?php
	 /* $ANTsql=mysqli_query($con,"select * from team_notification where user_type='Admin' and status='' order by id desc limit 8");
	  while($ANRow=mysqli_fetch_array($ANTsql)){
	  if($ANRow['purpose']=='Order'){
	  $OrD=Get_Fetch_Data($con,$ANRow['bid'],'id,uid','order_details');
	  $uid=$OrD['uid']; $Pages="NotificationDetail.php";
	  } else { $uid=$ANRow['bid']; $Pages="AllDealers.php"; }
	  $UserD=Get_Fetch_Data($con,$uid,'id,photo','user_details');
	  if($UserD['photo']!=''){ $Nphoto="$URLS/Banner/$UserD[photo]"; } else {  $Nphoto="$URLS/Banner/noimages.jpg"; }*/
	  ?>
              <li class="notification-message"> <a href="<?php echo $Pages; ?>?oid=<?php echo $ANRow['bid']; ?>&id=<?php echo $ANRow['id']; ?>">
                <div class="media"> <span class="avatar avatar-sm"> <img class="avatar-img rounded-circle" alt="User Image" src="<?php echo $Nphoto; ?>"> </span>
                  <div class="media-body">
                    <p class="noti-details"><span class="noti-title">Test</span></p>
                    <p class="noti-details"><?php echo $ANRow['message']; ?></p>
                    <p class="noti-time"><span class="notification-time"><?php echo $ANRow['send_time']; ?></span></p>
                  </div>
                </div>
                </a> </li>
             
            </ul>
          </div>
          
          <!-- <div class="topnav-dropdown-footer"> <a href="Notification.php">View all Notifications</a> </div> -->
        </div>
      </li>
      <!-- /Notifications --> 
      
      <!-- User Menu -->
      <li class="nav-item dropdown has-arrow"> <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown"> <span class="user-img"><img class="rounded-circle" src="<?php echo $Photos; ?>" width="31" alt="Ryan Taylor"></span> </a>
        <div class="dropdown-menu">
          <div class="user-header">
            <div class="avatar avatar-sm"> <img src="<?php echo $Photos; ?>" alt="User Image" class="avatar-img rounded-circle"> </div>
            <div class="user-text">
              <h6><?php echo substr($UserArr['contact_name'],0,13); ?></h6>
              <p class="text-muted mb-0"><?php echo $UserArr['designation']; ?></p>
            </div>
          </div>
          <a class="dropdown-item" href="MyProfile.php">My Profile</a>          
          <a class="dropdown-item" href="logout.php">Logout</a> </div>      
      </li>
      <!-- /User Menu -->      
    </ul>
    <!-- /Header Right Menu -->     
  </div>
  
  


  