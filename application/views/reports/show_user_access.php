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
            
            <table class="table table-striped table-hover table-bordered" id="data-table" style="table-layout: fixed; word-wrap: break-word;">
              <thead>
                <tr>
                  <th>User ID</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <!--<th>Dep Name</th>-->
                  <th width="70%">Permissions</th>
                </tr>
              </thead>
              <tbody>
                <?
                if( empty($access_for_users) ){?>
                  <tr>
                    <td colspan="7">No data to display</td>
                  </tr>
                <?} else {
                  //echo "<pre>";print_r($access_for_users);exit;
                  foreach ($access_for_users as $key => $value) {
                    //$encrypted_user_id = urlencode(base64_encode($value["user_id"]));
                    //$encrypted_user_id = $this->encryption->encrypt($value["user_id"]);
                    ?>
                    <tr>
                      <td><?=$value["user_id"];?></td>
                      <td><?=$value["first_name"];?></td>
                      <td><?=$value["last_name"];?></td>
                      <!--<td><?//=$value["department_name"];?></td>-->
                      <td width="70%"><?=$value["permissions"];?></td>
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
            "pageLength": 50,
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5', 'csvHtml5', 'excelHtml5', 'pdfHtml5', 'print'
            ]
          });
      } );
    </script>
  </body>
</html>
