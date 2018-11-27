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
              <li><a href="<?=base_url('FlightCheckSheets');?>">Flight Check Sheets</a></li>
              <li class="active">View Flight Check Sheet</li>
            </ol>

            <div class="row">
              <div class="col-md-2 col-md-offset-9">
                <button class="btn btn-lg btn-danger" name="btnPrint" id="btnPrint"><i class="fa fa-print"></i> Print Flight Check Sheet</button>
              </div>
            </div>

            <div id="area_to_print">

              <div class="row">
                <div class="col-md-2">
                  <img src="<?=base_url('assets/images/logo-gcg-220-120.jpg');?>" height="50" width="100">
                </div>
                <div class="col-md-10">
                  <p class="text-uppercase text-center"><strong><?=$page_title;?></strong></p>
                  <p class="text-uppercase text-center"><strong>Services Delivered to: <?= $client_name;?></strong></p>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 text-center">
                  <?=$company_address;?>
                </div>
              </div>

              <!--<h3 class="text-uppercase"><center></center></i></h3>-->

              <!--<h4 class="text-uppercase"><center></center></i></h4>       -->     

              <br />
              <div class="row">
                <div class="col-md-6 col-xs-12 col-sm-12 col-lg-12">
                  <label for="requisition-date" class="text-uppercase"><i>Date &amp; Time</i>:</label>
                  <?=date('d-M-Y', strtotime($flight_check_sheet["date_time"]));?>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <label for="requisition-date" class="text-uppercase"><i>Flight No</i>:</label>
                  <?= $client_abbreviation . $flight_check_sheet["flight_no"];?>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <label for="requisition-date" class="text-uppercase"><i>Tail No</i>:</label>
                  <?
                  if( $flight_check_sheet["tail_no"] == "" || empty( trim( $flight_check_sheet["tail_no"] ) ) ){
                    echo "N/A";
                  } else {
                    echo $flight_check_sheet["tail_no"];  
                  }?>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <label for="requisition-date" class="text-uppercase"><i>Check Sheet No.</i>:</label>
                  <?=$client_abbreviation . $flight_check_sheet["check_sheet_no"];?>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <label for="requisition-date"><i>CYCLE</i>:</label>
                  <?=$flight_check_sheet["cycle"];?>
                </div>
              </div>

              <br />

              <div class="row">
                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                  <table class="table table-bordered table-striped table-condensed" id="tblRequestedItems">
                    <thead>
                      <tr>
                        <th width="85%">Description</th>
                        <th width="10%">Qty</th>
                      </tr>
                    </thead>
                      <?
                      foreach ($headings as $key => $value) {
                        $column_name = str_replace(":", "", str_replace(" ", "_", strtolower($value["heading"])));
                        $tbody_id = str_replace("_", "-", $column_name);
                        $section_id = $value["heading_id"];

                        $items = json_decode( $flight_check_sheet[$column_name] );
                        //echo "<pre>";print_r($items);exit;
                        if( !empty($items) )
                        {
                          $_counter = 1;?>
                        <tbody id="<?=$tbody_id?>">
                            <tr>
                              <td><strong><?=$value["heading"]?></strong></td>
                              <td></td>
                            </tr>
                          <?foreach($items as $key2 => $value2)
                          {
                            //echo "<pre>";print_r($value->qty);exit;?>
                            <tr id = "<?=$_counter?>">
                              <td width="85%"><?=$value2->description;?></td>
                              <td width="10%"><?=$value2->qty;?></td>
                            </tr>
                          <?
                          $_counter++;}?>
                          </tbody>
                        <?} else {?>
                          <tbody id="<?=$tbody_id?>">
                            <tr>
                              <td><strong><?=$value["heading"]?></strong></td>
                              <td></td>
                            </tr>
                          </tbody>
                        <?}
                      }?>

                    <tbody id="service-charge-ext">
                      <tr>
                        <td><i>Seal No</i></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td><i>Temperature</i></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td><i>Time Approached Aircraft</i></td>
                        <td></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                  <label ><i>Crew Comment</i>:</label> ______________________________________________________________________________
                </div>
                
              </div>

              <div class="row">
                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                  <label ><i>Crew Signature</i>:</label> ______________________________________________________________________________
                </div>
              </div>

              <div class="row">
                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                  <label ><i>Delivery Personnel Comment</i>:</label> __________________________________________________________________
                </div>
              </div>

              <div class="row">
                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                  <label ><i>Supervisor's Signature</i>:</label> _______________________________________________________________________
                </div>
              </div>    

              <div class="row">
                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                  <label ><i>Deliver Personel Signature</i>:</label> ____________________________________________________________________
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

        <?
      foreach ($headings as $key => $value) {
        $tbody_id = str_replace(":", "", str_replace(" ", "-", strtolower($value["heading"])));
        $column_name = str_replace(":", "", str_replace(" ", "_", strtolower($value["heading"])));
        $items = json_decode( $flight_check_sheet[$column_name] );?>

        //i added 1 so that the temp counter can be accurate
        //without the addition, if a new row is added, it will have the same counter id as the amount of items

        //headings_enum.<?=$column_name?> = <?= count( $items ) > 1 ? count( $items ) + 1 : 1?>; 
                        
        <?if( !empty($items) )
        {?>
          $("#<?=$tbody_id?>").show();
          //total_items_added += <?=count( $items )?>;
        <?} else {?>
          $("#<?=$tbody_id?>").hide();
        <?}
      }?> 

    });

    $("#btnPrint").click(function(){
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
