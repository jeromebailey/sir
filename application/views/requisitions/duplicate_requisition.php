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

            <form id="frm" class="form-horizontal form-label-left" method="post" action="<?=base_url('Requisitions/do_duplicate_requisition')?>" data-toggle="validator" role="form"> 

              <input type="hidden" name="requisition_id" value="<?=$requisition_id?>">

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="requisition-date">Requisition Date<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="requisition-date" id="requisition-date" class="form-control" value="<?=date('M d, Y');?>" style="position: relative; z-index: 100000;">
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
                        foreach ($clients as $key => $value) {
                          if( $value["client_id"] == $requisition["client_id"] ){?>
                            <option value="<?=$value["client_id"]?>" selected><?=$value["client_name"]?></option>
                          <?} else {?>
                            <option value="<?=$value["client_id"]?>"><?=$value["client_name"]?></option>
                          <?}                          
                        }
                      } else {

                      }?>
                    </select>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="flight-type-id">Flight Type<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select id="flight-type-id" name="flight-type-id" class="form-control" required="required">
                    <option value="">Select Flight Type</option>
                    <?
                    if( !empty($flight_types) ){
                      foreach ($flight_types as $key => $value) {
                        if( $value["flight_type_id"] == $requisition["flight_type_id"] ){?>
                            <option value="<?=$value["flight_type_id"]?>" selected><?=$value["flight_type"]?></option>
                          <?} else {?>
                            <option value="<?=$value["flight_type_id"]?>"><?=$value["flight_type"]?></option>
                          <?}                        
                      }
                    } else {

                    }?>                
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="client-flight-id">Client Flights<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select id="client-flight-id" name="client-flight-id" class="form-control" required="required">
                    <option value="">Select Flight</option>
                    <?
                    if( !empty($client_flights) ){
                      foreach ($client_flights as $key => $value) {
                        if( $value["client_flight_id"] == $requisition["client_flight_id"] ){?>
                            <option value="<?=$value["client_flight_id"]?>" selected><?=$value["flight_no"]?></option>
                          <?} else {?>
                            <option value="<?=$value["client_flight_id"]?>"><?=$value["flight_no"]?></option>
                          <?}                        
                      }
                    } else {

                    }?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="passenger-count">No of Passengers<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="number" value="<?=$requisition["passenger_count"];?>" id="passenger-count" name="passenger-count" required = "required" autocomplete="off" class="form-control col-md-7 col-xs-12" placeholder="10">
                </div>
              </div>

              <div class="row">
                <div class="col-md-4 col-md-offset-1">
                  <label class="" for="product-id">Product Name</label>
                  <input type="text" id="product-name" name="product-name" autocomplete="off" class="form-control" placeholder="Carrots">
                </div>

                <div class="col-md-2">
                  <label class="" for="product-amount">Amount</label>
                  <input type="text" id="product-amount" name="product-amount" autocomplete="off" class="form-control" placeholder="4">
                </div>

                <div class="col-md-2">
                    <label class="" for="unit-id">Unit</label>
                    <select id="unit-id" name="unit-id" class="form-control">
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
                <div class="col-md-12">
                  <table class="table table-bordered" id="tblRequestedItems">
                    <thead>
                      <tr>
                        <th width="70%">Product Name</th>
                        <th>Amount</th>
                        <th>Unit</th>
                        <th>Options</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?
                      if( !empty( $requisition["details"] ) ){
                        $counter = 1;
                        $items = json_decode( $requisition["details"] );
                        foreach ($items as $key => $value) {?>
                          <tr id="<?=$counter?>">
                            <td><input type="text" name="requisition-product-name-<?=$counter?>" value = "<?=$value->product_name?>" class = "form-control" readonly /></td>
                            <td><input type="text" name="requisition-amount-<?=$counter?>" value = "<?=$value->amount?>" class = "form-control" readonly /></td>
                            <td><input type="text" name="requisition-unit-<?=$counter?>" value = "<?=$value->unit?>" class = "form-control" readonly /></td>
                            <td>
                              <a href="#" onClick="delete_requisition_item(<?=$counter?>)" title="Delete"><i class="fas fa-trash-alt"></i></a>
                            </td>
                          </tr>
                        <?
                        $counter++;
                        }
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>

              <br />
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="store-keeper-name">Store Keeper</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="store-keeper-name" readonly="readonly" placeholder="John Jackson" name="store-keeper-name" autocomplete="off" class="form-control col-md-7 col-xs-12" value="<?=$this->session->userdata("first_name") . " " .$this->session->userdata("last_name");?>">
                </div>
              </div>

              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <button type="submit" id="btnSendToStores" class="btn btn-lg btn-success">Duplicate Requisition</button>
                </div>
              </div>

              <input type="hidden" name="no_of_items" id="no_of_items" value="" />

            </form>

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

    $(document).ready(function(){
      $("#msg-holder").hide();
        $( "#requisition-date" ).datepicker({ 
          dateFormat: 'yy-mm-dd',
          changeYear: true
        }).datepicker("setDate", new Date());
        //$('#add-user-frm').validator();

        var client_id = $("#client-id").val();

        <?
        if( !empty( $requisition["details"] ) ){
          $no_of_items = count(json_decode( $requisition["details"] ));?>
          $("#no_of_items").val( <?=$no_of_items?> );
          req_item_counter = <?=$no_of_items?> + 1;
        <?}?>

        
    });

    $("#btnSendToStores").click(function(e){
      e.preventDefault();

      var client_id = $("#client-id").val();
      var flight_type_id = $("#flight-type-id").val();
      var flight_no = $("#client-flight-id").val();
      var pax_count = $("#passenger-count").val();
      var msg = "";

      if( client_id == "" ){
        msg += "Please select a Client.<br />";
      }

      if( flight_type_id == "" ){
        msg += "Please select a flight type.<br />";
      }

      if( flight_no == "" ){
        msg += "Please select a flight no.<br />";
      }

      if( pax_count == "" ){
        msg += "Please enter a passenger count. <br />";
      }


      if(table_body_is_empty('tblRequestedItems'))
      {
        msg += 'Requisition cannot be created because no items have been added.<br />';
      } 

      if(msg != "")
      {
        $("#msg-holder").addClass('alert-danger');
        $("#msg-holder").html(msg);
        $("#msg-holder").show();
      } else {
        $("#frm").submit();
      }
    });

    function table_body_is_empty(table_id)
    {
      var tbody = $("#"+table_id + " tbody");

      if (tbody.children().length == 0) {
          return true;
      }
      return false;
    }

    $("#client-id").change(function(){
        var client_id = $(this).val();

        get_client_flights( client_id );        
    });

    function get_client_flights( client_id ){
      $.ajax({
          url: "<?=base_url('WebService/get_client_flights/" + client_id +"');?>",
          type: 'post',
          data: {client_id:client_id},
          dataType: 'json',
          success:function(response){

              var len = response.length;

              $("#client-flight-id").empty();
              $("#client-flight-id").append("<option value=''>Select Flight</option>");
              for( var i = 0; i<len; i++){
                  var id = response[i]['client_flight_id'];
                  var name = response[i]['flight_no'];
                  
                  $("#client-flight-id").append("<option value='"+id+"'>"+name+"</option>");
              }
          }
      });
    }

    $('#edit_item_modal').on('show.bs.modal', function (e) {
        $("#m_product_name").autocomplete({
          source: function (request, response) {
              $.ajax({
                  url: "<?=base_url('WebService/search_products/" + request.term + "')?>",
                  type: "GET",
              dataType: "json",
              data: { searchText: request.term },
              success: function (data) {
                  response($.map(data, function (item) {
                      return {
                          label: item.product_name + ' (' +  item.product_id + ')',
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
    });

    function edit_requisition_item(item_counter){
      $("#edit_item_modal").modal('show');

      var product_name = $("#requisition-product-name-" + item_counter).val();
      var amount = $("#requisition-amount-" + item_counter).val();
      var product_name = $("#requisition-product-name-" + item_counter).val();

      $("#m_product_name").val( product_name );
    }

    $("#product-name").autocomplete({
      source: function (request, response) {
          $.ajax({
              url: "<?=base_url('WebService/search_products/" + request.term + "')?>",
              type: "GET",
          dataType: "json",
          data: { searchText: request.term },
          success: function (data) {
              response($.map(data, function (item) {
                  return {
                      label: item.product_name + ' (' +  item.product_id + ')',
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

    function clearProductFieldInputs(){
      $("#product-name").val('');
      $("#product-amount").val('');
      $("#unit-id").val(6);
    }

    $("#btnAdd").click(function(){
      var product_name = $("#product-name").val();
      var product_r_amount = $("#product-amount").val();
      var unit = $("#unit-id option:selected").text(); //$("#unit-id").val();
      var errors = '';

      if( product_name == '' ){
        errors += 'Product name must be entered. <br/>'
      }

      if( product_r_amount == '' ){
        errors += 'Product amount must be entered. <br/>'
      }

      if( errors != '' ){
        $("#msg-holder").addClass('alert-danger');
        $("#msg-holder").html(errors);
        $("#msg-holder").show();
      } else {
        $("#msg-holder").html('');
        $("#msg-holder").hide();

        addAnotherRowForRequisitionItem(product_name, product_r_amount, unit);
        clearProductFieldInputs();
      }
    });

    function addAnotherRowForRequisitionItem(product_name, amount, unit){
      var row = "";
      row = row + '<tr id=' + req_item_counter + '>';
      row = row + '<td><input type="text" id="requisition-product-name-' + req_item_counter + '" name="requisition-product-name-' + req_item_counter + '" autocomplete="off" value="' + product_name +'" class="form-control" readonly></td>';
      row = row + '<td><input type="text" id="requisition-amount-' + req_item_counter + '" name="requisition-amount-' + req_item_counter + '" required="required" autocomplete="off" value="' + amount +'" class="form-control" readonly></td>';
      row = row + '<td><input type="text" id="requisition-unit-' + req_item_counter + '" name="requisition-unit-' + req_item_counter + '" required="required" autocomplete="off" value="' + unit +'" class="form-control" readonly></td>';
      //row = row + '<td><select name="requisition-unit-id-' + req_item_counter + '" class="form-control" readonly disabled>';
      <?
      /*foreach($uom as $key => $value){?>
        if(<?=$value["unit_id"]?> == unit_id ){
          row = row + '<option value="<?=$value["unit_id"]?>" selected><?=$value["unit_abbreviation"];?></option>';
      } else {
          row = row + '<option value="<?=$value["unit_id"]?>"><?=$value["unit_abbreviation"];?></option>';
        }        
    <?}*/?>
      //row = row + '</select></td>';
      row = row + '<td style="margin-top: 23px;">';
      //row = row + '<a href="#" title="Edit" onClick="edit_requisition_item(' + req_item_counter + ')" ><i class="fas fa-edit"></i></a> |';
      row = row + '<a href="#" onClick="delete_requisition_item(' + req_item_counter + ')" title="Delete"><i class="fas fa-trash-alt"></i></a>';
      row = row + '</td>';      
      row = row + '</tr>';

      $("#tblRequestedItems").append(row);

      req_item_counter++;
      $("#no_of_items").val(req_item_counter);
    }

    function delete_requisition_item( item_counter ){
      console.log( "counter: " + req_item_counter );
      var do_delete_row = confirm("Are you sure you want to delete this item?");

      if( do_delete_row == true ){
        document.getElementById("tblRequestedItems").deleteRow(item_counter);
        //req_item_counter--;
        console.log( "counter: " + req_item_counter );
      }
    }

    </script>
  </body>
</html>