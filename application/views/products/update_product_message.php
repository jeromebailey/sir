<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?=base_url('assets/bootstrap-3.3.7/dist/css/bootstrap.min.css');?>" rel="stylesheet">
    <!--<link rel="stylesheet" href="<?=base_url('assets/css/jquery-ui.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/css/bootstrapValidator.css');?>">-->
    <meta http-equiv="X-UA-Compatible" content="IE=7" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <div class="container-fluid">

    <?include_once 'includes/status_message.inc';?> 

    <div class="form-group">
      <div class="col-md-6 col-sm-6 col-xs-8">
        <button type="button" class="btn btn-primary" onclick="window.location.href = '../ProductScanner/search'">Find another Product</button>
      </div>
    </div>

    </div>

    <!-- jQuery -->
    <?include_once 'includes/scripts.inc';?>
    <script src="<?=base_url('assets/js/bootstrap-wysiwyg.min.js');?>"></script>
    <script src="<?=base_url('assets/js/jquery-ui.min.js');?>"></script>
    <script type="text/javascript">
      setTimeout(function() { document.getElementById('s-bar-code').focus(); }, 10);
    </script>
  </body>
</html>
