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

            <ol class="breadcrumb">
              <li><a href="<?=base_url('Reports');?>">Reports</a></li>
              <li class="active"><?=$page_title;?></li>
            </ol>

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

            <table class="table table-striped table-hover table-bordered" id="data-table">
              <thead>
                <tr>
                  <th>Product Name</th>
                  <th>Category</th>
                  <th>Stock Level</th>
                  <th>Options</th>
                </tr>
              </thead>
              <tbody>
                <?
                if( empty($low_stock_in_categories) ){?>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                <?} else {
                  //echo "<pre>";print_r($all_users);exit;
                  foreach ($low_stock_in_categories as $key => $value) {
                    $product_id = $value["product_id"];
                    ?>
                    <tr>
                      <td><?=$value["product_name"];?></td>                      
                      <td><?=$value["category_name"];?></td>
                      <td><?=$value["current_stock_level"];?></td>

                      <td>
                        <a href="" title="Details"><i class="fas fa-file-alt"></i></a> |
                        <a href="<?=base_url('Products/edit_product/'.$product_id);?>" title="Edit"><i class="fas fa-edit"></i></a> |
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
          $('#data-table').DataTable({
            "pageLength": 100,
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5', 'csvHtml5', 'excelHtml5', 'pdfHtml5', 'print'
            ]
          });
      } );

      function set_url( id ){
        var url = "<?=base_url('Reports/low_stock_levels_per_category/')?>";

        url += id;

        window.location.href = url;
      }
    </script>

  </body>
</html>
