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
                  <th>Quote No</th>
                  <th>Client Name</th>
                  <th>Quote Date</th>
                  <th>Created By</th>
                  <th>Options</th>
                </tr>
              </thead>
              <tbody>
                <?
                if( empty($quotes) ){?>
                  <tr>
                    <td colspan="7">No data to display</td>
                  </tr>
                <?} else {
                  //echo "<pre>";print_r($quotes);exit;
                  foreach ($quotes as $key => $value) {
                  $quote_id = $value["quote_id"];
                    ?>
                    <tr>
                      <td><?=$value["quote_no"];?></td>
                      <td><?=$value["client_name"];?></td>
                      <td><?= date('M d, y', strtotime($value["quote_date"]));?></td>
                      <td><?=$value["created_by"];?></td>
                        <td>
                        <a href="<?=base_url('Quotes/view_quote/'.$quote_id)?>" title="Details"><i class="fas fa-file-alt"></i></a> |

                        <?if($this->sir->user_has_permission_to("edit_quote")){?>
                          <a href="<?=base_url('Quotes/edit_quote/'.$quote_id)?>" title="Edit"><i class="fas fa-edit"></i></a> |
                        <?}?>

                        <?if($this->sir->user_has_permission_to("delete_quote")){?>
                          <a href="#" onClick = "do_delete_item(<?=$quote_id;?>)" title="Delete"><i class="fas fa-trash-alt"></i></a>
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
            "order": [[ 0, "desc" ]],
            buttons: [
                'copyHtml5', 'csvHtml5', 'excelHtml5', 'pdfHtml5', 'print'
            ]
          });
      } );

      function do_delete_item(key){
        var do_delete = confirm("Are you sure you want to delete this item?");

        if (do_delete == true) {
            if( key != null ){
              $.post( "<?=base_url('WebService/do_delete_item/quotes/" + key + "');?>")
              .done(function( data ) {
                if( data == 0 ){
                  $("#msg-holder").addClass('alert-danger');
                  $("#msg-holder").html("Sorry, your Quote was not deleted. Please try again.");
                  $("#msg-holder").show();
                } else {
                  $("#data-table").load(location.href + " #data-table");
                  $("#msg-holder").addClass('alert-success');
                  $("#msg-holder").html("Your Quote was successfully deleted.");
                  $("#msg-holder").show();
                }
              });
            }
        }
      } // end of function
    </script>
  </body>
</html>
