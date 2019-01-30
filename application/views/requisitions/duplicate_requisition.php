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
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="creation-date">Creation Date</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="creation-date" id="creation-date" class="form-control" readonly="readonly" value="<?=date('M d, Y');?>">
                </div>
              </div>  

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="requisition-date">Requisition Date<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="requisition-date" id="requisition-date" class="form-control" value="<?=date('M d, Y');?>" >
                </div>
              </div>             

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="client-id">Client Name<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select id="client-id" name="client-id" class="form-control" required="required">
                      <option value="">Select Client</option>
                      <?
                      if( $requisition["client_id"] > 0 && $requisition["client_id"] < 8000 ){
                        if( !empty($clients) ){
                          foreach ($clients as $key => $value) {
                            if( $value["client_id"] == $requisition["client_id"] ){?>
                              <option value="<?=$value["client_id"]?>" selected><?=$value["client_name"]?></option>
                            <?} else {?>
                              <option value="<?=$value["client_id"]?>"><?=$value["client_name"]?></option>
                            <?}                          
                          }?>
                          <option value="sanitation">Sanitation</option>
                          <option value="other">Other</option>
                        <?} else {

                        }
                      } else {
                        foreach ($clients as $key => $value) {?>                            
                              <option value="<?=$value["client_id"]?>"><?=$value["client_name"]?></option>
                          <?}
                          if( $requisition["client_id"] == 8000 ){?>
                            <option value="sanitation" selected="selected">Sanitation</option>
                            <option value="other">Other</option>
                          <?} else {?>
                            <option value="sanitation">Sanitation</option>
                            <option value="other">Other</option>
                          <?}

                          if( $requisition["client_id"] == 9000 ){?>
                            <option value="sanitation" >Sanitation</option>
                            <option value="other" selected="selected">Other</option>
                          <?} else {?>
                            <option value="sanitation">Sanitation</option>
                            <option value="other">Other</option>
                          <?}                          
                      }?>
                    </select>
                </div>
              </div>

              <?if( $requisition["client_id"] == 9000 ){ //other client name was entered ?>
                <div class="form-group" id="other-client-div" style="display: block">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="client-id">Other Client Name<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" name="other-client" id="other-client" class="form-control" value="<?=$requisition['other_client_name']?>" autocomplete="off">
                    </div>
                  </div>
              <?} else {?>
                <div class="form-group" id="other-client-div" style="display: none" >
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="client-id">Other Client Name<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="other-client" id="other-client" class="form-control" autocomplete="off">
                  </div>
                </div>
              <?}?>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="flight-type-id">Flight Type<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select id="flight-type-id" name="flight-type-id" class="form-control" required="required">
                    <option value="">Select Flight Type</option>
                    <?
                    if( $requisition["flight_type_id"] > 0 && $requisition["client_id"] < 8000 ){
                      foreach ($flight_types as $key => $value) {
                          if( $value["flight_type_id"] == $requisition["flight_type_id"] ){?>
                              <option value="<?=$value["flight_type_id"]?>" selected><?=$value["flight_type"]?></option>
                            <?} else {?>
                              <option value="<?=$value["flight_type_id"]?>"><?=$value["flight_type"]?></option>
                            <?}                        
                        }?>
                        <option value="0" >Staff</option>
                        <option value="sanitation" >Sanitation</option>
                        <option value="other" >other</option>
                    <?} else {
                      if( !empty($flight_types) ){
                        foreach ($flight_types as $key => $value) {?>
                            <option value="<?=$value["flight_type_id"]?>"><?=$value["flight_type"]?></option>
                        <?}

                        switch ($requisition["flight_type_id"]) {
                          case 0:?>
                            <option value="0" selected="selected">Staff</option>
                            <option value="sanitation" >Sanitation</option>
                            <option value="other">Other</option>
                            <?break;

                          case 8000:?>
                            <option value="0" >Staff</option>
                            <option value="sanitation" selected="selected">Sanitation</option>
                            <option value="other">Other</option>
                            <?break;

                          case 9000:?>
                            <option value="0" >Staff</option>
                            <option value="sanitation" >Sanitation</option>
                            <option value="other" selected="selected">Other</option>
                            <?break;
                          
                          default:
                            # code...
                            break;
                        }
                      } else {

                      }
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
                    if( $requisition["client_flight_id"] > 0 && $requisition["client_flight_id"] < 8000 ){
                      foreach ($client_flights as $key => $value) {
                        if( $value["client_flight_id"] == $requisition["client_flight_id"] ){?>
                            <option value="<?=$value["client_flight_id"]?>" selected><?=$value["flight_no"]?></option>
                          <?} else {?>
                            <option value="<?=$value["client_flight_id"]?>"><?=$value["flight_no"]?></option>
                          <?}                        
                        }?>
                        <option value="0" >Staff</option>
                        <option value="sanitation" >Sanitation</option>
                        <option value="other" >other</option>
                    <?} else {
                      if( !empty($client_flights) ){
                        
                        foreach ($client_flights as $key => $value) {?>
                            <option value="<?=$value["client_flight_id"]?>"><?=$value["flight_no"]?></option>
                        <?}

                        switch ($requisition["client_flight_id"]) {
                          case 0:?>
                            <option value="0" selected="selected">Staff</option>
                            <option value="sanitation" >Sanitation</option>
                            <option value="other">Other</option>
                            <?break;

                          case 8000: echo "here";?>
                            <option value="0" >Staff</option>
                            <option value="sanitation" selected="selected">Sanitation</option>
                            <option value="other">Other</option>
                            <?break;

                          case 9000:?>
                            <option value="0" >Staff</option>
                            <option value="sanitation" >Sanitation</option>
                            <option value="other" selected="selected">Other</option>
                            <?break;
                          
                          default:
                            # code...
                            break;
                        }
                      } else {
                        switch ($requisition["client_flight_id"]) {
                          case 0:?>
                            <option value="0" selected="selected">Staff</option>
                            <option value="sanitation" >Sanitation</option>
                            <option value="other">Other</option>
                            <?break;

                          case 8000: echo "here";?>
                            <option value="0" >Staff</option>
                            <option value="sanitation" selected="selected">Sanitation</option>
                            <option value="other">Other</option>
                            <?break;

                          case 9000:?>
                            <option value="0" >Staff</option>
                            <option value="sanitation" >Sanitation</option>
                            <option value="other" selected="selected">Other</option>
                            <?break;
                          
                          default:
                            # code...
                            break;
                        }
                      }
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
                  <label class="" for="product-price">Price</label>
                  <input type="text" id="product-price" name="product-price" autocomplete="off" class="form-control" placeholder="2.50" >
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
                        <th>Product Name</th>
                        <th width="8%">Price</th>
                        <th width="8%">Amount</th>
                        <th width="8%">Unit</th>
                        <th width="10%">Options</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?
                      if( !empty( $requisition["details"] ) ){
                        $counter = 1;
                        $items = json_decode( $requisition["details"] );
                        foreach ($items as $key => $value) {
                          $product_id = (!isset($value->product_id)) ? 0 : $value->product_id;
                          $product_name_id = ($product_id == 0) ? stripslashes($value->product_name) : stripslashes($value->product_name) .' ('.$product_id.')';
                          $price = ( !isset($value->price) ) ? 0 : $value->price;?>
                          <tr id="<?=$counter?>">
                            <td><input type="text" name="requisition-product-name-<?=$counter?>" id="requisition-product-name-<?=$counter?>" value = "<?=$product_name_id?>" class = "form-control" readonly /></td>
                            <td><input type="text" name="requisition-price-<?=$counter?>" id = "requisition-price-<?=$counter?>" value = "<?=$price?>" class = "form-control" readonly /></td>
                            <td><input type="text" name="requisition-amount-<?=$counter?>" id="requisition-amount-<?=$counter?>" value = "<?=$value->amount?>" class = "form-control" readonly /></td>
                            <td><input type="text" name="requisition-unit-<?=$counter?>" id="requisition-unit-<?=$counter?>" value = "<?=$value->unit?>" class = "form-control" readonly /></td>
                            
                            <td>
                              <a href="#" onClick="edit_requisition_item(<?=$counter?>)" title="Edit"><i class="fas fa-edit"></i></a>
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
                            <label>Product Name</label>
                            <input type="text" name="m_product_name" id="m_product_name" class="form-control" style="z-index: 10000">
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-12">
                            <label>Price</label>
                            <input type="text" name="m_product_price" id="m_product_price" class="form-control">
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-12">
                            <label>Amount</label>
                            <input type="text" name="m_item_amount" id="m_item_amount" class="form-control">
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-12">
                            <label>Unit</label>
                            <select id="m_product_unit" name="m_product_unit" class="form-control">
                              <?if( !empty($uom) ){
                                  foreach ($uom as $key => $value) {?>
                                    <option value="<?=$value["unit_id"]?>"><?=$value["unit_abbreviation"];?></option>
                                  <?}
                                } else {

                                }?>
                            </select>
                          </div>
                        </div>

                        <input type="hidden" value="" name="m_item_key" id="m_item_key">
                          
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

        if( client_id == 6 ){
          $("#other-client-div").hide();
          prep_fields_for_staff_requisition();
        } else if( client_id == "other" ){
          $("#other-client-div").show();
          prep_fields_for_other_requisition();
        } else if( client_id == "sanitation" ){
          $("#other-client-div").hide();
          prep_fields_for_sanitation_requisition();
        } else {
          $("#other-client-div").hide();
          $("#flight-type-id").val( "" );
          get_client_flights(client_id);
        }        
    });

    function prep_fields_for_staff_requisition(){
      $("#flight-type-id").append("<option value='STAFF'>Staff</option>");
      $("#client-flight-id").append("<option value='STAFF'>Staff</option>");

      $("#flight-type-id").val( "STAFF" );
      $("#client-flight-id").val( "STAFF" );
    }

    function prep_fields_for_other_requisition(){
      $("#flight-type-id").append("<option value='OTHER'>OTHER</option>");
      $("#client-flight-id").append("<option value='OTHER'>OTHER</option>");

      $("#flight-type-id").val( "OTHER" );
      $("#client-flight-id").val( "OTHER" );
    }

    function prep_fields_for_sanitation_requisition(){
      $("#flight-type-id").append("<option value='SANITATION'>SANITATION</option>");
      $("#client-flight-id").append("<option value='SANITATION'>SANITATION</option>");

      $("#flight-type-id").val( "SANITATION" );
      $("#client-flight-id").val( "SANITATION" );
    }

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
      console.log( item_counter );

      var product_name = $("#requisition-product-name-" + item_counter).val();
      var price = $("#requisition-price-" + item_counter).val();
      var amount = $("#requisition-amount-" + item_counter).val();
      var unit = $("#requisition-unit-" + item_counter).val();
      //var product_name = $("#requisition-product-name-" + item_counter).val();

      $("#m_product_name").val( product_name );
      $("#m_product_price").val( price );
      $("#m_item_amount").val( amount );
      $("select#m_product_unit option")
        .each(function() { this.selected = (this.text == unit); });

      $("#m_item_key").val( item_counter );
    }

    $("#btnMEditItem").click(function(){      

      var product_name = $("#m_product_name").val();
      var price = $("#m_product_price").val();
      var amount = $("#m_item_amount").val();
      var item_counter = $("#m_item_key").val();
      var unit = $("#m_product_unit option:selected").text();

      $("#requisition-product-name-" + item_counter).val(product_name);
      $("#requisition-price-" + item_counter).val(price);
      $("#requisition-amount-" + item_counter).val(amount);
      $("#requisition-unit-" + item_counter).val(unit);

      $("#edit_item_modal").modal('hide');
    });

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
      select: function(event, ui){
        //var obj = $.parseJSON(ui);
        var index_of_open_bracket = ui.item.value.lastIndexOf("(");
        var index_of_closing_bracket = ui.item.value.lastIndexOf(")");

          //console.log(index_of_open_bracket);
          //console.log(index_of_closing_bracket);

          if( index_of_open_bracket != -1 && index_of_closing_bracket != -1 ){
            var product_id = ui.item.value.substring(index_of_open_bracket+1, index_of_closing_bracket);
            //console.log( "id: " + product_id );
            $.post( "<?=base_url('WebService/find_product_by_product_id/" + product_id + "');?>")
            .done(function( data ) {
                //var a = $.parseJSON(data);
                //console.log(data['unit_id']); //works
                //var b = JSON.parse(data);
                //console.log(b[0].product_id); works
                //console.log( "data: " + data );

                if( data == '[]' ){
                  //do nothing. no unit id is present
                } else {
                    var obj = $.parseJSON(data);
                    if( parseFloat(obj[0].current_stock_level) <= parseFloat(obj[0].minimum_stock_level) ){
                      $("#msg-holder").addClass('alert-danger');
                      $("#msg-holder").html("Sorry, item is below stock level and cannot be added.");
                      $("#msg-holder").show();
                      $("#btnAdd").attr("disabled", "disabled");
                    } else {
                      //console.log( obj[0].unit_id );
                      $("#unit-id").val( obj[0].unit_id );
                      $("#product-price").val( obj[0].price );
                      $("#unit-id").prop('disabled', 'disabled');
                    }                    
                }              
            });
          } /*end of if statement*/
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
      $("#product-price").val('');
    }

    $("#btnAdd").click(function(){
      var product_name = $("#product-name").val();
      var product_r_amount = $("#product-amount").val();
      var product_r_price = $("#product-price").val();
      var unit = $("#unit-id option:selected").text(); //$("#unit-id").val();
      var errors = '';

      if( product_name == '' ){
        errors += 'Product name must be entered. <br/>'
      }

      if( product_r_price == '' ){
        errors += 'Product price must be entered. <br/>'
      }

      if( product_r_amount == '' ){
        errors += 'Product amount must be entered. <br/>'
      }

      if( errors != '' ){
        $("#msg-holder").addClass('alert-danger');
        $("#msg-holder").html(errors);
        $("#msg-holder").show();
      } else {
        if( product_name_exists_in_inventory( product_name ) ){
          $("#msg-holder").html('');
          $("#msg-holder").hide();

          addAnotherRowForRequisitionItem(product_name, product_r_price, product_r_amount, unit);
          clearProductFieldInputs();
        } else {
          $("#msg-holder").addClass('alert-danger');
          $("#msg-holder").html("Product cannot be added because it does not exist in the inventory.");
          $("#msg-holder").show();
        }
      }
    });

    function product_name_exists_in_inventory( product_name ){
      if( product_name != null && product_name != "" ){
        if( product_name.indexOf("(") > -1 && product_name.indexOf(")") > -1 ) //check if the product name has the product id
          return true;
        else
          return false;
      }
    }

    function addAnotherRowForRequisitionItem(product_name, price, amount, unit){
      var row = "";
      row = row + '<tr id=' + req_item_counter + '>';
      row = row + '<td><input type="text" id="requisition-product-name-' + req_item_counter + '" name="requisition-product-name-' + req_item_counter + '" autocomplete="off" value="' + product_name +'" class="form-control" readonly></td>';
      row = row + '<td><input type="text" id="requisition-price-' + req_item_counter + '" name="requisition-price-' + req_item_counter + '" required="required" autocomplete="off" value="' + price +'" class="form-control" readonly></td>';
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
      row = row + '<a href="#" title="Edit" onClick="edit_requisition_item(' + req_item_counter + ')" ><i class="fas fa-edit"></i></a> |';
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