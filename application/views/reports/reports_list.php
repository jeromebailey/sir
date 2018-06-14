<!DOCTYPE html>
<html lang="en">
  <head>
    <?include_once 'includes/head.inc'; ?>
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

          <div class="x_content">
            <h3><?=$page_title;?></h3>
            
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
                <div class="panel panel-info">
                    <div class="panel-heading">Stock Level</div>
                      <div class="panel-body">
                          <ol>
                            <li><a href="<?=base_url('Reports/count_low_stock_items');?>">Count Low Stock Level</a></li>
                            <li><a href="<?=base_url('Reports/low_stock_levels');?>">Show Low Stock Level Items</a></li>
                            <li><a href="<?=base_url('Reports/count_low_stock_levels_per_category');?>">Count Low Stock Level Items Per Category</a></li>
                            <li><a href="<?=base_url('Reports/low_stock_levels_per_category');?>">Show Stock Level Items Per Category</a></li>
                            <li><a href="<?=base_url('Reports/inventory_total_per_category');?>">Total Value Per Category In Inventory</a></li>
                            <li><a href="<?=base_url('Reports/inventory_items_in_category');?>">Total Inventory Items In Inventory</a></li>
                          </ol>
                      </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
                <div class="panel panel-info">
                    <div class="panel-heading">Users</div>
                      <div class="panel-body">
                          <ol>
                            <li><a href="<?=base_url('Reports/show_user_access');?>">Show User Access</a></li>
                            
                          </ol>
                      </div>
                </div>
              </div>
            </div>
          </div>
          <!-- top tiles -->



        </div>
        <!-- /page content -->

        <!-- footer content -->
        <?include_once 'includes/footer.inc';?>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <?include_once 'includes/scripts.inc';?>
    <?include_once 'includes/data-table-scripts.inc';?>
    <script type="text/javascript">
      $(document).ready(function() {
          $('#data-table').DataTable({
            "pageLength": 100,
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5', 'csvHtml5', 'excelHtml5', 'pdfHtml5', 'print'
            ]
          });
      } );
    </script>

  </body>
</html>
