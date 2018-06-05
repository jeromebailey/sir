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
              <li><a href="<?=base_url('PurchaseOrders');?>">Purchase Orders</a></li>
              <li class="active">View Purchase Order</li>
            </ol>

            <div class="row">
              <div class="col-md-2 col-md-offset-9">
                <button class="btn btn-lg btn-danger" name="btnPrint" id="btnPrint"><i class="fa fa-print"></i> Print Purchase Order</button>
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
              <div class="col-md-10">
                <p class="text-uppercase text-center"><strong><?=$page_title;?></strong></p>
                <?=$company_address;?>
              </div>
            </div>

            <br />

              <div class="row">
                <div class="col-md-4">
                  <label for="supplier-id">Supplier</label><br />
                  <text>
                    <?=$purchase_order["supplier_name"];?> <br />
                    <?=$supplier_address;?>
                  </text>
                </div>

                <div class="col-md-4 col-md-offset-3 pull-right">                  
                    <label for="po-no-id">PO No.:</label> <?=$purchase_order["po_no"];?>
                  
                    <br />
                    <label for="requisition-date">Date:</label>
                    <?=date('M d, Y', strtotime($purchase_order["po_date"]));?>
                      
                </div>
              </div>

              <br />

              <div class="row">
                <div class="col-md-4">
                  <label for="">Bill To:</label>
                    <div class="" ><?=$bill_to_address;?></div>
                </div>
                <div class="col-md-4 col-md-offset-3 pull-right">
                  <label for="">Ship To:</label>
                    <div ><?=$ship_to_address;?></div>
                </div>
              </div>

              <br/>

              <h3>Item / Part Requested</h3>

              <div class="row">
                <div class="col-md-12">
                  <table class="table table-bordered table-striped table-condensed" id="tblRequestedItems">
                    <thead>
                      <tr>
                        <th width="7%">Qty</th>
                        <th width="20%">Part No.</th>
                        <th>Description</th>
                        <th width="10%">Price</th>
                        <th width="10%">Extension</th>
                      </tr>
                    </thead>
                    <tbody>
                      
                      <?
                      $items = json_decode( $purchase_order["po_details"] );
                      //echo "<pre>";print_r($items);exit;
                      if( !empty($items) )
                      {
                        foreach($items as $key => $value)
                        {
                          //echo "<pre>";print_r($value->qty);exit;?>
                          <tr>
                            <td><?=$value->qty;?></td>
                            <td><?=$value->part_no;?></td>
                            <td><?=$value->desc;?></td>
                            <td><?=number_format($value->price, 2, '.', ',');?></td>
                            <td><?=number_format($value->extn, 2, '.', ',');?></td>
                          </tr>
                        <?}
                      }?>
                    </tbody>
                    <tr>
                      <td colspan="3"></td>
                      <td>Total</td>
                      <td><?= '$' . number_format($purchase_order["po_total_amount"], 2, '.', ',');?></td>
                    </tr>
                  </table>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <!--<p style="margin-top: 23px;"><strong>For Shoes order:</strong> Please specify width (Medium or Wide)</p>-->
                  <label >Placed by:</label> <br />
                  <?=$purchase_order["placed_by"];?>
                  
                </div>
                <!--<div class="col-md-4 col-md-offset-2 pull-right">
                  <label >Send to:</label> <br />
                  <?//=$purchase_order["send_copy_to"];?>
                </div>-->
              </div>

              <br />

              <div class="row">
                <div class="col-md-6">
                  <label >Send to:</label> <br />
                  <?if( !empty( $purchase_order["send_copy_to"]) ){
                    echo "<u>". $purchase_order["send_copy_to"] . "</u>";
                  } else {
                    echo "_________________________________";
                  }?>
                </div>

                
                <div class="col-md- col-md-offset-2 pull-right">
                  <label >Approved by:</label> <br />
                  <?if( $purchase_order["approved"] == 1 ){
                    echo "<u>". $purchase_order["approved_by"] . "</u>";
                  } else {
                    echo "_________________________________";
                  }?>
                </div>                
                
              </div> <!-- end of row -->

              <br />

              <?if( $purchase_order["approved"] == 0 ){
                if($this->sir->user_has_permission_to("approve_purchase_order")){?>
                  <div class="row" id="approve_po_section">
                    <div class="col-md-12 ">
                      <form id="add-user-frm" class="form-horizontal form-label-left" method="post" action="<?=base_url('PurchaseOrders/approve_purchase_order')?>" data-toggle="validator" role="form">
                        <input type = "hidden" value = "<?=$purchase_order["purchase_order_id"];?>" name="po_id" id="po_id" />
                        <button type="submit" name = "btnApprove" id = "btnApprove" class="btn btn-success btn-lg">Approve Purchase Order <i class="fas fa-check"></i></button>
                      </form>
                    </div>
                  </div>
                  <?}
              }?>
  
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

    });

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
