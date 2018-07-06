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
    <link rel="stylesheet" href="<?=base_url('assets/css/jquery-ui.min.css');?>">
    <meta http-equiv="X-UA-Compatible" content="IE=7" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <div class="container-fluid">

    <h3><?=$page_title;?> <i class="fas fa-box"></i></h3>  

    <h4>By Bar Code</h4>
    <form id="demo-form2" method="post" data-toggle="validator" class="form-horizontal form-label-left" action="<?=base_url('ProductScanner/do_search');?>">
      <div class="row" >
        <div class="col-md-10 col-sm-10 col-xs-12">
          <label for="bar-code">Product Bar Code <span class="required">*</span>
          <input type="text" name="s-bar-code" id="s-bar-code" class="form-control" autocomplete="off" />
        </div>
      </div>
    </form>


    <h4>By Product Name</h4>
    <form id="demo-form2" method="post" data-toggle="validator" class="form-horizontal form-label-left" action="<?=base_url('ProductScanner/do_search_by_product_name');?>">
      <div class="row" >
        <div class="col-md-10 col-sm-10 col-xs-12">
          <label for="bar-code">Product Name <span class="required">*</span>
          <input type="text" name="s-product-name" id="s-product-name" class="form-control" autocomplete="off" />
        </div>
      </div>

      <div class="row" >
        <div class="col-md-10 col-sm-10 col-xs-12">
          <input type="submit" name="btnProductNameSearch" id="btnProductNameSearch" class="btn btn-success" value="Find Product" />
        </div>
      </div>  

    </form>

      <br />
    <div class="row">
      <div class="col-xs-12">
        <button onclick="EB.Application.quit();" class="btn btn-danger">Quit</button>
      </div>
    </div>

    </div>

    <!-- jQuery -->
    <?include_once 'includes/scripts.inc';?>
    <script src="<?=base_url('assets/js/bootstrap-wysiwyg.min.js');?>"></script>
    <script src="<?=base_url('assets/js/jquery-ui.min.js');?>"></script>
    <script src="<?=base_url('assets/js/ebapi-modules.js');?>"></script>
    <script src="<?=base_url('assets/js/jquery-ui.min.js');?>"></script>
    <script type="text/javascript">
      setTimeout(function() { document.getElementById('s-bar-code').focus(); }, 10);

      $("#s-product-name").autocomplete({
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
            }));              
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
