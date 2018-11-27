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
                  <th>Product ID</th>
                  <th>Product Name</th>
                  <th width="40%">Product Description</th>
                  <th>Price</th>
                  <th>Unit</th>
                  <th>Level</th>
                </tr>
              </thead>
              <tbody>
                <?
                if( empty($product_category_items_with_item_total_cost) ){?>
                  <tr>
                    <td colspan="6">No data to display</td>
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
                      <td><?=$product_id;?></td>
                      <td><?=$value["product_name"];?></td>
                      <td><?=$value["description"];?></td>
                      <td><?='$'.$value["price"];?></td>
                      <td>
                        <?=$value["unit_abbreviation"];?>
                      </td>
                      <td><?=$value["current_stock_level"];?></td>
                    </tr>
                  <?
                  $total_items++;
                  }
                }?>
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
    <script src="https://cdn.jsdelivr.net/npm/jquery-tabledit@1.0.0/jquery.tabledit.min.js"></script>
    <script type="text/javascript">

      $(document).ready(function() {
        

          $('#data-table').DataTable({
            "pageLength": 50,
            "ordering": false,
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5', 'csvHtml5', 'excelHtml5', 'pdfHtml5', 'print'
            ]
          });

          $('#data-table').Tabledit({
            url: "<?=base_url('ajax/commit-db-edits.php');?>",
            type : "POST",
            dataType : "json",
            editButton: true,
            deleteButton: false,
            hideIdentifier: true,
            columns: {
              identifier: [0, 'id'],                   
              editable: [[1, 'product_name'], [2, 'description'], [3, 'price'], [5, 'level']]
            },
            onDraw: function() {
                console.log('onDraw()');
            },
            onAjax: function(action, serialize) {
              // open your xhr here 
              console.log("on Ajax");
              console.log("action : ", action);
              console.log("data : ", serialize);
          },
            onSuccess: function(data, textStatus, jqXHR) {
                console.log('onSuccess(data, textStatus, jqXHR)');
                console.log("data: " + data);
                console.log("status: " + textStatus);
                console.log("object: " + jqXHR);
            },
            onFail: function(jqXHR, textStatus, errorThrown) {
                console.log('onFail(jqXHR, textStatus, errorThrown)');
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            }
          });
      } );

      function set_url( id ){
        var url = "<?=base_url('Reports/pricing_inventory/')?>";

        url += id;

        window.location.href = url;
      }
    </script>

  </body>
</html>
