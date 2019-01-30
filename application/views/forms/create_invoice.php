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
                <div class="col-md-3">
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

                <div class="col-md-3">
                  <label for="">Routes/Types:</label>
                    <select id="client-routes-types" name="client-routes-types" class="form-control" >
                    <option value="">Select Route/Type</option>
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
                <div class="col-md-2">
                    <label class="" for="unit-id">Heading</label>
                    <select name="heading_id" id="heading_id" class="form-control">
                      <option value="">Select Heading</option>
                      <?
                      if( !empty($invoice_headings) ){
                        foreach ($invoice_headings as $key => $value) {?>
                          <option value="<?=$value["heading_id"]?>"><?=$value["heading_title"]?></option>
                        <?}
                      } else {

                      }?>
                    </select>
                </div>

                <div class="col-md-1">
                    <label class="" for="unit-id">Qty</label>
                    <input type="number" id="qty" name="qty" autocomplete="off" class="form-control" placeholder="1">
                </div>

                <div class="col-md-5">
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
                    <tbody id="main_section"></tbody>

                    <tbody id="crew_heading">
                      <tr>
                        <td colspan="5"><strong>CREW</strong></td>
                      </tr>
                    </tbody>

                    <tbody id="passenger_heading">
                      <tr>
                        <td colspan="5"><strong>PASSENGER</strong></td>
                      </tr>
                    </tbody>

                    <!-- sub total -->

                    <tr>
                      <td colspan="2">Sub Total</td>
                      <td><span id="currency-label">USD</span></td>
                      <td><input type="text" name="base_total" id="base_total" class="form-control" readonly="readonly" value="0" /></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td colspan="2"></td>
                      <td><span id="alternate-total">KYD</span></td>
                      <td><input type="text" name="alternate_total_value" id="alternate_total_value" class="form-control" readonly="readonly" value="0" /></td>
                      <td></td>
                    </tr>

                    <!-- service charge -->
                    <tr>
                      <td colspan="2">Service Charge</td>
                      <td> <span id="service-charge-currency-label">USD</span></td>
                      <td><input type="text" name="base_service_charge" id="base_service_charge" class="form-control" autocomplete="off" value="0" /></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td colspan="2"></td>
                      <td><span id="service-charge-alternate-total">KYD</span></td>
                      <td><input type="text" name="alternate_service_charge" id="alternate_service_charge" class="form-control" readonly="readonly" value="0" /></td>
                      <td></td>
                    </tr>

                    <!-- grand total -->
                    <tr>
                      <td colspan="2"><strong>Grand Total</strong></td>
                      <td> <span id="grand-total-currency-label">USD</span></td>
                      <td><input type="text" name="grand_base_total" id="grand_base_total" class="form-control" readonly="readonly" value="0" /></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td colspan="2"></td>
                      <td><span id="grand-total-alternate-total">KYD</span></td>
                      <td><input type="text" name="grand_alternate_total_value" id="grand_alternate_total_value" class="form-control" readonly="readonly" value="0" /></td>
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
                        <input type="hidden" value="" name="m_heading_id" id="m_heading_id">
                        <input type="hidden" value="" name="m_base_total" id="m_base_total">
                        <input type="hidden" value="" name="m_grand_base_total" id="m_grand_base_total">
                          
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
      var invoice_sub_total_cost = 0;
      var req_item_counter = total_items_added = 1;
      var crew_heading_counter = passenger_heading_counter = 2;

    $(document).ready(function(){
      $("#msg-holder").hide();
        $('#add-user-frm').validator();

        hide_invoice_headings();

        $( "#flight-date" ).datepicker({ 
          dateFormat: 'yy-mm-dd',
          changeYear: true
        }).datepicker("setDate", new Date());

    });

    function hide_invoice_headings(){
      $("#crew_heading").hide();
      $("#passenger_heading").hide();
    }

    $("#client-id").change(function(){
        var client_id = $(this).val();

        $("#client-routes-types").val( "" );
        get_client_routes_types(client_id);
              
    });

    function get_client_routes_types( client_id ){
      $.ajax({
          url: "<?=base_url('WebService/get_client_routes_types/" + client_id +"');?>",
          type: 'post',
          data: {client_id:client_id},
          dataType: 'json',
          success:function(response){

              var len = response.length;

              $("#client-routes-types").empty();
              $("#client-routes-types").append("<option value=''>Select Route/Type</option>");
              for( var i = 0; i<len; i++){
                  var id = response[i]['destination_id'];
                  var name = response[i]['destination_abbreviation'];
                  
                  $("#client-routes-types").append("<option value='"+id+"'>"+name+"</option>");
              }
          }
      });
    }

    $("#currency-id").change(function(){
      var currency_id = $("#currency-id").val();
      var total = parseFloat($("#base_total").val());
      var service_charge = ( $("#base_service_charge").val() != null && $("#base_service_charge").val() != "" ) ? parseFloat( $("#base_service_charge").val() ) : 0;
      var grand_total = service_charge + total;

      calculate_alternate_sub_total_currency_value( total );
      calculate_alternate_service_charge_currency_value(service_charge);
      calculate_alternate_grand_total_currency_value(grand_total);

      if( currency_id != '' && total != '' ){
        /*$.get( "<?=base_url('Ajax/change_currency_value/" + currency_id + "/" + total + "' );?>")
        .done(function( data ) {
          console.log( data  );
          var obj = $.parseJSON(data);
          $("#alternate_total_value").val(obj);
        });*/



        if( currency_id == 1 ){
          $("#currency-label").text( "USD" );
          $("#alternate-total").text("KYD");

          $("#service-charge-currency-label").text( "USD" );
          $("#service-charge-alternate-total").text("KYD");

          $("#grand-total-currency-label").text( "USD" );
          $("#grand-total-alternate-total").text("KYD");
        } else {
          $("#currency-label").text( "KYD" );
          $("#alternate-total").text("USD");

          $("#service-charge-currency-label").text( "KYD" );
          $("#service-charge-alternate-total").text("USD");

          $("#grand-total-currency-label").text( "KYD" );
          $("#grand-total-alternate-total").text("USD");
        }

      } else {
        console.log("empty");
      }
    });

    $("#m_item_qty").keyup(function(){
      if( $(this).val() != null && $(this).val() != "" ){
        
        var price = extn = old_extn = "";
        var difference_in_extns = operation = base_total = grand_base_total = "";

        base_total = parseFloat( $("#base_total").val() );
        grand_base_total = parseFloat( $("#grand_base_total").val() );

        var item_counter = $("#m_item_counter").val();
        var heading_id = $("#m_heading_id").val();

        old_extn = $("#" + parseInt(heading_id) + "-extn-" + parseInt(item_counter) ).val();
        console.log("old extn: " + old_extn);

        var qty = parseInt($(this).val());
        
        price = $("#m_item_price").val();
        extn = parseFloat(price) * qty;

        if( parseFloat(old_extn) != extn ){
          if( parseFloat(old_extn) < extn ){
            difference_in_extns = parseFloat(extn - old_extn);
            operation = "addition";

            base_total += difference_in_extns;
            grand_base_total += difference_in_extns;

          } else {
            difference_in_extns = parseFloat(old_extn - extn);
            operation = "subtraction";

            base_total -= difference_in_extns;
            grand_base_total -= difference_in_extns;
            
          }
        }

        console.log("opt: " + operation );

        $("#m_base_total").val(base_total);
        $("#m_grand_base_total").val(grand_base_total);

        $("#m_item_extn").val( extn );
      }
    });

    $("#m_item_price").keyup(function(){
      if( $(this).val() != null && $(this).val() != "" ){
        
        var price = extn = old_extn = "";
        var difference_in_extns = operation = base_total = grand_base_total = "";

        base_total = parseFloat( $("#base_total").val() );
        grand_base_total = parseFloat( $("#grand_base_total").val() );

        var item_counter = $("#m_item_counter").val();
        var heading_id = $("#m_heading_id").val();

        old_extn = $("#" + parseInt(heading_id) + "-extn-" + parseInt(item_counter) ).val();
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
            grand_base_total += difference_in_extns;

          } else {
            difference_in_extns = parseFloat(old_extn - extn);
            operation = "subtraction";

            base_total -= difference_in_extns;
            grand_base_total -= difference_in_extns;
            
          }
        }

        console.log("opt: " + operation );

        $("#m_base_total").val(base_total);
        $("#m_grand_base_total").val(grand_base_total);
      }
    });

    $("#base_service_charge").keyup(function(){
      var base_total = parseFloat($("#base_total").val());

      if( $(this).val() != null && $(this).val() != "" ){
        var service_charge = parseFloat($(this).val());        
        var grand_total = service_charge + base_total;

        $("#grand_base_total").val(grand_total);
        calculate_alternate_service_charge_currency_value(service_charge);
        calculate_alternate_grand_total_currency_value(grand_total);
      } else {
        //$("#base_service_charge").val(0);
        $("#grand_base_total").val(base_total);
        calculate_alternate_grand_total_currency_value(base_total);
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
      $("#heading_id").val('');
      $("#qty").val('');
      $("#desc").val('');
      $("#price").val('');
      $("#extn").val('');
    }

    $("#btnAdd").click(function(){
      var heading_id = $("#heading_id").val();
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

        addAnotherRowForRequisitionItem(heading_id, qty, desc, price, extn);
        clearProductFieldInputs();
      }
    });

    $("#btnMEditItem").click(function(){      

      var description = $("#m_item_description").val();
      //var flt_qty = $("#m_item_flt_qty").val();
      var qty = $("#m_item_qty").val();
      var price = $("#m_item_price").val();
      var extn = $("#m_item_extn").val();
      var item_counter = $("#m_item_counter").val();
      var heading_id = $("#m_heading_id").val();
      var m_base_total = parseFloat($("#m_base_total").val());
      var m_grand_base_total = parseFloat($("#m_grand_base_total").val());

      $("#" + parseInt(heading_id) + "-desc-" + parseInt(item_counter)).val(description);
      $("#" + parseInt(heading_id) + "-qty-" + parseInt(item_counter)).val(qty);
      $("#" + parseInt(heading_id) + "-price-" + parseInt(item_counter)).val(price);
      $("#" + parseInt(heading_id) + "-extn-" + parseInt(item_counter)).val(extn);

      $("#base_total").val(m_base_total);
      $("#grand_base_total").val(m_grand_base_total);

      calculate_alternate_sub_total_currency_value(m_base_total);
      calculate_alternate_grand_total_currency_value(m_grand_base_total);

      $("#edit_item_modal").modal('hide');
    });

    function edit_invoice_item(heading_id, item_counter){
      $("#edit_item_modal").modal('show');

      var description = amount = qty = extn = "";

      description = $("#" + heading_id + "-desc-" + item_counter).val();
      amount = $("#" + heading_id + "-price-" + item_counter).val();
      qty = $("#" + heading_id + "-qty-" + item_counter).val();
      extn = $("#" + heading_id + "-extn-" + item_counter).val();      

      $("#m_item_description").val( description );
      $("#m_item_price").val( amount );
      $("#m_item_qty").val( qty );
      $("#m_item_extn").val( extn );
      $("#m_item_counter").val( item_counter );
      $("#m_heading_id").val( heading_id );
      
    }

    function addAnotherRowForRequisitionItem(heading_id, qty, desc, price, extn){
      var row = "";

      var temp_counter = 0;
      var heading_id_to_use = ( heading_id == "" ) ? 0 : heading_id;

      switch(parseInt(heading_id_to_use)) {
          case 0:
              temp_counter = req_item_counter;
              break;
          case 1:
              temp_counter = passenger_heading_counter;
              break;
          case 2:
              temp_counter = crew_heading_counter;
              break;          
      }

      row = row + '<tr id=' + temp_counter + '>';
      row = row + '<td><input type="text" id="'+ heading_id_to_use +'-qty-' + temp_counter + '"  name="'+ heading_id_to_use +'-qty-' + temp_counter + '" autocomplete="off" value="' + qty +'" class="form-control" readonly></td>';
      row = row + '<td><input type="text" id="'+ heading_id_to_use +'-desc-' + temp_counter + '" name="'+ heading_id_to_use +'-desc-' + temp_counter + '" required="required" autocomplete="off" value="' + desc +'" class="form-control" readonly></td>';
      row = row + '<td><input type="text" id="'+ heading_id_to_use +'-price-' + temp_counter + '" name="'+ heading_id_to_use +'-price-' + temp_counter + '" required="required" autocomplete="off" value="' + price +'" class="form-control" readonly></td>';
      row = row + '<td><input type="text" id="'+ heading_id_to_use +'-extn-' + temp_counter + '" name="'+ heading_id_to_use +'-extn-' + temp_counter + '" required="required" autocomplete="off" value="' + extn +'" class="form-control" readonly></td>';
      
      row = row + '<td style="margin-top: 23px;">';
      row = row + '<a href="#" onClick="edit_invoice_item(' + heading_id_to_use + ', ' + temp_counter + ')" title="Edit"><i class="fas fa-edit"></i></a> | ';
      row = row + '<a href="#" onClick="delete_invoice_item(' + heading_id_to_use + ', ' + temp_counter + ')" title="Delete"><i class="fas fa-trash-alt"></i></a>';
      row = row + '</td>';      
      row = row + '</tr>';

      console.log( "h id: " + heading_id );

      //if( heading_id != null && heading_id != "" ){
        //console.log("in with headings");
        switch(parseInt(heading_id_to_use)) {
          case 0:
              if(!$("#main_section").is(":visible")){
                $("#main_section").show();
              }
              $("#tblRequestedItems #main_section").append(row);
              req_item_counter++;
              break;
          case 1:
              if(!$("#passenger_heading").is(":visible")){
                $("#passenger_heading").show();
              }
              $("#tblRequestedItems #passenger_heading").append(row);
              passenger_heading_counter++;
              break;
          case 2:
              if(!$("#crew_heading").is(":visible")){
                $("#crew_heading").show();
              }
              $("#tblRequestedItems #crew_heading").append(row);
              crew_heading_counter++;
              break;
        }
      /*} else {
        console.log("in without headings");
        if(!$("#main_section").is(":visible")){
          $("#main_section").show();
        }
        $("#tblRequestedItems #main_section").append(row);
        req_item_counter++;
      }*/
      console.log( "total before adding: " + $("#base_total").val() );
      console.log( "extn before adding: " + extn );
      invoice_sub_total_cost += parseFloat(extn);
      console.log(invoice_sub_total_cost);
      $("#base_total").val(invoice_sub_total_cost);
      var service_charge = ( $("#base_service_charge").val() != null && $("#base_service_charge").val() != "" ) ? parseFloat( $("#base_service_charge").val() ) : 0;
      var grand_base_total = invoice_sub_total_cost + service_charge;
      $("#grand_base_total").val(grand_base_total);      

      calculate_alternate_sub_total_currency_value(invoice_sub_total_cost);
      calculate_alternate_service_charge_currency_value(service_charge);
      calculate_alternate_grand_total_currency_value(grand_base_total);

      total_items_added++;

      $("#no_of_items").val(total_items_added);
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

    function calculate_alternate_service_charge_currency_value( service_charge ){
      if(service_charge != null && service_charge != ""){
        console.log("in");
        console.log("sc: " + service_charge);
        var currency_id = $("#currency-id").val();

        if( currency_id != '' && service_charge != '' ){
          $.get( "<?=base_url('Ajax/change_currency_value/" + currency_id + "/" + service_charge + "' );?>")
          .done(function( data ) {
            console.log( data  );
            var obj = $.parseJSON(data);
            $("#alternate_service_charge").val(obj);
          });

        } else {
          console.log("empty");
        }
      } else {
        $("#alternate_service_charge").val(0);
      }
      
    }

    function calculate_alternate_grand_total_currency_value( grand_base_total ){
      var currency_id = $("#currency-id").val();
      
      if( currency_id != '' && grand_base_total != '' ){
        $.get( "<?=base_url('Ajax/change_currency_value/" + currency_id + "/" + grand_base_total + "' );?>")
        .done(function( data ) {
          console.log( data  );
          var obj = $.parseJSON(data);
          $("#grand_alternate_total_value").val(obj);
        });

      } else {
        console.log("empty");
      }
    }

    function delete_invoice_item( heading_id, item_counter ){
      
      var do_delete_row = confirm("Are you sure you want to delete this item?");

      if( do_delete_row == true ){
        //get price of item to be deleted
        //if( heading_id != null && heading_id != "" ){

        var extn = parseFloat( $("#" + heading_id + "-extn-" + item_counter).val());
        console.log( "extn from item to be deleted: " + extn );
        var base_total_before_deletion = parseFloat($("#base_total").val());        
        var service_charge = parseFloat($("#base_service_charge").val());
        var grand_total_before_deletion = parseFloat($("#grand_base_total").val());

        console.log("base total b4 d: " + base_total_before_deletion);
        console.log("sc b4 d: " + service_charge);
        console.log("grand base total b4 d: " + grand_total_before_deletion);

        var base_total_after_deletion = base_total_before_deletion - extn;
        var grand_total_after_deletion = base_total_after_deletion + service_charge;

        console.log("base total after d: " + base_total_after_deletion);
        console.log("grand base total after d: " + grand_total_after_deletion);

        var index_to_delete_from_table = parseInt(item_counter)-1;

        switch(parseInt(heading_id)) {
          case 0:
          //console.log($("#tblRequestedItems #main_section tr").length);
          //console.log( "counter for item to be deleted: " + item_counter );
            var tbody_length = $("#tblRequestedItems #main_section tr").length;
            index_to_delete_from_table = (tbody_length == 1) ? -1 : index_to_delete_from_table;
          
              document.getElementById("main_section").deleteRow(parseInt(index_to_delete_from_table));
              req_item_counter--;
              break;
          case 1:
              var tbody_length = $("#tblRequestedItems #passenger_heading tr").length;
              index_to_delete_from_table = (tbody_length == 1) ? -1 : index_to_delete_from_table;

              document.getElementById("passenger_heading").deleteRow(index_to_delete_from_table);
              passenger_heading_counter--;
              break;
          case 2:
              var tbody_length = $("#tblRequestedItems #crew_heading tr").length;
              index_to_delete_from_table = (tbody_length == 1) ? -1 : index_to_delete_from_table;

              document.getElementById("crew_heading").deleteRow(index_to_delete_from_table);
              crew_heading_counter--;
              break;
        }
        /*} else {
          document.getElementById("main_section").deleteRow(item_counter);
          req_item_counter--;
        }*/

        //invoice_sub_total_cost = invoice_sub_total_cost - extn;
        //console.log( invoice_sub_total_cost );

        $("#base_total").val(base_total_after_deletion);
        $("#grand_base_total").val(grand_total_after_deletion);

        calculate_alternate_sub_total_currency_value(base_total_after_deletion);
        calculate_alternate_grand_total_currency_value(grand_total_after_deletion);

        //document.getElementById("tblRequestedItems").deleteRow(item_counter);
        //req_item_counter--;
        //console.log( "counter: " + req_item_counter );
      }
    }  

    </script>
  </body>
</html>
