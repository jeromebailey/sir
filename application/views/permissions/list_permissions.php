<!DOCTYPE html>
<html lang="en">
  <head>
    <?include_once 'includes/head.inc' ?>
    <?include_once 'includes/data-table-css.inc' ?>
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
                  <th>Permission</th>
                  <th>Permission Description</th>
                  <th>Options</th>
                </tr>
              </thead>
              <tbody>
                <?
                if( empty($permissions) ){?>
                  <tr>
                    <td colspan="7">No data to display</td>
                  </tr>
                <?} else {
                  //echo "<pre>";print_r($permissions);exit;
                  foreach ($permissions as $key => $value) {
                    $id = $value["permission_id"];
                    ?>
                    <tr>
                      <td><?=$value["permission"];?></td>
                      <td><?=$value["description"];?></td>
                      <td>
                        <a href="" title="Details"><i class="fas fa-file-alt"></i></a> |
                        <a href="<?=base_url('Permissions/edit_permission/'.$id)?>" title="Edit"><i class="fas fa-edit"></i></a> |
                        <a href="javascript:delete(<?=$id?>)" title="Delete"><i class="fas fa-trash-alt"></i></a>
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
        <?include_once 'includes/footer.inc'?>
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
