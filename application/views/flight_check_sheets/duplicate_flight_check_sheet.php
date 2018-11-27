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

            <h3><?=$page_title;?> <i class="fas fa-plane"></i></h3>

            <ol class="breadcrumb">
              <li><a href="<?=base_url('FlightCheckSheets');?>">Flight Check Sheets</a></li>
              <li class="active">Edit Flight Check Sheet</li>
            </ol>

              <br />

              <div class="row" >
                <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
                  <div class="alert " id="msg-holder"></div>
                </div>
              </div>

              <form id="frm" class="form-horizontal form-label-left" method="post" action="<?=base_url('FlightCheckSheets/do_create_flight_check_sheet_from_duplicate')?>" data-toggle="validator" role="form"> 

                <input type="hidden" name="flight_check_sheet_id" value="<?=$flight_check_sheet_id?>" />

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="requisition-date">Date &amp; Time: </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type = "text" name="date-and-time" id="date-and-time" autocomplete="off" class="form-control col-md-7 col-xs-12" style="position: relative; z-index: 100;" />
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="client-id">Clients: </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="client-id" name="client-id" class="form-control" required="required">
                      <option value="">Select Client</option>
                      <?
                      if( !empty($clients) ){
                        foreach ($clients as $key => $value) {
                          if( $value["client_id"] == $flight_check_sheet["client_id"] ){?>
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
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="requisition-date">Flight No: <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="input-group">
                      <span class="input-group-addon" id="flight-no-client-abbreviation"><?=$client_abbreviation?></span>
                      <input type="text" class="form-control" placeholder="102" value="<?=$flight_check_sheet["flight_no"]?>" name="flight-no" id="flight-no" aria-describedby="basic-addon1" autocomplete = "off" >
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tail-no">Tail No: </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" class="form-control" autocomplete="off" placeholder="7T-WHM" name="tail-no" id="tail-no" value="<?=$flight_check_sheet["tail_no"]?>" >
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="requisition-date">Check Sheet No: <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="input-group">
                      <span class="input-group-addon" id="sheet-no-client-abbreviation"><?=$client_abbreviation?></span>
                      <input type="text" class="form-control" value="<?=$flight_check_sheet["check_sheet_no"]?>" readonly="readonly" placeholder="15232" name="check-sheet-no" id="check-sheet-no" aria-describedby="basic-addon1">
                    </div>
                  </div>                
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cycle">Cycle: </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="cycle" name="cycle" class="form-control" required="required">
                      <option value="">Select Cycle</option>
                      <?for($a = 1; $a <= 5; $a++) {
                        if( $a == $flight_check_sheet["cycle"] ){?>
                          <option value="<?=$a;?>" selected><?=$a;?></option>
                        <?} else {?>
                          <option value="<?=$a;?>"><?=$a;?></option>
                        <?} ?>
                          
                      <?}?>
                    </select>
                  </div>
                </div>

                <br />

                <div class="row">
                  <div class="col-md-3">
                      <label class="" for="unit-id">Section</label>
                      <select id="section-id" name="section-id" class="form-control" >
                        <option value="">Select Section</option>
                        <?
                        if( !empty($headings) ){
                          foreach ($headings as $key => $value) {?>
                            <option value="<?=$value["heading_id"]?>"><?=$value["heading"]?></option>
                          <?}
                        } else {

                        }?>
                    </select>
                  </div>

                  <div class="col-md-6">
                    <label class="" for="product-id">Description</label>
                    <input type="text" id="desc" name="desc" autocomplete="off" class="form-control" placeholder="Lemon Slices">
                  </div>

                  <div class="col-md-1">
                      <label class="" for="unit-id">Qty</label>
                      <input type="number" id="qty" name="qty" autocomplete="off" class="form-control" placeholder="1">
                  </div>              

                  <div class="col-md-2">
                    <input type="button" name="btnAdd" id="btnAdd" value="Add item" class="btn btn-success" style="margin-top: 23px;">
                  </div>
                </div>

                <br />

                <div class="row">
                  <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                    <table class="table table-bordered table-striped table-condensed" id="tblRequestedItems">
                      <thead>
                        <tr>
                          <th>Description</th>
                          <th width="10%">Qty</th>
                          <th width="7%">Options</th>
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
                              <td></td>
                            </tr>
                          <?foreach($items as $key => $value)
                          {
                            //echo "<pre>";print_r($value->qty);exit;?>
                            <tr id = "<?=$_counter?>">
                              <td width=""> <input type="text" readonly="readonly" name="<?=$section_id?>-desc-<?=$_counter?>" id="<?=$section_id?>-desc-<?=$_counter?>" value="<?=$value->description;?>" class="form-control" /> </td>
                              <td width="10%"><input type="text" readonly="readonly" name="<?=$section_id?>-qty-<?=$_counter?>" id="<?=$section_id?>-qty-<?=$_counter?>" value="<?=$value->qty;?>" class="form-control" /></td>
                              <td> <a href="#" onClick="edit_fcs_item(<?=$section_id?>, <?=$_counter?>)" title="Edit"><i class="fas fa-edit"></i></a> 
                                <a href="#" onClick="delete_fcs_item(<?=$section_id?>, <?=$_counter?>)" title="Delete"><i class="fas fa-trash-alt"></i></a> </td>
                            </tr>
                          <?
                          $_counter++;}?>
                          </tbody>
                        <?} else {?>
                          <tbody id="<?=$tbody_id?>">
                            <tr>
                              <td><strong><?=$value["heading"]?></strong></td>
                              <td></td>
                              <td></td>
                            </tr>
                          </tbody>
                        <?}
                      }?>

                    </table>
                  </div>
                </div>

                <br />

              <div class="row">
                <div class="col-md-4">
                  <button type="submit" class="btn btn-lg btn-primary" id="btnEdit" style="margin-top: 23px;">Duplicate Flight Check Sheet <i class="fas fa-copy"></i></button>
                </div>                
              </div>
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
                      <div class="col-md-12">
                        <label>Amount</label>
                        <input type="text" name="m_item_amount" id="m_item_amount" class="form-control">
                      </div>
                    </div>

                    <input type="hidden" value="" name="m_section_key" id="m_section_key">
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
        <?include_once 'includes/footer.inc'?>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <?include_once 'includes/scripts.inc';?>
    <script src="<?=base_url('assets/js/bootstrapValidator.js');?>"></script>
    <script src="<?=base_url('assets/js/jquery-ui.min.js');?>"></script>

    <script type="text/javascript">
      //var bcm = bfcm = lcm = lfcm = dcm = dfcm = mis = sc = be = le = de = total_items_added = 1;
      var total_items_added = 0;
      var headings_enum = {};

    $(document).ready(function(){
      $("#msg-holder").hide();

      $( "#date-and-time" ).datepicker({ 
          dateFormat: 'yy-mm-dd',
          changeYear: true
        }).datepicker("setDate", new Date());

      var client_id = $("#client-id").val();

      get_next_client_flight_check_sheet_no(client_id);

      <?
      foreach ($headings as $key => $value) {
        $tbody_id = str_replace(":", "", str_replace(" ", "-", strtolower($value["heading"])));
        $column_name = str_replace(":", "", str_replace(" ", "_", strtolower($value["heading"])));
        $items = json_decode( $flight_check_sheet[$column_name] );

        if( empty($items) || $items == "" ){?>
          headings_enum.<?=$column_name?> = 1;
        <?} else {?>
          headings_enum.<?=$column_name?> = <?= count( $items ) >= 1 ? count( $items ) + 1 : 1?>;
        <?}?>

        //i added 1 so that the temp counter can be accurate
        //without the addition, if a new row is added, it will have the same counter id as the amount of items

        <?if( !empty($items) )
        {?>
          $("#<?=$tbody_id?>").show();
          total_items_added += <?=count( $items )?>;
        <?} else {?>
          $("#<?=$tbody_id?>").hide();
        <?}
      }?>  

        $('#add-user-frm').validator();
    });

    $("#client-id").change(function(){
      var client_id = $("#client-id").val();

      if( client_id != '' ){
        $.get( "<?=base_url('WebService/get_client_abbreviation_by_id/" + client_id + "' );?>")
        .done(function( data ) {
          //console.log( JSON.parse( data ) );
          $("#flight-no-client-abbreviation").html(JSON.parse( data ));
          $("#sheet-no-client-abbreviation").html(JSON.parse( data ));
        });

        get_next_client_flight_check_sheet_no(client_id);
      }
    });

    function get_next_client_flight_check_sheet_no(client_id){
      $.get( "<?=base_url('WebService/get_next_client_flight_check_no/" + client_id + "' );?>")
        .done(function( data ) {
          //console.log( JSON.parse( data ) );
          $("#check-sheet-no").val(JSON.parse( data ));
        });
    }

    function clearProductFieldInputs(){
      $("#qty").val('');
      $("#section-id").val('');
      $("#desc").val('');
    }

    $("#btnMEditItem").click(function(){      

      var description = $("#m_item_description").val();
      var amount = $("#m_item_amount").val();
      var section_id = $("#m_section_key").val();
      var item_counter = $("#m_item_key").val();

      $('#'+section_id +'-desc-' + item_counter).val(description);
      $('#'+section_id +'-qty-' + item_counter).val(amount);

      $("#edit_item_modal").modal('hide');
    })

    $("#btnAdd").click(function(){
      var section_id = $("#section-id").val();
      var qty = $("#qty").val();
      var desc = $("#desc").val();
      var errors = '';

      if( section_id == '' ){
        errors += 'Section/Header is required. <br/>'
      }

      if( desc == '' ){
        errors += 'Description is required. <br/>'
      }

      if( qty == '' ){
        errors += 'Quantity is required. <br/>'
      }

      if( errors != '' ){
        $("#msg-holder").addClass('alert-danger');
        $("#msg-holder").html(errors);
        $("#msg-holder").show();

      } else {

        $("#msg-holder").html('');
        $("#msg-holder").hide();

        addAnotherRowForRequisitionItem(qty, section_id, desc);
        clearProductFieldInputs();
      }
    });

    function edit_fcs_item(section_id, item_counter){
      $("#edit_item_modal").modal('show');
      console.log( "seciton: " + section_id + " -- counter: " + item_counter );

      var description = $('#'+section_id +'-desc-' + item_counter).val();
      var amount = $('#'+section_id +'-qty-' + item_counter).val();

      $("#m_item_description").val( description );
      $("#m_item_amount").val( amount );
      $("#m_section_key").val( section_id );
      $("#m_item_key").val( item_counter );
    }

    function addAnotherRowForRequisitionItem(qty, section_id, desc){

      var temp_counter = 0;

      switch(parseInt(section_id)) {
          case 1:
              temp_counter = headings_enum.breakfast_crew_meals;
              break;
          case 2:
              temp_counter = headings_enum.breakfast_first_class_meals;
              break;
          case 3:
              temp_counter = headings_enum.lunch_crew_meals;
              break;
          case 4:
              temp_counter = headings_enum.lunch_first_class_meals;
              break;
          case 5:
              temp_counter = headings_enum.dinner_crew_meals;
              break;
          case 6:
              temp_counter = headings_enum.dinner_first_class_meals;
              break;
          case 7:
              temp_counter = headings_enum.miscellaneous;
              break;
          case 8:
              temp_counter = headings_enum.service_charge;
              break;

          case 9:
              temp_counter = headings_enum.breakfast_economy;
              break;

          case 10:
              temp_counter = headings_enum.lunch_economy;
              break;

          case 11:
              temp_counter = headings_enum.dinner_economy;
              break;
          
      }

      console.log( "section: " + section_id );
      console.log( "counter: " + temp_counter );

      var row = "";
      row = row + '<tr id =' + temp_counter + '>';
      row = row + '<td><input type="text" id="'+ section_id +'-desc-' + temp_counter + '" name="'+ section_id +'-desc-' + temp_counter + '" autocomplete="off" value="' + desc +'" class="form-control" readonly></td>';
      row = row + '<td width="10%"><input type="text" id="'+ section_id +'-qty-' + temp_counter + '" name="'+ section_id +'-qty-' + temp_counter + '" autocomplete="off" value="' + qty +'" class="form-control" readonly></td>';      
      row = row + '<td width="7%" style="margin-top: 23px;">';
      row = row + '<a href="#" title="Edit" onClick="edit_fcs_item(' + section_id + ',' + temp_counter +')"><i class="fas fa-edit"></i></a> |';
      row = row + '<a href="#" onClick="delete_fcs_item(' + section_id + ', ' + temp_counter + ')" title="Delete"><i class="fas fa-trash-alt"></i></a>';
      row = row + '</td>';      
      row = row + '</tr>';

      switch(parseInt(section_id)) {
          case 1:
              if(!$("#breakfast-crew-meals").is(":visible")){
                $("#breakfast-crew-meals").show();
              }
              $("#tblRequestedItems #breakfast-crew-meals").append(row);
              headings_enum.breakfast_crew_meals++;
              break;
          case 2:
              if(!$("#breakfast-first-class-meals").is(":visible")){
                $("#breakfast-first-class-meals").show();
              }
              $("#tblRequestedItems #breakfast-first-class-meals").append(row);
              headings_enum.breakfast_first_class_meals++;
              break;
          case 3:
              if(!$("#lunch-crew-meals").is(":visible")){
                $("#lunch-crew-meals").show();
              }
              $("#tblRequestedItems #lunch-crew-meals").append(row);
              headings_enum.lunch_crew_meals++;
              break;
          case 4:
              if(!$("#lunch-first-class-meals").is(":visible")){
                $("#lunch-first-class-meals").show();
              }
              $("#tblRequestedItems #lunch-first-class-meals").append(row);
              headings_enum.lunch_first_class_meals++;
              break;
          case 5:
              if(!$("#dinner-crew-meals").is(":visible")){
                $("#dinner-crew-meals").show();
              }
              $("#tblRequestedItems #dinner-crew-meals").append(row);
              headings_enum.dinner_crew_meals++;
              break;
          case 6:
              if(!$("#dinner-first-class-meals").is(":visible")){
                $("#dinner-first-class-meals").show();
              }
              $("#tblRequestedItems #dinner-first-class-meals").append(row);
              headings_enum.dinner_first_class_meals++;
              break;
          case 7:
              $("#tblRequestedItems #miscellaneous").append(row);
              headings_enum.miscellaneous++;
              break;
          case 8:
              $("#tblRequestedItems #service-charge").append(row);
              headings_enum.service_charge++;
              break;

            case 9:
              if(!$("#breakfast-economy").is(":visible")){
                $("#breakfast-economy").show();
              }
              $("#tblRequestedItems #breakfast-economy").append(row);
              headings_enum.breakfast_economy++;
              break;

            case 10:
              if(!$("#lunch-economy").is(":visible")){
                $("#lunch-economy").show();
              }
              $("#tblRequestedItems #lunch-economy").append(row);
              headings_enum.lunch_economy++;
              break;

            case 11:
              if(!$("#dinner-economy").is(":visible")){
                $("#dinner-economy").show();
              }
              $("#tblRequestedItems #dinner-economy").append(row);
              headings_enum.dinner_economy++;
              break;
      }
      $("#total_items_added").val(total_items_added);
      total_items_added++;

    }    

    $("#btnEdit").click(function(e){
      e.preventDefault();

      var client_id = $("#client-id").val();
      var flight_no = $("#flight-no").val();
      var cycle = $("#cycle").val();
      var msg = "";
      var empty_items_table = false;
      var no_of_items = Object.keys(headings_enum).length;
      var no_of_items_empty = 0;

      if( client_id = "" ){
        msg += "Please select a client <br />";
      }

      if( flight_no = "" ){
        msg += "Please enter a Flight No. <br />";
      }

      if( cycle = "" ){
        msg += "Please select a cycle <br />";
      }



      Object.keys(headings_enum).forEach(function(key){
        console.log( key, headings_enum[key] );

        if( headings_enum[key] <= 1 ){
          //empty_items_table = true;
          no_of_items_empty++;
        } 
      });

      //console.log( empty_items_table );

      if( no_of_items_empty == no_of_items ){
        msg += "Sorry, the Flight Check Sheet cannot be submitted without any items being added. Please add at least one item.";
      }

      if( msg != "" ){
        $("#msg-holder").addClass('alert-danger');
        $("#msg-holder").html(msg);
        $("#msg-holder").show();
      } else {
        $("#frm").submit();
      }

    });

    function delete_fcs_item( section_id, counter ){
      
      var do_delete_row = confirm("Are you sure you want to delete this item?");

      if( do_delete_row == true ){

        switch(parseInt(section_id)) {
          case 1:
              document.getElementById("breakfast-crew-meals").deleteRow(counter);
              //$("#breakfast-crew-meals").removeChild(counter);
              headings_enum.breakfast_crew_meals--;

              console.log( headings_enum.breakfast_crew_meals );
              break;
          case 2:
              document.getElementById("breakfast-first-class-meals").deleteRow(counter);
              headings_enum.breakfast_first_class_meals--;
              break;
          case 3:
              document.getElementById("lunch-crew-meals").deleteRow(counter);
              headings_enum.lunch_crew_meals--;
              break;
          case 4:
              document.getElementById("lunch-first-class-meals").deleteRow(counter);
              headings_enum.lunch_first_class_meals--;
              break;
          case 5:
              document.getElementById("dinner-crew-meals").deleteRow(counter);
              headings_enum.dinner_crew_meals--;
              break;
          case 6:
              document.getElementById("dinner-first-class-meals").deleteRow(counter);
              headings_enum.dinner_first_class_meals--;
              break;
          case 7:
              document.getElementById("miscellaneous").deleteRow(counter);
              headings_enum.miscellaneous--;
              break;
          case 8:
              document.getElementById("service-charge").deleteRow(counter);
              headings_enum.service_charge--;
              break;

          case 9:
              document.getElementById("breakfast-economy").deleteRow(counter);
              headings_enum.breakfast_economy--;
              break;

          case 10:
              document.getElementById("lunch-economy").deleteRow(counter);
              headings_enum.lunch_economy--;
              break;

          case 11:
              document.getElementById("dinner-economy").deleteRow(counter);
              headings_enum.dinner_economy--;
              break;
        }        
      }
    }

    </script>

  </body>
</html>
