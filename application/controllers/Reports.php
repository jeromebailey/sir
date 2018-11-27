<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

	function __construct(){
		parent::__construct();

		$this->load->model('sir/Sir_model', 'sir');
		$this->load->model('users/Users_model', 'sir_users');
		$this->load->model('clients/Clients_model', 'clients');
		$this->load->model('products/Products_model', 'products');
		$this->load->model('session/Session_model', 'sir_session');
		$this->load->model('suppliers/Suppliers_model', 'suppliers');
		$this->load->model('departments/Departments_model', 'departments');
		$this->load->model('notifications/Notifications_model', 'notifications');
		$this->load->model('requisitions/Requisitions_model', 'requisitions');
		$this->load->model('categories/Categories_model', 'categories');

		$this->sir->manage_session();

		//load libraries
		$this->load->library('encryption');
		
	}

	public function index()
	{
		$PageTitle = "List of Reports";

		$this->sir_session->clear_status_message();

		$data = array(
			"page_title" => $PageTitle
			);

		$this->load->view('reports/reports_list', $data);
	}

	public function count_low_stock_items()
	{
		$PageTitle = "No. of low stock levels";
		$low_stock_levels = $this->products->count_number_of_low_stock_levels();
		//echo "<pre>";print_r($low_stock_levels);exit;

		$data = array(
			"page_title" => $PageTitle,
			"low_stock_levels_count" => $low_stock_levels[0]["total"]
			);

		$this->load->view('reports/no_of_low_stock_levels', $data);
	}

	public function low_stock_levels()
	{
		$PageTitle = "Low Stock Levels";
		$low_stock = $this->products->get_low_stock_level_items();

		$data = array(
			"page_title" => $PageTitle,
			"low_stock_levels_count" => count( $low_stock ),
			"low_stock_items" => $low_stock
			);

		$this->load->view('reports/low_stock_items', $data);
	}

	public function count_low_stock_levels_per_category()
	{
		$PageTitle = "Count Low Stock Levels per Category";
		$low_stock_count_in_categories = $this->products->count_low_stock_items_per_category();

		$data = array(
			"page_title" => $PageTitle,
			"low_stock_count_in_categories" => $low_stock_count_in_categories
			);

		$this->load->view('reports/count_low_stock_items_per_category', $data);
	}

	public function low_stock_levels_per_category()
	{
		$PageTitle = "Low Stock Levels per Category";

		$category_id = $this->uri->segment(3);
		$categories = $this->categories->get_all_categories();

		if(empty($category_id))
		{
			$low_stock_in_categories = null;
			$category_id = null;
		} else {
			$low_stock_in_categories = $this->products->low_stock_items_by_category_id($category_id);
		}

		$data = array(
			"page_title" => $PageTitle,
			"low_stock_in_categories" => $low_stock_in_categories,
			"categories" => $categories,
			"category_id" => $category_id
			);

		$this->load->view('reports/low_stock_items_per_category', $data);
	}

	public function show_user_access(){
		$PageTitle = "User Access";

		$access_for_users = $this->sir_users->show_user_access();

		$data = array(
			"page_title" => $PageTitle,
			"access_for_users" => $access_for_users
			);

		$this->load->view('reports/show_user_access', $data);
	}

	public function inventory_total_per_category(){
		$PageTitle = "Total Value Per Category In Inventory";

		$category_id = $this->uri->segment(3);
		$categories = $this->categories->get_all_categories();

		if(empty($category_id))
		{
			$product_category_items_with_item_total_cost = null;
			$category_id = null;
			//$no_of_items_in_category = null;
			//$total_product_cost_in_category = null;
		} else {
			$product_category_items_with_item_total_cost = $this->products->get_inventory_by_category_with_product_item_total_cost( $category_id );
			//$no_of_items_in_category = $this->products->count_no_of_items_in_a_category( $category_id );
			//$total_product_cost_in_category = $this->products->get_total_cost_in_a_category( $category_id );
		}

		$data = array(
			"page_title" => $PageTitle,
			"product_category_items_with_item_total_cost" => $product_category_items_with_item_total_cost,
			"categories" => $categories,
			//"no_of_items_in_category" => $no_of_items_in_category[0]["product_count"],
			"category_id" => $category_id
			//"total_product_cost_in_category" => $total_product_cost_in_category[0]["total_cost"]
			);

		$this->load->view('reports/inventory_total_per_category', $data);
	}

	public function inventory_items_in_category(){
		
		$category_id = $this->uri->segment(3);
		$categories = $this->categories->get_all_categories();
		$todays_date = date("F d, Y");
		$category_name = "" ;

		if(empty($category_id))
		{
			$product_category_items_with_item_total_cost = null;
			$category_id = null;
			//$no_of_items_in_category = null;
			//$total_product_cost_in_category = null;
		} else {
			$category_name = $this->sir->get_category_name($category_id);
			$product_category_items_with_item_total_cost = $this->products->get_inventory_by_category_with_product_item_total_cost( $category_id );
			//$no_of_items_in_category = $this->products->count_no_of_items_in_a_category( $category_id );
			//$total_product_cost_in_category = $this->products->get_total_cost_in_a_category( $category_id );
		}

		$PageTitle =  $category_name . " Inventory Items for " . $todays_date; 

		$data = array(
			"page_title" => $PageTitle,
			"product_category_items_with_item_total_cost" => $product_category_items_with_item_total_cost,
			"categories" => $categories,
			//"no_of_items_in_category" => $no_of_items_in_category[0]["product_count"],
			"category_id" => $category_id
			//"total_product_cost_in_category" => $total_product_cost_in_category[0]["total_cost"]
			);

		$this->load->view('reports/inventory_items_in_category', $data);
	}

	public function pricing_inventory(){
		$category_id = $this->uri->segment(3);
		$categories = $this->categories->get_all_categories();
		$todays_date = date("F d, Y");
		$category_name = "" ;

		if(empty($category_id))
		{
			$product_category_items_with_item_total_cost = null;
			$category_id = null;
			//$no_of_items_in_category = null;
			//$total_product_cost_in_category = null;
		} else {
			$category_name = $this->sir->get_category_name($category_id);
			$product_category_items_with_item_total_cost = $this->products->get_inventory_by_category_with_product_item_total_cost( $category_id );
			//$no_of_items_in_category = $this->products->count_no_of_items_in_a_category( $category_id );
			//$total_product_cost_in_category = $this->products->get_total_cost_in_a_category( $category_id );
		}

		$PageTitle =  $category_name . " Inventory Items for " . $todays_date; 
		$uom = $this->sir->get_all_uom();

		foreach ($uom as $key => $value) {
			$my_array[$value["unit_id"]] = $value["unit_abbreviation"];
		}

		//echo "<pre>";print_r($my_array);exit;

		$data = array(
			"page_title" => $PageTitle,
			"product_category_items_with_item_total_cost" => $product_category_items_with_item_total_cost,
			"categories" => $categories,
			"uom" => $uom,
			"my_uom" => $my_array,
			"category_id" => $category_id
			//"total_product_cost_in_category" => $total_product_cost_in_category[0]["total_cost"]
			);

		$this->load->view('reports/pricing_inventory', $data);
	}

}
