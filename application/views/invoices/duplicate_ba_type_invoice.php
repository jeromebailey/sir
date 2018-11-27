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

            <form id="add-user-frm" class="form-horizontal form-label-left" method="post" action="<?=base_url('Invoices/do_duplicate_ba_type_invoice')?>" data-toggle="validator" role="form">

              <!--<div class="row">
                <div class="col-md-3">
                  <img src="<?=base_url('assets/images/logo-gcg-220-120.jpg');?>" height="120" width="220">
                </div>
              </div>-->

              <input type="hidden" name="invoice-id" value="<?=$next_invoice_no?>">

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
                <div class="col-md-3">
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

                <div class="col-md-3">
                  <label for="">Routes/Types:</label>
                    <select id="client-routes-types" name="client-routes-types" class="form-control" >
                    <option value="">Select Route/Type</option>
                    <?
                    if( !empty($client_routes) ){
                      foreach ($client_routes as $key => $value) {
                        if( $invoice["routes_type_id"] == $value["destination_id"] ){?>
                          <option value="<?=$value["destination_id"]?>" selected><?=$value["destination_abbreviation"]?></option>
                        <?} else {?>
                          <option value="<?=$value["destination_id"]?>"><?=$value["destination_abbreviation"]?></option>
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
                <div class="col-md-1 col-md-offset-7" >
                  <label for="">Flt Qty:</label>
                    <input type="number" name="flight-quantity" id="flight-quantity" class="form-control" value='<?=$invoice["flt_qty"]?>'>
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
                  <input type="text" id="desc" name="desc" autocomplete="off" class="form-control" placeholder="Compressor">
                </div>

                <div class="col-md-1">
                    <label class="" for="unit-id">%</label>
                    <input type="number" id="flt-qty-pctg" name="flt-qty-pctg" autocomplete="off" class="form-control" placeholder="1">
                </div>

                <div class="col-md-1">
                    <label class="" for="unit-id">Qty</label>
                    <input type="number" id="qty" name="qty" autocomplete="off" class="form-control" placeholder="1">
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
                        <th width="8%">Qty</th>
                        <th width="8%">Qty</th>
                        <th width="8%">Price</th>
                        <th width="8%">Extension</th>
                        <th width="7%">Options</th>
                      </tr>
                    </thead>
                    
                      <?
                      foreach ($headings as $key => $value) {
                        //echo "<pre>";print_r($headings);exit;
                        $section_id = $value["heading_id"];

                        switch ($section_id) {
                          case 3:
                            $tbody_id = "wtp";
                            $table_column = "wtp_details";
                            $heading_title = "World Travel Plus";
                            break;

                          case 4:
                            $tbody_id = "wt";
                            $table_column = "wt_details";
                            $heading_title = "World Travel";
                            break;

                          case 5:
                            $tbody_id = "cw";
                            $table_column = "cw_details";
                            $heading_title = "Club World";
                            break;

                          case 6:
                            $tbody_id = "retro";
                            $table_column = "retro_details";
                            $heading_title = "Retro";
                            break;

                          case 7:
                            $tbody_id = "bf";
                            $table_column = "bf_details";
                            $heading_title = "Breakfast";
                            break;

                          case 8:
                            $tbody_id = "entree";
                            $table_column = "entree_details";
                            $heading_title = "Entree";
                            break;

                          case 9:
                            $tbody_id = "ii";
                            $table_column = "ii_details";
                            $heading_title = "Inter-Island";
                            break;

                          case 10:
                            $tbody_id = "tc";
                            $table_column = "tech_crew_details";
                            $heading_title = "Tech Crew Savory Snack";
                            break;

                          case 11:
                            $tbody_id = "cc";
                            $table_column = "cc_details";
                            $heading_title = "Cabin Crew";
                            break;

                          case 12:
                            $tbody_id = "misc";
                            $table_column = "misc_details";
                            $heading_title = "Miscellaneous";
                            break;
                          
                          default:
                            # code...
                            break;
              //echo "<pre>";print_r($temp_row);exit;
                          
                        } //end of case

                        /*$column_name = strtolower($value["heading_title"]);
                        if( $column_name == "invoice_details" ){
                          $tbody_id = "main_section";
                          $section_id = 0;
                          $table_column = "invoice_details";
                          $heading_title = "";
                        } else {
                          $tbody_id = $column_name . "_heading";
                          $section_id = $value["heading_id"];
                          $table_column = $column_name . "_details";
                          $heading_title = strtoupper($value["heading_title"]);
                        }*/
                        //echo $tbody_id;
                        $items = json_decode( $invoice[$table_column] );

                        if( !empty($items) )
                        {
                          $counter = 1;?>
                          <tbody id="<?=$tbody_id?>">
                            <tr>
                              <td><strong><?=$heading_title?></strong></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                            <?foreach($items as $key => $value)
                            {
                              //echo "<pre>";print_r($value->qty);exit;?>
                              <tr id="<?=$counter?>">                                
                                <td><input type="text" name="<?=$section_id?>-desc-<?=$counter?>" id="<?=$section_id?>-desc-<?=$counter?>" value = "<?=$value->desc?>" class = "form-control" readonly /></td>
                                <td><input type="text" name="<?=$section_id?>-pctg-<?=$counter?>" id="<?=$section_id?>-pctg-<?=$counter?>" value = "<?=$value->percentage?>" class = "form-control" readonly /></td>
                                <td><input type="text" name="<?=$section_id?>-qty-<?=$counter?>" id="<?=$section_id?>-qty-<?=$counter?>" value = "<?=$value->qty?>" class = "form-control" readonly /></td>
                                <td><input type="text" name="<?=$section_id?>-price-<?=$counter?>" id="<?=$section_id?>-price-<?=$counter?>" value = "<?=$value->price?>" class = "form-control" readonly /></td>
                                <td><input type="text" name="<?=$section_id?>-extn-<?=$counter?>" id="<?=$section_id?>-extn-<?=$counter?>" value = "<?=$value->extn?>" class = "form-control" readonly /></td>
                                <td>
                                  <a href="#" onClick="edit_invoice_item(<?=$section_id?>,<?=$counter?>)" title="Edit"><i class="fas fa-edit"></i></a>
                                  <a href="#" onClick="delete_invoice_item(<?=$section_id?>,<?=$counter?>)" title="Delete"><i class="fas fa-trash-alt"></i></a>
                                </td>
                              </tr>
                            <?
                            $counter++;}?>
                            </tbody>
                          <?} else {?>
                            <tbody id="<?=$tbody_id?>" style = "display: none">
                              <tr>
                                <td><strong><?=$heading_title;?></strong></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                              </tr>
                            </tbody>
                          <?}
                          
                      } //end of foreach
                      ?>
                    
                    <tr>
                      <td colspan="3">Sub Total</td>
                      <td><span id="currency-label">USD</span></td>
                      <td><input type="text" name="base_total" id="base_total" class="form-control" readonly="readonly" value="<?= sprintf("%.2f", $invoice['invoice_total_amount'])?>" /></td>
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
                      <td><input type="text" name="base_service_charge" id="base_service_charge" class="form-control" autocomplete="off" value="<?=$invoice['service_charge_amount'];?>" /></td>
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
                      <td><input type="text" name="grand_base_total" id="grand_base_total" class="form-control" readonly="readonly" value="<?=$invoice['grand_total_amount']?>" /></td>
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
      //$items = json_decode( $invoice["invoice_details"] );
      //$items_count = count( $items );
      ?>
      var invoice_total_cost = <?= $invoice['invoice_total_amount'];?>;
      var invoice_sub_total_cost = 0;
      var bf_counter = cc_counter = entree_counter = cw_counter = ii_counter = retro_counter = wt_counter = wtp_counter = misc_counter = total_items_added = 1;

      bf_counter = $('#tblRequestedItems #bf >tr').length;
      cc_counter = $('#tblRequestedItems #cc >tr').length;
      entree_counter = $('#tblRequestedItems #entree >tr').length;
      cw_counter = $('#tblRequestedItems #cw >tr').length;
      ii_counter = $('#tblRequestedItems #ii >tr').length;
      retro_counter = $('#tblRequestedItems #retro >tr').length;
      wt_counter = $('#tblRequestedItems #wt >tr').length;
      wtp_counter = $('#tblRequestedItems #wtp >tr').length;
      misc_counter = $('#tblRequestedItems #misc >tr').length;

    $(document).ready(function(){
      $("#msg-holder").hide();
        $( "#dob" ).datepicker({ 
          dateFormat: 'yy-mm-dd',
          changeYear: true,
          yearRange: "-50:+0" 
        });
        $('#add-user-frm').validator(); 


        $( "#flight-date" ).datepicker({ 
          dateFormat: 'yy-mm-dd',
          changeYear: true
        });

        //console.log( "counter: " + $("#no_of_items").val() ); 

        //$("#currency-id").trigger("change");

        var currency_id = <?=$invoice["currency_id"]?>;
        var total = <?=$invoice["invoice_total_amount"]?>;
        var service_charge = <?=$invoice["service_charge_amount"]?>;
        var grand_total = <?=$invoice["grand_total_amount"]?>;
        var selected_client_id = <?=$invoice["client_id"]?>;
        var route_type_id = <?=$invoice["routes_type_id"]?>;
        //get_client_routes_types( selected_client_id );
        //console.log( route_type_id );
        //$("#client-routes-types option[id='"+route_type_id+"']").attr("selected", "selected");
        //$("mySelectList option[id='1']").attr("selected", "selected");
        //$("#form-field").val("5").trigger("change");
        //$('#client-routes-types').find('option[value='+ route_type_id +']').attr('selected','selected');

        //set_alternate_total( currency_id, total );
        calculate_alternate_sub_total_currency_value( total );
        calculate_alternate_service_charge_currency_value(service_charge);
        calculate_alternate_grand_total_currency_value(grand_total);

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
      if(service_charge != null && parseFloat(service_charge) != ""){
        console.log("in");
        console.log("sc: " + service_charge);
        var currency_id = parseInt($("#currency-id").val());
        //console.log("currency id: " + isNaN( currency_id));
        //console.log("sc id: " + isNaN( service_charge));
        //var service_charge_2 = parseFloat( service_charge );
        //console.log("sc 2: " + service_charge_2);
        if( currency_id != '' && parseFloat(service_charge) != '' ){
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

    function edit_invoice_item(heading_id, item_counter){
      $("#edit_item_modal").modal('show');

      var description = amount = qty = extn = "";

      var pctg = $("#" + heading_id + "-pctg-" + item_counter).val();
      var flt_qty = $("#flight-quantity").val();
      description = $("#" + heading_id + "-desc-" + item_counter).val();
      amount = $("#" + heading_id + "-price-" + item_counter).val();
      qty = $("#" + heading_id + "-qty-" + item_counter).val();
      extn = $("#" + heading_id + "-extn-" + item_counter).val();      

      $("#m_item_pctg").val( pctg );
      $("#m_item_flt_qty").val( flt_qty );
      $("#m_item_description").val( description );
      $("#m_item_price").val( amount );
      $("#m_item_qty").val( qty );
      $("#m_item_extn").val( extn );
      $("#m_item_counter").val( item_counter );
      $("#m_heading_id").val( heading_id );
      
    }

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

    $("#client-id").change(function(){
        var client_id = $(this).val();

        $("#client-routes-types").val( "" );
        get_client_routes_types(client_id);
              
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

    $("#currency-id").change(function(){
      var currency_id = $("#currency-id").val();
      var total = parseFloat($("#base_total").val());
      var service_charge = ( $("#base_service_charge").val() != null && $("#base_service_charge").val() != "" ) ? parseFloat( $("#base_service_charge").val() ) : 0;
      var grand_total = service_charge + total;

      calculate_alternate_sub_total_currency_value( total );
      calculate_alternate_service_charge_currency_value(service_charge);
      calculate_alternate_grand_total_currency_value(grand_total);

      if( currency_id != '' && total != '' ){

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
      $("#heading_id").val('');
      $("#qty").val('');
      $("#desc").val('');
      $("#price").val('');
      $("#extn").val('');
      $("#flt-qty-pctg").val('');
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
      var heading_id_to_use = ( heading_id == "" ) ? 0 : heading_id;

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

      row = row + '<tr id=' + temp_counter + '>';      
      row = row + '<td><input type="text" id="'+ heading_id_to_use +'-desc-' + temp_counter + '" name="'+ heading_id_to_use +'-desc-' + temp_counter + '" required="required" autocomplete="off" value="' + desc +'" class="form-control" readonly></td>';
      row = row + '<td><input type="text" id="'+ heading_id +'-pctg-' + temp_counter + '" name="'+ heading_id +'-pctg-' + temp_counter + '" autocomplete="off" value="' + pctg +'" class="form-control" readonly></td>';
      row = row + '<td><input type="text" id="'+ heading_id_to_use +'-qty-' + temp_counter + '"  name="'+ heading_id_to_use +'-qty-' + temp_counter + '" autocomplete="off" value="' + qty +'" class="form-control" readonly></td>';
      row = row + '<td><input type="text" id="'+ heading_id_to_use +'-price-' + temp_counter + '" name="'+ heading_id_to_use +'-price-' + temp_counter + '" required="required" autocomplete="off" value="' + price +'" class="form-control" readonly></td>';
      row = row + '<td><input type="text" id="'+ heading_id_to_use +'-extn-' + temp_counter + '" name="'+ heading_id_to_use +'-extn-' + temp_counter + '" required="required" autocomplete="off" value="' + extn +'" class="form-control" readonly></td>';
      
      row = row + '<td style="margin-top: 23px;">';
      row = row + '<a href="#" onClick="edit_invoice_item(' + heading_id_to_use + ', ' + temp_counter + ')" title="Edit"><i class="fas fa-edit"></i></a> | ';
      row = row + '<a href="#" onClick="delete_invoice_item(' + heading_id_to_use + ', ' + temp_counter + ')" title="Delete"><i class="fas fa-trash-alt"></i></a>';
      row = row + '</td>';      
      row = row + '</tr>';

      console.log( "h id: " + heading_id );

      switch(parseInt(heading_id)) {
          case 3:
              if(!$("#wtp").is(":visible") || $("#wtp").is(":hidden")){
                $("#wtp").show();
              }
              $("#tblRequestedItems #wtp").append(row);
              wtp_counter++;
              break;
          case 4:
              if(!$("#wt").is(":visible") || $("#wt").is(":hidden")){
                $("#wt").show();
              }
              $("#tblRequestedItems #wt").append(row);
              wt_counter++;
              break;
          case 5:
              if(!$("#cw").is(":visible") || $("#cw").is(":hidden")){
                $("#cw").show();
              }
              $("#tblRequestedItems #cw").append(row);
              cw_counter++;
              break;
          case 6:
              if(!$("#retro").is(":visible") || $("#retro").is(":hidden")){
                $("#retro").show();
              }
              $("#tblRequestedItems #retro").append(row);
              retro_counter++;
              break;
          case 7:
              if(!$("#bf").is(":visible") || $("#bf").is(":hidden")){
                $("#bf").show();
              }
              $("#tblRequestedItems #bf").append(row);
              bf_counter++;
              break;
          case 8:
              if(!$("#entree").is(":visible") || $("#entree").is(":hidden")){
                $("#entree").show();
              }
              $("#tblRequestedItems #entree").append(row);
              entree_counter++;
              break;
          case 9:
              if(!$("#ii").is(":visible") || $("#ii").is(":hidden")){
                $("#ii").show();
              }
              $("#tblRequestedItems #ii").append(row);
              ii_counter++;
              break;
          case 11:
              if(!$("#cc").is(":visible") || $("#cc").is(":hidden")){
                $("#cc").show();
              }
              $("#tblRequestedItems #cc").append(row);
              cc_counter++;
              break;
          case 12:
              if(!$("#misc").is(":visible") || $("#misc").is(":hidden")){
                $("#misc").show();
              }
              $("#tblRequestedItems #misc").append(row);
              misc_counter++;
              break;
        }

      console.log( "total before adding: " + $("#base_total").val() );
      console.log( "extn before adding: " + extn );
      var invoice_sub_total_cost = parseFloat($("#base_total").val());
      invoice_sub_total_cost += parseFloat(extn);
      console.log("total after adding: " + invoice_sub_total_cost);
      $("#base_total").val(invoice_sub_total_cost);
      var service_charge = ( $("#base_service_charge").val() != null && $("#base_service_charge").val() != "" ) ? parseFloat( $("#base_service_charge").val() ) : 0;
      var grand_base_total = invoice_sub_total_cost + service_charge;
      $("#grand_base_total").val(grand_base_total);      

      calculate_alternate_sub_total_currency_value(invoice_sub_total_cost);
      calculate_alternate_service_charge_currency_value(service_charge);
      calculate_alternate_grand_total_currency_value(grand_base_total);

      total_items_added++;

      //$("#no_of_items").val(req_item_counter);
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

    function delete_invoice_item( heading_id, item_counter ){
      //console.log( "counter: " + req_item_counter );
      var do_delete_row = confirm("Are you sure you want to delete this item?");

      if( do_delete_row == true ){
        //get price of item to be deleted

        var extn = parseFloat( $("#" + parseInt(heading_id) + "-extn-" + parseInt(item_counter)).val());
        console.log( "extn: " + extn );
        var invoice_sub_total_cost = $("#base_total").val();
        var service_charge = $("#base_service_charge").val();
        var new_grand_total = 0;
        invoice_sub_total_cost -= extn;
        new_grand_total = parseFloat(invoice_sub_total_cost) + parseFloat(service_charge);
        console.log( invoice_sub_total_cost );

        $("#base_total").val(invoice_sub_total_cost);
        $("#grand_base_total").val(new_grand_total);

        calculate_alternate_sub_total_currency_value(invoice_sub_total_cost);
        calculate_alternate_service_charge_currency_value(service_charge);
        calculate_alternate_grand_total_currency_value(new_grand_total);

        //document.getElementById("tblRequestedItems").deleteRow(item_counter);
        //req_item_counter--;
        //console.log( "counter: " + req_item_counter );

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
