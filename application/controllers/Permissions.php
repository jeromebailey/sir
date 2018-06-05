<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permissions extends CI_Controller {

	function __construct(){
		parent::__construct();

		$this->load->model('sir/Sir_model', 'sir');
		$this->load->model('log/SirLog_model', 'logger');
		$this->load->model('users/Users_model', 'sir_users');
		$this->load->model('session/Session_model', 'sir_session');
		$this->load->model('exceptions/AppExceptions_model', 'xxx');
		$this->load->model('permissions/Permissions_model', 'permissions');
		$this->load->model('notifications/Notifications_model', 'notifications');

		//$this->load->library('encryption');
		
	}

	public function index()
	{
		$this->sir->manage_session();
		$PageTitle = "All Permissions";

		$permissions = $this->permissions->get_all_permissions();
		$data = array(
			"page_title" => $PageTitle,
			"permissions" => $permissions
			);

		$this->load->view('permissions/list_permissions', $data);
	}

	public function add_permission()
	{
		$PageTitle = "Add Permission";

		$data = array(
			"page_title" => $PageTitle
			);

		$this->load->view('permissions/add_permission', $data);
	}

	public function do_add_permission(){
		//echo "<pre>";print_r($this->input->post());exit;
		$data = array(
			'permission' => $this->input->post('permission')
			);

		try{
			$this->permissions->insert_permission($data);

			try{
				$this->logger->add_log(18, $this->session->userdata("user_id"), NULL, json_encode($data));
			} catch(Exception $x){
				$this->xxx->log_exception( $x->getMessage() );
			}
			$this->sir_session->add_status_message("Permission was successfully added", "success");
		} catch(Exception $ex){
			$this->xxx->log_exception( $ex->getMessage() );
			$this->sir_session->add_status_message("Permission was not added", "danger");
		}
		return redirect('/Permissions/add_permission');		
	}

	public function assign_permission_to_user(){
		$PageTitle = "Assign Permission to user";

		$all_active_users = $this->sir_users->get_all_users_by_status_code( 1 );
		$permissions = $this->permissions->get_all_permissions();

		if( empty( $this->uri->segment(3) ) ){
			$assigned_permissions = NULL;
		} else {
			$decrypted_user_id = $this->sir->decrypt_user_id($this->uri->segment(3));		
			$assigned_permissions = $this->permissions->get_ids_of_permissions_assigned_to_user( $decrypted_user_id );

			if( empty($assigned_permissions) ){
				$assigned_permissions = NULL;
			} else {
				$i = 0;
				foreach ($assigned_permissions as $key => $value) {
					$new_assigned_permissions[$i] = $value["permission_id"];
					$i++;
				}

				$assigned_permissions = $new_assigned_permissions;
			}
		}

		$data = array(
			"page_title" => $PageTitle,
			"active_users" => $all_active_users,
			"permissions" => $permissions,
			"assigned_permissions" => $assigned_permissions
			);

		$this->load->view('permissions/assign_permission_to_user', $data);
	}

	public function do_assign_permission_to_user(){
		//echo "<pre>";print_r($this->input->post());exit;

		$encrypted_user_id = $this->input->post("user-id");
		$decrypted_user_id = $this->sir->decrypt_user_id( $encrypted_user_id );
		$permissions_to_set = $this->input->post("permission_id");

		$log_data = array(
			"user_id" => $decrypted_user_id,
			"permissions" => $permissions_to_set
		);

		try{
			$this->permissions->set_permissions_for_user($decrypted_user_id, $permissions_to_set);

			try{
				$this->logger->add_log(17, $this->session->userdata("user_id"), NULL, json_encode($log_data));
			} catch(Exception $x){
				$this->xxx->log_exception( $x->getMessage() );
			}
			$this->sir_session->add_status_message("Permissions were successfully set for user", "success");
		} catch(Exception $ex){
			$this->xxx->log_exception( $ex->getMessage() );
			$this->sir_session->add_status_message("Permissions were NOT set for user", "danger");
		}

		return redirect('/Permissions/assign_permission_to_user');
	}
}
