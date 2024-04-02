<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<title> Manmesh MLM Work - Login</title>
<!-- Favicon -->
<!-- <link rel="shortcut icon" type="image/x-icon" href="img/fav.png"> -->
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="<?php echo ROOTURL;?>/assets/css/bootstrap.min.css">
<!-- Fontawesome CSS -->
<link rel="stylesheet" href="<?php echo ROOTURL;?>/assets/css/font-awesome.min.css">
<!-- Main CSS -->
<link rel="stylesheet" href="<?php echo ROOTURL;?>/assets/css/style.css">
<link rel="stylesheet" href="<?php echo ROOTURL;?>/assets/css/feathericon.min.css">
<link rel="stylesheet" href="login/jsRapClock.css" />
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="login/jsRapClock.js"></script>
<!--[if lt IE 9]>
<script src="assets/js/html5shiv.min.js"></script>
<script src="assets/js/respond.min.js"></script>
<![endif]-->

 
<style>
.back {
	background:#F6FDC3;
	position:relative;
}
.lo-img {
	position: absolute;
	left: 0px;
	top: 0px;
	z-index:999999;
	
}
.loh-H {
	width:100%;
	float:left;
	height: 100vh;
/*	background: url(login/graphic1.svg) no-repeat top center;
*/	background-size: 80% 80%;
position:relative;
}
.mob {
	text-align:left !important;
	color:#000000;
	padding:0px;
	font-size:18px;
	font-weight: 600;
}
.mob:before {
	content:url(login/mob.png);
	position: absolute;
	left: 9px;
	top: 42px;
	width:32px;
}
.mob-ent {
	border:0px;
	border:1px solid #ffd9d5;
	background:#f1efef;
	line-height:48px;
	height:48px;
	/*padding-left:95px;*/
	box-shadow: none;
	border-radius:5px;
	font-size:18px;
	font-weight:400;
}
.form-cover label {
    float: left;
    line-height:1.5;
}

