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
            <h3><?=$page_title;?></h3> <button class="btn btn-danger" onclick="window.location.href='<?=base_url('Products/add_product');?>'"><i class="fab fa-product-hunt"></i> Add New Product</button>

            <div class="row" >
              <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
                <div class="alert " id="msg-holder"></div>
              </div>
            </div>

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

            <table class="table table-striped table-hover table-bordered" id="data-table">
              <thead>
                <tr>
                  <th>Barcode</th>
                  <th>Product Name</th>
                  <th>Product Description</th>
                  <th>Category</th>
                  <th>Price</th>
                  <th>Options</th>
                </tr>
              </thead>
              <tbody>
                <?
                if( empty($products) ){?>
                  <tr>
                    <td colspan="7">No data to display</td>
                  </tr>
                <?} else {
                  //echo "<pre>";print_r($all_users);exit;
                  foreach ($products as $key => $value) {
                    $product_id = $value["product_id"];
                    ?>
                    <tr>
                      <td width="15%"><?=$value["barcode"];?></td>
                      <td><?=$value["product_name"];?></td>
                      <td><?=$value["description"];?></td>
                      <td><?=$value["category_name"];?></td>
                      <td><?=$value["price"];?></td>

                      <td>
                        <a href="<?=base_url('Products/view_product/'.$product_id);?>" title="Details"><i class="fas fa-file-alt"></i></a> |
                        <a href="<?=base_url('Products/edit_product/'.$product_id);?>" title="Edit"><i class="fas fa-edit"></i></a> |
                        <a href="#" onClick = "do_delete_item(<?=$product_id;?>)" title="Delete"><i class="fas fa-trash-alt"></i></a>
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
            "pageLength": 100,
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5', 'csvHtml5', 'excelHtml5', 'pdfHtml5', 'print'
            ]
          });
      } );

      function do_delete_item(key){
        var do_delete = confirm("Are you sure you want to delete this item?");

        if (do_delete == true) {
            if( key != null ){
              $.post( "<?=base_url('WebService/do_delete_item/products/" + key + "');?>")
              .done(function( data ) {
                if( data == 0 ){
                  $("#msg-holder").addClass('alert-danger');
                  $("#msg-holder").html("Sorry, your Product was not deleted. Please try again.");
                  $("#msg-holder").show();
                } else {
                  $("#data-table").load(location.href + " #data-table");
                  $("#msg-holder").addClass('alert-success');
                  $("#msg-holder").html("Your Product was successfully deleted.");
                  $("#msg-holder").show();
                }
              });
            }
        }
      } // end of function

      function set_url( id ){
        var url = "<?=base_url('Products/index/')?>";

        url += id;

        window.location.href = url;
      }
    </script>

  </body>
</html>
