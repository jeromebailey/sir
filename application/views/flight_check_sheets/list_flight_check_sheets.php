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

            <div class="row" >
              <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
                <div class="alert " id="msg-holder"></div>
              </div>
            </div>

            <table class="table table-striped table-hover table-bordered" id="data-table">
              <thead>
                <tr>
                  <th>Check Sheet No.</th>
                  <th>Client Name</th>                  
                  <th>Flight No.</th>
                  <th>Cycle</th>
                  <th>Date/Time</th>
                  <th>Created By</th>
                  <th>Options</th>
                </tr>
              </thead>
              <tbody>
                <?
                if( empty($flight_check_sheets) ){?>
                  <tr>
                    <td colspan="7">No data to display</td>
                  </tr>
                <?} else {
                  //echo "<pre>";print_r($flight_check_sheets);exit;
                  foreach ($flight_check_sheets as $key => $value) {
                  $id = $value["sheet_no"];
                    ?>
                    <tr>
                      <td><?=$value["check_sheet_no"];?></td>
                      <td><?=$value["client_name"];?></td>
                      <td><?=$value["flight_no"];?></td>
                      <td><?=$value["cycle"];?></td>
                      <td><?= date('M d, Y', strtotime($value["date_time"]));?></td>
                      <td><?=$value["created_by"];?></td>
                      <td>
                        <a href="<?=base_url('FlightCheckSheets/view_flight_check_sheet/'.$id)?>" title="Details"><i class="fas fa-file-alt"></i></a> |

                        <?if($this->sir->user_has_permission_to("duplicate_flight_check_sheet")){?>
                          <a href="<?=base_url('FlightCheckSheets/duplicate_flight_check_sheet/'.$id)?>" title="Duplicate"><i class="fas fa-copy"></i></a> |
                        <?}?>

                        <?if($this->sir->user_has_permission_to("edit_flight_check_sheet")){?>
                          <a href="<?=base_url('FlightCheckSheets/edit_flight_check_sheet/'.$id)?>" title="Edit"><i class="fas fa-edit"></i></a> |
                        <?}?>
                        
                        <?if($this->sir->user_has_permission_to("delete_flight_check_sheet")){?>
                          <a href="#" onClick = "do_delete_item(<?=$id;?>)" title="Delete"><i class="fas fa-trash-alt"></i></a>
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
              $.post( "<?=base_url('WebService/do_delete_item/flight_check_sheets/" + key + "');?>")
              .done(function( data ) {
                if( data == 0 ){
                  $("#msg-holder").addClass('alert-danger');
                  $("#msg-holder").html("Sorry, your Flight Check Sheet was not deleted. Please try again.");
                  $("#msg-holder").show();
                } else {
                  $("#data-table").load(location.href + " #data-table");
                  $("#msg-holder").addClass('alert-success');
                  $("#msg-holder").html("Your Flight Check Sheet was successfully deleted.");
                  $("#msg-holder").show();
                }
              });
            }
        }
      } // end of function
    </script>
  </body>
</html>
