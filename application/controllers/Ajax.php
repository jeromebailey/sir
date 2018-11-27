<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {

	function __construct(){
		parent::__construct();

		//load models
		$this->load->model('sir/Sir_model', 'sir');
		$this->load->model('ajax/Ajax_model', 'ajax');
		$this->load->model('log/SirLog_model', 'logger');
		$this->load->model('users/Users_model', 'sir_users');
		$this->load->model('clients/Clients_model', 'clients');
		$this->load->model('products/Products_model', 'products');
		$this->load->model('session/Session_model', 'sir_session');
		$this->load->model('job_titles/Jobtitles_model', 'job_titles');
		$this->load->model('departments/Departments_model', 'departments');
		$this->load->model('notifications/Notifications_model', 'notifications');

		//load libraries
		$this->load->library('encryption');

		//$this->sir->manage_session();
	}

	public function change_currency_value( $currency_id, $value ){

		echo $this->ajax->change_currency_value( $currency_id, $value );

	}
	
}