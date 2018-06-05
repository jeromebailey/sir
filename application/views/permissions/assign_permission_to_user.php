<!DOCTYPE html>
<html lang="en">
  <head>
    <?include_once 'includes/head.inc'; ?>
    <?include_once 'includes/data-table-css.inc'; ?>
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

            <div class="alert" id="msg-holder"></div>
            <h3><?=$page_title;?></h3>

            <form method="post" id="frm" action="<?=base_url('Permissions/do_assign_permission_to_user');?>">

              <div class="row">
                <div class="col-md-4">
                  <label>Users</label>
                  <select id="user-id" name="user-id" required="required" class="form-control" onchange="set_url(this.value)" >
                    <option value="">Select User</option>
                      <?if( !empty($active_users) ){
                        
                        foreach ($active_users as $key => $value) {
                          $encrypted_user_id = urlencode(base64_encode($value["user_id"]));
                          if( $encrypted_user_id == $this->uri->segment(3) ){?>
                            <option value="<?=$encrypted_user_id;?>" selected><?=$value["first_name"] . " " . $value["last_name"];?></option>
                          <?} else {?>
                            <option value="<?=$encrypted_user_id;?>"><?=$value["first_name"] . " " . $value["last_name"];?></option>
                          <?}
                        }
                      } else {

                      }?>
                  </select>
                </div>
                <div class="col-md-4">
                  <input type="submit" name="btnAssign" id="btnAssign" value="Assign Permissions" class="btn btn-primary align_button_with_text_field_no_label">
                </div>
              </div>

              <div class="row">
                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                  <table class="table table-striped table-hover table-bordered" id="data-table">
                    <thead>
                      <tr>
                        <th><input type="checkbox" id="checkAll" name="checkAll"></th>
                        <th>Permission</th>
                        <th>Permission Description</th>
                        <th>Options</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?
                      if( empty($permissions) ){?>
                        <tr>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
                      <?} else {
                        //echo "<pre>";print_r($permissions);exit;

                        if( empty( $assigned_permissions ) ){
                          foreach ($permissions as $key => $value) {
                            $id = $value["permission_id"];
                            ?>
                            <tr>
                              <td>
                                <input type="checkbox" name="permission_id[]" class="" value="<?=$id;?>">
                              </td>
                              <td><?=$value["permission"];?></td>
                              <td><?=$value["description"];?></td>
                              <td>
                                <a href="" title="Details"><i class="fas fa-file-alt"></i></a> |
                                <a href="<?=base_url('Permissions/edit_permission/'.$id)?>" title="Edit"><i class="fas fa-edit"></i></a>                              
                              </td>
                            </tr>
                          <?}
                        } else {
                          //echo "<pre>";print_r($assigned_permissions);exit;
                          foreach ($permissions as $key => $value) {
                            $id = $value["permission_id"];
                            ?>
                            <tr>
                              <td>
                                <?
                                if( in_array($id, $assigned_permissions) ){?>
                                  <input type="checkbox" checked="checked" name="permission_id[]" class="" value="<?=$id;?>">
                                <?} else {?>
                                  <input type="checkbox" name="permission_id[]" class="" value="<?=$id;?>">
                                <?}?>
                                
                              </td>
                              <td><?=$value["permission"];?></td>
                              <td><?=$value["description"];?></td>
                              <td>
                                <a href="" title="Details"><i class="fas fa-file-alt"></i></a> |
                                <a href="<?=base_url('Permissions/edit_permission/'.$id)?>" title="Edit"><i class="fas fa-edit"></i></a>                              
                              </td>
                            </tr>
                          <?}
                        }                        
                      }?>
                    </tbody>
                  </table>
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
    <?include_once 'includes/data-table-scripts.inc';?>
    <script type="text/javascript">
      $(document).ready(function() {
          $("#msg-holder").hide();
          $('#data-table').DataTable({
            "bPaginate": false,
            "bLengthChange": false
          });
      } );

      $("#checkAll").click(function(){
          $('input:checkbox').not(this).prop('checked', this.checked);
      });

      $("#btnAssign").click(function(e){
        e.preventDefault();

        var number_of_checked_checkboxes = $('input:checkbox:checked').length;
        var selected_user_id = $("#user-id").val();
        var errors = "";

        if( selected_user_id == "" ){
          errors += "Please select a user to assign the permission(s) to. <br />";
        }

        if( number_of_checked_checkboxes == 0 ){
          errors += "Please select at least one permission to assign to a user <br />";
        } 

        if( errors != "" ){
          $("#msg-holder").addClass('alert-danger');
          $("#msg-holder").html(errors);
          $("#msg-holder").show();
        } else {
          $("#frm").submit();        
        }
      });

      function set_url( id ){
        var url = "<?=base_url('Permissions/assign_permission_to_user/')?>";

        url += id;

        console.log(url);

        window.location.href = url;
      }
    </script>
  </body>
</html>
