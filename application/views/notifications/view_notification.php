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
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user-id">Title</label>
                <div class="col-md-9 col-sm-12 col-xs-12">
                  <p><?=$notification["title"];?></p>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user-id">Details</label>
                <div class="col-md-9 col-sm-12 col-xs-12">
                  <p><?=$notification["details"];?></p>
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
            "pageLength": 100
          });
      } );
    </script>

  </body>
</html>
