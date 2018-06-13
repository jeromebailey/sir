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
              <li class="active">View Product</li>
            </ol>

            <!-- Tab panes -->
                <h3><?=$page_title;?> <i class="fas fa-box"></i></h3>

                <form id="demo-form2" data-toggle="validator" class="form-horizontal form-label-left" method="post" action="<?=base_url('Products/do_edit_product');?>">

                  <input type="hidden" name="product_id" id="product_id" value="<?=$product['product_id'];?>">

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bar-code">Product Bar Code: </label>
                    <div class="col-md-6 col-sm-6 col-xs-12 align_text_with_label_no_input">
                      <?
                      if( empty($product['barcode']) ){
                        echo "No Bar Code has been set for this product as yet.";
                      } else {
                        echo $product['barcode'];
                      }?>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="product-name">Product Name: </label>
                    <div class="col-md-6 col-sm-6 col-xs-12 align_text_with_label_no_input" >
                      <?=$product['product_name'];?>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bar-code">Product Category: </label>
                    <div class="col-md-6 col-sm-6 col-xs-12 align_text_with_label_no_input">
                      
                      <?
                      $category_name = "";

                      if( !empty($categories) ){
                          foreach ($categories as $key => $value) {
                            if( $value["category_id"] == $product['product_category_id'] ){
                              $category_name =  $value["category_name"];
                            } else {
                              
                            }
                          }
                        } else {

                        }

                        if( empty($category_name) ){
                          echo "No category has been set for this product as yet.";
                        } else {
                          echo $category_name;
                        }?>
                      
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bar-code">Product Price: </label>
                    <div class="col-md-6 col-sm-6 col-xs-12 align_text_with_label_no_input">
                      <?= "$". $product['price'];?>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bar-code">Product Weight: </label>
                    <div class="col-md-4 col-sm-6 col-xs-12 align_text_with_label_no_input">
                      <?
                      if( empty($product['weight']) ){
                        echo "This product has no weight inputted for it.";
                      } else {
                        $unit_of_measurement = "";
                        if( !empty($uom) ){
                            foreach ($uom as $key => $value) {
                              if($product["unit_id"] == $value["unit_id"]){
                                $unit_of_measurement = $value["unit_abbreviation"];
                              } else {
                                
                              }                              
                            }
                          } else {

                          }

                          if( empty($unit_of_measurement) ){
                            echo $product['weight'] . " N/A";
                          } else {
                            echo $product['weight'] . " " . $unit_of_measurement;
                          }
                        }?>

                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="product-description">Product Description: </label>
                    <div class="col-md-6 col-sm-6 col-xs-12 align_text_with_label_no_input">
                      <?=$product['description'];?>
                    </div>
                  </div>

                  <div class="ln_solid"></div>


                </form>


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
