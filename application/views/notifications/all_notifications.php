<!DOCTYPE html>
<html lang="en">
  <head>
    <?include_once 'includes/head.inc' ?>
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
            <table class="table table-striped table-hover table-bordered" id="data-table">
              <thead>
                <tr>
                  <th>Title</th>
                  <th>Details</th>
                  <th>Date Received</th>
                  <th>Date Read</th>
                  <th>Status</th>
                  <th>Options</th>
                </tr>
              </thead>
              <tbody>
                <?
                if( empty($notifications) ){?>
                  <tr>
                    <td colspan="7">No data to display</td>
                  </tr>
                <?} else {
                    foreach ($notifications as $key => $value) {?>
                    <tr>
                      <td><?=$value["title"];?></td>
                      <td><?=$value["details"];?></td>
                      <td><?=date("M d, Y", strtotime($value["date_received"]));?></td>
                      <td><?if($value["date_read"] == null){
                                echo "N/A";
                            } else {
                                echo date("M d, Y", strtotime($value["date_read"]));
                            }?></td>
                      <td><?=$value["notification_status"];?></td>
                      <td>
                        <a href="<?=base_url("Notifications/view_notification/" . $value["user_notification_id"]);?>?>" title="Details"><i class="fas fa-file-alt"></i></a> |
                        <a href="" title="Delete"><i class="fas fa-trash-alt"></i></a>
                      </td>
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
    <?include_once 'includes/data-table-scripts.inc';?>
    <script type="text/javascript">
      $(document).ready(function() {
          $('#data-table').DataTable({
            "pageLength": 50
          });
      } );
    </script>

  </body>
</html>
