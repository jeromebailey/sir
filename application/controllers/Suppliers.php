<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Suppliers extends CI_Controller {

	function __construct(){
		parent::__construct();

		$this->load->model('sir/Sir_model', 'sir');
		$this->load->model('log/SirLog_model', 'logger');
		$this->load->model('clients/Clients_model', 'clients');
		$this->load->model('session/Session_model', 'sir_session');
		$this->load->model('exceptions/AppExceptions_model', 'xxx');
		$this->load->model('suppliers/Suppliers_model', 'suppliers');
		$this->load->model('notifications/Notifications_model', 'notifications');

		$this->sir->manage_session();

		//load libraries
		$this->load->library('encryption');
		
	}

	public function index()
	{
		$PageTitle = "Suppliers";

		$this->sir_session->clear_status_message();

		$suppliers = $this->suppliers->get_all_suppliers();


		$data = array(
			"page_title" => $PageTitle,
			"suppliers" => $suppliers
			);

		$this->load->view('suppliers/suppliers_list', $data);
	}

	public function get_supplier_address_by_id($supplier_id)
	{
		//$supplier_id = $_GET['supplier_id'];
		//echo "<pre>";print_r($this->suppliers->get_supplier_address_by_id($supplier_id));exit;

		$address_string = '';

		$address = $this->suppliers->get_supplier_address_by_id($supplier_id);

		if( !empty( $address ) ){
			$address_string = ( $address[0]['address_line_1'] != null || $address[0]['address_line_1'] != '' ) ? $address[0]['address_line_1'] . '<br/>' : '';
			$address_string .= ( $address[0]['address_line_2'] != null || $address[0]['address_line_2'] != '' ) ? $address[0]['address_line_2'] . '<br/>' : '';
			$address_string .= ( $address[0]['city'] != null || $address[0]['city'] != '' ) ? $address[0]['city'] . '<br/>' : '';
			$address_string .= ( $address[0]['state'] != null || $address[0]['state'] != '' ) ? $address[0]['state'] . '<br/>' : '';
			$address_string .= ( $address[0]['zip'] != null || $address[0]['zip'] != '' ) ? $address[0]['zip'] . '<br/>' : '';
		}
		echo $address_string;

	}

	public function edit_supplier( $supplier_id ){
		$PageTitle = "Edit Supplier";

		$supplier = $this->suppliers->get_supplier_by_id( $supplier_id );

		if( empty($supplier) ){
			show_error( "Sorry, unable to retrieve supplier information", 404, "Error Retrieving Supplier Information" );
		} else {
			$data = array(
			"page_title" => $PageTitle,
			"supplier" => $supplier[0],
			"supplier_id" => $supplier_id
			);

			$this->load->view('suppliers/edit_supplier', $data);
		}
	}

	public function do_edit_supplier(){
		$supplier_id = $this->input->post("supplier-id");
		$supplier_name = $this->input->post("supplier-name");
		$address_line_1 = $this->input->post("address-line-1");
		$address_line_2 = $this->input->post("address-line-2");
		$city = $this->input->post("city");
		$state = $this->input->post("state");
		$zip = $this->input->post("zip");
		$territory = $this->input->post("territory");

		$data = array(
			"supplier_name" => $supplier_name,
			"address_line_1" => $address_line_1,
			"address_line_2" => $address_line_2,
			"city" => $city,
			"state" => $state,
			"zip" => $zip,
			"is_local" => $territory
		);

		try{
			$this->suppliers->update_supplier( $data, $supplier_id );
			$old_data = $this->suppliers->get_supplier_by_id( $supplier_id );
			$this->logger->add_log(9, $this->session->userdata("user_id"), json_encode($old_data), json_encode($data));
			$this->sir_session->add_status_message("Supplier was successfully updated!", "success");
		} catch(Exception $ex){
			$this->xxx->log_exception( $ex->getMessage() );
			$this->sir_session->add_status_message("Supplier was NOT updated!", "danger");
		}
		redirect("/Suppliers/edit_supplier/" . $supplier_id);
	}

	public function add_supplier(){
		$PageTitle = "Add Supplier";

		$data = array(
			"page_title" => $PageTitle
			);

		$this->load->view('suppliers/add_supplier', $data);
	}

	public function do_add_supplier(){
		$supplier_name = $this->input->post("supplier-name");
		$address_line_1 = $this->input->post("address-line-1");
		$address_line_2 = $this->input->post("address-line-2");
		$city = $this->input->post("city");
		$state = $this->input->post("state");
		$zip = $this->input->post("zip");
		$territory = $this->input->post("territory");

		$data = array(
			"supplier_name" => $supplier_name,
			"address_line_1" => $address_line_1,
			"address_line_2" => $address_line_2,
			"city" => $city,
			"state" => $state,
			"zip" => $zip,
			"is_local" => $territory
		);

		try{
			$this->suppliers->insert_supplier( $data );
			$this->logger->add_log(8, $this->session->userdata("user_id"), NULL, json_encode($data));
			$this->sir_session->add_status_message("Supplier was successfully added!", "success");
		} catch(Exception $ex){
			$this->xxx->log_exception( $ex->getMessage() );
			$this->sir_session->add_status_message("Supplier was NOT added!", "danger");
		}
		redirect("/Suppliers/add_supplier");
	}

	public function view_supplier( $supplier_id ){
		$PageTitle = "View Supplier";

		$supplier = $this->suppliers->get_supplier_by_id( $supplier_id );

		if( empty($supplier) ){
			show_error( "Sorry, unable to retrieve supplier information", 404, "Error Retrieving Supplier Information" );
		} else {
			$data = array(
			"page_title" => $PageTitle,
			"supplier" => $supplier[0],
			"supplier_id" => $supplier_id
			);

			$this->load->view('suppliers/view_supplier', $data);
		}
	}

}
