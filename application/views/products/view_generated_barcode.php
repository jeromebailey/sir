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
              <li><a href="<?=base_url('Products/list_generated_barcodes');?>">Product Barcodes</a></li>
              <li class="active">View Product Barcode</li>
            </ol>

            <div class="row">
              <div class="col-md-2 col-md-offset-9">
                <button class="btn btn-lg btn-danger" name="btnPrint" id="btnPrint"><i class="fa fa-print"></i> Print Product Barcode</button>
              </div>
            </div>

            <a href="#" class="btn btn-primary" id="btnt" download="barcode.pub">test print</a>

            <div id="area_to_print" class="border border-danger">

              <div class="row">
                <div class="col-md-12">
                  <p class="text-uppercase text-center" style="font-size: 11px">Product Name: <?=$products_and_barcode["product_name"];?> <br />                  
                Category Name: <?=$products_and_barcode["category_name"];?></p>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12 text-center">
                    <img src="<?=$uploaded_barcode_path?>/<?=$products_and_barcode['barcode']?>.png" width="160" height = "38" style = "margin-top: -12px"> 
                </div>
              </div>

              <br />

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

     //uriContent = "data:application/octet-stream," + encodeURIComponent(printContents);
     //newWindow = window.open(uriContent, 'neuesDokument');

     window.print();

     document.body.innerHTML = originalContents;
    });

    $("#btnt").click( function(){
      var printContents = document.getElementById('area_to_print').innerHTML;
     var originalContents = document.body.innerHTML;

     //document.body.innerHTML = printContents;

     uriContent = "data:application/x-mspublisher," + encodeURIComponent(printContents);
     //newWindow = window.open(uriContent, 'neuesDokument');
    } );


    </script>
    

  </body>
</html>
