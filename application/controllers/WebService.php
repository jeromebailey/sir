<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WebService extends CI_Controller {

	function __construct(){
		parent::__construct();

		$this->load->model('sir/Sir_model', 'sir');
		$this->load->model('log/SirLog_model', 'logger');
		$this->load->model('quotes/Quotes_model', 'quotes');
		$this->load->model('purchase_orders/PO_model', 'po');
		$this->load->model('clients/Clients_model', 'clients');
		$this->load->model('invoices/Invoice_model', 'invoice');
		$this->load->model('products/Products_model', 'products');
		$this->load->model('exceptions/AppExceptions_model', 'xxx');
		$this->load->model('suppliers/Suppliers_model', 'suppliers');	
		$this->load->model('categories/Categories_model', 'categories');	
		$this->load->model('requisitions/Requisitions_model', 'requisitions');
		$this->load->model('flight_check_sheets/FlightCheckSheets_model', 'flight_check_sheet');

	}

	public function get_json_product_list()
	{
		//echo $prefix;exit;
		//echo $_GET["term"] . $_GET["searchText"];
		echo $this->products->json_get_all_products();
		//echo "<pre>";print_r($result);exit;
	}

	public function search_products($term){
		echo $this->products->search_products($term);
	}

	public function get_all_products_as_string(){
		echo $this->products->get_all_products_as_string();
	}

	public function get_client_flights($client_id){
		echo $this->clients->json_get_client_flights($client_id);
	}

	public function get_client_routes_types($client_id){
		echo $this->clients->json_get_client_routes_types($client_id);
	}

	public function find_product_by_barcode($bar_code){
	    //echo "<pre>";print_r( $this->products->search_product_by_barcode($bar_code) );exit;
	    echo json_encode($this->products->search_product_by_barcode($bar_code));
	}

	public function find_product_by_product_id($product_id){
	    //echo "<pre>";print_r( $this->products->search_product_by_barcode($bar_code) );exit;
	    echo json_encode($this->products->search_product_by_product_id($product_id));
	}

	public function set_inventory_date($inventory_date){
		echo $this->sir->set_inventory_date($inventory_date);
	}

	public function get_client_abbreviation_by_id($client_id){
		echo $this->clients->get_client_abbreviation_by_id($client_id);
	}

	public function get_next_client_flight_check_no($client_id){
		echo $this->clients->get_next_client_flight_check_no($client_id);
	}

	public function dispatch_requisition( $requisition_id ){
		echo $this->requisitions->dispatch_requisition_service( $requisition_id );
	}

	public function do_delete_item($controller_name, $key, $type = null){
		if( !empty($controller_name) ){
			switch ($controller_name) {
				case 'requisitions':
					echo $this->requisitions->delete_requisition($key);
					break;

				case 'flight_check_sheets':
					echo $this->flight_check_sheet->delete_check_sheets($key);
					break;

				case 'purchase_orders':
					echo $this->po->delete_po($key);
					break;

				case 'clients':
					echo $this->clients->delete_client($key);
					break;

				case 'suppliers':
					echo $this->suppliers->delete_supplier($key);
					break;

				case 'invoices':
					echo $this->invoice->delete_invoice($key, $type);
					break;

				case 'quotes':
					echo $this->quotes->delete_quote($key);
					break;

				case 'products':
					echo $this->products->delete_product($key);
					break;

				case 'categories':
					echo $this->categories->delete_category($key);
					break;
				
				default:
					# code...
					break;
			}
		}
	}

	public function generate_product_barcode( $product_id ){
		if( !empty($product_id) ){

			$barcode = "";

			$product = $this->products->get_product_by_product_id($product_id);
			$product_category_id = $product[0]["product_category_id"];

			$this->load->config("sir_config");
			$company_prefix = $this->config->item("company_barcode_prefix");

			$this->load->library('Zend');
			$this->zend->load('Zend/Barcode');

			$_category_id = $this->sir->pad_product_category_id( $product_category_id );
			$_product_id = $this->sir->pad_product_id( $product_id );

			$barcode .= $company_prefix . $_category_id . $_product_id;

			try{
				$this->products->save_generated_product_barcode( $product_id, $barcode );

				$this->products->store_generated_barcode( $barcode );

				$data = array(
					"product_information" => $product,
					"barcode" => $barcode
				);

				$this->logger->add_log(20, $this->session->userdata("user_id"), NULL, json_encode($data));
				echo $barcode;
			} catch( Exception $ex){
				echo $barcode;
				$this->xxx->log_exception( $ex->getMessage() );
			}
		}		
	} //end of function

	public function generate_new_product_barcode( $product_id, $category_id ){
		if( !empty($product_id) ){

			$barcode = "";

			//$product = $this->products->get_product_by_product_id($product_id);
			//$product_category_id = $product[0]["product_category_id"];

			$this->load->config("sir_config");
			$company_prefix = $this->config->item("company_barcode_prefix");

			$this->load->library('Zend');
			$this->zend->load('Zend/Barcode');

			$_category_id = $this->sir->pad_product_category_id( $category_id );
			$_product_id = $this->sir->pad_product_id( $product_id );

			$barcode .= $company_prefix . $_category_id . $_product_id;

			try{
				$this->products->save_generated_product_barcode( $product_id, $barcode );

				$this->products->store_generated_barcode( $barcode );

				$data = array(
					"product_information" => NULL,
					"barcode" => $barcode
				);

				$this->logger->add_log(20, $this->session->userdata("user_id"), NULL, json_encode($data));
				echo $barcode;
			} catch( Exception $ex){
				echo $barcode;
				$this->xxx->log_exception( $ex->getMessage() );
			}
		}		
	} //end of function

	public function get_suppliers_by_territory_id( $territory_id ){
		echo json_encode( $this->suppliers->get_suppliers_by_territory_id( $territory_id ) );
	}

	public function get_ship_to_address_by_territory_id( $territory_id ){

		if( $territory_id == 1 ){
			$result = $this->sir->get_settings_by_slug('ship_to');
		} else {
			$result = $this->sir->get_settings_by_slug('ship_to_overseas');
		}

		echo json_encode($result[0]["settings_value"]);
	}
}
