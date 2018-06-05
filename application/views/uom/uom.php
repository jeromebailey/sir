<!DOCTYPE html>
<html lang="en">
  <head>
    <?include_once 'includes/head.inc' ?>
    <?include_once 'includes/bs-css.inc';?>
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
            <table class="table table-striped table-hover table-bordered" id="tbl-Units">
              <thead>
                <tr>
                  <th>Unit Name</th>
                  <th>Abbreviation</th>
                  <th>Options</th>
                </tr>
              </thead>
              <tbody>
                <?if( empty($uom) ){?>
                  <tr>
                    <td colspan="3">No data to display</td>
                  </tr>
                <?} else {
                  foreach ($uom as $key => $value) {?>
                    <tr>
                      <td><?=$value['unit_name'];?></td>
                      <td><?=$value['unit_abbreviation'];?></td>
                      <td></td>
                    </tr>
                  <?}
                }
                ?>
              </tbody>
            </table>
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
    <?include_once 'includes/bs-scripts.inc';?>
    <script type="text/javascript">
      $(document).ready(function(){
          $('#tbl-Units').DataTable();
      });
    </script>
  
  </body>
</html>