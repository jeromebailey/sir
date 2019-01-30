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

            <form method="post" id="frm" data-toggle="validator" role="form" action="<?=base_url('Reports/do_search_requisition_category_item_level_cost_by_date_range')?>">

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

                <div class="col-md-4">
                  <label>Category</label>
                  <select id="product-category" name="product-category" required="required" class="form-control" >
                    <option value="">Select Product Category</option>
                    <?if( !empty($categories) ){
                        foreach ($categories as $key => $value) {
                          if($category_id == $value["category_id"]){?>
                            <option value="<?=$value["category_id"]?>" selected><?=$value["category_name"];?></option>
                          <?} else {?>
                            <option value="<?=$value["category_id"]?>"><?=$value["category_name"];?></option>
                          <?}                        
                        }
                      } else {

                      }?>
                  </select>
                </div>

                <div class="col-md-2">
                  <button class="btn btn-success btn-sm align_small_button_with_text_field_no_label" name="btn" id="btn" type="submit" ><i class="fa fa-search"></i> Search</button>
                </div>
              </div>

              <br />

              <table class="table table-striped table-hover table-bordered" id="data-table">
                <thead>
                  <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Amount</th>
                    <th>Unit</th>
                    <th>Total Item Cost</th>
                  </tr>
                </thead>
                <tbody>
                  <?
                  if( empty($requisition_category_log) ){?>
                    <tr>
                      <td colspan="5">No data to display</td>
                    </tr>
                  <?} else {
                    //echo "<pre>";print_r($requisition_category_log);exit;
                      $total_cost = $grand_total_cost = 0;
                      $total_items = 1;

                      $selected_column_data = json_decode($requisition_category_log[0]["column_data"]);
                      //echo "<pre>";print_r($selected_column_data);exit;
                      if( empty( $selected_column_data ) ){?>
                        <tr>
                          <td colspan="5">No data to display</td>
                        </tr>
                      <?} else {
                        foreach ($selected_column_data as $key => $value) {
                          //echo "<pre>";print_r($key);exit;
                          $product_id = $value->product_id;
                          $total_cost = $value->price * $value->amount;
                          $grand_total_cost += $total_cost;
                          ?>
                          <tr>
                            <td><?=$value->product_name;?></td>
                            <td><?='$'.$value->price;?></td>
                            <td><?=$value->amount;?></td>
                            <td><?=$value->unit;?></td>
                            <td><?='$'.$total_cost;?></td>
                          </tr>
                        <?
                        $total_items++;
                        }
                      }
                      ?>
                    <tr>
                      <td><strong>Total:</strong></td>
                      <td></td>
                      <td></td>
                      <td><?//=$total_items;?></td>
                      <td><?='$'.number_format($grand_total_cost, 2, '.', ',');?></td>
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
    <script src="<?=base_url('assets/js/jquery-ui.min.js');?>"></script>
    <script type="text/javascript">
      $(document).ready(function() {

        $( "#start-date" ).datepicker({ 
          dateFormat: 'yy-mm-dd',
          changeYear: true
        });

        $( "#end-date" ).datepicker({ 
          dateFormat: 'yy-mm-dd',
          changeYear: true
        });

          $('#data-table').DataTable({
            "pageLength": 1000,
            "ordering": false,
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5', 'csvHtml5', 'excelHtml5', 'pdfHtml5', 'print'
            ]
          });
      } );

      function set_url( id ){
        var url = "<?=base_url('Reports/inventory_total_per_category/')?>";

        url += id;

        window.location.href = url;
      }
    </script>

  </body>
</html>
