<?php
  $Page="Dashboard";
  include('header.php'); 
  include('sidebar.php'); 
  $Years=date('Y');
  ?>  
<!-- /Sidebar --> 
<style>
  .highcharts-credits {
  display: none;
  }
  h6.text-muted a {
  color: #383838 !important;
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
  text-align: left;
  white-space: nowrap;
  }
  .dash-widget-info h3 span:nth-child(2){font-size:1.3rem;}
  .dash-widget-info h3 > span {
  padding: 0px 10px;
  }
  .dash-widget-info h3 > span:nth-last-child(2) {
   
  border-right: 1px solid #9f9f9f;
  }
  .active {
  font-size: 14px;
  font-weight: 400;
  color:#000 !important;
  line-height: 2;
  }
span.text-center.s-cover {
    position: relative;
    width: 120px;
    font-size: 16px;
    background: #f9f9f9;
    padding: 10px;
    border: 1px solid #efefef;
    border-radius: 4px;
	transition: all .2s;
	 
}
span.text-center.s-cover:hover {
    position: relative;
    width: 120px;
    font-size: 16px;
    background: #ffffff;
    padding: 10px;
    border: 1px solid #efefef;
    border-radius: 4px;
}

a.add_d {
    position: absolute;
    right: 6px;
    font-size: 20px;
    top: 2px;
}
.s-cover img {
    width: 60px !important;
}

