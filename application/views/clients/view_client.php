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
              <li><a href="<?=base_url('Clients');?>">Clients</a></li>
              <li class="active"><?=$page_title;?></li>
            </ol>

            <!-- Tab panes -->
            <h3><?=$page_title;?> <i class="fas fa-box"></i></h3>

              <div class="row">                  
                <div class="col-md-8 col-sm-12 col-xs-12 col-md-8">
                  <label class="" for="client-name">Client Name: </label> <?=$client["client_name"];?>
                </div>
              </div>

              <div class="row">                  
                <div class="col-md-8 col-sm-12 col-xs-12 col-md-8">
                  <label class="" for="client-name">Abbreviation: </label> <?=$client["abbreviation"];?>
                </div>
              </div>

              <div class="row">                  
                <div class="col-md-8 col-sm-12 col-xs-12 col-md-8">
                  <label class="" for="client-name">Address Line 1: </label> <?=$client["address_line_1"];?>
                </div>
              </div>

              <div class="row">                  
                <div class="col-md-8 col-sm-12 col-xs-12 col-md-8">
                  <label class="" for="client-name">Address Line 2: </label> <?=$client["address_line_2"];?>
                </div>
              </div>

              <div class="row">                  
                <div class="col-md-8 col-sm-12 col-xs-12 col-md-8">
                  <label class="" for="client-name">City: </label> <?=$client["city"];?>
                </div>
              </div>

              <div class="row">                  
                <div class="col-md-8 col-sm-12 col-xs-12 col-md-8">
                  <label class="" for="client-name">State: </label> <?=$client["state"];?>
                </div>
              </div>

              <div class="row">                  
                <div class="col-md-8 col-sm-12 col-xs-12 col-md-8">
                  <label class="" for="client-name">Zip: </label> <?=$client["zip"];?>
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
    <script src="<?=base_url('assets/js/bootstrap-wysiwyg.min.js');?>"></script>
    <script src="<?=base_url('assets/js/prettify.js');?>"></script>
    <script src="<?=base_url('assets/js/bootstrapValidator.js');?>"></script>
  
  </body>
</html>
