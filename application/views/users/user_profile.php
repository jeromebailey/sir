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

            <ol class="breadcrumb">
              <li><a href="<?=base_url('Users');?>">Users</a></li>
              <li class="active">Edit User</li>
            </ol>

            <h3><?=$page_title;?> <i class="fas fa-user"></i></h3>

            <div class="row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="is-an-admin">Administrator: </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <?= ($user_details[0]['is_an_admin'] == 1) ? "Yes" : "No" ?>
              </div>
            </div>

            <div class="row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user-id">User ID: </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <?=$user_details[0]['user_id'];?>
              </div>
            </div>
            <div class="row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">First Name: </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <?=$user_details[0]['first_name'];?>
              </div>
            </div>
            <div class="row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Last Name: </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <?=$user_details[0]['last_name'];?>
              </div>
            </div>
            <div class="row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email-address">Email Address:
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <?=$user_details[0]['email_address'];?>
              </div>
            </div>
            <div class="row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Gender:</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <p>
                      <?=( $user_details[0]['gender_id'] == 1 ) ? "Male" : "Female" ?>                     
                </p>
              </div>
            </div>
            <div class="row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email-address">Date of Birth:
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <?=( $user_details[0]['dob'] == null ) ? "N/A" : date("F d, Y", strtotime($user_details[0]['dob'])) ?>                  
              </div>
            </div>

            <div class="row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email-address">Department: </label>
              <div class="col-md-6 col-sm-6 col-xs-12">                
                  <?= ( $user_details[0]["department_name"] == null ) ? "N/A" : $user_details[0]["department_name"]; ?>
              </div>
            </div>

            <div class="row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="job-title-id">Job Title:</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <?= ( $user_details[0]["job_title"] == null ) ? "N/A" : $user_details[0]["job_title"]; ?>
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
    $(document).ready(function(){
        $( "#dob" ).datepicker({ 
          dateFormat: 'yy-mm-dd',
          changeYear: true,
          yearRange: "-50:+0" 
        });
          $('#add-user-frm').validator();
    });

    </script>
  </body>
</html>
