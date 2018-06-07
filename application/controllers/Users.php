<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	function __construct(){
		parent::__construct();

		//load models
		$this->load->model('sir/Sir_model', 'sir');
		$this->load->model('log/SirLog_model', 'logger');
		$this->load->model('users/Users_model', 'sir_users');
		$this->load->model('session/Session_model', 'sir_session');
		$this->load->model('exceptions/AppExceptions_model', 'xxx');
		$this->load->model('job_titles/Jobtitles_model', 'job_titles');
		$this->load->model('departments/Departments_model', 'departments');
		$this->load->model('notifications/Notifications_model', 'notifications');		

		//load libraries
		$this->load->library('encryption');

		$this->load->helper('cookie');
	}

	public function index()
	{
		//manage session
		$this->sir->manage_session();

		$this->sir_session->clear_status_message();
		$PageTitle = "ALL SIR Users";
		$allUsers = $this->sir_users->get_all_users();

		$data = array(
			"page_title" => $PageTitle,
			'all_users' => $allUsers
			);

		$this->load->view('users/list_users', $data);
	}

	public function login()
	{
		//$this->sir_session->clear_status_message();
		//if user is not logged in and the cookie is found
		if( empty( $this->session->userdata("user_id") ) && !empty(get_cookie("remember_sir_user")) ){
			list( $selector, $authenticator ) = explode(":", get_cookie("remember_sir_user"));

			$auth_record = $this->sir_users->get_auth_record( $selector );

			if( !empty( $auth_record ) ){
				if( hash_equals( $auth_record[0]["user_token"], hash( "sha256", base64_decode($authenticator) ) ) ){
					$this->sir_users->login_user_by_remeber_me_cookie( $auth_record[0]["user_id"] );
					return redirect("Dashboard/index");
				}
			} else {
				$this->load->view('users/login');
			}
		} else if( !empty( $this->session->userdata("user_id") ) )  { 
			//if the user is already logged in
			return redirect("Dashboard/index");
		} else if( empty( $this->session->userdata("user_id") ) && empty(get_cookie("remember_sir_user")) ) {
			//if the user is not logged in and the cookie is not found
			$this->load->view('users/login');
		}
	}

	public function do_login()
	{
		$email_address = $this->input->post('email');
		$password = $this->input->post('pass');
		$remember_me = $this->input->post('remember-me');

		if( $this->sir_users->validate_user($email_address, $password, $remember_me) ){			
			redirect("/Dashboard/index");
		} else {
			$this->sir_session->add_status_message("Sorry, invalid credentials were entered. Please try again", "danger");
			redirect("/Users/login");
		}

		//$this->load->view('users/login');
	}

	public function logout(){
		$this->session->sess_destroy();

		delete_cookie('remember_sir_user', "codedbyjb.com", "/clients/gcg/sir");

		/*if( !empty(get_cookie("remember_sir_user")) ){
			list( $selector, $authenticator ) = explode(":", get_cookie("remember_sir_user"));

			$this->sir_users->delete_auth_record( $selector );
		}*/

		redirect("/Users/login");
	}

	public function add_user()
	{
		//manage session
		$this->sir->manage_session();

		$PageTitle = "Add SIR User";
		$genders = $this->sir->get_genders();
		$departments = $this->departments->get_all_departments();
		$job_titles = $this->job_titles->get_all_job_titles();

		$data = array(
			"page_title" => $PageTitle,
			"genders" => $genders,
			"departments" => $departments,
			"job_titles" => $job_titles
			);

		$this->load->view('users/add_user', $data);
	}

	public function do_add_user(){
		//echo "<pre>";print_r($this->input->post());exit;
		$data = array(
			'user_id' => $this->input->post('user-id'),
			'first_name' => $this->input->post('first-name'),
			'last_name' => $this->input->post('last-name'),
			'email_address' => $this->input->post('email-address'),
			'gender_id' => $this->input->post('gender_id'),
			'dob' => $this->input->post('dob'),
			'department_id' => $this->input->post('department_id'),
			'job_title_id' => $this->input->post('job-title-id'),
			'user_password' => $this->input->post('user-password'),
			'is_an_admin' => ($this->input->post('is-an-admin') == "on") ? 1 : 0
			);

		//echo "<pre>";print_r($data);exit;

		try{
			$this->sir_users->insert_user($data);

			try{
				$this->logger->add_log(5, $this->session->userdata("user_id"), NULL, json_encode($data));
			} catch(Exception $x){
				$this->xxx->log_exception( $x->getMessage() );
			}
			
			$this->sir_session->add_status_message("User was successfully added", "success");
		} catch( Exception $e ){
			$this->xxx->log_exception( $e->getMessage() );
			$this->sir_session->add_status_message("Sorry, there was an error adding the user. Please try again", "danger");
		}

		return redirect('/Users/add_user');
	}

	public function edit_user()
	{
		//manage session
		$this->sir->manage_session();

		$PageTitle = "Edit SIR User";

		$encrypted_id = $this->uri->segment(3);
		$this->encryption->decrypt($this->uri->segment(3));

		if( !isset($encrypted_id) ){

		} else {
			//echo "decrypted :: " . $this->encryption->decrypt($encrypted_id);exit;
			$genders = $this->sir->get_genders();
			$departments = $this->departments->get_all_departments();
			$job_titles = $this->job_titles->get_all_job_titles();

			$user_details = $this->sir_users->get_user_details_by_encrypted_id($encrypted_id);
			//echo "<pre>";print_r($user_details);exit;

			$data = array(
				"page_title" => $PageTitle,
				"genders" => $genders,
				"departments" => $departments,
				"job_titles" => $job_titles,
				"user_details" => $user_details
				);

			$this->load->view('users/edit_user', $data);
		}
	}

	public function do_edit_user()
	{
		//echo "<pre>";print_r($this->input->post());exit;

		$update_password = false;

		if( empty( $this->input->post('user-password') ) )
		{

			$data = array(
				'first_name' => $this->input->post('first-name'),
				'last_name' => $this->input->post('last-name'),
				'email_address' => $this->input->post('email-address'),
				'gender_id' => $this->input->post('gender_id'),
				'dob' => $this->input->post('dob'),
				'department_id' => $this->input->post('department_id'),
				'job_title_id' => $this->input->post('job-title-id'),
				'is_an_admin' => ($this->input->post('is-an-admin') == "on") ? 1 : 0
			);
		} else {
			$update_password = true;

			$data = array(
				'first_name' => $this->input->post('first-name'),
				'last_name' => $this->input->post('last-name'),
				'email_address' => $this->input->post('email-address'),
				'gender_id' => $this->input->post('gender_id'),
				'dob' => $this->input->post('dob'),
				'department_id' => $this->input->post('department_id'),
				'job_title_id' => $this->input->post('job-title-id'),
				'user_password' => $this->input->post('user-password'),
				'is_an_admin' => ($this->input->post('is-an-admin') == "on") ? 1 : 0
			);
		}

		//get old data
		$user_details = $this->sir_users->get_user_details_by_id($this->input->post('user-id'));

		try{
			$this->sir_users->update_user($data, $this->input->post('user-id'), $update_password);

			try{
				$this->logger->add_log(6, $this->session->userdata("user_id"), json_encode($user_details[0]), json_encode($data));
			} catch(Exception $x){
				$this->xxx->log_exception( $x->getMessage() );
			}
			
			$this->sir_session->add_status_message("User was successfully updated", "success");
		} catch( Exception $e ){
			$this->xxx->log_exception( $e->getMessage() );
			$this->sir_session->add_status_message("Sorry, there was an error updating the user. Please try again", "danger");
		}

		//return redirect('/Users/');
		return redirect('/Users/edit_user/' . urlencode(base64_encode($this->input->post('user-id')))); //$this->encryption->encrypt($this->input->post('user-id'))
	}

	public function view_user_profile()
	{
		//manage session
		$this->sir->manage_session();

		$PageTitle = "User Profile";

		$encrypted_id = $this->uri->segment('3');

		$user_details = $this->sir_users->get_user_profile_details_by_encrypted_id($encrypted_id);

		if( !isset($encrypted_id) ){

		} else {
			$data = array(
			"page_title" => $PageTitle,
			"profile" => $user_details
			);

			$this->load->view('users/user_profile', $data);
		}
	}

	public function delete_user_by_encrypted_id($encrypted_id)
	{
		//get old data
		$user_details = $this->sir_users->get_user_details_by_encrypted_id($encrypted_id);

		try{
			$this->sir_users->delete_user_by_encrypted_id($encrypted_id);

			try{
				$this->logger->add_log(7, $this->session->userdata("user_id"), json_encode($user_details[0]), NULL);
			} catch(Exception $e){
				$this->xxx->log_exception( $e->getMessage() );
			}
			echo true;
		} catch(Exception $ex){
			$this->xxx->log_exception( $ex->getMessage() );
			echo false;
		}
	}

}