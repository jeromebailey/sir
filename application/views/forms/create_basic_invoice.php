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

            <h3><?=$page_title;?> <i class="fas fa-receipt"></i></h3>

            <div class="row" >
              <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
                <div class="alert " id="msg-holder"></div>
              </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                  <img src="<?=base_url('assets/images/logo-gcg-220-120.jpg');?>" height="50" width="100">
                </div>
                <div class="col-md-10">
                  <p class="text-uppercase text-center" style="margin-top: -40px;font-size: 22px;"><strong>INVOICE</strong></p>
                </div>
              </div>
              <br />

            <form id="add-user-frm" class="form-horizontal form-label-left" method="post" action="<?=base_url('Forms/do_add_invoice')?>" data-toggle="validator" role="form">

              <div class="row">
                <div class="col-md-6">
                  <label for="supplier-id"><?=$company_name;?></label><br />
                  <?=$company_address;?>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="control-label col-md-4 col-sm-12 col-xs-12" for="po-no-id">Invoice No.:</label>
                        <div class="col-md-8 col-sm-12 col-xs-12" style="margin-top: 7px;">
                          <?=$next_invoice_no;?>
                          <input type="hidden" name="invoice_no" id="invoice_no" value="<?=$next_invoice_no;?>">
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="control-label col-md-4 col-sm-12 col-xs-12" for="requisition-date">Creation Date:</label>
                        <div class="col-md-8 col-sm-12 col-xs-12" style="margin-top: 7px;"><?=date('d-M-Y');?></div>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="control-label col-md-4 col-sm-12 col-xs-12" for="requisition-date">Flight Date:</label>
                        <div class="col-md-4 col-sm-12 col-xs-12" style="margin-top: 7px;">
                          <input type="text" class="form-control input-sm" autocomplete="off" placeholder="" name="flight-date" id="flight-date" style="position: relative; z-index: 100;" >
                        </div>
                      </div>
                    </div>
                  </div>                  

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="control-label col-md-4 col-sm-12 col-xs-12" for="requisition-date">Tail No:</label>
                        <div class="col-md-4 col-sm-12 col-xs-12" >
                          <input type="text" class="form-control input-sm" autocomplete="off" placeholder="7T-WHM" name="tail-no" id="tail-no" >
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="control-label col-md-4 col-sm-12 col-xs-12" for="requisition-date">Disbursement No.:</label>
                        <div class="col-md-4 col-sm-12 col-xs-12" style="margin-top: 7px;">
                          <input type="text" class="form-control input-sm" autocomplete="off" placeholder="4520000" name="disbursement-no" id="disbursement-no" >
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </div> <!-- end of row-->

              <br />

              <div class="row">
                <div class="col-md-4">
                  <label for="">Bill To:</label>
                    <select id="client-id" name="client-id" class="form-control" required="required">
                    <option value="">Select Client</option>
                    <?
                    if( !empty($clients) ){
                      foreach ($clients as $key => $value) {?>
                        <option value="<?=$value["client_id"]?>"><?=$value["client_name"]?></option>
                      <?}
                    } else {

                    }?>
                  </select>                  
                </div>
              </div> <!-- end of row -->

              <div class="row">
                <div class="col-md-2">
                  <label for="">Item Currency:</label>
                    <select id="currency-id" name="currency-id" class="form-control" required="required">
                    <option value="">Select Currency</option>
                      <option value="1" selected="selected">USD</option>
                      <option value="2">KYD</option>
                  </select>                  
                </div>
              </div> <!-- end of row -->

              <br/>

              <div class="row">
                <div class="col-md-1">
                    <label class="" for="unit-id">Qty</label>
                    <input type="number" id="qty" name="qty" autocomplete="off" class="form-control" placeholder="1">
                </div>

                <div class="col-md-7">
                  <label class="" for="product-id">Description</label>
                  <input type="text" id="desc" name="desc" autocomplete="off" class="form-control" placeholder="Size 12 Nike Caps">
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
                        <th>Description</th>
                        <th width="10%">Price</th>
                        <th width="10%">Extension</th>
                        <th width="7%">Options</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                    <tr>
                      <td colspan="2"></td>
                      <td>Total <span id="currency-label">USD</span></td>
                      <td><input type="text" name="base_total" id="base_total" class="form-control" readonly="readonly" /></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td colspan="2"></td>
                      <td>Total <span id="alternate-total">KYD</span></td>
                      <td><input type="text" name="alternate_total_value" id="alternate_total_value" class="form-control" readonly="readonly" /></td>
                      <td></td>
                    </tr>
                  </table>
                </div>
              </div>

              <br />

              <div class="row">
                <div class="dol-md-4">
                  <button type="submit" class="btn btn-lg btn-success" style="margin-top: 23px;">Create Invoice</button>
                </div>                
              </div>

              <input type="hidden" name="no_of_items" id="no_of_items">

            </form>

            <div id="edit_item_modal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title">Edit Item</h4>
                      </div>
                      <div class="modal-body">                        

                        <div class="row">
                          <div class="col-md-12">
                            <label>Item Description</label>
                            <input type="text" name="m_item_description" id="m_item_description" class="form-control" style="z-index: 10000">
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-3">
                            <label>Qty</label>
                            <input type="number" name="m_item_qty" id="m_item_qty" class="form-control" >
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-3">
                            <label>Price</label>
                            <input type="number" name="m_item_price" id="m_item_price" class="form-control">
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-3">
                            <label>Extn</label>
                            <input type="text" name="m_item_extn" id="m_item_extn" class="form-control" readonly="readonly" >
                          </div>
                        </div>

                        <input type="hidden" value="" name="m_item_counter" id="m_item_counter">
                        <input type="hidden" value="" name="m_grand_base_total" id="m_base_total">
                          
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <button type="button" name="btnMEditItem" id="btnMEditItem" class="btn btn-primary">Save changes</button>
                      </div>
                  </div>
              </div>
          </div>


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
    <script src="<?=base_url('assets/js/bootstrapValidator.js');?>"></script>
    <script src="<?=base_url('assets/js/jquery-ui.min.js');?>"></script>
    
    <script type="text/javascript">
      var req_item_counter = 1;
      var po_total_cost = 0;

    $(document).ready(function(){
      $("#msg-holder").hide();
        $('#add-user-frm').validator();

        $( "#flight-date" ).datepicker({ 
          dateFormat: 'yy-mm-dd',
          changeYear: true
        }).datepicker("setDate", new Date());

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

    $("#currency-id").change(function(){
      var currency_id = $("#currency-id").val();
      var total = $("#base_total").val();

      if( currency_id != '' && total != '' ){
        $.get( "<?=base_url('Ajax/change_currency_value/" + currency_id + "/" + total + "' );?>")
        .done(function( data ) {
          console.log( data  );
          var obj = $.parseJSON(data);
          $("#alternate_total_value").val(obj);
        });

        if( currency_id == 1 ){
          $("#currency-label").text( "USD" );
          $("#alternate-total").text("KYD");
        } else {
          $("#currency-label").text( "KYD" );
          $("#alternate-total").text("USD");
        }

      } else {
        console.log("empty");
      }
    });

    $("#price").keyup(function(){
      var qty = $("#qty").val();
      var price = $("#price").val();
      var extn_value = qty * price;
      var extn = extn_value.toFixed(2);

      $("#extn").val(extn);

    });

    $("#qty").keyup(function(){
      var qty = $("#qty").val();
      var price = $("#price").val();
      var extn_value = qty * price;
      var extn = extn_value.toFixed(2);

      if( price != null ){
        $("#extn").val(extn);
      }

    });

    function clearProductFieldInputs(){
      $("#qty").val('');
      $("#desc").val('');
      $("#price").val('');
      $("#extn").val('');
    }

    $("#btnAdd").click(function(){
      var qty = $("#qty").val();
      var desc = $("#desc").val();
      var price = $("#price").val();
      var extn = $("#extn").val();
      var errors = '';

      if( qty == '' ){
        errors += 'Quantity is required. <br/>'
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

        addAnotherRowForRequisitionItem(qty, desc, price, extn);
        clearProductFieldInputs();
      }
    });

    $("#m_item_qty").keyup(function(){
      if( $(this).val() != null && $(this).val() != "" ){
        
        var price = extn = old_extn = "";
        var difference_in_extns = operation = base_total = "";

        base_total = parseFloat( $("#base_total").val() );

        var item_counter = $("#m_item_counter").val();

        old_extn = $("#extn-" + parseInt(item_counter) ).val();
        console.log("old extn: " + old_extn);

        var qty = parseInt($(this).val());
        
        price = $("#m_item_price").val();
        extn = parseFloat(price) * qty;

        if( parseFloat(old_extn) != extn ){
          if( parseFloat(old_extn) < extn ){
            difference_in_extns = parseFloat(extn - old_extn);
            operation = "addition";

            base_total += difference_in_extns;
          } else {
            difference_in_extns = parseFloat(old_extn - extn);
            operation = "subtraction";

            base_total -= difference_in_extns;
          }
        }

        console.log("opt: " + operation );

        $("#m_base_total").val(base_total);
        $("#m_item_extn").val( extn );
      }
    });

    $("#m_item_price").keyup(function(){
      if( $(this).val() != null && $(this).val() != "" ){
        
        var price = extn = old_extn = "";
        var difference_in_extns = operation = base_total = "";

        base_total = parseFloat( $("#base_total").val() );

        var item_counter = $("#m_item_counter").val();

        old_extn = $("#extn-" + parseInt(item_counter) ).val();
        console.log("old extn: " + old_extn);

        var price = extn = qty = "";
        var price = parseFloat($(this).val());
        
        qty = parseInt($("#m_item_qty").val());
        extn = parseFloat(price) * qty;

        $("#m_item_extn").val( extn );

        if( parseFloat(old_extn) != extn ){
          if( parseFloat(old_extn) < extn ){
            difference_in_extns = parseFloat(extn - old_extn);
            operation = "addition";

            base_total += difference_in_extns;
          } else {
            difference_in_extns = parseFloat(old_extn - extn);
            operation = "subtraction";

            base_total -= difference_in_extns;
          }
        }

        console.log("opt: " + operation );

        $("#m_base_total").val(base_total);
      }
    });

    $("#btnMEditItem").click(function()
    {
      var description = $("#m_item_description").val();
      var qty = $("#m_item_qty").val();
      var price = $("#m_item_price").val();
      var extn = $("#m_item_extn").val();
      var item_counter = $("#m_item_counter").val();
      var m_base_total = parseFloat($("#m_base_total").val());

      $("#desc-" + parseInt(item_counter)).val(description);
      $("#qty-" + parseInt(item_counter)).val(qty);
      $("#price-" + parseInt(item_counter)).val(price);
      $("#extn-" + parseInt(item_counter)).val(extn);
      $("#base_total").val(m_base_total);

      calculate_alternate_sub_total_currency_value(m_base_total);

      $("#edit_item_modal").modal('hide');
    });

    function edit_invoice_item(item_counter){
      $("#edit_item_modal").modal('show');

      var description = amount = qty = extn = "";

      description = $("#desc-" + item_counter).val();
      amount = $("#price-" + item_counter).val();
      qty = $("#qty-" + item_counter).val();
      extn = $("#extn-" + item_counter).val();      

      $("#m_item_description").val( description );
      $("#m_item_price").val( amount );
      $("#m_item_qty").val( qty );
      $("#m_item_extn").val( extn );
      $("#m_item_counter").val( item_counter );      
    }

    function addAnotherRowForRequisitionItem(qty, desc, price, extn){
      var row = "";
      row = row + '<tr id=' + req_item_counter + '>';
      row = row + '<td><input type="text" id="qty-' + req_item_counter + '" name="qty-' + req_item_counter + '" autocomplete="off" value="' + qty +'" class="form-control" readonly></td>';
      row = row + '<td><input type="text" id="desc-' + req_item_counter + '" name="desc-' + req_item_counter + '" required="required" autocomplete="off" value="' + desc +'" class="form-control" readonly></td>';
      row = row + '<td><input type="text" id="price-' + req_item_counter + '" name="price-' + req_item_counter + '" required="required" autocomplete="off" value="' + price +'" class="form-control" readonly></td>';
      row = row + '<td><input type="text" id="extn-' + req_item_counter + '" name="extn-' + req_item_counter + '" required="required" autocomplete="off" value="' + extn +'" class="form-control" readonly></td>';
      
      row = row + '<td style="margin-top: 23px;">';
      row = row + '<a href="#" onClick="edit_invoice_item(' + req_item_counter + ')" title="Edit"><i class="fas fa-edit"></i></a> | ';
      row = row + '<a href="#" onClick="delete_po_item(' + req_item_counter + ')" title="Delete"><i class="fas fa-trash-alt"></i></a>';
      row = row + '</td>';      
      row = row + '</tr>';

      $("#tblRequestedItems").append(row);

      po_total_cost += parseFloat(extn);
      console.log(po_total_cost);
      $("#base_total").val(po_total_cost);

      var currency_id = $("#currency-id").val();

      if( currency_id != '' && po_total_cost != '' ){
        $.get( "<?=base_url('Ajax/change_currency_value/" + currency_id + "/" + po_total_cost + "' );?>")
        .done(function( data ) {
          console.log( data  );
          var obj = $.parseJSON(data);
          $("#alternate_total_value").val(obj);
        });

      } else {
        console.log("empty");
      }

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

        $("#base_total").val(po_total_cost);
        $("#alternate_total_value").val(po_total_cost);

        document.getElementById("tblRequestedItems").deleteRow(item_counter);
        req_item_counter--;
        console.log( "counter: " + req_item_counter );
      }
    }  

    function calculate_alternate_sub_total_currency_value( base_total ){
      var currency_id = $("#currency-id").val();

      if( currency_id != '' && base_total != '' ){
        $.get( "<?=base_url('Ajax/change_currency_value/" + currency_id + "/" + base_total + "' );?>")
        .done(function( data ) {
          console.log( data  );
          var obj = $.parseJSON(data);
          $("#alternate_total_value").val(obj);
        });

      } else {
        console.log("empty");
      }
    }

    </script>
  </body>
</html>
