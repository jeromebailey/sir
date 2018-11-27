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

            <form id="add-user-frm" class="form-horizontal form-label-left" method="post" action="<?=base_url('Invoices/do_edit_basic_invoice')?>" data-toggle="validator" role="form">

              <!--<div class="row">
                <div class="col-md-3">
                  <img src="<?=base_url('assets/images/logo-gcg-220-120.jpg');?>" height="120" width="220">
                </div>
              </div>-->

              <input type="hidden" name="invoice-id" value="<?=$invoice_id?>">

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
                          <?=$invoice['invoice_no'];?>
                          <input type="hidden" name="invoice_no" id="invoice_no" value="<?=$invoice['invoice_no'];?>">
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="control-label col-md-4 col-sm-12 col-xs-12" for="requisition-date">Creation Date:</label>
                        <div class="col-md-8 col-sm-12 col-xs-12" style="margin-top: 7px;"><?=date('d-M-Y', strtotime($invoice["invoice_date"]));?></div>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="control-label col-md-4 col-sm-12 col-xs-12" for="requisition-date">Flight Date:</label>
                        <div class="col-md-4 col-sm-12 col-xs-12" style="margin-top: 7px;">
                          <?
                          if( empty( $invoice["flight_date"] ) ){?>
                            <input type="text" class="form-control input-sm" autocomplete="off" placeholder="" name="flight-date" id="flight-date" style="position: relative; z-index: 100;" value="<?=date('d-M-Y');?>">
                          <?} else {?>
                            <input type="text" class="form-control input-sm" autocomplete="off" placeholder="" name="flight-date" id="flight-date" style="position: relative; z-index: 100;" value="<?=date('d-M-Y', strtotime($invoice["flight_date"]));?>" >
                          <?}?>                          
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="control-label col-md-4 col-sm-12 col-xs-12" for="requisition-date">Tail No:</label>
                        <div class="col-md-4 col-sm-12 col-xs-12" >
                          <input type="text" class="form-control input-sm" autocomplete="off" placeholder="7T-WHM" name="tail-no" id="tail-no" value="<?=$invoice["tail_no"];?>" >
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="control-label col-md-4 col-sm-12 col-xs-12" for="requisition-date">Disbursement No.:</label>
                        <div class="col-md-4 col-sm-12 col-xs-12" style="margin-top: 7px;">
                          <input type="text" class="form-control input-sm" autocomplete="off" placeholder="4520000" name="disbursement-no" id="disbursement-no" value="<?=$invoice['disbursement_no']?>" >
                        </div>
                      </div>
                    </div>
                  </div>

                </div>

              </div>

              <br />

              <div class="row">
                <div class="col-md-4">
                  <label for="client-id">Bill To:</label>
                  <select id="client-id" name="client-id" class="form-control" required="required">
                    <option value="">Select Client</option>
                    <?
                    if( !empty($clients) ){
                      foreach ($clients as $key => $value) {
                        if( $invoice["client_id"] == $value["client_id"] ){?>
                          <option value="<?=$value["client_id"]?>" selected><?=$value["client_name"]?></option>
                        <?} else {?>
                          <option value="<?=$value["client_id"]?>"><?=$value["client_name"]?></option>
                        <?}
                      }
                    } else {

                    }?>
                  </select>
                  
                </div>
              </div>

              <div class="row">
                <div class="col-md-2">
                  <label for="">Item Currency:</label>
                    <select id="currency-id" name="currency-id" class="form-control" required="required">
                    <option value="">Select Currency</option>
                      <?
                      if( $invoice["currency_id"] == 1 ){?>
                        <option value="1" selected="selected">USD</option>
                        <option value="2">KYD</option>
                      <?}

                      if( $invoice["currency_id"] == 2 ){?>
                        <option value="1">USD</option>
                        <option value="2" selected="selected">KYD</option>
                      <?}?>
                      
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
                        <th>Description</th>
                        <th width="10%">Price</th>
                        <th width="10%">Extension</th>
                        <th width="7%">Options</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?
                      if( !empty( $invoice["invoice_details"] ) ){
                        $counter = 1;
                        $items = json_decode( $invoice["invoice_details"] );
                        foreach ($items as $key => $value) {?>
                          <tr id="<?=$counter?>">
                            <td><input type="text" name="qty-<?=$counter?>" id="qty-<?=$counter?>" value = "<?=$value->qty?>" class = "form-control" readonly /></td>
                            <td><input type="text" name="desc-<?=$counter?>" id="desc-<?=$counter?>" value = "<?=$value->desc?>" class = "form-control" readonly /></td>
                            <td><input type="text" name="price-<?=$counter?>" id="price-<?=$counter?>" value = "<?=$value->price?>" class = "form-control" readonly /></td>
                            <td><input type="text" name="extn-<?=$counter?>" id="extn-<?=$counter?>" value = "<?=$value->extn?>" class = "form-control" readonly /></td>
                            <td>
                              <a href="#" onClick="edit_invoice_item(<?=$counter?>)" title="Edit"><i class="fas fa-edit"></i></a>
                              <a href="#" onClick="delete_invoice_item(<?=$counter?>)" title="Delete"><i class="fas fa-trash-alt"></i></a>
                            </td>
                          </tr>
                        <?
                        $counter++;
                        }
                      }
                      ?>
                    </tbody>
                    <tr>
                      <td colspan="2"></td>
                      <td>Total <span id="currency-label">USD</span></td>
                      <td><input type="text" name="base_total" id="base_total" class="form-control" readonly="readonly" value="<?= sprintf("%.2f", $invoice['invoice_total_amount'])?>" /></td>
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

              <!--<div class="row">
                <div class="col-md-4">
                  <label >Created by:</label>
                  <input type="text" id="placed-by" readonly="readonly" placeholder="johnjackson@gmail.com" name="placed-by" autocomplete="off" class="form-control" value="<?//=$this->session->userdata("first_name") . " " .$this->session->userdata("last_name");?>">
                </div>
                
              </div>-->

              <br />

              <div class="row">
                <div class="dol-md-4">
                  <button type="submit" class="btn btn-lg btn-success" style="margin-top: 23px;">Update Invoice</button>
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
                          <div class="col-md-3">
                            <label>Qty</label>
                            <input type="number" name="m_item_qty" id="m_item_qty" class="form-control">
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-12">
                            <label>Item Description</label>
                            <input type="text" name="m_item_description" id="m_item_description" class="form-control" style="z-index: 10000">
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
      $items = json_decode( $invoice["invoice_details"] );
      $items_count = count( $items );
      ?>
      var req_item_counter = <?= $items_count;?> + 1;
      var invoice_total_cost = <?= $invoice['invoice_total_amount'];?>;

    $(document).ready(function(){
      $("#msg-holder").hide();
        $( "#dob" ).datepicker({ 
          dateFormat: 'yy-mm-dd',
          changeYear: true,
          yearRange: "-50:+0" 
        });
        $('#add-user-frm').validator(); 

        $("#no_of_items").val(<?=$items_count?>+1);

        $( "#flight-date" ).datepicker({ 
          dateFormat: 'yy-mm-dd',
          changeYear: true
        });

        //console.log( "counter: " + $("#no_of_items").val() ); 

        //$("#currency-id").trigger("change");

        var currency_id = <?=$invoice["currency_id"]?>;
        var total = <?=$invoice["invoice_total_amount"]?>;

        set_alternate_total( currency_id, total );

    });

    function set_alternate_total( currency_id, total ){

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
    }

    function edit_invoice_item(item_counter){
      $("#edit_item_modal").modal('show');
      console.log( " -- counter: " + item_counter );

      var description = $('#desc-' + item_counter).val();
      var qty = $('#qty-' + item_counter).val();
      var price = $('#price-' + item_counter).val();
      var extn = $('#extn-' + item_counter).val();

      $("#m_item_description").val( description );
      $("#m_item_qty").val( qty );
      $("#m_item_price").val( price );
      $("#m_item_extn").val( extn );
      $("#m_item_counter").val( item_counter );
    }

    $("#btnMEditItem").click(function(){      

      var description = $("#m_item_description").val();
      var qty = $("#m_item_qty").val();
      var price = $("#m_item_price").val();
      var extn = $("#m_item_extn").val();
      var item_counter = $("#m_item_counter").val();

      $('#desc-' + item_counter).val(description);
      $('#qty-' + item_counter).val(qty);
      $('#price-' + item_counter).val(price);
      $('#extn-' + item_counter).val(extn);

      $("#edit_item_modal").modal('hide');

      recalculate_total();
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

      $("#extn").val(qty * price);

    });

    $("#m_item_price").keyup(function(){
      var qty = $("#m_item_qty").val();
      var price = $("#m_item_price").val();

      $("#m_item_extn").val(qty * price);

    });

    $("#qty").keyup(function(){
      var qty = $("#qty").val();
      var price = $("#price").val();

      if( price != null ){
        $("#extn").val(qty * price);
      }

    });

    $("#m_item_qty").keyup(function(){
      var qty = $("#m_item_qty").val();
      var price = $("#m_item_price").val();

      console.log( "qty change" );
      console.log( "qty -- " + qty );
      console.log( "price -- " + price );

      if( price != null ){
        $("#m_item_extn").val(qty * price);
      }
    });

    $(":input").bind('keyup mouseup', function () {
        var qty = $("#m_item_qty").val();
        var price = $("#m_item_price").val();

        console.log( "qty change" );
        console.log( "qty -- " + qty );
        console.log( "price -- " + price );

        if( price != null ){
          $("#m_item_extn").val(qty * price);
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

    function addAnotherRowForRequisitionItem(qty, desc, price, extn){
      var row = "";
      row = row + '<tr id=' + req_item_counter + '>';
      row = row + '<td><input type="text" id="" name="qty-' + req_item_counter + '" autocomplete="off" value="' + qty +'" class="form-control" readonly></td>';
      row = row + '<td><input type="text" id="" name="desc-' + req_item_counter + '" required="required" autocomplete="off" value="' + desc +'" class="form-control" readonly></td>';
      row = row + '<td><input type="text" id="price-' + req_item_counter + '" name="price-' + req_item_counter + '" required="required" autocomplete="off" value="' + price +'" class="form-control" readonly></td>';
      row = row + '<td><input type="text" id="extn-' + req_item_counter + '" name="extn-' + req_item_counter + '" required="required" autocomplete="off" value="' + extn +'" class="form-control" readonly></td>';
      
      row = row + '<td style="margin-top: 23px;">';
      row = row + '<a href="#" title="Edit" onClick="edit_fcs_item(' + req_item_counter +')"><i class="fas fa-edit"></i></a> |';
      row = row + '<a href="#" onClick="delete_invoice_item(' + req_item_counter + ')" title="Delete"><i class="fas fa-trash-alt"></i></a>';
      row = row + '</td>';      
      row = row + '</tr>';

      $("#tblRequestedItems").append(row);

      invoice_total_cost += parseFloat(extn);
      console.log(invoice_total_cost);
      $("#base_total").val(invoice_total_cost);      

      //var currency_id = $("#currency-id").val();

      //calculate_alternate_total_cost( currency_id, invoice_total_cost );

      req_item_counter++;

      $("#no_of_items").val(req_item_counter);

      recalculate_total();
    }  

    function calculate_alternate_total_cost( currency_id, base_total_cost ){
      if( currency_id != '' && base_total_cost != '' ){
        $.get( "<?=base_url('Ajax/change_currency_value/" + currency_id + "/" + base_total_cost + "' );?>")
        .done(function( data ) {
          console.log( data  );
          var obj = $.parseJSON(data);
          $("#alternate_total_value").val(obj);
        });

      } else {
        console.log("empty");
      }
    }

    function delete_invoice_item( item_counter ){
      console.log( "counter: " + req_item_counter );
      var do_delete_row = confirm("Are you sure you want to delete this item?");

      if( do_delete_row == true ){
        //get price of item to be deleted
        var extn = parseFloat( $("#extn-" + item_counter).val());
        var currency_id = $("#currency-id").val();
        
        console.log( extn );
        invoice_total_cost = invoice_total_cost - extn;
        console.log( invoice_total_cost );

        $("#base_total").val(invoice_total_cost);
        calculate_alternate_total_cost( currency_id, invoice_total_cost );
        //$("#alternate_total_value").val(invoice_total_cost);

        document.getElementById("tblRequestedItems").deleteRow(item_counter);
        req_item_counter--;
        console.log( "counter: " + req_item_counter );
      }
    }  

    function recalculate_total(){
      var total_cost = 0;
      var currency_id = $("#currency-id").val();

      for( var i =1; i < $("#no_of_items").val(); i++ ){
        if( $("#extn-" + i).val() != "" ){
          total_cost = parseFloat(total_cost) + parseFloat( $("#extn-" + i).val());  
        }
        
      }

      console.log( "total cost: " + total_cost );

      $("#base_total").val(total_cost);

      calculate_alternate_total_cost( currency_id, total_cost );

      //$("#alternate_total_value").val(invoice_total_cost);

    }

    </script>
  </body>
</html>
