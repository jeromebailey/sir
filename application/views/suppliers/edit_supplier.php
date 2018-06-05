<!DOCTYPE html>
<html lang="en">
  <head>
    <?include_once 'includes/head.inc'; ?>
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

            <ol class="breadcrumb">
              <li><a href="<?=base_url('Suppliers');?>">Suppliers</a></li>
              <li class="active"><?=$page_title;?></li>
            </ol>

            <?include_once 'includes/status_message.inc';?>

            <!-- Tab panes -->
            <h3><?=$page_title;?> <i class="fas fa-box"></i></h3>

              <form id="demo-form2" data-toggle="validator" class="form-horizontal form-label-left" method="post" action="<?=base_url('Suppliers/do_edit_supplier');?>">

                <input type="hidden" name="supplier-id" value="<?=$supplier_id?>" >

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="territory">Territory <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select class="form-control" id="territory" name="territory" required="required">
                    <option value="">Select Territory</option>

                    <?
                    if( $supplier['is_local'] == 1 ){?>
                      <option value="1" selected="selected">Local</option>
                    <?} else {?>
                      <option value="1">Local</option>
                    <?}?>

                    <?
                    if( $supplier['is_local'] == 2 ){?>
                      <option value="2" selected="selected">Overseas</option>
                    <?} else {?>
                      <option value="2">Overseas</option>
                    <?}?>                   
                    
                  </select>
                </div>
              </div>

              <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="supplier-name">Supplier Name <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="supplier-name" name="supplier-name" required="required" autocomplete="off" class="form-control col-md-7 col-xs-12" value="<?=$supplier['supplier_name']?>">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address-line-1">Address Line 1</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="address-line-1" name="address-line-1" autocomplete="off" class="form-control col-md-7 col-xs-12" value="<?=$supplier['address_line_1']?>">                  
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address-line-2">Address Line 2</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="address-line-2" name="address-line-2" autocomplete="off" class="form-control col-md-7 col-xs-12" value="<?=$supplier['address_line_2']?>">                  
                  </div>
                </div>
                
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="city">City</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <!--<div id="editor-one" class="editor-wrapper"></div>-->
                    <input type="text" id="city" name="city" autocomplete="off" class="form-control col-md-7 col-xs-12" value="<?=$supplier['city']?>"><!-- style="display:none;" -->
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="state">State</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <!--<div id="editor-one" class="editor-wrapper"></div>-->
                    <input type="text" id="state" name="state" autocomplete="off" class="form-control col-md-7 col-xs-12" value="<?=$supplier['state']?>"><!-- style="display:none;" -->
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="zip">Zip</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <!--<div id="editor-one" class="editor-wrapper"></div>-->
                    <input type="text" id="zip" name="zip" autocomplete="off" class="form-control col-md-7 col-xs-12" value="<?=$supplier['zip']?>"><!-- style="display:none;" -->
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
        <?include_once 'includes/footer.inc';?>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <?include_once 'includes/scripts.inc';?>
    <script src="<?=base_url('assets/js/bootstrap-wysiwyg.min.js');?>"></script>
    <script src="<?=base_url('assets/js/prettify.js');?>"></script>
    <script src="<?=base_url('assets/js/bootstrapValidator.js');?>"></script>
    <script type="text/javascript"></script>
  
  </body>
</html>
