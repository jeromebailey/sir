<!DOCTYPE html>
<html lang="en">
  <head>
    <?include_once 'includes/head.inc' ?>
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

            <form id="add-user-frm" class="form-horizontal form-label-left" method="post" action="<?=base_url('Requisitions/do_create_requisition')?>" data-toggle="validator" role="form">

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="requisition-date">Requisition Date<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="requisition-date" id="requisition-date" class="form-control" readonly="readonly" value="<?=date('M d, Y');?>">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="client-id">Client Name<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
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
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="client-id">Flight Type<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select id="flight-type-id" name="flight-type-id" class="form-control" required="required">
                    <option value="">Select Flight Type</option>
                    <option value="first_class">First Class</option>
                    <option value="coach">Coach</option>                    
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="client-id">Client Flights<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select id="client-flight-id" name="client-flight-id" class="form-control" required="required">
                    <option value="">Select Flight</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">No of Passengers<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="passenger-count" name="passenger-count" required autocomplete="off" class="form-control col-md-7 col-xs-12" placeholder="10">
                </div>
              </div>
              <div class="row">
                <div class="col-md-4 col-md-offset-1">
                  <label class="" for="product-id">Product Name</label>
                  <input type="text" id="product-name" name="product-name" required="required" autocomplete="off" class="form-control" placeholder="Carrots">
                </div>

                <div class="col-md-2">
                  <label class="" for="product-id">Amount</label>
                  <input type="text" id="" name="amount" required="required" autocomplete="off" class="form-control" placeholder="4">
                </div>

                <div class="col-md-2">
                    <label class="" for="product-id">Unit</label>
                    <select id="client-id" name="client-id" class="form-control" required="required">
                      <?if( !empty($uom) ){
                          foreach ($uom as $key => $value) {?>
                            <option value="<?=$value["unit_id"]?>"><?=$value["unit_abbreviation"];?></option>
                          <?}
                        } else {

                        }?>
                    </select>
                </div>

                <div class="col-md-2">
                  <input type="button" name="btnAdd" id="btnAdd" value="Add another item" class="btn btn-success" style="margin-top: 23px;">
                </div>

              </div>

              <div id="more_items"></div>

              <br />

              <h3>Items Requested</h3>

              <div class="row">
                <div class="col-md-8 col-md-offset-2">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>Product Name</th>
                        <th>Amount</th>
                        <th>Unit</th>
                        <th>Options</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>
              </div>

              <br />
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email-address">Store Keeper</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="email-address" readonly="readonly" placeholder="johnjackson@gmail.com" name="email-address" autocomplete="off" class="form-control col-md-7 col-xs-12" value="<?=$this->session->userdata("first_name") . " " .$this->session->userdata("last_name");?>">
                </div>
              </div>
              
              
              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <button type="submit" class="btn btn-lg btn-success">Submit</button>
                </div>
              </div>

            </form>


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

    $(document).ready(function(){
        $( "#dob" ).datepicker({ 
          dateFormat: 'yy-mm-dd',
          changeYear: true,
          yearRange: "-50:+0" 
        });
        $('#add-user-frm').validator();
    });

    $("#btnAdd").click(function(){
      var product_name = $("#product-name").val();
      var amount = $("#amount").val();
      

      addAnotherRowForRequisitionItem();
    });

    function addAnotherRowForRequisitionItem(){
      var row = "";
      row = row + '<tr><td>';
      row = row + '<input type="text" id="" name="product-name-"' + req_item_counter + '" autocomplete="off" value="" class="form-control" readonly>';
      row = row + '<div class="col-md-2"><input type="text" id="" name="amount-"' + req_item_counter + '" required="required" autocomplete="off" class="form-control"></div>';
      
      row = row + '</tr>';

      $("#more_items").append(row);

      req_item_counter++;
    }

    $("#product-name").autocomplete({
      source: function (request, response) {
          $.ajax({
              url: "<?=base_url('WebService/get_json_product_list')?>",
              type: "POST",
          dataType: "json",
          data: { searchText: request.term },
          success: function (data) {
              response($.map(data, function (item) {
                  return {
                      label: item.product_name,
                      value: item.product_name + ' (' +  item.product_id + ')'
                  };
              }))
          }
          })
      },
      messages: {
          noResults: "No results found",
          results: function (count) {
              return count + (count > 1 ? ' results' : ' result') + 'found';
          }
      }
    });

    

    </script>
  </body>
</html>
