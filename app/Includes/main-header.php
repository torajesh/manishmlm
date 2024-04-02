		<nav id="navbar">
			<div class="left_item">
				<div id="mySidebar" class="overlay">
					<div class="top-red">
						<div class="left-item2">
							<img src="<?php echo SITEURL;?>/assets/images/flogo.png" alt="">
						</div>
					</div>
					<div class="overlay-content">
						<a href="<?php echo SITEURL;?>"><i class="fa-solid fa-house-chimney"></i> Home</a>

						<a href="javascript:" class="get_enroll_with_us_form_cls"><i class="fa-solid fa-clipboard-user"></i> Enroll With Us</a>

						<a href="javascript:" class="get_advertise_with_us_form_cls"><i class="fa-solid fa-rectangle-ad"></i> Advertise With Us</a>

						<a href="javascript:" class="get_faq_page_cls"><i class="fa-solid fa-basket-shopping"></i> FAQ</a>
						
						<a href="javascript:" class="get_aboutus_page_cls"><i class="fa-solid fa-address-card"></i> About Us</a>						 
						<a href="javascript:" class="get_contact_us_form_cls"> <i class="fa-solid fa-address-book"></i> Contact Us</a>
					</div>
				</div>
				<span style="font-size:20px; font-weight:500; cursor:pointer"><i class="fa fa-bars" onclick="w3_open()"></i>
					<span style="color:#e31c26"> Make My Foodie</span><div id="longilati"></div>
				</span>
			</div>

			<div class="right_item">
				<div class="icon">
					<div class="dropdown">
						<a href="javascript:" id="header_main_city_search_btn" style="margin-left:10px ; color:#fff !important;" class="ahref"><i class="fa fa-search"></i></a>
					</div>
					<div class="dropdown-two">
						<a href="javascript:" style="color: #fff !important;" class="ahref notification"><i class="fa-regular fa-bell"></i></a>
						<div class="dropdown-content-two">
							<p>No Notification !!</p>
						</div>
						<!--a href="javascript:" style="color: #fff !important;" class="ahref notification"><i class="fa-regular fa-bell"></i>
							<span class="badge">3</span></a>
						<div class="dropdown-content-two">
							<p>You have 3 notifications</p>
							<a href="#">
								<i class="fa fa-users text-aqua"></i>Lorem ipsum dolor sit amet.
							</a>
						</div-->
					</div>
					<div class="dropdown">
						<a href="javascript:" style="color: #fff !important;" class="ahref"><i class="fa-solid fa-ellipsis-vertical"></i></a>
						<div class="dropdown-content">
							<?php
							if(isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0) {
								?>
								<p style="padding: 5px; color:#d61200; font-size:14px;">Welcome, <?php echo $_SESSION['username'];?></p>
								 
								<?php
							}
							else {
								?>
								<a href="javascript:" id="menuLoginBtn" style="width:auto;">Login</a>
								<a href="javascript:" id="menuRegisterBtn"  style="width:auto;">Register</a>	
								<?php
							}
							?>
														 
													 
							<a href="javascript:" id="menuShareBtn">Share App</a>
							<a href="https://play.google.com/store/apps/details?id=app.makemyfoodie">Rate Our App</a>
							<a href="javascript:" id="termNcondBtn" style="border-bottom: none;">Terms &amp; Conditions</a>
							<?php
							if(isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0) {
								?>
								 
								<a href="javascript:" id="menuLogoutBtn" style=" border-top: 2px #ccc solid; border-bottom: none;">Logout</a>
								<?php
							}
							 
							?>
						</div>
					</div>
				</div>
			</div>
		</nav>
		<!-- Overlay effect when opening sidebar on small screens -->
		<div class="w3-overlay " onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

 

	 