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

            <h3><?=$page_title;?> <i class="fas fa-receipt"></i></h3>

            <div class="row" >
              <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
                <div class="alert " id="msg-holder"></div>
              </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                  <img src="<?=base_url('assets/images/logo-gcg-220-120.jpg');?>" height="50" width="100">
                </div>
                <div class="col-md-10">
                  <p class="text-uppercase text-center" style="margin-top: -40px;font-size: 22px;"><strong>QUOTE</strong></p>
                </div>
              </div>
              <br />

            <form id="add-user-frm" class="form-horizontal form-label-left" method="post" action="<?=base_url('Forms/do_add_quote')?>" data-toggle="validator" role="form">

              <div class="row">
                <div class="col-md-6">
                  <label for="supplier-id"><?=$company_name;?></label><br />
                  <?=$company_address;?>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="control-label col-md-4 col-sm-12 col-xs-12" for="po-no-id">Quote No.:</label>
                        <div class="col-md-8 col-sm-12 col-xs-12" style="margin-top: 7px;">
                          <?=$next_quote_no;?>
                          <input type="hidden" name="quote_no" id="quote_no" value="<?=$next_quote_no;?>">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="control-label col-md-4 col-sm-12 col-xs-12" for="requisition-date">Date:</label>
                        <div class="col-md-8 col-sm-12 col-xs-12" style="margin-top: 7px;"><?=date('d-M-Y');?></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <br />

              <div class="row">
                <div class="col-md-4">
                  <label for="">Bill To:</label>
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
              </div> <!-- end of row -->

              <br/>

              <div class="row">
                <div class="col-md-1">
                    <label class="" for="unit-id">Qty</label>
                    <input type="number" id="qty" name="qty" autocomplete="off" class="form-control" placeholder="1">
                </div>

                <div class="col-md-7">
                  <label class="" for="product-id">Description</label>
                  <input type="text" id="desc" name="desc" autocomplete="off" class="form-control" placeholder="Size 12 Nike Caps">
                </div>

                <div class="col-md-1">
                  <label class="" for="product-amount">Price</label>
                  <input type="number" id="price" name="price" autocomplete="off" class="form-control" placeholder="100">
                </div>

                <div class="col-md-1">
                  <label class="" for="product-amount">Extn</label>
                  <input type="text" id="extn" name="extn" autocomplete="off" class="form-control" placeholder="400" readonly="readonly">
                </div>                

                <div class="col-md-2">
                  <input type="button" name="btnAdd" id="btnAdd" value="Add item" class="btn btn-success" style="margin-top: 23px;">
                </div>
              </div>

              <h3>Item / Part Requested</h3>

              <div class="row">
                <div class="col-md-12">
                  <table class="table table-bordered" id="tblRequestedItems">
                    <thead>
                      <tr>
                        <th width="7%">Qty</th>
                        <th>Description</th>
                        <th width="10%">Price</th>
                        <th width="10%">Extension</th>
                        <th width="7%">Options</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                    <tr>
                      <td colspan="2"></td>
                      <td>Total</td>
                      <td><input type="text" name="total_cost" id="total_cost" class="form-control" readonly="readonly" /></td>
                      <td></td>
                    </tr>
                  </table>
                </div>
              </div>

              <br />

              <div class="row">
                <div class="dol-md-4">
                  <button type="submit" class="btn btn-lg btn-success" style="margin-top: 23px;">Create Quote</button>
                </div>                
              </div>

              <input type="hidden" name="no_of_items" id="no_of_items">

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
      var po_total_cost = 0;

    $(document).ready(function(){
      $("#msg-holder").hide();
        $('#add-user-frm').validator();      

    });

    $("#supplier-id").change(function(){
      var supplier_id = $("#supplier-id").val();

      if( supplier_id != '' ){
        $.get( "<?=base_url('Suppliers/get_supplier_address_by_id/" + supplier_id + "' );?>")
        .done(function( data ) {
          console.log( data  );
          $("#supplier-address").html(data);
        });
      }
    });

    $("#territory").change(function(){
        var territory_id = $(this).val();
        $("#supplier-address").html('');

        $.ajax({
            url: "<?=base_url('WebService/get_suppliers_by_territory_id/" + territory_id +"');?>",
            type: 'post',
            dataType: 'json',
            success:function(response){
                var len = response.length;
                $("#supplier-id").empty();
                $("#supplier-id").append("<option value=''>Select Supplier</option>");
                for( var i = 0; i<len; i++){
                    var id = response[i]['supplier_id'];
                    var name = response[i]['supplier_name'];
                    
                    $("#supplier-id").append("<option value='"+id+"'>"+name+"</option>");

                }
            }
        });
    });

    $("#price").keyup(function(){
      var qty = $("#qty").val();
      var price = $("#price").val();

      $("#extn").val(qty * price);

    });

    $("#qty").keyup(function(){
      var qty = $("#qty").val();
      var price = $("#price").val();

      if( price != null ){
        $("#extn").val(qty * price);
      }

    });

    function clearProductFieldInputs(){
      $("#qty").val('');
      $("#desc").val('');
      $("#price").val('');
      $("#extn").val('');
    }

    $("#btnAdd").click(function(){
      var qty = $("#qty").val();
      var desc = $("#desc").val();
      var price = $("#price").val();
      var extn = $("#extn").val();
      var errors = '';

      if( qty == '' ){
        errors += 'Quantity is required. <br/>'
      }

      if( desc == '' ){
        errors += 'Description is required. <br/>'
      }

      if( price == '' ){
        errors += 'Price is required. <br/>'
      }

      if( errors != '' ){
        $("#msg-holder").addClass('alert-danger');
        $("#msg-holder").html(errors);
        $("#msg-holder").show();

      } else {

        $("#msg-holder").html('');
        $("#msg-holder").hide();

        addAnotherRowForRequisitionItem(qty, desc, price, extn);
        clearProductFieldInputs();
      }
    });

    function addAnotherRowForRequisitionItem(qty, desc, price, extn){
      var row = "";
      row = row + '<tr id=' + req_item_counter + '>';
      row = row + '<td><input type="text" id="" name="qty-' + req_item_counter + '" autocomplete="off" value="' + qty +'" class="form-control" readonly></td>';
      row = row + '<td><input type="text" id="" name="desc-' + req_item_counter + '" required="required" autocomplete="off" value="' + desc +'" class="form-control" readonly></td>';
      row = row + '<td><input type="text" id="price-' + req_item_counter + '" name="price-' + req_item_counter + '" required="required" autocomplete="off" value="' + price +'" class="form-control" readonly></td>';
      row = row + '<td><input type="text" id="extn-' + req_item_counter + '" name="extn-' + req_item_counter + '" required="required" autocomplete="off" value="' + extn +'" class="form-control" readonly></td>';
      
      row = row + '<td style="margin-top: 23px;">';
      //row = row + '<a href="" title="Edit"><i class="fas fa-edit"></i></a> |';
      row = row + '<a href="#" onClick="delete_po_item(' + req_item_counter + ')" title="Delete"><i class="fas fa-trash-alt"></i></a>';
      row = row + '</td>';      
      row = row + '</tr>';

      $("#tblRequestedItems").append(row);

      po_total_cost += parseFloat(extn);
      console.log(po_total_cost);
      $("#total_cost").val(po_total_cost);

      req_item_counter++;

      $("#no_of_items").val(req_item_counter);
    }  

    function delete_po_item( item_counter ){
      console.log( "counter: " + req_item_counter );
      var do_delete_row = confirm("Are you sure you want to delete this item?");

      if( do_delete_row == true ){
        //get price of item to be deleted
        var extn = parseFloat( $("#extn-" + item_counter).val());
        console.log( extn );
        po_total_cost = po_total_cost - extn;
        console.log( po_total_cost );

        $("#total_cost").val(po_total_cost);

        document.getElementById("tblRequestedItems").deleteRow(item_counter);
        req_item_counter--;
        console.log( "counter: " + req_item_counter );
      }
    }  

    </script>
  </body>
</html>
