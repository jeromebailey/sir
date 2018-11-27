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
              <li><a href="<?=base_url('Invoices/list_basic_invoices');?>">Invoices</a></li>
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
              <div class="col-md-10 text-center">
                <strong><?=$page_title;?></strong>
                <?//=$company_address_top;?>
              </div>
            </div>

            <br />

              <div class="row">
                <div class="col-md-4">
                  <label for="supplier-id"><?=$company_name;?></label><br />
                  <?=$company_address;?>
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

              <div class="row">
                <div class="col-md-4">
                  <label for="">Bill To:</label>
                    <div class="" >
                      <?=$invoice["client_name"];?> <br />
                      <?=$client_address;?>
                    </div>
                </div>
              </div>

              <br/>

              <h3>Item / Part Requested</h3>

              <div class="row">
                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                  <table class="table table-bordered table-striped table-condensed" id="tblRequestedItems">
                    <thead>
                      <tr>
                        <th width="7%">Qty</th>
                        <th>Description</th>
                        <th width="10%">Price</th>
                        <th width="10%">Extension</th>
                      </tr>
                    </thead>
                    <tbody>
                      
                      <?
                      $items = json_decode( $invoice["invoice_details"] );
                      //echo "<pre>";print_r($items);exit;
                      if( !empty($items) )
                      {
                        foreach($items as $key => $value)
                        {
                          //echo "<pre>";print_r($value->qty);exit;?>
                          <tr>
                            <td><?=$value->qty;?></td>
                            <td><?=$value->desc;?></td>
                            <td><?=sprintf("%.2f", $value->price);?></td>
                            <td><?=sprintf("%.2f", $value->extn);?></td>
                          </tr>
                        <?}
                      }?>
                    </tbody>
                    <tr>
                      <td colspan="2"></td>
                      <td>Total <span id="currency-label">USD</span></td>
                      <td><?= '$' . sprintf("%.2f", $invoice["invoice_total_amount"]);?></td>
                    </tr>
                    <tr>
                      <td colspan="2"></td>
                      <td>Total <span id="alternate-total">KYD</span></td>
                      <td>$<span id="alternate_total_value"></span></td>
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

    $(document).ready(function(){
      $("#msg-holder").hide();
        $( "#dob" ).datepicker({ 
          dateFormat: 'yy-mm-dd',
          changeYear: true,
          yearRange: "-50:+0" 
        });
        $('#add-user-frm').validator();  

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