.sub_btn {
	color: #fff;
	 background: linear-gradient(-45deg, #020202, #363131);    border: 1px solid #080505;
	width:150px;
 
	font-size: 20px;
	font-weight: 700;
	margin:0px auto;
	margin-top: 20px;
}
.sub_btn:hover {
	
	background-color: #da4948;
	border: 1px solid #e1dbdb;
	color:#b3b3b3;
}
.login-logo {
	margin-bottom:60px;
	max-width:70%;
}
button:focus {
	outline:none !important;
}
.errors {
	color: #ef0b0bdd;
	font-size: 18px;
	text-align: left;
	font-weight: bold;
	position:absolute;
	top:15px;
}
.slog {
  background: #1b1819;
  color: #fff;
  border-radius: 10px;
  padding-top: 15px;
  border: 1px solid #332f31;
  position: absolute;
  z-index: 9999;
  bottom: 50px;
  box-shadow: 0px 0px 14px #15131391;
}
.slog p {
	font-size: 16px;
	font-weight: 300;
	padding-bottom: 10px;
}
.tim {
	width: 50%;
	height: 50px;
	background: #c20404;
	position: absolute;
	right: 10px;
	/* top: 50px; */
    bottom: -15px;
}
.form-cover {
    border: 1px solid #ccccccb5;
    padding: 15px 30px;
    border-radius: 20px;
    background: #ffffff;
    box-shadow: 0px 0px 15px #0003;
}
.no-pad {
	margin: 0px 0px 10px 0px !important;
}
.coll-2 {
	padding-top:60px;
	text-align:center;
	position:relative;
	height:100vh
}
.bot-tex{text-align: center;
    font-size: 12px;
    color: #ccc;width: 95%; padding:10px 20px;box-sizing: border-box; text-align:center; 

bottom: 10px}


.canvas_append {
	position:absolute;
	left:0px; z-index:999;
	overflow:hidden;
	top:10%;
	opacity: 0.2;
	    z-index: 0;
	
  
}
canvas {

    width: 100% !important;
    background: #fff4f4 !important;
    height: auto;

}
.people{
    font-size: 45px;
    font-weight: 700;
    color: #9b5d7d;
   text-transform: uppercase;
   text-align:center;
}
.plus {
    position: absolute;
    left:16%;
    top: 42px;
    font-size: 25px;
    color: #666;
}

@media only screen and (max-width: 600px) {
 .back {
position: static;
background: #EADCA6;
float: left;
}
 .loh-H {
height:100%;
position:relative;
}
 .coll-2 {
width: 100%;
float: left;
position:static;
height:100%;
padding-top:20px;
}
.bot-tex{ position:static;}
.canvas_append,.slog{ display:none;}
.people{ visibility:hidden;}
.coll-2 {
    padding-top: 38%;
}
.form-cover{padding: 30px 15px;}
.plus {left: 51px;}
.mob-ent,.plus{font-size:20px;}
.mob-ent{padding-left:80px;}
form.form-horizontal.offset-sm-1.col-sm-10 {
    padding: 0px;
}
}
#Date {
    background: #635c61 !important;
}
body{background:#F6FDC3;}
</style>
</head>
<body >
<div class="container-fluid">
  <div class="row">
    <div class=" col-md-12 back"  > 
      <div class="canvas_append"></div>
	  <div class="row">	  
	  </div>     
    </div>
    <div class=" col-md-6 coll-2 offset-md-3"  >    
	  
    <form class="form-horizontal  col-sm-12" action="" method="post" autocomplete="off" name="user_login_form" id="user_login_form">

	    <div class="col-sm-12 form-cover" style="background:#7fd181;color:#ffffffd4;">
		    <div style="width:100%; text-align:center; "> 
		    <img src="<?php echo ROOTURL;?>/images/manmesh_logo.jpeg" style="    width: 150px;">
		    <p class="mt-2"><span style="font-size:20px;"><b>Welcome !</b> <span style="color:#964B00;font-weight: 500">
		    Manmesh MLM Work</span></span><br>
		    Please enter your login details. </p>
		    </div>
	 
            <div class="form-group no-pad position-relative px-5">
	            <label class="control-label col-sm-12 mob"  for="user_email">Email Address</label>
	            <div class=""><input type="text" name="user_email" id="user_email"  class="form-control mob-ent" placeholder="Your Email Address">
	            	<label class="text-danger" id="user_email_error"></label>
	            </div>
            </div>

            <div class="form-group no-pad position-relative px-5">
	            <label class="control-label col-sm-12 mob"  for="user_password">Password</label>
	            <div class=""><input type="password" name="user_password" id="user_password"  class="form-control mob-ent" placeholder="Your Password">
	            	<label class="text-danger" id="user_password_error"></label>
	            </div>
            </div>

            <div class="form-group">
            	<button type="button" name="Login" class="btn btn-default sub_btn" id="user_login_btn">Login</button>
            </div>
		
        </div>
      </form>
     
      <p class="bot-tex" style="color:#393437;">New Delhi<br>
        New Delhi -03 Helpline No. +91-7428404356<br><span ><strong>   Email: manmeshmlm@gmail.com</strong></span> <br>
        Copyright © 2024 Manmesh MLM Work. All rights reserved.</p>
    </div>
  </div>
</div>
</body>
<script type="text/javascript">
	$(document).ready(function(){
		$(document).on('click', '#user_login_btn', function(){

	        if ($("#user_email").val().length == 0) {
	            $("#user_email_error").html('Please Enter E-Mail');
	            $("#user_email").focus();
	            return false;
	        }
	        else {
	            $("#user_email_error").html('');
	        }

	        if ($("#user_password").val().length == 0) {
	            $("#user_password_error").html('Please Enter E-Mail');
	            $("#user_password").focus();
	            return false;
	        }
	        else {
	            $("#user_password_error").html('');
	        }

	       

	        $("#user_login_btn").prop('disabled', true);
	        $("#user_login_btn").html('Please Wait...');

	        var ajax_url = '<?php echo SITEURL;?>/?page=ajaxglobal&calling_block=ajax_login';
	        var formData = new FormData($("#user_login_form")[0]);
	       	$.ajax ({
	            
	            type: "POST",
	            url: ajax_url,
	            contentType: false,
	            cache: false,
	             
	            processData:false,
	            data:  formData,
	            success: function(msg) {

	                console.log(msg);

	                var jsonData = JSON.parse(msg);

	                if(jsonData.ajax_status == 'error') {

	                    //$("#submit_user").prop('disabled', false);

	                    $.each( jsonData, function( key, value ) {

	                        if(key == 'ajax_alert') {

	                            alert(value);
	                        }
	                        else if(key != 'ajax_status') {

	                            $("#"+key).closest(".form-group").addClass( "has-error" );
	                            $("#"+key+"_error").html(value);
	                        }
	                    });
	                }
	                else if(jsonData.ajax_status == 'success') {

	                   $("#user_login_form").html('<div class="alert alert-block alert-success"><p><strong><i class="ace-icon fa fa-check"></i>Success!</strong> Save successfully...</p></div>');

	                   window.location.reload(true);
	                }

	                 $("#user_login_btn").prop('disabled', false);
	                 $("#user_login_btn").html('Login');
	            },
	            error : function(msg, status) {
	                
	                alert(msg+status);
	            }
	        });
	    });
	});
</script>

</html>