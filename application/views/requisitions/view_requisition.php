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
              <li><a href="<?=base_url('Requisitions');?>">Requisitions</a></li>
              <li class="active">View Requisition</li>
            </ol>

            <div class="row">
              <div class="col-md-2 col-md-offset-9">
                <button class="btn btn-lg btn-danger" name="btnPrint" id="btnPrint"><i class="fa fa-print"></i> Print Requisition</button>
              </div>
            </div>

            <div id="area_to_print">

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
                <div class="col-md-6 col-xs-12 col-sm-12 col-lg-12">
                  <label for="requisition-date" class="text-uppercase"><i>Creation Date</i>:</label>
                  <?=date('d-M-Y', strtotime($requisition["date_created"]));?>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 col-xs-12 col-sm-12 col-lg-12">
                  <label for="requisition-date" class="text-uppercase"><i>Requisition Date</i>:</label>
                  <?=date('d-M-Y', strtotime($requisition["requisition_date"]));?>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <label for="requisition-date" class="text-uppercase"><i>Client Name</i>:</label>
                  <?=$requisition["client_name"];?>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <label for="requisition-date" class="text-uppercase"><i>Flight Type</i>:</label>
                  <?
                  if( $requisition["flight_type_id"] == 0 ){
                    echo "Staff";
                  } else {
                    echo $requisition["flight_type"];
                  }
                  ?>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <label for="requisition-date"><i>Flight No.</i>:</label>
                  <?
                  if( $requisition["client_flight_id"] == 0 ){
                    echo "Staff";
                  } else {
                    echo $requisition["flight_no"];
                  }
                  ?>
                </div>
              </div>

               <div class="row">
                <div class="col-md-6">
                  <label for="requisition-date"><i>Passenger Count</i>:</label>
                  <?=$requisition["passenger_count"];?>
                </div>
              </div>

              <br />

              <div class="row">
                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                  <table class="table table-bordered table-striped table-condensed" id="tblRequestedItems">
                    <thead>
                      <tr>
                        <th width="8%">Product Name</th>
                        <th width="10%">Amount</th>
                        <th width="10%">Unit</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?
                      $items = json_decode( $requisition["details"] );
                      //echo "<pre>";print_r($items);exit;
                      if( !empty($items) )
                      {
                        foreach($items as $key => $value)
                        {
                          //echo "<pre>";print_r($value->qty);exit;?>
                          <tr>
                            <td><?=$value->product_name;?></td>
                            <td width="10%"><?=$value->amount;?></td>
                            <td width="10%"><?=$value->unit;?></td>
                          </tr>
                        <?}
                      }?>
                    </tbody>

                  </table>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                  <label ><i>Created By</i>:</label> <?=$requisition["created_by"];?>                  
                </div>
              </div>

              <?
              if( $requisition["dispatched"] == 1 ){?>
                <div class="row">
                  <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                    <label ><i>Dispatched By</i>:</label> <?=$requisition["dispatched_by"];?>                  
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                    <label ><i>Dispatched On</i>:</label> <?= date("M d, Y", strtotime($requisition["dispatched_date"]));?>                  
                  </div>
                </div>
              <?} else {?>
                <br />
                <div id="dispatch_requisition_section">
                  <form method = "post" id="frmDispatch" action="<?=base_url('Requisitions/dispatch_requisition')?>">
                    <input type="hidden" name = "requisition_id" id="requisition_id" value = "<?=$requisition["requisition_id"];?>"  />
                    <button type="submit" name="btnDispatch" id="btnDispatch" class="btn btn-warning btn-lg">Dispatch Requisition <i class="fas fa-share-square"></i></button>
                  </form>
                </div>
              <?}?>

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
        $( "#dob" ).datepicker({ 
          dateFormat: 'yy-mm-dd',
          changeYear: true,
          yearRange: "-50:+0" 
        });
        $('#add-user-frm').validator();      

    });

    $("#btnPrint").click(function(){
      if($("#dispatch_requisition_section").is(":visible")){
          $("#dispatch_requisition_section").hide();
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
