<!DOCTYPE html>
<html lang="en">
  <head>
    <?include_once 'includes/head.inc'; ?>
    <?include_once 'includes/data-table-css.inc'; ?>
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

            <div class="row" >
              <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
                <div class="alert " id="msg-holder"></div>
              </div>
            </div>

            <button class="btn btn-danger" onclick="window.location.href='<?=base_url('Suppliers/add_supplier');?>'"><i class="fab fa-user-hunt"></i> Add New Supplier</button>
            <table class="table table-striped table-hover table-bordered" id="data-table">
              <thead>
                <tr>
                  <th>Supplier's Name</th>
                  <th>Address Ln 1</th>
                  <th>Address Ln 2</th>
                  <th>City</th>
                  <th>State</th>
                  <th>Zip</th>
                  <th>Territory</th>
                  <th>Options</th>
                </tr>
              </thead>
              <tbody>
                <?
                if( empty($suppliers) ){?>
                  <tr>
                    <td colspan="7">No data to display</td>
                  </tr>
                <?} else {
                  //echo "<pre>";print_r($suppliers);exit;
                  foreach ($suppliers as $key => $value) {
                    $supplier_id = $value["supplier_id"];
                    ?>
                    <tr>
                      <td><?=$value["supplier_name"];?></td>
                      <td><?=$value["address_line_1"];?></td>
                      <td><?=$value["address_line_1"];?></td>
                      <td><?=$value["city"];?></td>
                      <td><?=$value["state"];?></td>
                      <td><?=$value["zip"];?></td>
                      <td>
                        <?if($value["is_local"] == 1){
                          echo "Local";
                        } else if( $value["is_local"] == 2 ){
                          echo "Overseas";
                        } else {
                          echo "N/A";
                        }?></td>
                      <td>
                        <a href="<?=base_url('Suppliers/view_supplier/'.$supplier_id)?>" title="Details"><i class="fas fa-file-alt"></i></a> |

                        <?if($this->sir->user_has_permission_to("edit_supplier")){?>
                          <a href="<?=base_url('Suppliers/edit_supplier/'.$supplier_id)?>" title="Edit"><i class="fas fa-edit"></i></a> |
                        <?}?>

                        <?if($this->sir->user_has_permission_to("delete_supplier")){?>
                          <a href="#" onClick = "do_delete_item(<?=$supplier_id;?>)" title="Delete"><i class="fas fa-trash-alt"></i></a>
                        <?}?>                        
                        
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
        $("#msg-holder").hide();
          $('#data-table').DataTable({
            dom: 'Bfrtip',
            "pageLength": 50,
            buttons: [
                'copyHtml5', 'csvHtml5', 'excelHtml5', 'pdfHtml5', 'print'
            ]
          });
      } );

      function do_delete_item(key){
        var do_delete = confirm("Are you sure you want to delete this item?");

        if (do_delete == true) {
            if( key != null ){
              $.post( "<?=base_url('WebService/do_delete_item/suppliers/" + key + "');?>")
              .done(function( data ) {
                if( data == 0 ){
                  $("#msg-holder").addClass('alert-danger');
                  $("#msg-holder").html("Sorry, Supplier was not deleted. Please try again.");
                  $("#msg-holder").show();
                } else {
                  $("#data-table").load(location.href + " #data-table");
                  $("#msg-holder").addClass('alert-success');
                  $("#msg-holder").html("Supplier was successfully deleted.");
                  $("#msg-holder").show();
                }
              });
            }
        }
      } // end of function
    </script>
  </body>
</html>
