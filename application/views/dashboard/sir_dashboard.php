<!DOCTYPE html>
<html lang="en">
  <head>
    <?include_once 'includes/head.inc';?>
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        
        <?include_once 'includes/sidebar.inc'; ?>

        <!-- top navigation -->
        <?include_once 'includes/topnav.inc'; ?>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">

          <!-- top tiles -->
          <div class="row tile_count">
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> <a href="<?=base_url('Users');?>">Total Users</a></span>
              <div class="count red"><?=$user_count;?></div>
              <!--<span class="count_bottom"><i class="green">4% </i> From last Week</span>-->
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-clock-o"></i> <a href="<?=base_url('Products');?>">Total Products</a></span>
              <div class="count red"><?=$product_count;?></div>
              <!--<span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span>-->
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Departments</span>
              <div class="count red"><?=$department_count;?></div>
              <!--<span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>-->
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Clients</span>
              <div class="count red"><?=$client_count;?></div>
              <!--<span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> From last Week</span>-->
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Suppliers</span>
              <div class="count red"><?=$supplier_count;?></div>
              <!--<span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>-->
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> <a href="<?=base_url('Reports/low_stock_levels');?>">Low Stock Levels</a> </span>
              <div class="count red"><?=$low_stock_levels_count;?></div>
              <!--<span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>-->
            </div>
          </div>
          <!-- /top tiles -->

          <div class="row">            

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="dashboard_graph">

                <div class="row x_title">
                  <div class="col-md-6">
                    <h3>No. of products in categories </h3>
                  </div>
                  <!--<div class="col-md-6">
                    <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                      <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                      <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                    </div>
                  </div>-->
                </div>

                <div class="col-md-9 col-sm-9 col-xs-12">
                  <div id="bar-example2"></div>
                  <!--<div id="chart_plot_01" class="demo-placeholder"></div>-->
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12 bg-white">
                  <div class="x_title">
                    <h2>Total Requisitions</h2>
                    <div class="clearfix"></div>
                  </div>

                  <div class="col-md-12 col-sm-12 col-xs-6">
                    <div>
                      <p>Today</p>
                      <div class="">
                        <div class="progress progress_sm" >
                          <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="0"></div>
                        </div>
                      </div>
                    </div>
                    <div>
                      <p>Last 7 days</p>
                      <div class="">
                        <div class="progress progress_sm" >
                          <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="0"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12 col-sm-12 col-xs-6">
                    <div>
                      <p>This Month</p>
                      <div class="">
                        <div class="progress progress_sm" >
                          <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="0"></div>
                        </div>
                      </div>
                    </div>
                    <div>
                      <p>This Year</p>
                      <div class="">
                        <div class="progress progress_sm" >
                          <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="0"></div>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>

                <div class="clearfix"></div>
              </div>
            </div>

          </div>
          <br />

          <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
              <div class="x_panel tile overflow_hidden">
                <div class="x_title">
                  <h2>Total Requisition Sales</h2>                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">                  
                  <table class="table table-bordered table-hover table-striped">
                    <thead>
                      <tr>
                        <th>Today</th>
                        <th>This week</th>
                        <th>This month</th>
                        <th>This year</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><?=$requisition_sales_today;?></td>
                        <td><?=$requisition_sales_this_week;?></td>
                        <td><?=$requisition_sales_this_month;?></td>
                        <td><?=$requisition_sales_this_year;?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

          <div class="row">

            <div class="col-md-4 col-sm-12 col-xs-12 col-lg-4">
              <div class="x_panel tile fixed_height_320 overflow_hidden">
                <div class="x_title">
                  <h2>No. of products in categories</h2>                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">                  
                  <div id="count_products_in_categories" height="140" width="140" style="margin: -50px 10px 10px 0"></div>
                </div>
              </div>
            </div>

            <div class="col-md-4 col-sm-12 col-xs-12 col-lg-4">
              <div class="x_panel tile fixed_height_320">
                <div class="x_title">
                  <h2>Total cost in Categories</h2>                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <div id="category_product_cost" height="140" width="140" style="margin: -50px 10px 10px 0"></div>
                </div>
              </div>
            </div>

            <div class="col-md-4 col-sm-4 col-xs-12 col-lg-4">
              <div class="x_panel tile fixed_height_320">
                <div class="x_title">
                  <h2>Quick Actions</h2>
                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <div class="dashboard-widget-content">
                    <ul class="quick-actions">
                      <?if($this->sir->user_has_permission_to("create_purchase_order")){?>
                        <li><i class="fas fa-money-bill-alt"></i><a href="<?=base_url('Forms/create_purchase_order');?>">Create Purchase Order</a></li>
                      <?}?>

                      <?if($this->sir->user_has_permission_to("create_requisition")){?>
                          <li><i class="fas fa-question"></i><a href="<?=base_url('Forms/create_requisition');?>">Product Requisition Form</a></li>
                      <?}?>

                      <?if($this->sir->user_has_permission_to("create_flight_check_sheet")){?>
                        <li><i class="fas fa-plane"></i><a href="<?=base_url('Forms/create_flight_check_sheet');?>">Create Flight Check Sheet</a> </li>
                      <?}?>                      
                      
                      <li><i class="fab fa-product-hunt"></i><a href="<?=base_url('Products/');?>">Products List</a> </li>
                      <li><i class="fas fa-boxes"></i><a href="<?=base_url('Forms/create_flight_check_sheet');?>">Inventory List</a> </li>
                      
                      <?if($this->sir->user_has_permission_to("view_reports")){?>
                        <li><i class="fas fa-list-alt"></i><a href="<?=base_url('Reports/');?>">Reports</a> </li>
                      <?}?>
                      
                    </ul>                    
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>GCG Locations</h2>
                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <div class="dashboard-widget-content">

                    <table class="table table-bordered table-hover table-striped">
                      <thead>
                        <tr>
                        <th>Country</th>
                        <th>Location</th>
                      </tr>
                      </thead>                      
                      <tbody>
                        <?
                        if( !empty( $gcg_locations ) ){
                          foreach ($gcg_locations as $key => $value) {?>
                            <tr>
                              <td><?=$value["country"];?></td>
                              <td><?=$value["location"];?></td>
                            </tr>
                          <?}
                        } else {?>
                          <tr>
                            <td></td>
                            <td></td>
                          </tr>
                        <?}?>
                      </tbody>
                    </table>                    
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-md-8 col-sm-8 col-xs-12">
              <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>GCG Location <small>geo-presentation</small></h2>
                      
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <div class="dashboard-widget-content">
                        
                        <div id="world-map-gdp" class="col-md-12 col-sm-12 col-xs-12" style="height:230px;"></div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
              <div class="row">


                <!-- Start to do list -->
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>To Do List <small>Sample tasks</small></h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Settings 1</a>
                            </li>
                            <li><a href="#">Settings 2</a>
                            </li>
                          </ul>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                      <div class="">
                        
                      </div>
                    </div>
                  </div>
                </div>
                <!-- End to do list -->
                
                <!-- start of weather widget -->
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Daily active users <small>Sessions</small></h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Settings 1</a>
                            </li>
                            <li><a href="#">Settings 2</a>
                            </li>
                          </ul>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      
                    </div>
                  </div>

                </div>
                <!-- end of weather widget -->
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <?include_once 'includes/footer.inc';?>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <?include_once 'includes/scripts.inc';?>
    <script src="<?=base_url('assets/js/raphael.min.js');?>"></script>
    <script src="<?=base_url('assets/js/morris.min.js');?>"></script>
    <script type="text/javascript">

      $(document).ready(function(){
        //cost_colours( ['#9CC4E4', '#3A89C9', '#F26C4F','#9CC4E4', '#3A89C9', '#F26C4F','#ff0000'] );

        Morris.Bar({
  element: 'bar-example2',
  data: [
  <?
    if(!empty($no_of_products_in_categories)){
      $record_count = count($no_of_products_in_categories);
      $counter = 1;

      foreach ($no_of_products_in_categories as $key => $value) {
        if( $counter == $record_count ){
          echo '{y: "'. $value["category_name"] .'", a: '.$value["product_count"].'}';
        } else {
          echo '{y: "'. $value["category_name"] .'", a: '.$value["product_count"].'},';
        }
        $counter++;
      }
    }
    ?>
    
  ],
  xkey: 'y',
  ykeys: ['a'],
  labels: ['Total Requisitons']
});

        Morris.Donut({
          element: 'count_products_in_categories',
          colors: ['#ffffcc', '#ffcc00', '#990033','#cc6666', '#33CCFF', '#CCFF00','#ccccff'],
          data: [
          <?
          if(!empty($no_of_products_in_categories)){
            $record_count = count($no_of_products_in_categories);
            $counter = 1;

            foreach ($no_of_products_in_categories as $key => $value) {
              if( $counter == $record_count ){
                echo '{label: "'. $value["category_name"] .'", value: '.$value["product_count"].'}';
              } else {
                echo '{label: "'. $value["category_name"] .'", value: '.$value["product_count"].'},';
              }
              $counter++;
            }
          }
          ?>

          ]
        }); 

        Morris.Donut({
          element: 'category_product_cost',
          colors: ['#9CC4E4', '#FF9900', '#990033','#FFCCFF', '#33CCFF', '#CCFF00','#ff0000'],
          data: [
          <?
          if(!empty($total_product_category_cost)){
            $record_count = count($total_product_category_cost);
            $counter = 1;

            foreach ($total_product_category_cost as $key => $value) {
              if( $counter == $record_count ){
                echo '{label: "'. $value["category_name"] .'", value: '.$value["total_cost"].'}';
              } else {
                echo '{label: "'. $value["category_name"] .'", value: '.$value["total_cost"].'},';
              }
              $counter++;
            }
          }
          ?>

          ]
        });

      });
    </script>
  
  </body>
</html>