.s-cover .text-dark {
    color: #000 !important;
    font-style: italic;
    font-weight: bold;
    font-size: 12px;
}
.table td, .table th {
padding: 4px 8px;}
.text-dark.text-center.fs-14{font-size:14px !important}  
</style>
<!-- Page Wrapper -->
<div class="page-wrapper">
  <div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
      <div class="row">
        <div class="col-sm-12 d-flex justify-content-between">
          <h3 class="page-title">Welcome <?php echo $_SESSION['MANM_NAME']; ?>!</h3>
          <ul class="breadcrumb">
            <li class="breadcrumb-item active"> <span style="">Home</span> / Dashboard</li>
          </ul>
        </div>
      </div>
    </div>
    <!-- /Page Header -->   
	  <div class="row dash-icon">
      <div class="col-xl-3 col-sm-6 col-12">
        <div class="card ">
          <div class="card-body">
            <div class="dash-widget-header">
              <div>
                <h6 class="text-muted"><a href="">Today Sale  </a></h6>
              </div>
            </div>
            <div class="dash-widget-info">
              <h3><span><img src="images/icon/sales.png" class="w-50"></span> 
                
                <span><span class="text-danger">0</span><br>
                <span class="active text-success">Total</span></span> 
              </h3>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-sm-6 col-12">
        <div class="card ">
          <div class="card-body">
            <div class="dash-widget-header">
              <div>
                <h6 class="text-muted"><a href="">Weekly Sale  </a></h6>
              </div>
            </div>
            <div class="dash-widget-info">
              <h3><span><img src="images/icon/sales.png" class="w-50"></span> 
                
                <span><span class="text-danger">0</span><br>
                <span class="active text-success">Total</span></span> 
              </h3>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-sm-6 col-12">
        <div class="card ">
          <div class="card-body">
            <div class="dash-widget-header">
              <div>
                <h6 class="text-muted"><a href="">Monthly Sale  </a></h6>
              </div>
            </div>
            <div class="dash-widget-info">
              <h3><span><img src="images/icon/sales.png" class="w-50"></span> 
                
                <span><span class="text-danger">0</span><br>
                <span class="active text-success">Total</span></span> 
              </h3>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
          <div class="card-body">
            <div class="dash-widget-header">
              <div>
                <h6 class="text-muted"><a href="">Today Payment</a></h6>
              </div>
            </div>
            <div class="dash-widget-info">
              <h3><span><img src="images/icon/collection.png" class="w-50"></span> 
                
                <span><span class="text-danger">0</span><br>
                <span class="active text-success">Total</span></span> 
              </h3>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
          <div class="card-body">
            <div class="dash-widget-header">
              <div>
                <h6 class="text-muted"><a href="Supplier.php">Total Invoice</a></h6>
              </div>
            </div>
            <div class="dash-widget-info">
              <h3><span><img src="images/icon/invoice.png" class="w-50"></span> 
                <span><span class="text-danger">0</span><br>
                <span class="active text-success">Total</span></span> 
              </h3>
            </div>
          </div>
        </div>
      </div>
	  <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
          <div class="card-body">
            <div class="dash-widget-header">
              <div>
                <h6 class="text-muted"><a href="Buyer.php">Total Customers</a></h6>
              </div>
            </div>
            <div class="dash-widget-info">
              <h3><span><img src="images/icon/customer.png" class="w-50"></span> 
                <span><span class="text-danger"> 0</span><br>
                <span class="active text-success">Total</span></span> 
              </h3>
            </div>
          </div>
        </div>
      </div>
    </div> 
	<div class="row dash-icon">
      <div class="col-xl-6 col-sm-6 col-12">
        <div class="card ">
          <div class="card-body">
            <div class="dash-widget-header">
              <div>
                <h6 class="text-muted"><a href="">Today Product</a></h6>
              </div>
            </div>
            <div class="dash-widget-info">
              <h3><span><img src="images/icon/sales.png" class="w-25"></span> 
               
              
                <span><span class="text-danger"> 0</span><br>
                <span class="active text-success">Total</span></span> 
                 
              </h3>
            </div>
          </div>
        </div>
      </div>
	  <div class="col-xl-6 col-sm-6 col-12">
        <div class="card ">
          <div class="card-body">
            <div class="dash-widget-header">
              <div>
                <h6 class="text-muted"><a href="">Today Payment</a></h6>
              </div>
            </div>
            <div class="dash-widget-info">
              <h3><span><img src="images/icon/collection.png" class="w-25"></span> 
               
                <span style="flex-basis: 165px;border-right: 1px solid #9f9f9f;padding-right: 20px;margin-right: 20px;">
                <span class="text-danger">₹50000</span><br>
                <!-- <span class="active text-success">10 Bill </span> -->
                </span> 
                <span><span class="text-danger">₹0</span><br>
                <!-- <span class="active text-success">Total Billing - 200</span> -->
                </span> 
                 
              </h3>
            </div>
          </div>
        </div>
      </div>
	  </div>
    <!-- <div class="row dash-icon">
      <div class="col-xl-12 col-sm-6 col-12">
        <div class="card ">
          <div class="card-body">
            <div class="dash-widget-info">
              <h3 style="line-height: 2.5;"><span>Monthly Billing ( <?php echo date("M-Y");?>)
