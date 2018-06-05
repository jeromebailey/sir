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

            <h3><?=$page_title;?> <i class="fas fa-plane"></i></h3>

            <div class="row" >
              <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
                <div class="alert " id="msg-holder"></div>
              </div>
            </div>

            <!--<div class="row">
              <div class="col-md-3">
                <img src="<?=base_url('assets/images/logo-gcg-220-120.jpg');?>" height="120" width="220">
              </div>
            </div>-->

            <br />

            <form id="frm" class="form-horizontal form-label-left" method="post" action="<?=base_url('Forms/do_add_flight_check_sheet')?>" data-toggle="validator" role="form"> 

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="requisition-date">Date &amp; Time: </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                <input type = "text" name="date-and-time" id="date-and-time" autocomplete="off" class="form-control col-md-7 col-xs-12" style="position: relative; z-index: 100000;" />
                </div>
              </div>             

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="client-id">Clients: </label>
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
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="requisition-date">Flight No: <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="input-group">
                    <span class="input-group-addon" id="flight-no-client-abbreviation"></span>
                    <input type="text" class="form-control" autocomplete="off" placeholder="102" name="flight-no" id="flight-no" aria-describedby="basic-addon1">
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="requisition-date">Check Sheet No: <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="input-group">
                    <span class="input-group-addon" id="sheet-no-client-abbreviation"></span>
                    <input type="text" class="form-control" readonly="readonly" placeholder="15232" name="check-sheet-no" id="check-sheet-no" aria-describedby="basic-addon1">
                  </div>
                </div>                
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cycle">Cycle: </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select id="cycle" name="cycle" class="form-control" required="required">
                    <option value="">Select Cycle</option>
                    <?for($a = 1; $a <= 4; $a++) {?>
                        <option value="<?=$a;?>"><?=$a;?></option>
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

              <div class="row">
                <div class="col-md-12">
                  <table class="table table-bordered" id="tblRequestedItems">
                    <thead>
                      <tr>
                        <th>Description</th>
                        <th width="10%">Qty</th>
                        <th width="7%">Options</th>
                      </tr>
                    </thead>
                    <tbody id="bcm">
                      <tr>
                        <td><strong>BREAKFAST: CREW MEALS</strong></td>
                        <td id="bcm_total"></td>
                        <td></td>
                      </tr>
                    </tbody>

                    <tbody id="bfcm">
                      <tr>
                        <td><strong>BREAKFAST: FIRST CLASS MEALS</strong></td>
                        <td></td>
                        <td></td>
                      </tr>
                    </tbody>

                    <tbody id="becon">
                      <tr>
                        <td><strong>BREAKFAST: ECONOMY</strong></td>
                        <td></td>
                        <td></td>
                      </tr>
                    </tbody>

                    <tbody id="lcm">
                      <tr>
                        <td><strong>LUNCH: CREW MEALS</strong></td>
                        <td></td>
                        <td></td>
                      </tr>
                    </tbody>

                    <tbody id="lfcm">
                      <tr>
                        <td><strong>LUNCH: FIRST CLASS MEALS</strong></td>
                        <td></td>
                        <td></td>
                      </tr>
                    </tbody>

                    <tbody id="lecon">
                      <tr>
                        <td><strong>LUNCH: ECONOMY</strong></td>
                        <td></td>
                        <td></td>
                      </tr>
                    </tbody>

                    <tbody id="dcm">
                      <tr>
                        <td><strong>DINNER: CREW MEALS</strong></td>
                        <td></td>
                        <td></td>
                      </tr>
                    </tbody>

                    <tbody id="dfcm">
                      <tr>
                        <td><strong>DINNER: FIRST CLASS MEALS</strong></td>
                        <td></td>
                        <td></td>
                      </tr>
                    </tbody>

                    <tbody id="decon">
                      <tr>
                        <td><strong>DINNER: ECONOMY</strong></td>
                        <td></td>
                        <td></td>
                      </tr>
                    </tbody>

                    <tbody id="spml">
                      <tr>
                        <td><strong>DINNER: SPML</strong></td>
                        <td></td>
                        <td></td>
                      </tr>
                    </tbody>

                    <tbody id="miscellaneous">
                      <tr>
                        <td><strong>MISCELLANEOUS</strong></td>
                        <td></td>
                        <td></td>
                      </tr>
                    </tbody>

                    <tbody id="service-charge">
                      <tr>
                        <td><strong>SERVICE CHARGE</strong></td>
                        <td></td>
                        <td></td>
                      </tr>
                    </tbody>

                    <tbody id="service-charge-ext">
                      <tr>
                        <td><i>Seal No</i></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td><i>Temperature</i></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td><i>Time Approached Aircraft</i></td>
                        <td></td>
                        <td></td>
                      </tr>
                    </tbody>
                    
                  </table>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                  <label ><i>Crew Comment</i>:</label> <br />
                  <input type="text" name="crew_comment" id="crew_comment" class="form-control" />
                </div>
              </div>

              <div class="row">
                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                  <label ><i>Crew Signature</i>:</label> <br />
                  <input type="text" name="crew_signature" id="crew_signature" class="form-control" />
                </div>
              </div>

              <div class="row">
                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                  <label ><i>Delivery Personnel Comment</i>:</label> <br />
                  <input type="text" name="delivery_personnel_comment" id="delivery_personnel_comment" class="form-control" />
                </div>
              </div>

              <div class="row">
                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                  <label ><i>Supervisor's Signature</i>:</label> <br />
                  <input type="text" name="supervisors_signature" id="supervisors_signature" class="form-control" />
                </div>
              </div>    

              <div class="row">
                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                  <label ><i>Deliver Personel Signature</i>:</label> <br />
                  <input type="text" name="delivery_personnel_signature" id="delivery_personnel_signature" class="form-control" />
                </div>
              </div>

              <br />

              <div class="row">
                <div class="col-md-4">
                  <button type="submit" class="btn btn-lg btn-success" id="btnCreate" style="margin-top: 23px;">Create Flight Check Sheet</button>
                </div>                
              </div>

              <input type="hidden" name="total_items_added" id="total_items_added">

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
      var bcm = bfcm = lcm = lfcm = dcm = dfcm = mis = sc = be = le = de = spml = total_items_added = 1;

    $(document).ready(function(){
      $("#msg-holder").hide();

      $("#bcm").hide();
      $("#bfcm").hide();
      $("#becon").hide();
      $("#lecon").hide();
      $("#decon").hide();
      $("#lcm").hide();
      $("#lfcm").hide();
      $("#dcm").hide();
      $("#dfcm").hide();
      $("#spml").hide();

        $( "#date-and-time" ).datepicker({ 
          dateFormat: 'yy-mm-dd',
          changeYear: true
        }).datepicker("setDate", new Date());
        $('#frm').validator();      

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

        $.get( "<?=base_url('WebService/get_next_client_flight_check_no/" + client_id + "' );?>")
        .done(function( data ) {
          //console.log( JSON.parse( data ) );
          $("#check-sheet-no").val(JSON.parse( data ));
        });
      }
    });

    function clearProductFieldInputs(){
      $("#qty").val('');
      $("#section-id").val('');
      $("#desc").val('');
    }

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

    function addAnotherRowForRequisitionItem(qty, section_id, desc){

      var temp_counter = 0;

      switch(parseInt(section_id)) {
          case 1:
              temp_counter = bcm;
              break;
          case 2:
              temp_counter = bfcm;
              break;
          case 3:
              temp_counter = lcm;
              break;
          case 4:
              temp_counter = lfcm;
              break;
          case 5:
              temp_counter = dcm;
              break;
          case 6:
              temp_counter = dfcm;
              break;
          case 7:
              temp_counter = mis;
              break;
          case 8:
              temp_counter = sc;
              break;
          case 9:
              temp_counter = be;
              break;
          case 10:
              temp_counter = le;
              break;
          case 11:
              temp_counter = de;
              break; 
          case 12:
              temp_counter = spml;
              break;
          
      }

      console.log( "section: " + section_id );
      console.log( "counter: " + temp_counter );

      var row = "";
      row = row + '<tr id =' + temp_counter + '>';
      row = row + '<td><input type="text" id="" name="'+ section_id +'-desc-' + temp_counter + '" autocomplete="off" value="' + desc +'" class="form-control" readonly></td>';
      row = row + '<td width="10%"><input type="text" id="" name="'+ section_id +'-qty-' + temp_counter + '" autocomplete="off" value="' + qty +'" class="form-control" readonly></td>';      
      row = row + '<td width="7%" style="margin-top: 23px;">';
      //row = row + '<a href="" title="Edit"><i class="fas fa-edit"></i></a> |';
      row = row + '<a href="#" onClick="delete_fcs_item(' + section_id + ', ' + temp_counter + ')" title="Delete"><i class="fas fa-trash-alt"></i></a>';
      row = row + '</td>';      
      row = row + '</tr>';

      switch(parseInt(section_id)) {
          case 1:
              if(!$("#bcm").is(":visible")){
                $("#bcm").show();
              }
              $("#tblRequestedItems #bcm").append(row);
              bcm++;
              break;
          case 2:
              if(!$("#bfcm").is(":visible")){
                $("#bfcm").show();
              }
              $("#tblRequestedItems #bfcm").append(row);
              bfcm++;
              break;
          case 3:
              if(!$("#lcm").is(":visible")){
                $("#lcm").show();
              }
              $("#tblRequestedItems #lcm").append(row);
              lcm++;
              break;
          case 4:
              if(!$("#lfcm").is(":visible")){
                $("#lfcm").show();
              }
              $("#tblRequestedItems #lfcm").append(row);
              lfcm++;
              break;
          case 5:
              if(!$("#dcm").is(":visible")){
                $("#dcm").show();
              }
              $("#tblRequestedItems #dcm").append(row);
              dcm++;
              break;
          case 6:
              if(!$("#dfcm").is(":visible")){
                $("#dfcm").show();
              }
              $("#tblRequestedItems #dfcm").append(row);
              dfcm++;
              break;
          case 7:
              $("#tblRequestedItems #miscellaneous").append(row);
              mis++;
              break;
          case 8:
              $("#tblRequestedItems #service-charge").append(row);
              sc++;
              break;
          case 9:
              if(!$("#becon").is(":visible")){
                $("#becon").show();
              }
              $("#tblRequestedItems #becon").append(row);
              be++;
              break;
          case 10:
              if(!$("#lecon").is(":visible")){
                $("#lecon").show();
              }
              $("#tblRequestedItems #lecon").append(row);
              le++;
              break;
          case 11:
             if(!$("#decon").is(":visible")){
                $("#decon").show();
              }
              $("#tblRequestedItems #decon").append(row);
              de++;
              break;
          case 12:
              if(!$("#spml").is(":visible")){
                $("#spml").show();
              }
              $("#tblRequestedItems #spml").append(row);
              spml++;
              break;

      }
      $("#total_items_added").val(total_items_added);
      total_items_added++;

    }    

    $("#btnCreate").click(function(e){
      e.preventDefault();

      if(bcm == bfcm == lcm == lfcm == dcm == dfcm == mis == sc == total_items_added == 1){
        $("#msg-holder").addClass('alert-danger');
        $("#msg-holder").html("Sorry, the Flight Check Sheet cannot be submitted without any items being added. Please add at least one item.");
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
              document.getElementById("bcm").deleteRow(counter);
              //$("#tblRequestedItems #bcm").deleteRow(counter);
              bcm--;
              break;
          case 2:
              document.getElementById("bfcm").deleteRow(counter);
              bfcm--;
              break;
          case 3:
              document.getElementById("lcm").deleteRow(counter);
              lcm--;
              break;
          case 4:
              document.getElementById("lfcm").deleteRow(counter);
              lfcm--;
              break;
          case 5:
              document.getElementById("dcm").deleteRow(counter);
              dcm--;
              break;
          case 6:
              document.getElementById("dfcm").deleteRow(counter);
              dfcm--;
              break;
          case 7:
              document.getElementById("mis").deleteRow(counter);
              mis--;
              break;
          case 8:
              document.getElementById("sc").deleteRow(counter);
              sc--;
              break;
          case 9:
              document.getElementById("becon").deleteRow(counter);
              be--;
              break;
          case 10:
              document.getElementById("lecon").deleteRow(counter);
              le--;
              break;
          case 11:
              document.getElementById("decon").deleteRow(counter);
              de--;
              break;
          case 12:
              document.getElementById("spml").deleteRow(counter);
              spml--;
              break;
        }
        
      }
    }

    </script>
  </body>
</html>
