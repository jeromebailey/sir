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

          <?include_once 'includes/status_message.inc';?>

          <ol class="breadcrumb">
              <li><a href="<?=base_url('Products');?>">Products</a></li>
              <li class="active">Edit Product</li>
            </ol>

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Product Information</a></li>
              <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Product Stock Level</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="home">
                <h3><?=$page_title;?> <i class="fas fa-box"></i></h3>

                <div class="row" >
                  <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
                    <div class="alert " id="msg-holder"></div>
                  </div>
                </div>

                <form id="demo-form2" data-toggle="validator" class="form-horizontal form-label-left" method="post" action="<?=base_url('Products/do_edit_product');?>">

                  <input type="hidden" name="product_id" id="product_id" value="<?=$product['product_id'];?>">

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bar-code">Product Bar Code </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" id="bar-code" name="bar-code" autocomplete="off" class="form-control col-md-7 col-xs-12" value="<?=$product['barcode'];?>" readonly> 

                      <?
                      if( empty($product['barcode']) ){?>
                        <a href="#" onclick="generate_barcode_for_product(<?=$product['product_id'];?>)">Generate Barcode</a>
                      <?}?>

                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="product-name">Product Name <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" id="product-name" value="<?=$product['product_name'];?>" name="product-name" required="required" autocomplete="off" class="form-control col-md-7 col-xs-12">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bar-code">Product Category <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <select id="product-category" name="product-category" required="required" class="form-control col-md-7 col-xs-12">
                      <option value="">Select Product Category</option>
                      <?if( !empty($categories) ){
                          foreach ($categories as $key => $value) {
                            if( $value["category_id"] == $product['product_category_id'] ){?>
                              <option value="<?=$value["category_id"];?>" selected><?=$value["category_name"];?></option>
                            <?} else {?>
                              <option value="<?=$value["category_id"];?>"><?=$value["category_name"];?></option>
                            <?}
                          }
                        } else {

                        }?>
                      </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bar-code">Product Price <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" id="product-price" name="product-price" required="required" autocomplete="off" class="form-control col-md-7 col-xs-12" value="<?=$product['price'];?>">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bar-code">Product Weight </label>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                      <input type="text" id="product-weight" name="product-weight" autocomplete="off" class="form-control col-md-7 col-xs-12" value="<?=$product['weight'];?>">
                    </div>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                      <select id="unit-id" name="unit-id" class="form-control" >
                        <?if( !empty($uom) ){
                            foreach ($uom as $key => $value) {
                              if($product["unit_id"] == $value["unit_id"]){?>
                                <option value="<?=$value["unit_id"]?>" selected><?=$value["unit_abbreviation"];?></option>
                              <?} else {?>
                                <option value="<?=$value["unit_id"]?>"><?=$value["unit_abbreviation"];?></option>
                              <?}                              
                            }
                          } else {

                          }?>
                      </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="product-description">Product Description </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <?//include_once 'includes/text-area-toolbar-with-image.inc'; ?>
                      <!--<div id="editor-one" class="editor-wrapper"></div>-->
                      <textarea name="product-description" id="product-description" class="form-control" ><?=$product['description'];?></textarea> <!-- style="display:none;" -->
                    </div>
                  </div>

                  <div class="ln_solid"></div>
                  <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                      <button type="submit" class="btn btn-lg btn-success">Submit</button>
                    </div>
                  </div>

                </form>
              </div>
              <div role="tabpanel" class="tab-pane" id="profile">
                <h3>Product Stock Level <i class="fas fa-box"></i></h3>

                <form id="frm-sl" data-toggle="validator" class="form-horizontal form-label-left" method="post" action="<?=base_url('Products/do_edit_product_stock_level');?>">

                  <input type="hidden" name="product_id" id="product_id" value="<?=$product['product_id'];?>">

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bar-code">New Stock Level <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" id="new-stock-level" name="new-stock-level" required="required" autocomplete="off" class="form-control col-md-7 col-xs-12" value="">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bar-code">Minimum Stock Level <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <?
                      if( empty($product_min_max_data) ){?>
                        <input type="text" id="minimum-stock-level" name="minimum-stock-level" required="required" autocomplete="off" class="form-control col-md-7 col-xs-12" value="">
                      <?} else {?>
                        <input type="text" id="minimum-stock-level" name="minimum-stock-level" required="required" autocomplete="off" class="form-control col-md-7 col-xs-12" value="<?=$product_min_max_data['minimum_stock_level'];?>">
                      <?}?>                      
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bar-code">Maximum Stock Level</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <?
                      if( empty($product_min_max_data) ){?>
                        <input type="text" id="maximum-stock-level" name="maximum-stock-level" autocomplete="off" class="form-control col-md-7 col-xs-12" value="">
                      <?} else {?>
                        <input type="text" id="maximum-stock-level" name="maximum-stock-level" autocomplete="off" class="form-control col-md-7 col-xs-12" value="<?=$product_min_max_data['maximum_stock_level'];?>">
                      <?}?>                      
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bar-code">Unit <span class="required">*</span>
                    </label>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                      <select id="unit-id" name="unit-id" class="form-control" >
                        <?if( !empty($uom) ){
                          if( !empty($product["unit_id"]) ){
                            foreach ($uom as $key => $value) {
                              if($product["unit_id"] == $value["unit_id"]){?>
                                <option value="<?=$value["unit_id"]?>" selected><?=$value["unit_abbreviation"];?></option>
                              <?} else {?>
                                <option value="<?=$value["unit_id"]?>"><?=$value["unit_abbreviation"];?></option>
                              <?}                              
                            }
                          } else {
                            foreach ($uom as $key => $value) {?>
                              <option value="<?=$value["unit_id"]?>"><?=$value["unit_abbreviation"];?></option>
                            <?}
                          }                            
                        } else {

                        }?>
                      </select>
                    </div>
                  </div>

                  

                  <div class="ln_solid"></div>
                  <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                      <button type="submit" class="btn btn-lg btn-success">Submit</button>
                    </div>
                  </div>

                </form>
              </div>
            </div>

            

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
    <script src="<?=base_url('assets/js/bootstrap-wysiwyg.min.js');?>"></script>
    <script src="<?=base_url('assets/js/prettify.js');?>"></script>
    <script src="<?=base_url('assets/js/bootstrapValidator.js');?>"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        $("#msg-holder").hide();
      });

      function generate_barcode_for_product( product_id ){
        var product_category_id = $("#product-category").val();

        if( product_category_id == "" ){
          $("#msg-holder").addClass('alert-danger');
          $("#msg-holder").html("Please update the Product Category before trying to generate a barcode for this product.");
          $("#msg-holder").show();
        } else {
          $.post( "<?=base_url('WebService/generate_product_barcode/" + product_id + "');?>")
            .done(function( data ) {
            console.log( "response: " + data );

            if( data != "" ){
              $("#msg-holder").addClass('alert-success');
              $("#msg-holder").html("The barcode was successfully generated for the product!");
              $("#msg-holder").show();
              $("#bar-code").val( data );
            } else {
              $("#msg-holder").addClass('alert-danger');
              $("#msg-holder").html("Sorry, no barcode was generated for the product. Please try again.");
              $("#msg-holder").show();
            }            
          })
          .fail(function() {
            $("#msg-holder").addClass('alert-danger');
            $("#msg-holder").html("Sorry, there was a problem generating the barcode for the product. Please try again.");
            $("#msg-holder").show();
          });
        }
      }
    </script>

  </body>
</html>
