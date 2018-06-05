<!DOCTYPE html>
<html lang="en">
  <head>
    <?include_once 'includes/head.inc'; ?>
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

            <?include_once 'includes/status_message.inc';?>

            <h3><?=$page_title;?> <i class="fas fa-user"></i></h3>

            <div class="row" >
              <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
                <div class="alert " id="msg-holder"></div>
              </div>
            </div>

            <form id="add-user-frm" class="form-horizontal form-label-left" method="post" action="<?=base_url('PurchaseOrders/do_edit_purchase_order')?>" data-toggle="validator" role="form">

              <!--<div class="row">
                <div class="col-md-3">
                  <img src="<?=base_url('assets/images/logo-gcg-220-120.jpg');?>" height="120" width="220">
                </div>
              </div>-->

              <input type="hidden" name="po-id" value="<?=$po_id?>">

              <div class="row">
                <div class="col-md-4">
                  <label for="supplier-id">Supplier</label>
                  <select id="supplier-id" name="supplier-id" class="form-control" required="required">
                    <option value="">Select Supplier</option>
                    <?
                    if( !empty($suppliers) ){
                      foreach ($suppliers as $key => $value) {
                        if( $purchase_order["supplier_id"] == $value["supplier_id"] ){?>
                          <option value="<?=$value["supplier_id"]?>" selected><?=$value["supplier_name"]?></option>
                        <?} else {?>
                          <option value="<?=$value["supplier_id"]?>"><?=$value["supplier_name"]?></option>
                        <?}
                      }
                    } else {

                    }?>
                  </select>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div id="supplier-address"></div>
                </div>

                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="control-label col-md-4 col-sm-12 col-xs-12" for="po-no-id">PO No.:</label>
                        <div class="col-md-8 col-sm-12 col-xs-12" style="margin-top: 7px;">
                          <?=$purchase_order['po_no'];?>
                          <input type="hidden" name="po_no" id="po_no" value="<?=$purchase_order['po_no'];?>">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="control-label col-md-4 col-sm-12 col-xs-12" for="requisition-date">Date:</label>
                        <div class="col-md-8 col-sm-12 col-xs-12" style="margin-top: 7px;"><?=date('d-M-Y', strtotime($purchase_order["po_date"]));?></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <br />

              <div class="row">
                <div class="col-md-4">
                  <label for="">Bill To:</label>
                    <div class="" ><?=$bill_to_address;?></div>
                </div>
                <div class="col-md-4 col-md-offset-3">
                  <label for="">Ship To:</label>
                    <div ><?=$ship_to_address;?></div>
                </div>
              </div>

              <br/>

              <div class="row">
                <div class="col-md-1">
                    <label class="" for="unit-id">Qty</label>
                    <input type="number" id="qty" name="qty" autocomplete="off" class="form-control" placeholder="1">
                </div>
                <div class="col-md-3">
                  <label class="" for="product-id">Part No.</label>
                  <input type="text" id="part-no" name="part-no" autocomplete="off" class="form-control" placeholder="CRNO-TF5-970">
                </div>

                <div class="col-md-4">
                  <label class="" for="product-id">Description</label>
                  <input type="text" id="desc" name="desc" autocomplete="off" class="form-control" placeholder="Compressor">
                </div>

                <div class="col-md-1">
                  <label class="" for="product-amount">Price</label>
                  <input type="number" id="price" name="price" autocomplete="off" class="form-control" placeholder="100">
                </div>

                <div class="col-md-1">
                  <label class="" for="product-amount">Extn</label>
                  <input type="text" id="extn" name="extn" autocomplete="off" class="form-control" placeholder="400" readonly="readonly">
                </div>                

                <div class="col-md-2">
                  <input type="button" name="btnAdd" id="btnAdd" value="Add item" class="btn btn-success" style="margin-top: 23px;">
                </div>
              </div>

              <h3>Item / Part Requested</h3>

              <div class="row">
                <div class="col-md-12">
                  <table class="table table-bordered" id="tblRequestedItems">
                    <thead>
                      <tr>
                        <th width="7%">Qty</th>
                        <th width="20%">Part No.</th>
                        <th>Description</th>
                        <th width="10%">Price</th>
                        <th width="10%">Extension</th>
                        <th width="7%">Options</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?
                      if( !empty( $purchase_order["po_details"] ) ){
                        $counter = 1;
                        $items = json_decode( $purchase_order["po_details"] );
                        foreach ($items as $key => $value) {?>
                          <tr id="<?=$counter?>">
                            <td><input type="text" name="qty-<?=$counter?>" value = "<?=$value->qty?>" class = "form-control" readonly /></td>
                            <td><input type="text" name="part-no-<?=$counter?>" value = "<?=$value->part_no?>" class = "form-control" readonly /></td>
                            <td><input type="text" name="desc-<?=$counter?>" value = "<?=$value->desc?>" class = "form-control" readonly /></td>
                            <td><input type="text" name="price-<?=$counter?>" value = "<?=$value->price?>" class = "form-control" readonly /></td>
                            <td><input type="text" name="extn-<?=$counter?>" value = "<?=$value->extn?>" class = "form-control" readonly /></td>
                            <td>
                              <a href="#" onClick="delete_po_item(<?=$counter?>)" title="Delete"><i class="fas fa-trash-alt"></i></a>
                            </td>
                          </tr>
                        <?
                        $counter++;
                        }
                      }
                      ?>
                    </tbody>
                    <tr>
                      <td colspan="3"></td>
                      <td>Total</td>
                      <td><input type="text" name="total_cost" id="total_cost" class="form-control" readonly="readonly" value="<?= number_format($purchase_order['po_total_amount'], 2)?>" /></td>
                      <td></td>
                    </tr>
                  </table>
                </div>
              </div>

              <div class="row">
                <div class="col-md-4">
                  <label >Placed by:</label>
                  <input type="text" id="placed-by" readonly="readonly" placeholder="johnjackson@gmail.com" name="placed-by" autocomplete="off" class="form-control" value="<?=$this->session->userdata("first_name") . " " .$this->session->userdata("last_name");?>">
                </div>
                
              </div>

              <br />

              <div class="row">
                <div class="col-md-4">
                  <label >Send to (Vendor and Copy):</label>
                  <input type="email" name="send-to" id="send-to" class="form-control" placeholder="" autocomplete="off" value="<?//=$this->session->userdata("email_address");?>">
                </div>

                <!--<div class="col-md-4 col-md-offset-2">
                  <label >Approved by:</label>
                  <input type="text" id="approved-by" readonly="readonly" placeholder="John Jackson" name="approved-by" autocomplete="off" class="form-control" value="">
                </div>-->
              </div>

              <div class="row">
                <div class="dol-md-4">
                  <button type="submit" class="btn btn-lg btn-success" style="margin-top: 23px;">Update Purchase Order</button>
                </div>                
              </div>

              <input type="hidden" name="no_of_items" id="no_of_items">

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
    <script src="<?=base_url('assets/js/bootstrapValidator.js');?>"></script>
    <script src="<?=base_url('assets/js/jquery-ui.min.js');?>"></script>
    
    <script type="text/javascript">
      <?
      $items = json_decode( $purchase_order["po_details"] );
      $items_count = count( $items );
      ?>
      var req_item_counter = <?= $items_count;?> + 1;
      var po_total_cost = <?= $purchase_order['po_total_amount'];?>;

    $(document).ready(function(){
      $("#msg-holder").hide();
        $( "#dob" ).datepicker({ 
          dateFormat: 'yy-mm-dd',
          changeYear: true,
          yearRange: "-50:+0" 
        });
        $('#add-user-frm').validator(); 

        $("#no_of_items").val(<?=$items_count?>);

        var supplier_id = $("#supplier-id").val();

        $.get( "<?=base_url('Suppliers/get_supplier_address_by_id/" + supplier_id + "' );?>")
          .done(function( data ) {
            console.log( data  );
            $("#supplier-address").html(data);
          });   

    });

    $("#supplier-id").change(function(){
      var supplier_id = $("#supplier-id").val();

      if( supplier_id != '' ){
        $.get( "<?=base_url('Suppliers/get_supplier_address_by_id/" + supplier_id + "' );?>")
        .done(function( data ) {
          console.log( data  );
          $("#supplier-address").html(data);
        });
      }
    });

    $("#price").keyup(function(){
      var qty = $("#qty").val();
      var price = $("#price").val();

      $("#extn").val(qty * price);

    });

    $("#qty").keyup(function(){
      var qty = $("#qty").val();
      var price = $("#price").val();

      if( price != null ){
        $("#extn").val(qty * price);
      }

    });

    function clearProductFieldInputs(){
      $("#qty").val('');
      $("#part-no").val('');
      $("#desc").val('');
      $("#price").val('');
      $("#extn").val('');
    }

    $("#btnAdd").click(function(){
      var part_no = $("#part-no").val();
      var qty = $("#qty").val();
      var desc = $("#desc").val();
      var price = $("#price").val();
      var extn = $("#extn").val();
      var errors = '';

      if( qty == '' ){
        errors += 'Quantity is required. <br/>'
      }

      if( part_no == '' ){
        errors += 'Part No. is required. <br/>'
      }

      if( desc == '' ){
        errors += 'Description is required. <br/>'
      }

      if( price == '' ){
        errors += 'Price is required. <br/>'
      }

      if( errors != '' ){
        $("#msg-holder").addClass('alert-danger');
        $("#msg-holder").html(errors);
        $("#msg-holder").show();

      } else {

        $("#msg-holder").html('');
        $("#msg-holder").hide();

        addAnotherRowForRequisitionItem(qty, part_no, desc, price, extn);
        clearProductFieldInputs();
      }
    });

    function addAnotherRowForRequisitionItem(qty, part_no, desc, price, extn){
      var row = "";
      row = row + '<tr id=' + req_item_counter + '>';
      row = row + '<td><input type="text" id="" name="qty-' + req_item_counter + '" autocomplete="off" value="' + qty +'" class="form-control" readonly></td>';
      row = row + '<td><input type="text" id="" name="part-no-' + req_item_counter + '" required="required" autocomplete="off" value="' + part_no +'" class="form-control" readonly></td>';
      row = row + '<td><input type="text" id="" name="desc-' + req_item_counter + '" required="required" autocomplete="off" value="' + desc +'" class="form-control" readonly></td>';
      row = row + '<td><input type="text" id="price-' + req_item_counter + '" name="price-' + req_item_counter + '" required="required" autocomplete="off" value="' + price +'" class="form-control" readonly></td>';
      row = row + '<td><input type="text" id="extn-' + req_item_counter + '" name="extn-' + req_item_counter + '" required="required" autocomplete="off" value="' + extn +'" class="form-control" readonly></td>';
      
      row = row + '<td style="margin-top: 23px;">';
      //row = row + '<a href="" title="Edit"><i class="fas fa-edit"></i></a> |';
      row = row + '<a href="#" onClick="delete_po_item(' + req_item_counter + ')" title="Delete"><i class="fas fa-trash-alt"></i></a>';
      row = row + '</td>';      
      row = row + '</tr>';

      $("#tblRequestedItems").append(row);

      po_total_cost += parseFloat(extn);
      console.log(po_total_cost);
      $("#total_cost").val(po_total_cost);

      req_item_counter++;

      $("#no_of_items").val(req_item_counter);
    }  

    function delete_po_item( item_counter ){
      console.log( "counter: " + req_item_counter );
      var do_delete_row = confirm("Are you sure you want to delete this item?");

      if( do_delete_row == true ){
        //get price of item to be deleted
        var extn = parseFloat( $("#extn-" + item_counter).val());
        console.log( extn );
        po_total_cost = po_total_cost - extn;
        console.log( po_total_cost );

        $("#total_cost").val(po_total_cost);

        document.getElementById("tblRequestedItems").deleteRow(item_counter);
        req_item_counter--;
        console.log( "counter: " + req_item_counter );
      }
    }  

    </script>
  </body>
</html>
