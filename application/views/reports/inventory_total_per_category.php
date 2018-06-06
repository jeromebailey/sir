<!DOCTYPE html>
<html lang="en">
  <head>
    <?include_once 'includes/head.inc'; ?>
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

            <div class="row">
              <div class="col-md-4">
                <label>Category</label>
                <select id="product-category" name="product-category" required="required" class="form-control" onchange="set_url(this.value)" >
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
            </div>

            <br />

            <!--<table class="table table-striped table-hover table-bordered" id="data-table-2">
              <thead>
                <tr>
                  <th>Total Items in Category</th>
                  <th>Total Item Cost in Category</th>
                </tr>                
              </thead>
              <tbody>
                <tr>
                  <td><?=$no_of_items_in_category;?></td>
                  <td><?=$total_product_cost_in_category;?></td>
                </tr>
              </tbody>
            </table>-->


            <table class="table table-striped table-hover table-bordered" id="data-table">
              <thead>
                <tr>
                  <th>Product Name</th>
                  <th>Product Description</th>
                  <th>Price</th>
                  <th>Level</th>
                  <th>Total Item Cost</th>
                </tr>
              </thead>
              <tbody>
                <?
                if( empty($product_category_items_with_item_total_cost) ){?>
                  <tr>
                    <td colspan="5">No data to display</td>
                  </tr>
                <?} else {
                  //echo "<pre>";print_r($all_users);exit;
                    $total_cost = 0;
                    $total_items = 1;

                    foreach ($product_category_items_with_item_total_cost as $key => $value) {
                    $product_id = $value["product_id"];
                    $total_cost += $value["item_total_cost"];
                    ?>
                    <tr>
                      <td><?=$value["product_name"];?></td>
                      <td><?=$value["description"];?></td>
                      <td><?='$'.$value["price"];?></td>
                      <td><?=$value["current_stock_level"];?></td>
                      <td><?='$'.$value["item_total_cost"];?></td>
                    </tr>
                  <?
                  $total_items++;
                  }?>
                  <tr>
                    <td><strong>Total:</strong></td>
                    <td></td>
                    <td></td>
                    <td><?=$total_items;?></td>
                    <td><?='$'.number_format($total_cost, 2, '.', ',');?></td>
                  </tr>
                <?}
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
