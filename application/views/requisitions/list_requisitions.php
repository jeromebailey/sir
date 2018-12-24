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

            <button class="btn btn-danger" onclick="window.location.href='<?=base_url('Forms/create_requisition');?>'"><i class="fab fa-product-hunt"></i> Create New Requisition</button>
            <table class="table table-striped table-hover table-bordered" id="data-table">
              <thead>
                <tr>
                  <th>Client's Name</th>
                  <th>Flt Type</th>
                  <th>Flt No.</th>
                  <th>Created By</th>
                  <th>Created On</th>
                  <th>Dispatched</th>
                  <th>Dispatched On</th>
                  <th>Options</th>
                </tr>
              </thead>
              <tbody>
                <?
                if( empty($requisitions) ){?>
                  <tr>
                    <td colspan="7">No data to display</td>
                  </tr>
                <?} else {
                  //echo "<pre>";print_r($clients);exit;
                  foreach ($requisitions as $key => $value) {
                    $requisition_id = $value["requisition_id"];

                    if( $value["flight_type_id"] != 0 && $value["flight_type_id"] < 8000 ){
                      $flight_type = $value["flight_type"];
                      $flight_no = $value["flight_no"];
                    } else {
                      switch ($value["flight_type_id"]) {
                        case 0:
                          $flight_type = "Staff";
                          $flight_no = "Staff";
                          break;

                        case 8000:
                            $flight_type = "Sanitation";
                            $flight_no = "Sanitation";
                          break;

                        case 9000:
                            $flight_type = "Other";
                            $flight_no = "Other";
                          break;
                        
                        default:
                          # code...
                          break;
                      }
                    }
                    
                    //$flight_type = ( $value["flight_type_id"] == 0 ) ? "Staff" : $value["flight_type"];
                    //$flight_no = ( $value["flight_no"] == 0 ) ? "Staff" : $value["flight_no"];
                    ?>
                    <tr>
                      <td><?=$value["client_name"];?></td>
                      <td><?=$flight_type;?></td>
                      <td><?=$flight_no;?></td>
                      <td><?=$value["created_by"];?></td>
                      <td><?= date("M d, Y", strtotime($value["requisition_date"]));?></td>
                      <td>
                        <?
                        if($value["dispatched"] == 1){
                          echo "Yes";
                        } else {
                          echo "No";
                        }?>                        
                      </td>
                      <td>
                        <?
                        if(empty($value["dispatched_date"])){
                          echo "N/A";
                        } else {
                          echo date("M d, Y", strtotime($value["dispatched_date"]));
                        }?>                          
                      </td>
                      <td>
                        <a href="<?=base_url('Requisitions/view_requisition/'.$requisition_id)?>" title="Details"><i class="fas fa-file-alt"></i></a> |

                        <?if($this->sir->user_has_permission_to("duplicate_requisition")){?>
                          <a href="<?=base_url('Requisitions/edit_duplicate_requisition/'.$requisition_id)?>" title="Duplicate"><i class="fas fa-copy"></i></a> |
                        <?}?>

                        <?if($this->sir->user_has_permission_to("dispatch_requisition")){?>
                          <a href="#" onclick="dispatch_requisition(<?=$requisition_id?>)" title="Dispatch"><i class="fas fa-share-square"></i></a> |
                        <?}?>

                        <?if($this->sir->user_has_permission_to("edit_requisition")){?>
                          <a href="<?=base_url('Requisitions/edit_requisition/'.$requisition_id)?>" title="Edit"><i class="fas fa-edit"></i></a> |
                        <?}?>

                        <?if($this->sir->user_has_permission_to("delete_requisition")){?>
                          <a href="#" onClick = "do_delete_item(<?=$requisition_id;?>)" title="Delete"><i class="fas fa-trash-alt"></i></a>
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
        <?include_once 'includes/footer.inc';?>
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
            "order": [[ 4, "desc" ]],
            buttons: [
                'copyHtml5', 'csvHtml5', 'excelHtml5', 'pdfHtml5', 'print'
            ]
          });
      } );

      function do_delete_item(key){
        var do_delete = confirm("Are you sure you want to delete this item?");

        if (do_delete == true) {
            if( key != null ){
              $.post( "<?=base_url('WebService/do_delete_item/requisitions/" + key + "');?>")
              .done(function( data ) {
                if( data == 0 ){
                  $("#msg-holder").addClass('alert-danger');
                  $("#msg-holder").html("Sorry, your requisition was not deleted. Please try again.");
                  $("#msg-holder").show();
                } else {
                  $("#data-table").load(location.href + " #data-table");
                  $("#msg-holder").addClass('alert-success');
                  $("#msg-holder").html("Your requisition was successfully deleted.");
                  $("#msg-holder").show();
                }
              });
            }
        }
      } // end of function

      function dispatch_requisition( requisition_id ){

        var do_dispatch_requisition = confirm("Are you sure you want to dispatch this requisition?");

        if (do_dispatch_requisition == true) {
            if( requisition_id != null ){
              $.post( "<?=base_url('WebService/dispatch_requisition/" + requisition_id + "');?>")
              .done(function( data ) {
                if( data == 0 ){
                  $("#msg-holder").addClass('alert-danger');
                  $("#msg-holder").html("Sorry, your requisition was not dispatched. Please try again.");
                  $("#msg-holder").show();
                } else {
                  $("#data-table").load(location.href + " #data-table");
                  $("#msg-holder").addClass('alert-success');
                  $("#msg-holder").html("Your requisition was successfully dispatched.");
                  $("#msg-holder").show();
                }
              });
            }
        }        
      } //end of function

    </script>
  </body>
</html>