</span> 
                <div class="d-flex justify-content-between w-100 align-items-center"> 
		<a href="supplierbilled.php"><span class="text-dark text-center fs-14">Billed : <span class="text-danger">0</span></span> </a>
				<span class="text-dark text-center fs-14">Pending Bills : <span class="text-danger">0</span></span> 
				 </div>
              </h3>
            </div>
          </div>
        </div>
      </div>
    </div> -->

	<!--  <div class="row dash-icon">
      <div class="col-xl-12 col-sm-6 col-12">
        <div class="card ">
          <div class="card-body">
            <div class="dash-widget-info">
              <h3 style="line-height: 2.5;"><span>Lead Followup</span> 
                <div class="d-flex justify-content-between w-100 align-items-center"  > 
				<a href="todayleads.php"><span class="text-dark text-center fs-14">Today Follow up : <span class="text-danger">0</span></span> </a>
				<a href="AllLeads.php"><span class="text-dark text-center fs-14">Pending Followup : <span class="text-danger">0</span></span></a>
				 </div>
              </h3>
            </div>
          </div>
        </div>
      </div>
    </div> -->
    <?php
    /*
    ?>
    <div class="row dash-icon">
      <div class="col-xl-6 col-sm-6 col-12">
        <div class="card ">
          <div class="card-body">
            <h6>Top 5 Customers</h6>
            <table class="table">
              <thead>
                <tr>
                  <th>S.No</th>
                  <th>Name</th>
                  <th>Payment</th>
                </tr>
              </thead>
              <tbody>
              <?php              
              $topcustomer=mysqli_query($con,"SELECT sum(final_amount) amount, buyerid FROM `sale_details` WHERE id!='' group by buyerid limit 5");
              $i=1;
              while($tcArr=mysqli_fetch_array($topcustomer)){
                $buyerArr=Get_Fetch_Data($con,$tcArr["buyerid"],"All","buyer_details");
                //print_r($buyerArr);
                ?>
                <tr>
        			  <td><?php echo $i++;?></td>
        			  <td><?php echo $buyerArr["CName"];?></td>
        			  <td><?php echo $tcArr["amount"];?></td>
        			  </tr>
        			  <?php } 
                ?>  
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-xl-6 col-sm-6 col-12">
        <div class="card ">
          <div class="card-body">
            <h6>Top 5 Suppliers</h6>
            <table class="table">
              <thead>
                <tr>
                  <th>S.No</th>
                  <th>Name</th>
                  <th>Payment</th>
                </tr>
              </thead>
              <tbody>
                <?php 
          $topsupplier=mysqli_query($con,"SELECT sum(final_amount) amount,supplierid FROM `sale_details` WHERE id!='' group by supplierid limit 5");
          $i=1;
          while($topsupplier1=mysqli_fetch_array($topsupplier)){
            $sname=Get_Fetch_Data($con,$topsupplier1["supplierid"],"CName","supplier");
                          ?>
              <tr>
			  <td><?php echo $i++;?></td>
			  <td><?php echo $sname['CName'];?></td>
			  <td><?php echo $topsupplier1['amount'];?></td>
			  </tr>
      <?php } ?>
			  
              </tbody>
            </table>
          </div>
        </div>
      </div>
      
     
    </div>
    <?php
    */?>
    
    <div class="row">
      <div class="col-md-12 col-lg-12">
        <div class="card card-chart">
          <div class="card-body">
            <div id="Sale_Graph"></div>
          </div>
        </div>
      </div>
      
    </div>
    
    
  </div>
</div>
<!-- /Page Wrapper --> 
</div>
<!-- /Main Wrapper --> 
<?php include('footer.php'); ?>
<script src="graph/highcharts.js"></script>
<script src="graph/highcharts-3d.js"></script>
<!-- <script type="text/javascript">
  Highcharts.chart('Sale_Graph', {
  
      chart: {
          type: 'column'
      },
      title: {
          text: 'Monthly Sale Report <?php echo date("M");?> <?php echo date('Y'); ?>'
      },
      xAxis: {
          type: 'category'
      },
      yAxis: {
          title: {
              text: 'Monthly Sale Report <?php echo date("M");?>'
          }
  
      },
      legend: {
          enabled: false
      },
      plotOptions: {
          series: {
              borderWidth: 0,
              dataLabels: {
                  enabled: true,
                  format: '{point.y}'
              }
          }
      },
  
      tooltip: {
          headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
          pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
      },
  
      series: [
          {
              name: "Total Sale",
              colorByPoint: true,
              data: [
                <?php 
                // $statelist=mysqli_query($con,"select * from state_details where status='Active' order by state_name asc");
                $statelist=mysqli_query($con,"SELECT state_details.*, supplier.id as supplierid FROM state_details left join supplier on state_details.id=supplier.State");
                while($statelist1=mysqli_fetch_array($statelist)){
                ?>
          { name: "<?php echo $statelist1["state_name"];?>",y: <?php echo Get_Order_Amount_Recieved($con,$statelist1["id"]); ?>,drilldown: "<?php echo $statelist1["state_name"];?>" },
          <?php } ?>
              ]
          }
      ],  
  });
  //Order Details

</script> -->