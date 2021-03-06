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

            <?include_once 'includes/status_message.inc';?>

            <!-- Tab panes -->
            <h3><?=$page_title;?> <i class="fas fa-box"></i></h3>

              <form id="demo-form2" data-toggle="validator" class="form-horizontal form-label-left" method="post" action="<?=base_url('Clients/do_edit_client');?>">

                <input type="hidden" name="client-id" value="<?=$client_id?>" >

              <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="client-name">Client Name <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="client-name" name="client-name" required="required" autocomplete="off" class="form-control col-md-7 col-xs-12" value="<?=$client['client_name']?>">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="abbreviation">Abbreviation <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="abbreviation" name="abbreviation" required="required" autocomplete="off" class="form-control col-md-7 col-xs-12" value="<?=$client['abbreviation']?>">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address-line-1">Address Line 1</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="address-line-1" name="address-line-1" autocomplete="off" class="form-control col-md-7 col-xs-12" value="<?=$client['address_line_1']?>">                  
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address-line-2">Address Line 2</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="address-line-2" name="address-line-2" autocomplete="off" class="form-control col-md-7 col-xs-12" value="<?=$client['address_line_2']?>">                  
                  </div>
                </div>
                
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="city">City</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <!--<div id="editor-one" class="editor-wrapper"></div>-->
                    <input type="text" id="city" name="city" autocomplete="off" class="form-control col-md-7 col-xs-12" value="<?=$client['city']?>"><!-- style="display:none;" -->
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="state">State</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <!--<div id="editor-one" class="editor-wrapper"></div>-->
                    <input type="text" id="state" name="state" autocomplete="off" class="form-control col-md-7 col-xs-12" value="<?=$client['state']?>"><!-- style="display:none;" -->
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="zip">Zip</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <!--<div id="editor-one" class="editor-wrapper"></div>-->
                    <input type="text" id="zip" name="zip" autocomplete="off" class="form-control col-md-7 col-xs-12" value="<?=$client['zip']?>"><!-- style="display:none;" -->
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
