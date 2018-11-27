<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

	function __construct(){
		parent::__construct();

		//load models
		$this->load->model('sir/Sir_model', 'sir');	
		$this->load->model('log/SirLog_model', 'logger');	
		$this->load->model('users/Users_model', 'sir_users');
		$this->load->model('products/Products_model', 'products');
		$this->load->model('session/Session_model', 'sir_session');
		$this->load->model('exceptions/AppExceptions_model', 'xxx');
		$this->load->model('categories/Categories_model', 'categories');
		$this->load->model('notifications/Notifications_model', 'notifications');

		$this->sir->manage_session();
	}

	public function index()
	{
		$PageTitle = "ALL Products";
		$category_id = $this->uri->segment(3);
		$categories = $this->categories->get_all_categories();

		if(empty($category_id))
		{
			$products = $this->products->get_all_products(null);
		} else {
			$products = $this->products->get_all_products($category_id);
		}

		$data = array(
			"page_title" => $PageTitle,
			"products" => $products,
			"categories" => $categories,
			"category_id" => $category_id
			);

		$this->load->view('products/list_all_products', $data);
	}

	public function add_product()
	{
		$PageTitle = "Add Product";

		$uom = $this->sir->get_all_uom();
		$categories = $this->categories->get_all_categories();
		$next_product_id = $this->products->get_next_product_id();

		$data = array(
			"page_title" => $PageTitle,
			"uom" => $uom,
			"product_id" => $next_product_id,
			"categories" => $categories
			);

		$this->load->view('products/add_product', $data);
	}

	public function do_add_product(){
		$barcode = $this->input->post("bar-code");
		$product_name = $this->input->post("product-name");
		$category_id = $this->input->post("product-category");
		$price = $this->input->post("product-price");
		$weight = $this->input->post("product-weight");
		$uom_id = $this->input->post("unit-id");
		$description = $this->input->post("product-description");

		$product_info_data = array(
			"product_name" => $product_name,
			"description" => $description,
			"barcode" => $barcode,
			"product_category_id" => $category_id,
			"price" => $price,
			"weight" => $weight,
			"unit_id" => $uom_id
		);

		try{
			$this->products->insert_product( $product_info_data );

			//get newly inserted product id
			$new_product_id = $this->db->insert_id();

			//send newly inserted product id to the view
			$data = array(
				"new_product_id" => $new_product_id
			);

			//$this->session->set_userdata('new_product_id', $new_product_id);

			try{
				$this->logger->add_log(14, $this->session->userdata("user_id"), NULL, json_encode($product_info_data));
			} catch(Exception $x){
				$this->xxx->log_exception( $x->getMessage() );
			}

			$this->sir_session->add_status_message("Product information was successfully added", "success");
		} catch(Exception $ex){
			$this->xxx->log_exception( $ex->getMessage() );
			$this->sir_session->add_status_message("Sorry, product information was not added", "danger");
		}
		return redirect("Products/add_product/", $data);		
	}

	public function add_inventory()
	{
		$PageTitle = "Add Inventory";

		$uom = $this->sir->get_all_uom();
		$categories = $this->categories->get_all_categories();

		$data = array(
			"page_title" => $PageTitle,
			"uom" => $uom,
			"categories" => $categories
			);

		$this->load->view('products/add_inventory', $data);
	}

	public function view_product($product_id)
	{
		$this->sir_session->clear_status_message();

		$PageTitle = "View Product";

	    $product_to_edit = $this->products->get_product_by_product_id($product_id);
	    $uom = $this->sir->get_all_uom();
		$categories = $this->categories->get_all_categories();
		$product_min_max_data = $this->products->get_minimum_maximum_stock_level_by_product_id($product_id);

		$data = array(
	        "page_title" => $PageTitle,
	        "product" => $product_to_edit[0],
	        "uom" => $uom,
			"categories" => $categories,
			"product_id" => $product_id
			//"product_min_max_data" => $product_min_max_data[0]
	    );

		if( empty( $product_min_max_data ) ){
			$data["product_min_max_data"] = null;
		} else {
			$data["product_min_max_data"] = $product_min_max_data[0];
		}
	    //echo "<pre>";print_r($data);exit;

	    $this->load->view('products/view_product', $data);
	}

	public function edit_product($product_id)
	{
		$PageTitle = "Edit Product";

	    $product_to_edit = $this->products->get_product_by_product_id($product_id);
	    $uom = $this->sir->get_all_uom();
		$categories = $this->categories->get_all_categories();
		$product_min_max_data = $this->products->get_minimum_maximum_stock_level_by_product_id($product_id);

		$data = array(
	        "page_title" => $PageTitle,
	        "product" => $product_to_edit[0],
	        "uom" => $uom,
			"categories" => $categories,
			"product_id" => $product_id
			//"product_min_max_data" => $product_min_max_data[0]
	    );

		if( empty( $product_min_max_data ) ){
			$data["product_min_max_data"] = null;
		} else {
			$data["product_min_max_data"] = $product_min_max_data[0];
		}
	    //echo "<pre>";print_r($data);exit;

	    $this->load->view('products/edit_product', $data);
	}

	public function do_edit_product(){
		$product_id = $this->input->post("product_id");

		if( empty($product_id) ){
			show_error("Sorry, unable to update product due to product key.");
			$this->xxx->log_exception( "Unable to update product due to missing product id." );
		} else {

			try{
				$old_product_data = $this->products->get_product_by_product_id($product_id);
			} catch( Exception $product_id_ex ){
				$this->xxx->log_exception( $product_id_ex->getMessage() );
			}
			
			$barcode = $this->input->post("bar-code");
			$product_name = $this->input->post("product-name");
			$category_id = $this->input->post("product-category");
			$price = $this->input->post("product-price");
			$weight = $this->input->post("product-weight");
			$uom_id = $this->input->post("unit-id");
			$description = $this->input->post("product-description");

			$product_info_data = array(
				"product_name" => $product_name,
				"description" => $description,
				"barcode" => $barcode,
				"product_category_id" => $category_id,
				"price" => $price,
				"weight" => $weight,
				"unit_id" => $uom_id
			);

			try{
				$this->products->update_product( $product_id, $product_info_data );

				try{
					$this->logger->add_log(15, $this->session->userdata("user_id"), json_encode($old_product_data), json_encode($product_info_data));
				} catch(Exception $x){
					$this->xxx->log_exception( $x->getMessage() );
				}

				$this->sir_session->add_status_message("Product information was successfully updated", "success");
			} catch(Exception $ex){
				$this->xxx->log_exception( $ex->getMessage() );
				$this->sir_session->add_status_message("Sorry, product information was not updated", "danger");
			}
			return redirect("Products/edit_product/" . $product_id);
		}		
	}

	public function inventory_list(){
	    $PageTitle = "Inventory List";
	    
	    $category_id = $this->uri->segment(3);
		$categories = $this->categories->get_all_categories();

		if(empty($category_id))
		{
			$inventory = $this->products->get_inventory_list();
		} else {
			$inventory = $this->products->get_inventory_list($category_id);
		}

	    $data = array(
	        "page_title" => $PageTitle,
	        "inventory" => $inventory,
	        "categories" => $categories,
			"category_id" => $category_id
	    );

	    $this->load->view('products/inventory_list', $data);
	}

	public function update_product_stock_level(){
		$product_id = $this->input->post("product_id");
		$barcode = $this->input->post("bar-code");
		$product_name = $this->input->post("product-name");
		$category_id = $this->input->post("product-category");
		$price = $this->input->post("product-price");
		$weight = $this->input->post("product-weight");
		$uom_id = $this->input->post("unit-id");
		$description = $this->input->post("product-description");
		$current_stock_level = $this->input->post("amt-in-stock");
		$new_stock_level = $this->input->post("inventory-amt");

		$product_info_data = array(
			"product_name" => $product_name,
			"description" => $description,
			"barcode" => $barcode,
			"product_category_id" => $category_id,
			"price" => $price,
			"weight" => $weight,
			"unit_id" => $uom_id
		);

		if( $this->products->update_product_stock_level( $product_info_data, $current_stock_level, $new_stock_level, $product_id )){
			$this->sir_session->add_status_message("Product stock information was successfully update", "success");
		} else {
			$this->sir_session->add_status_message("Sorry, product stock information was not updated", "danger");
		}

		return redirect('/Products/add_inventory');
	}

	public function generate_barcode(){
		$this->load->config("sir_config");
		$company_prefix = $this->config->item("company_barcode_prefix");
		//load library
		$this->load->library('Zend');
		//load in folder Zend
		$this->zend->load('Zend/Barcode');
		$code_to_use = $company_prefix . "07" . "0456";
		//generate barcode
		Zend_Barcode::render('upca', 'image', array('text'=>$code_to_use), array());
	}

	public function list_generated_barcodes(){
		$PageTitle = "Generated Barcodes";

	    $products_and_barcodes = $this->products->get_all_generated_barcodes();

	    $data = array(
	        "page_title" => $PageTitle,
	        "products_and_barcodes" => $products_and_barcodes
	    );

	    $this->load->view('products/list_generated_product_barcodes', $data);
	}

	public function view_generated_barcode($product_id){
		$this->sir_session->clear_status_message();
		$PageTitle = "Product Barcode";

		$this->load->config("sir_config");
		$uploaded_barcode_path = $this->config->item("uploaded_barcode_path");

	    $products_and_barcode = $this->products->get_generated_barcode_by_product_id($product_id);
	    $company_address = $this->sir->get_settings_by_slug('address_for_forms');

	    $data = array(
	        "page_title" => $PageTitle,
	        "products_and_barcode" => $products_and_barcode[0],
	        "company_address" => $company_address[0]["settings_value"],
	        "uploaded_barcode_path" => $uploaded_barcode_path
	    );

	    $this->load->view('products/view_generated_barcode', $data);
	}

	public function do_edit_product_stock_level(){
		$product_id = $this->input->post("product_id");
		$new_stock_level = $this->input->post("new-stock-level");
		$minimum_stock_level = $this->input->post("minimum-stock-level");
		$maximum_stock_level = $this->input->post("maximum-stock-level");
		$unit_id = $this->input->post("unit-id");

		$min_max_data = array(
			"minimum_stock_level" => $minimum_stock_level,
			"maximum_stock_level" => $maximum_stock_level,
			"unit_id" => $unit_id
		);

		try{
			$this->products->update_product_minimum_maximum_stock_level( $product_id, $new_stock_level, $min_max_data );
			$this->sir_session->add_status_message("Product minimum/maximum information was successfully updated", "success");
		} catch(Exception $ex){
			$this->xxx->log_exception( $ex->getMessage() );
			$this->sir_session->add_status_message("Sorry, minimum/maximum product information was not updated", "danger");
		}
		return redirect("Products/edit_product/" . $product_id);
	}
}