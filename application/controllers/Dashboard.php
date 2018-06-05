<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct(){
		parent::__construct();

		$this->load->model('sir/Sir_model', 'sir');
		$this->load->model('users/Users_model', 'sir_users');
		$this->load->model('clients/Clients_model', 'clients');
		$this->load->model('products/Products_model', 'products');
		$this->load->model('session/Session_model', 'sir_session');
		$this->load->model('suppliers/Suppliers_model', 'suppliers');
		$this->load->model('departments/Departments_model', 'departments');		
		$this->load->model('requisitions/Requisitions_model', 'requisitions');
		$this->load->model('notifications/Notifications_model', 'notifications');

		$this->sir->manage_session();

		//load libraries
		$this->load->library('encryption');
		
	}

	public function index()
	{
		$PageTitle = "SIR Dashboard";

		$this->sir_session->clear_status_message();

		$product_count = $this->products->_count_items();
		
		$user_count = $this->sir_users->_count_items();
		$department_count = $this->departments->_count_items();
		$client_count = $this->clients->_count_items();
		$supplier_count = $this->suppliers->_count_items();
		$no_of_products_in_categories = $this->products->count_no_of_products_in_categories();
		$total_product_category_cost = $this->products->get_total_product_category_cost();
		$total_requisitions = $this->requisitions->get_total_items_requisitioned_for_the_last_7_days();
		$low_stock_levels = $this->products->count_number_of_low_stock_levels();
		$gcg_locations = $this->sir->get_gcg_locations();
		//$last_login_for_user = $this->sir_users->get_last_login_date($this->session->userdata("user_id"));
		$requisition_sales_today = $this->requisitions->get_total_requisition_sales_for_a_today();
		$requisition_sales_this_week = $this->requisitions->get_total_requisition_sales_for_a_week();
		$requisition_sales_this_month = $this->requisitions->get_total_requisition_sales_for_a_month();
		$requisition_sales_this_year = $this->requisitions->get_total_requisition_sales_for_a_year();
		//echo "<pre>";print_r($last_login_for_user);exit;


		$data = array(
			"page_title" => $PageTitle,
			"user_count" => $user_count[0]["_count_"],
			"product_count" => $product_count[0]["_count_"],
			"department_count" => $department_count[0]["_count_"],
			"client_count" => $client_count[0]["_count_"],
			"supplier_count" => $supplier_count[0]["_count_"],
			"no_of_products_in_categories" => $no_of_products_in_categories,
			"total_product_category_cost" => $total_product_category_cost,
			"total_requisitions" => $total_requisitions,
			"low_stock_levels_count" => $low_stock_levels[0]["total"],
			"gcg_locations" => $gcg_locations,
			//"last_login" => $last_login_for_user[0]["login_date"],
			"requisition_sales_today" => '$' . number_format( $requisition_sales_today[0]["total_cost"], 2),
			"requisition_sales_this_week" => '$' .number_format( $requisition_sales_this_week[0]["total_cost"], 2),
			"requisition_sales_this_month" => '$' .number_format( $requisition_sales_this_month[0]["total_cost"], 2),
			"requisition_sales_this_year" => '$' .number_format( $requisition_sales_this_year[0]["total_cost"], 2)
			);

		$this->load->view('dashboard/sir_dashboard', $data);
	}
}