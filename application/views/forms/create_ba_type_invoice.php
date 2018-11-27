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

            <form id="add-user-frm" class="form-horizontal form-label-left" method="post" action="<?=base_url('Forms/do_add_ba_type_invoice')?>" data-toggle="validator" role="form">

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
                    <select id="client-id" name="client-id" class="form-control" required="required" >
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
                <div class="col-md-1 col-md-offset-7" >
                  <label for="">Flt Qty:</label>
                    <input type="number" name="flight-quantity" id="flight-quantity" class="form-control">
                </div>
              </div> <!-- end of row -->

              <br />

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

                <div class="col-md-4">
                  <label class="" for="product-id">Description</label>
                  <input type="text" id="desc" name="desc" autocomplete="off" class="form-control" placeholder="Size 12 Nike Caps">
                </div>

                <div class="col-md-1">
                    <label class="" for="unit-id">%</label>
                    <input type="number" id="flt-qty-pctg" name="flt-qty-pctg" autocomplete="off" class="form-control" placeholder="1">
                </div>

                <div class="col-md-1">
                    <label class="" for="unit-id">Qty</label>
                    <input type="number" id="qty" name="qty" autocomplete="off" class="form-control" placeholder="25" readonly="readonly">
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
                        <th>Description</th>
                        <th width="7%">%</th>
                        <th width="7%">Qty</th>
                        <th width="10%">Price</th>
                        <th width="10%">Extension</th>
                        <th width="7%">Options</th>
                      </tr>
                    </thead>

                    <tbody id="bf">
                      <tr>
                        <td colspan="6"><strong>BREAKFAST</strong></td>
                      </tr>
                    </tbody>

                    <tbody id="cc">
                      <tr>
                        <td colspan="6"><strong>CABIN CREW</strong></td>
                      </tr>
                    </tbody>

                    <tbody id="cw">
                      <tr>
                        <td colspan="6"><strong>CLUB WORLD</strong></td>
                      </tr>
                    </tbody>

                    <tbody id="entree">
                      <tr>
                        <td colspan="6"><strong>ENTREE</strong></td>
                      </tr>
                    </tbody>

                    <tbody id="ii">
                      <tr>
                        <td colspan="6"><strong>INTER ISLAND</strong></td>
                      </tr>
                    </tbody>

                    <tbody id="retro">
                      <tr>
                        <td colspan="6"><strong>RETRO</strong></td>
                      </tr>
                    </tbody>

                    <tbody id="wt">
                      <tr>
                        <td colspan="6"><strong>WORLD TRAVEL</strong></td>
                      </tr>
                    </tbody>

                    <tbody id="wtp">
                      <tr>
                        <td colspan="6"><strong>WORLD TRAVEL PLUS</strong></td>
                      </tr>
                    </tbody>

                    <tbody id="misc">
                      <tr>
                        <td colspan="6"><strong>MISCELLANEOUS</strong></td>
                      </tr>
                    </tbody>

                    <!-- sub total -->

                    <tr>
                      <td colspan="3">Sub Total</td>
                      <td><span id="currency-label">USD</span></td>
                      <td><input type="text" name="base_total" id="base_total" class="form-control" readonly="readonly" /></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td colspan="3"></td>
                      <td><span id="alternate-total">KYD</span></td>
                      <td><input type="text" name="alternate_total_value" id="alternate_total_value" class="form-control" readonly="readonly" /></td>
                      <td></td>
                    </tr>

                    <!-- service charge -->
                    <tr>
                      <td colspan="3">Service Charge</td>
                      <td> <span id="service-charge-currency-label">USD</span></td>
                      <td><input type="text" name="base_service_charge" id="base_service_charge" class="form-control" autocomplete="off" value="0" /></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td colspan="3"></td>
                      <td><span id="service-charge-alternate-total">KYD</span></td>
                      <td><input type="text" name="alternate_service_charge" id="alternate_service_charge" class="form-control" readonly="readonly" /></td>
                      <td></td>
                    </tr>

                    <!-- grand total -->
                    <tr>
                      <td colspan="3"><strong>Grand Total</strong></td>
                      <td> <span id="grand-total-currency-label">USD</span></td>
                      <td><input type="text" name="grand_base_total" id="grand_base_total" class="form-control" readonly="readonly" /></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td colspan="3"></td>
                      <td><span id="grand-total-alternate-total">KYD</span></td>
                      <td><input type="text" name="grand_alternate_total_value" id="grand_alternate_total_value" class="form-control" readonly="readonly" /></td>
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
                            <label>Flt Qty</label>
                            <input type="number" name="m_item_flt_qty" id="m_item_flt_qty" class="form-control" readonly="readonly">
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-3">
                            <label>Percentage</label>
                            <input type="number" name="m_item_pctg" id="m_item_pctg" class="form-control">
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-3">
                            <label>Qty</label>
                            <input type="number" name="m_item_qty" id="m_item_qty" class="form-control" readonly="readonly">
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
      var req_item_counter = 1;
      var invoice_sub_total_cost = 0;
      var ba_client_id = 2;

      var bf_counter = cc_counter = entree_counter = cw_counter = ii_counter = retro_counter = wt_counter = wtp_counter = misc_counter = total_items_added = 1;

    $(document).ready(function(){
      $("#msg-holder").hide();
        $('#add-user-frm').validator();

        hide_invoice_headings();
        //get_client_routes_types(ba_client_id);

        $( "#flight-date" ).datepicker({ 
          dateFormat: 'yy-mm-dd',
          changeYear: true
        }).datepicker("setDate", new Date());

    });

    function hide_invoice_headings(){
      $("#cc").hide();
      $("#bf").hide();
      $("#cw").hide();
      $("#entree").hide();
      $("#ii").hide();
      $("#retro").hide();
      $("#wt").hide();
      $("#wtp").hide();
      $("#misc").hide();
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

    /*$("#flight-quantity").keyup(function(){
      if( $(this).val() != null && $(this).val() != "" ){
        if( parseInt($(this).val()) == 0){
          $("#qty").attr("readonly", false);
          $("#flt-qty-pctg").val(0);
        } else {
          $("#flt-qty-pctg").val("");
          $("#qty").attr("readonly", true);
        }
      }
    });*/

    $("#flt-qty-pctg").keyup(function(){
      if( $(this).val() != null && $(this).val() != "" ){
        if( parseInt($(this).val()) == 0){
          $("#qty").attr("readonly", false);
          //$("#flt-qty-pctg").val(0);
        } else {
          //$("#flt-qty-pctg").val("");
          var flt_qty_pctg = "";
          var flt_qty = parseInt($("#flight-quantity").val());
          var flt_qty_pctg = Math.ceil( parseInt($(this).val())/100 * flt_qty);

          $("#qty").val( flt_qty_pctg );
          $("#qty").attr("readonly", true);
        }
      }
    });

    $("#m_item_pctg").keyup(function(){
      if( $(this).val() != null && $(this).val() != "" ){
        var flt_qty_pctg = price = extn = flt_qty = qty = old_extn = heading_id = item_counter = "";
        var difference_in_extns = operation = base_total = grand_base_total = "";

        base_total = parseFloat( $("#base_total").val() );
        grand_base_total = parseFloat( $("#grand_base_total").val() );

        var item_counter = $("#m_item_counter").val();
        var heading_id = $("#m_heading_id").val();

        old_extn = $("#" + parseInt(heading_id) + "-extn-" + parseInt(item_counter) ).val();
        console.log("old extn: " + old_extn);

        if( parseInt($(this).val()) == 0){
          $("#m_item_qty").attr("readonly", false);
          //$("#flt-qty-pctg").val(0);
          qty = parseInt($("#m_item_qty").val());
          price = $("#m_item_price").val();          
          extn = parseFloat(price) * qty;
        } else {
          //$("#flt-qty-pctg").val("");
          $("#m_item_qty").attr("readonly", true);
          
          var flt_qty = parseInt($("#m_item_flt_qty").val());
          qty = Math.ceil( parseInt($(this).val())/100 * flt_qty);

          price = $("#m_item_price").val();
          extn = parseFloat(price) * qty;
        }

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

        $("#m_item_qty").val( qty );
        $("#m_item_extn").val( extn );
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

    $("#btnMEditItem").click(function(){      

      var description = $("#m_item_description").val();
      //var flt_qty = $("#m_item_flt_qty").val();
      var pctg = $("#m_item_pctg").val();
      var qty = $("#m_item_qty").val();
      var price = $("#m_item_price").val();
      var extn = $("#m_item_extn").val();
      var item_counter = $("#m_item_counter").val();
      var heading_id = $("#m_heading_id").val();
      var m_base_total = parseFloat($("#m_base_total").val());
      var m_grand_base_total = parseFloat($("#m_grand_base_total").val());

      $("#" + parseInt(heading_id) + "-desc-" + parseInt(item_counter)).val(description);
      $("#" + parseInt(heading_id) + "-pctg-" + parseInt(item_counter)).val(pctg);
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

      var description = $("#" + heading_id + "-desc-" + item_counter).val();
      var pctg = $("#" + heading_id + "-pctg-" + item_counter).val();
      var amount = $("#" + heading_id + "-price-" + item_counter).val();
      var qty = $("#" + heading_id + "-qty-" + item_counter).val();
      var extn = $("#" + heading_id + "-extn-" + item_counter).val();
      var flt_qty = $("#flight-quantity").val();
      console.log( "flt qty" + flt_qty );

      $("#m_item_description").val( description );
      $("#m_item_price").val( amount );
      $("#m_item_qty").val( qty );
      $("#m_item_pctg").val( pctg );
      $("#m_item_extn").val( extn );
      $("#m_item_flt_qty").val( flt_qty );
      $("#m_item_counter").val( item_counter );
      $("#m_heading_id").val( heading_id );
      
    }

    function clearProductFieldInputs(){
      $("#heading_id").val('');
      $("#qty").val('');
      $("#flt-qty-pctg").val('');
      //$("#flight-quantity").val('');
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
      var pctg = $("#flt-qty-pctg").val();
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

        addAnotherRowForRequisitionItem(heading_id, qty, desc, price, extn, pctg);
        clearProductFieldInputs();
      }
    });

    function addAnotherRowForRequisitionItem(heading_id, qty, desc, price, extn, pctg){
      var row = "";

      var temp_counter = 0;

      switch(parseInt(heading_id)) {
          case 3:
              temp_counter = wtp_counter;
              break;
          case 4:
              temp_counter = wt_counter;
              break;
          case 5:
              temp_counter = cw_counter;
              break;
          case 6:
              temp_counter = retro_counter;
              break;
          case 7:
              temp_counter = bf_counter;
              break;
          case 8:
              temp_counter = entree_counter;
              break;
          case 9:
              temp_counter = ii_counter;
              break;
          case 11:
              temp_counter = cc_counter;
              break;
          case 12:
              temp_counter = misc_counter;
              break;
      }

      row = row + '<tr id=' + req_item_counter + '>';      
      row = row + '<td><input type="text" id="'+ heading_id +'-desc-' + req_item_counter + '" name="'+ heading_id +'-desc-' + req_item_counter + '" required="required" autocomplete="off" value="' + desc +'" class="form-control" readonly></td>';
      row = row + '<td><input type="text" id="'+ heading_id +'-pctg-' + req_item_counter + '" name="'+ heading_id +'-pctg-' + req_item_counter + '" autocomplete="off" value="' + pctg +'" class="form-control" readonly></td>';
      row = row + '<td><input type="text" id="'+ heading_id +'-qty-' + req_item_counter + '" name="'+ heading_id +'-qty-' + req_item_counter + '" autocomplete="off" value="' + qty +'" class="form-control" readonly></td>';
      row = row + '<td><input type="text" id="'+ heading_id +'-price-' + req_item_counter + '" name="'+ heading_id +'-price-' + req_item_counter + '" required="required" autocomplete="off" value="' + price +'" class="form-control" readonly></td>';
      row = row + '<td><input type="text" id="'+ heading_id +'-extn-' + req_item_counter + '" name="'+ heading_id +'-extn-' + req_item_counter + '" required="required" autocomplete="off" value="' + extn +'" class="form-control" readonly></td>';
      
      row = row + '<td style="margin-top: 23px;">';
      row = row + '<a href="#" onClick="edit_invoice_item(' + heading_id + ', '  + req_item_counter + ')" title="Edit"><i class="fas fa-edit"></i></a> | ';
      row = row + '<a href="#" onClick="delete_invoice_item(' + heading_id + ', '  + req_item_counter + ', ' + extn +')" title="Delete"><i class="fas fa-trash-alt"></i></a>';
      row = row + '</td>';      
      row = row + '</tr>';

      console.log( "h id: " + heading_id );

      //if( heading_id != null && heading_id != "" ){
        //console.log("in with headings");
        switch(parseInt(heading_id)) {
          case 3:
              if(!$("#wtp").is(":visible")){
                $("#wtp").show();
              }
              $("#tblRequestedItems #wtp").append(row);
              wtp_counter++;
              break;
          case 4:
              if(!$("#wt").is(":visible")){
                $("#wt").show();
              }
              $("#tblRequestedItems #wt").append(row);
              wt_counter++;
              break;
          case 5:
              if(!$("#cw").is(":visible")){
                $("#cw").show();
              }
              $("#tblRequestedItems #cw").append(row);
              cw_counter++;
              break;
          case 6:
              if(!$("#retro").is(":visible")){
                $("#retro").show();
              }
              $("#tblRequestedItems #retro").append(row);
              retro_counter++;
              break;
          case 7:
              if(!$("#bf").is(":visible")){
                $("#bf").show();
              }
              $("#tblRequestedItems #bf").append(row);
              bf_counter++;
              break;
          case 8:
              if(!$("#entree").is(":visible")){
                $("#entree").show();
              }
              $("#tblRequestedItems #entree").append(row);
              entree_counter++;
              break;
          case 9:
              if(!$("#ii").is(":visible")){
                $("#ii").show();
              }
              $("#tblRequestedItems #ii").append(row);
              ii_counter++;
              break;
          case 11:
              if(!$("#cc").is(":visible")){
                $("#cc").show();
              }
              $("#tblRequestedItems #cc").append(row);
              cc_counter++;
              break;
          case 12:
              if(!$("#misc").is(":visible")){
                $("#misc").show();
              }
              $("#tblRequestedItems #misc").append(row);
              misc_counter++;
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

      $("#no_of_items").val(req_item_counter);
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

    function delete_invoice_item(heading_id, item_counter, extn ){
      console.log( "counter: " + req_item_counter );
      var do_delete_row = confirm("Are you sure you want to delete this item?");

      if( do_delete_row == true ){
        //get price of item to be deleted

        switch(parseInt(heading_id)) {
          case 3:
              document.getElementById("wtp").deleteRow(item_counter);
              wtp_counter--;
              break;
          case 4:
              document.getElementById("wt").deleteRow(item_counter);
              wt_counter--;
              break;
          case 5:
              document.getElementById("cw").deleteRow(item_counter);
              cw_counter--;
              break;
          case 6:
              document.getElementById("retro").deleteRow(item_counter);
              retro_counter--;
              break;
          case 7:
              document.getElementById("bf").deleteRow(item_counter);
              bf_counter--;
              break;
          case 8:
              document.getElementById("entree").deleteRow(item_counter);
              entree_counter--;
              break;
          case 9:
              document.getElementById("ii").deleteRow(item_counter);
              ii_counter--;
              break;
          case 11:
              document.getElementById("cc").deleteRow(item_counter);
              cc_counter--;
              break;
          case 12:
              document.getElementById("misc").deleteRow(item_counter);
              misc_counter--;
              break;
        }

        var base_total = parseFloat( $("#base_total").val());
        //var field = heading_id + "-extn-" + item_counter;
        //var extn = $("#" + field).val();
        //console.log("field: " + field);
        var grand_total_cost = parseFloat($("#grand_base_total").val());
        var service_charge = ( $("#base_service_charge").val() != null && $("#base_service_charge").val() != "" ) ? parseFloat( $("#base_service_charge").val() ) : 0;
        console.log( "b bt: " + invoice_sub_total_cost );
        console.log( "extn: " + extn );
        console.log( "b gt: " + grand_total_cost );
        invoice_sub_total_cost = invoice_sub_total_cost - extn;
        grand_total_cost = invoice_sub_total_cost + service_charge;
        console.log( "a bt: " + invoice_sub_total_cost );
        console.log( "a gt: " + grand_total_cost );

        $("#base_total").val(invoice_sub_total_cost);
        $("#grand_base_total").val(grand_total_cost);

        calculate_alternate_sub_total_currency_value(invoice_sub_total_cost);
        calculate_alternate_grand_total_currency_value(grand_total_cost);
      }
    }  

    </script>
  </body>
</html>
