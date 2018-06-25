<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?=base_url('assets/bootstrap-3.3.7/dist/css/bootstrap.min.css');?>" rel="stylesheet">
    <!--<link rel="stylesheet" href="<?=base_url('assets/css/jquery-ui.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/css/bootstrapValidator.css');?>">-->
    <meta http-equiv="X-UA-Compatible" content="IE=7" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <div class="container-fluid">

            <?include_once 'includes/status_message.inc';?>
            
            <h3><?=$page_title;?> <i class="fas fa-box"></i></h3>

            <?
            if( empty($product) ){?>
              <div class="row" >
                <div class="col-md-12 col-sm-12 col-xs-8">
                  <div class="alert alert-danger" >Sorry, no product exist with that barcode</div>
                </div>
              </div> 

              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-8">
                  <button type="button" class="btn btn-primary" onclick="window.location.href = '../ProductScanner/search'">Find another Product</button>
                </div>
              </div>
            <?} else {?>
              <form id="demo-form2" method="post" data-toggle="validator" class="form-horizontal form-label-left" action="<?=base_url('ProductScanner/update_product_stock_level');?>">

                <fieldset>
                  <legend>Product Details</legend>

                  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bar-code">Product Bar Code <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-8">
                          <input type="text" id="bar-code" name="bar-code" required="required" value="<?=$product['barcode'];?>" autocomplete="off" class="form-control col-md-7 col-xs-8">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="product-name">Product Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-8">
                          <input type="text" id="product-name" name="product-name" value="<?=$product['product_name'];?>" required="required" autocomplete="off" class="form-control col-md-7 col-xs-8">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="product-category">Product Category <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-8">
                          <select id="product-category" name="product-category" required="required" class="form-control col-md-7 col-xs-8">
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="product-price">Product Price <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-8">
                          <input type="text" id="product-price" name="product-price" value="<?=$product['price'];?>" required="required" autocomplete="off" class="form-control col-md-7 col-xs-8">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="product-weight">Product Weight <span class="required">*</span>
                        </label>

                        <div class="col-md-4 col-sm-6 col-xs-8">
                          <input type="text" id="product-weight" name="product-weight" autocomplete="off" class="form-control col-md-7 col-xs-12" value="<?=$product['weight'];?>">
                        </div>
                        <div class="col-md-2 col-sm-6 col-xs-8">
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
                        <div class="col-md-6 col-sm-6 col-xs-8">
                          <?//include_once 'includes/text-area-toolbar-with-image.inc'; ?>
                          <!--<div id="editor-one" class="editor-wrapper"></div>-->
                          <textarea name="product-description" id="product-description" class="form-control" ><?=$product['description'];?></textarea> <!-- style="display:none;" -->
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="amt-in-stock">Current Stock Level <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-8">
                          <input type="text" id="amt-in-stock" name="amt-in-stock" autocomplete="off" class="form-control col-md-7 col-xs-12" readonly="readonly" value="<?=$product['current_stock_level']?>">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="inventory-amt">New Amount to add <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-8">
                          <input type="text" id="inventory-amt" name="inventory-amt" required="required" autocomplete="off" class="form-control col-md-7 col-xs-8">
                        </div>
                      </div>

                      <div class="ln_solid"></div>

                      <input type="hidden" name="product_id" id="product_id" value="<?=$product['product_id'];?>">

                      <br />

                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-8 col-md-offset-3">
                          <button type="submit" class="btn btn-success">Update Stock Information</button>
                        </div>
                      </div>
                </fieldset>
              </form>
            <?}?>

    </div>

    <!-- jQuery -->
    <?include_once 'includes/scripts.inc';?>
    <script src="<?=base_url('assets/js/bootstrap-wysiwyg.min.js');?>"></script>
    <script src="<?=base_url('assets/js/prettify.js');?>"></script>
    <script src="<?=base_url('assets/js/bootstrapValidator.js');?>"></script>
    <script src="<?=base_url('assets/js/jquery-ui.min.js');?>"></script>

    <script type="text/javascript">

      $(document).ready(function(){
      	$("#msg-holder").hide();
      	$("#s-bar-code").focus();

        $( "#inventory-date" ).datepicker({ 
            dateFormat: 'yy-mm-dd'
          });
      });

      $("#btnSetInventoryDate").click(function(){
        var inventory_date = $("#inventory-date").val();

        if( inventory_date == '' || inventory_date == null ){
          $("#msg-holder").addClass('alert-danger');
            $("#msg-holder").html("Please select an Inventory Date.");
            $("#msg-holder").show();
        } else {
          $.post( "<?=base_url('WebService/set_inventory_date/" + inventory_date + "');?>")
            .done(function( data ) {
console.log( "response: " + data );
            if( data == 0 ){
              $("#msg-holder").addClass('alert-danger');
              $("#msg-holder").html("Sorry, Inventory Date was not set. Please try again.");
              $("#msg-holder").show();
            } else {
              location.reload();
              $("#msg-holder").addClass('alert-success');
              $("#msg-holder").html("Inventory Date was successfully set.");
              $("#msg-holder").show();
            }
          });
        }

        
      });

      $("#s-product-name").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "<?=base_url('WebService/search_products/" + request.term + "')?>",
                type: "GET",
            dataType: "json",
            data: { searchText: request.term },
            success: function (data) {
                response($.map(data, function (item) {
                    return {
                        label: item.product_name,
                        value: item.product_name + ' (' +  item.product_id + ')'
                    };
                }))
            }
            })
        },
        messages: {
            noResults: "No results found",
            results: function (count) {
                return count + (count > 1 ? ' results' : ' result') + 'found';
            }
        }
      });

      $("#s-product-name").on('autocompleteselect', function(e, ui){
    	  //$("#s-product-name").prop("disabled", true);
          var index_of_open_bracket = ui.item.value.lastIndexOf("(");
          var index_of_closing_bracket = ui.item.value.lastIndexOf(")");

          //console.log(index_of_open_bracket);
          //console.log(index_of_closing_bracket);

          if( index_of_open_bracket != -1 && index_of_closing_bracket != -1 ){
      			var product_id = ui.item.value.substring(index_of_open_bracket+1, index_of_closing_bracket);
      			$.post( "<?=base_url('WebService/find_product_by_product_id/" + product_id + "');?>")
	      	  .done(function( data ) {
	          	  //var a = $.parseJSON(data);
	          	  //console.log(a[0].product_id); works
	          	  //var b = JSON.parse(data);
	          	  //console.log(b[0].product_id); works
	          	  //console.log( "data: " + data );

	      	    if( data == '[]' ){
	      	    	$("#msg-holder").addClass('alert-danger');
	      	        $("#msg-holder").html("Sorry, a product was not found with that barcode. Please try again or consider adding it.");
	      	        $("#msg-holder").show();
	      	    } else {
	      	    	$("#msg-holder").addClass('alert-success');
	      	        $("#msg-holder").html("Product found.");
	      	        $("#msg-holder").show();

	      	        var obj = $.parseJSON(data);
	      	        populate_product_info_fields(obj);
	      	    }
	      	  });
          }
      });

      document.getElementById("btnFP").click( function(){
          $.post( "<?=base_url('WebService/find_product_by_barcode/" + bar_code + "');?>")
            .done(function( data ) {

              if( data == '[]' ){
                alert( "nothing" );
                $("#msg-holder").addClass('alert-danger');
                  $("#msg-holder").html("Sorry, a product was not found with that barcode. Please try again or consider adding it.");
                  $("#msg-holder").show();
              } else {
                $("#msg-holder").addClass('alert-success');
                  $("#msg-holder").html("Product found.");
                  $("#msg-holder").show();

                  var obj = $.parseJSON(data);
                  populate_product_info_fields(obj);

                  //simulate key press to remove error border around inputs
                  similutateTabKeyPressAfterScan();

              }
            });
        });

      if ($.browser.msie) {
        var bar_code = $("#s-bar-code").val();

        $.post( "<?=base_url('WebService/find_product_by_barcode/" + bar_code + "');?>")
            .done(function( data ) {
                //var a = $.parseJSON(data);
                //console.log(a[0].product_id); works
                //var b = JSON.parse(data);
                //console.log(b[0].product_id); works
                //console.log( "data: " + data );

              if( data == '[]' ){
                $("#msg-holder").addClass('alert-danger');
                  $("#msg-holder").html("Sorry, a product was not found with that barcode. Please try again or consider adding it.");
                  $("#msg-holder").show();
              } else {
                $("#msg-holder").addClass('alert-success');
                  $("#msg-holder").html("Product found.");
                  $("#msg-holder").show();

                  var obj = $.parseJSON(data);
                  populate_product_info_fields(obj);

                  //simulate key press to remove error border around inputs
                  similutateTabKeyPressAfterScan();

              }
            });
      }

      $("#s-bar-code").change(function(){
          var bar_code = $("#s-bar-code").val();

          console.log("barcode: " + bar_code);

          if( bar_code != null || bar_code.length > 5 || bar_code != "" ){
        	  $.post( "<?=base_url('WebService/find_product_by_barcode/" + bar_code + "');?>")
        	  .done(function( data ) {
            	  //var a = $.parseJSON(data);
            	  //console.log(a[0].product_id); works
            	  //var b = JSON.parse(data);
            	  //console.log(b[0].product_id); works
            	  //console.log( "data: " + data );

        	    if( data == '[]' ){
        	    	$("#msg-holder").addClass('alert-danger');
        	        $("#msg-holder").html("Sorry, a product was not found with that barcode. Please try again or consider adding it.");
        	        $("#msg-holder").show();
        	    } else {
        	    	$("#msg-holder").addClass('alert-success');
        	        $("#msg-holder").html("Product found.");
        	        $("#msg-holder").show();

        	        var obj = $.parseJSON(data);
        	        populate_product_info_fields(obj);

                  //simulate key press to remove error border around inputs
                  similutateTabKeyPressAfterScan();

        	    }
        	  });
          }
      });

		function populate_product_info_fields(obj){
      $("#product_id").val(obj[0].product_id);      
			$("#bar-code").val( obj[0].barcode );
			$("#product-name").val( obj[0].product_name );
      $("#product-name").focusout();
			$("#product-category").val( obj[0].product_category_id );
			$("#product-price").val( obj[0].price );
			$("#product-description").val(obj[0].description);
			$("#product-weight").val(obj[0].weight);
      $("#amt-in-stock").val(obj[0].current_stock_level);
		}

    function similutateTabKeyPressAfterScan(){
      $("#bar-code").focusout();
      $("#product-name").focusout();
      $("#product-category").focusout();
      $("#product-price").focusout();
      $("#product-description").focusout();
      $("#product-weight").focusout();
      $("#amt-in-stock").focusout();
      $("#inventory-amt").focus();
    }

    </script>

  </body>
</html>
