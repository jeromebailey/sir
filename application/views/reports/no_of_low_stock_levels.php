<!DOCTYPE html>
<html lang="en">
  <head>
    <?include_once 'includes/head.inc';?>
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">

        <?include_once 'includes/sidebar.inc';?>

        <!-- top navigation -->
        <?include_once 'includes/topnav.inc';?>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">

          <div class="x_content">

            <ol class="breadcrumb">
              <li><a href="<?=base_url('Reports');?>">Reports</a></li>
              <li class="active"><?=$page_title;?></li>
            </ol>

            <h3><?=$page_title;?></h3>
            <p>There are <?=$low_stock_levels_count;?> low stock item(s).</p>
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

  </body>
</html>
