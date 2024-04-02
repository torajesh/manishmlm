<style>
.mini-sidebar .name-cover{display:none;} 
.mini-sidebar .sidebar-menu ul ul {
    display: none !important;
}
.mini-sidebar.expand-menu .sidebar a.subdrop + ul {
    display: block !important;
}
</style>
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
      <div id="sidebar-menu" class="sidebar-menu">
        <ul>
		<li style="text-align: center;padding: 15px;border-bottom: 1px solid;" > 
		<span class="user-img"><img class="rounded-circle" src="<?php echo $Photos; ?>" width="45" alt="admin"></span>
		<div class="name-cover">
		<p class="m-0 p-0 text-dark"><?php echo $UserArr['contact_name']; ?></p>
		<h5 class="text-dark"><?php echo $UserArr['designation']; ?></h5>
		</div>
		</li>
  <li class="<?php if($Page=='Dashboard'){ echo 'active'; } ?>"> <a href="Dashboard.php"><i class="fe fe-home"></i> <span>Dashboard</span></a> </li> 

  <li class="submenu" <?php if($Page=='OurMembers'){ echo 'style="background: #fff;border-radius: 4px"'; }else{}  ?>> <a href="#"><i class="fe  "><img src="images/icon/report.png"></i><span> Our Members</span> <span class="menu-arrow"></span></a>
  <ul <?php if($Page=='OurMembers'){ echo 'style="display: block;"'; } else { echo 'style="display: none;"'; } ?>>
  <li class="<?php if($InnPage=='membersList'){ echo 'active'; } ?>"><a href="MembersList.php">Members List</a></li>  
  </ul>
  </li> 

  <li class="submenu" <?php if($Page=='OurProduct'){ echo 'style="background: #f9f9f9;border-radius: 4px"'; }else{}  ?>> <a href="#"><i class="fe  "><img src="images/icon/report.png"></i><span> Our Product</span> <span class="menu-arrow"></span></a>
  <ul <?php if($Page=='OurProduct'){ echo 'style="display: block;"'; } else { echo 'style="display: none;"'; } ?>>
  <li class="<?php if($InnPage=='ProductCategory'){ echo 'active'; } ?>"><a href="ProductCategory.php">Product Category</a></li>    
  <li class="<?php if($InnPage=='ProductList'){ echo 'active'; } ?>"><a href="ProductList.php">Product List</a></li>
  <li class="<?php if($InnPage=='AddEditProduct'){ echo 'active'; } ?>"><a href="aditedit_product.php">Add Product</a></li>  
  </ul>
  </li>

  <li class="submenu" <?php if($Page=='Setting'){ echo 'style="background: #f9f9f9;border-radius: 4px"'; }else{}  ?>> <a href="#"><i class="fe  "><img src="images/icon/report.png"></i><span> Master</span> <span class="menu-arrow"></span></a>
  <ul <?php if($Page=='Setting'){ echo 'style="display: block;"'; } else { echo 'style="display: none;"'; } ?>>
  <li class="<?php if($InnPage=='State'){ echo 'active'; } ?>"><a href="AllState.php">State</a></li>
  <li class="<?php if($InnPage=='City'){ echo 'active'; } ?>"><a href="AllCity.php">City </a></li>
  <li class="<?php if($InnPage=='hsncode'){ echo 'active'; } ?>"><a href="hsncode.php">HSN Code</a></li>
  <li class="<?php if($InnPage=='SupplierLevel'){ echo 'active'; } ?>"><a href="MembershipLevel.php"> Membership Type</a></li>
  </ul>
  </li>
      
 		
         
        </ul>
      </div>
    </div>
  </div>