<!DOCTYPE html>
<html lang="en">
  <head>
    <?include_once 'includes/head.inc'; ?>
    <link rel="stylesheet" href="<?=base_url('assets/css/jquery-ui.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/css/bootstrapValidator.css');?>">
</style>
    
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
              <li><a href="<?=base_url('Invoices');?>">Invoices</a></li>
              <li class="active">View Invoice</li>
            </ol>

            <div class="row">
              <div class="col-md-2 col-md-offset-9">
                <button class="btn btn-lg btn-danger" name="btnPrint" id="btnPrint"><i class="fa fa-print"></i> Print Invoice</button>
              </div>
            </div>

            <div id="area_to_print">

              <div class="row" >
              <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
                <div class="alert " id="msg-holder"></div>
              </div>
            </div>

            <br />

            <div class="row">
              <div class="col-md-2">
                <img src="<?=base_url('assets/images/logo-gcg-220-120.jpg');?>" height="50" width="100">
              </div>
              <div class="col-md-8 text-center">
                <strong><?=$page_title;?></strong><br/>
                <?=$company_address_top;?>
              </div>
            </div>

            <br />

              <div class="row">
                <!--<div class="col-md-4">
                  <label for="supplier-id"><?=$company_name;?></label><br />
                  <?=$company_address;?>
                </div>-->

                <div class="col-md-4">
                  <label for="">Bill To:</label>
                    <div class="" >
                      <?=$invoice["client_name"] . " " . $invoice["destination_abbreviation"];?> <br />
                      <?=$client_address;?>
                    </div>
                </div>

                <div class="col-md-4 col-md-offset-3 pull-right">                  
                    <label for="po-no-id">Invoice No.:</label> <?=$invoice["invoice_no"];?>
                  
                    <br />
                    <label for="requisition-date">Creation Date:</label>
                    <?=date('M d, Y', strtotime($invoice["invoice_date"]));?><br />

                    <label for="requisition-date">Flight Date:</label>
                    <?=date('M d, Y', strtotime($invoice["flight_date"]));?><br />

                    <label for="tail-no">Tail No:</label>
                    <?=$invoice["tail_no"];?><br />

                    <label for="requisition-date">Disbursement No.:</label>
                    <?=$invoice["disbursement_no"];?>
                      
                </div>
              </div>

              <br />

              <!--<div class="row">
                <div class="col-md-4">
                  <label for="">Bill To:</label>
                    <div class="" >
                      <?=$invoice["client_name"] . " " . $invoice["destination_abbreviation"];?> <br />
                      <?=$client_address;?>
                    </div>
                </div>
              </div>

              <br/>-->

              <div class="row">
                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                  <table class="table table-bordered table-striped table-condensed" id="tblRequestedItems">
                    <thead>
                      <tr>
                        <th width="7%"><h4>Qty</h4></th>
                        <th><h4>Description</h4></th>
                        <th width="10%"><h4>Price</h4></th>
                        <th width="10%"><h4>Extension</h4></th>
                      </tr>
                    </thead>                    
                      
                      <?
                      foreach ($headings as $key => $value) {
                        $column_name = strtolower($value["heading_title"]);
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
                        }
                        //echo $tbody_id;
                        $items = json_decode( $invoice[$table_column] );
                      
                      //echo "<pre>";print_r($items);exit;
                      if( !empty($items) )
                      {?>
                        <tbody id="<?=$tbody_id?>">
                            <tr>
                              <td colspan="4"><strong><?=$heading_title?></strong></td>
                            </tr>
                        <?foreach($items as $key => $value)
                        {
                          //echo "<pre>";print_r($value->qty);exit;?>
                          <tr>
                            <td class="right_align_number"><?=$value->qty;?></td>
                            <td><?=$value->desc;?></td>
                            <td class="right_align_number"><?=sprintf("%.2f", $value->price);?></td>
                            <td class="right_align_number"><?=sprintf("%.2f", $value->extn);?></td>
                          </tr>
                        <?}
                      }
                    }?>
                    </tbody>
                    <tr>
                      <td colspan="2">Sub Total</td>
                      <td><span id="currency-label">USD</span></td>
                      <td class="right_align_number">$<?= sprintf("%.2f", $invoice['invoice_total_amount'])?></td>
                    </tr>
                    <tr>
                      <td colspan="2"></td>
                      <td><span id="alternate-total">KYD</span></td>
                      <td class="right_align_number">$<span name="alternate_total_value" id="alternate_total_value" ></span></td>
                    </tr>

                    <!-- service charge -->
                    <tr>
                      <td colspan="2">Service Charge</td>
                      <td> <span id="service-charge-currency-label">USD</span></td>
                      <td class="right_align_number">$<?=$invoice['service_charge_amount'];?></td>
                    </tr>
                    <tr>
                      <td colspan="2"></td>
                      <td><span id="service-charge-alternate-total">KYD</span></td>
                      <td class="right_align_number">$<span name="alternate_service_charge" id="alternate_service_charge" ></span></td>
                    </tr>

                    <!-- grand total -->
                    <tr>
                      <td colspan="2"><strong>Grand Total</strong></td>
                      <td> <span id="grand-total-currency-label">USD</span></td>
                      <td class="right_align_number">$<?=$invoice['grand_total_amount']?></td>
                    </tr>
                    <tr>
                      <td colspan="2"></td>
                      <td><span id="grand-total-alternate-total">KYD</span></td>
                      <td class="right_align_number">$<span name="grand_alternate_total_value" id="grand_alternate_total_value" ></span></td>
                    </tr>
                  </table>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <!--<p style="margin-top: 23px;"><strong>For Shoes order:</strong> Please specify width (Medium or Wide)</p>-->
                  <label >Created by:</label> <br />
                  <?=$invoice["created_by"];?>
                  
                </div>
                <!--<div class="col-md-4 col-md-offset-2 pull-right">
                  <label >Send to:</label> <br />
                  <?//=$invoice["send_copy_to"];?>
                </div>-->
              </div>

              <br />
  
        </div>

        <!--<div class="row">
          <div class="col-md-2 col-md-offset-4">
            <input type="button" name="btnPrint" id="btnPrint" class="btn btn-lg btn-danger" value="Print Purchase Order">
          </div>
        </div>-->

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
      var currency_id = <?=$invoice["currency_id"]?>;

    $(document).ready(function(){
      $("#msg-holder").hide();
        $( "#dob" ).datepicker({ 
          dateFormat: 'yy-mm-dd',
          changeYear: true,
          yearRange: "-50:+0" 
        });
        $('#add-user-frm').validator();  

        
        var total = <?=$invoice["invoice_total_amount"]?>;
        var service_charge = <?=$invoice["service_charge_amount"]?>;
        var grand_total = <?=$invoice["grand_total_amount"]?>;
        var currency_id = <?=$invoice["currency_id"]?>;

        toggle_item_currency_labels(currency_id);

        //set_alternate_total( currency_id, total );
        calculate_alternate_sub_total_currency_value( total );
        calculate_alternate_service_charge_currency_value(service_charge);
        calculate_alternate_grand_total_currency_value(grand_total);

    });

    function toggle_item_currency_labels(currency_id){
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
    }

    function calculate_alternate_sub_total_currency_value( base_total ){
      
      console.log("currency_id: " + currency_id);
      console.log("base_total: " + base_total);
      //console.log( 'Ajax/change_currency_value/' + currency_id + '/' + base_total );

      if( parseInt(currency_id) != '' && parseFloat(base_total) != '' ){
        $.get( "<?=base_url('Ajax/change_currency_value/" + currency_id + "/" + base_total + "' );?>")
        .done(function( data ) {
          console.log( data  );
          var obj = $.parseJSON(data);
          $("#alternate_total_value").text(obj);
        });

      } else {
        //console.log("is empty");
        $("#alternate_total_value").text(0);
      }
    }

    function calculate_alternate_service_charge_currency_value( service_charge ){
      if(service_charge != null && parseFloat(service_charge) != ""){
        console.log("in");
        console.log("sc: " + service_charge);
        //var currency_id = parseInt($("#currency-id").val());
        //console.log("currency id: " + isNaN( currency_id));
        //console.log("sc id: " + isNaN( service_charge));
        //var service_charge_2 = parseFloat( service_charge );
        //console.log("sc 2: " + service_charge_2);
        if( currency_id != '' && parseFloat(service_charge) != '' ){
            $.get( "<?=base_url('Ajax/change_currency_value/" + currency_id + "/" + service_charge + "' );?>")
          .done(function( data ) {
            console.log( data  );
            var obj = $.parseJSON(data);
            $("#alternate_service_charge").text(obj);
          });

        } else {
          console.log("empty");
        }
      } else {
        $("#alternate_service_charge").text(0);
      }
      
    }

    function calculate_alternate_grand_total_currency_value( grand_base_total ){
      //var currency_id = $("#currency-id").val();
      
      if( currency_id != '' && grand_base_total != '' ){
        $.get( "<?=base_url('Ajax/change_currency_value/" + currency_id + "/" + grand_base_total + "' );?>")
        .done(function( data ) {
          console.log( data  );
          var obj = $.parseJSON(data);
          $("#grand_alternate_total_value").text(obj);
        });

      } else {
        //console.log("empty");
        $("#grand_alternate_total_value").text(0);
      }
    }

    function set_alternate_total( currency_id, total ){

        if( currency_id != '' && total != '' ){
          $.get( "<?=base_url('Ajax/change_currency_value/" + currency_id + "/" + total + "' );?>")
          .done(function( data ) {
            console.log( data  );
            var obj = $.parseJSON(data);
            $("#alternate_total_value").text(obj);
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

    $("#btnPrint").click(function(){
        if($("#approve_po_section").is(":visible")){
            $("#approve_po_section").hide();
        }
        
      /*var divToPrint=document.getElementById('area_to_print');

      var newWin=window.open('','Print-Window');

      newWin.document.open();

      newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

      newWin.document.close();

      setTimeout(function(){newWin.close();},10);*/

      var printContents = document.getElementById('area_to_print').innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
    });


    </script>
    

  </body>
</html>
