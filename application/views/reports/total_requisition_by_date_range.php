<!DOCTYPE html>
<html lang="en">
  <head>
    <?include_once 'includes/head.inc'; ?>
    <?include_once 'includes/data-table-css.inc'; ?>
    <link rel="stylesheet" href="<?=base_url('assets/css/jquery-ui.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/css/bootstrapValidator.css');?>">
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
            <ol class="breadcrumb">
              <li><a href="<?=base_url('Reports');?>">Reports</a></li>
              <li class="active"><?=$page_title;?></li>
            </ol>

            <h3><?=$page_title;?></h3>

            <div class="row" >
              <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
                <div class="alert " id="msg-holder"></div>
              </div>
            </div>

            <form method="post" id="frm" data-toggle="validator" role="form" action="<?=base_url('Reports/do_search_total_requisition_by_date_range')?>">
              <div class="row">
                <div class="col-md-2">
                  <label>Start Date</label>
                  <?
                  if( empty($start_date) && $start_date == null ){?>
                    <input type="text" name="start-date" id="start-date" class="form-control input-sm" autocomplete="off" required="required">
                  <?} else {?>
                    <input type="text" name="start-date" id="start-date" class="form-control input-sm" value="<?=$start_date?>" autocomplete="off" required="required">
                  <?}?>                  
                </div>

                <div class="col-md-2">
                  <label>End Date</label>
                  <?
                  if( empty($end_date) && $end_date == null ){?>
                    <input type="text" name="end-date" id="end-date" class="form-control input-sm" autocomplete="off" required="required">
                  <?} else {?>
                    <input type="text" name="end-date" id="end-date" class="form-control input-sm" value="<?=$end_date?>" autocomplete="off" required="required">
                  <?}?>                  
                </div>

                <div class="col-md-2">
                  <button class="btn btn-success btn-sm align_small_button_with_text_field_no_label" name="btn" id="btn" type="submit" ><i class="fa fa-search"></i> Search</button>
                </div>
              </div>

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
                  <th>Total</th>
                  <th>Options</th>
                </tr>
              </thead>
              <tbody>
                <?
                if( empty($requisition_results) ){?>
                  <tr>
                    <td colspan="7">No data to display</td>
                  </tr>
                <?} else {
                  //echo "<pre>";print_r($clients);exit;
                  $total_date_range_cost = 0;
                  foreach ($requisition_results as $key => $value) {
                    $requisition_id = $value["requisition_id"];

                    $item_total = $value["total_cost"];

                    $total_date_range_cost += $item_total;
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
                        <?=$item_total;?>
                      </td>
                      <td>
                        <a href="<?=base_url('Requisitions/view_requisition/'.$requisition_id)?>" title="Details"><i class="fas fa-file-alt"></i></a>
                      </td>
                    </tr>
                  <?}?>
                  <tr>
                    <td colspan="7"><strong>Grand Total</strong></td>
                    <td><strong>$<?=sprintf("%.2f", $total_date_range_cost);?></strong></td>
                    <td></td>
                  </tr>
                <?}
                ?>
                
              </tbody>
            </table>


            </form>
            
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
    <script src="<?=base_url('assets/js/bootstrapValidator.js');?>"></script>
    <script src="<?=base_url('assets/js/jquery-ui.min.js');?>"></script>

    <script type="text/javascript">
      $(document).ready(function() {
        $("#msg-holder").hide();
        //$('#frm').validator();

        $( "#start-date" ).datepicker({ 
          dateFormat: 'yy-mm-dd',
          changeYear: true
        });

        $( "#end-date" ).datepicker({ 
          dateFormat: 'yy-mm-dd',
          changeYear: true
        });

        $('#data-table').DataTable({
          dom: 'Bfrtip',
          "pageLength": 0,
          "order": [[ 4, "desc" ]],
          buttons: [
              'copyHtml5', 'csvHtml5', 'excelHtml5', 'pdfHtml5', 'print'
          ]
        });
      } );

    </script>
  </body>
</html>
