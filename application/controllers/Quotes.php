<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quotes extends CI_Controller {

	function __construct(){
		parent::__construct();

		//load models
		$this->load->model('sir/Sir_model', 'sir');
		$this->load->model('log/SirLog_model', 'logger');
		$this->load->model('purchase_orders/PO_model', 'po');
		$this->load->model('users/Users_model', 'sir_users');
		$this->load->model('clients/Clients_model', 'clients');
		$this->load->model('quotes/Quotes_model', 'quotes');
		$this->load->model('session/Session_model', 'sir_session');
		$this->load->model('suppliers/Suppliers_model', 'suppliers');
		$this->load->model('job_titles/Jobtitles_model', 'job_titles');
		$this->load->model('departments/Departments_model', 'departments');
		$this->load->model('notifications/Notifications_model', 'notifications');

		//load libraries
		$this->load->library('encryption');

		$this->sir->manage_session();
	}

	public function index()
	{

		$this->sir_session->clear_status_message();
		$PageTitle = "All Quotes";

		$quotes = $this->quotes->get_all_quotes();

		$data = array(
			"page_title" => $PageTitle,
			'quotes' => $quotes
			);

		$this->load->view('quotes/list_quotes', $data);
	}

	public function view_quote($quote_id)
	{
		$this->sir_session->clear_status_message();
		$PageTitle = "Invoice";

		$quote = $this->quotes->get_quote_by_id($quote_id);
		$bill_to_address = $this->sir->get_settings_by_slug('bill_to');
		//echo "<pre>";print_r($quote[0]);exit;
		$address = $this->clients->get_client_address_by_id($quote[0]["client_id"]);
		$company_address_top = $this->sir->get_settings_by_slug('address_for_forms');

		$company_address = $this->sir->get_settings_by_slug('invoice_address_layout');
		$company_name = $this->sir->get_settings_by_slug('company_name_invoice');

		if( !empty( $address ) ){
			$address_string = ( $address[0]['address_line_1'] != null || $address[0]['address_line_1'] != '' ) ? $address[0]['address_line_1'] . '<br/>' : '';
			$address_string .= ( $address[0]['address_line_2'] != null || $address[0]['address_line_2'] != '' ) ? $address[0]['address_line_2'] . '<br/>' : '';
			$address_string .= ( $address[0]['city'] != null || $address[0]['city'] != '' ) ? $address[0]['city'] . '<br/>' : '';
			$address_string .= ( $address[0]['state'] != null || $address[0]['state'] != '' ) ? $address[0]['state'] . '<br/>' : '';
			$address_string .= ( $address[0]['zip'] != null || $address[0]['zip'] != '' ) ? $address[0]['zip'] . '<br/>' : '';
		}

		$data = array(
			"page_title" => $PageTitle,
			'quote' => $quote[0],
			"client_address" => $address_string,
			"bill_to_address" => $bill_to_address[0]['settings_value'],
			"company_address_top" => $company_address_top[0]["settings_value"],
			"company_name" => $company_name[0]["settings_value"],
			"company_address" => $company_address[0]["settings_value"]
			);

		$this->load->view('quotes/view_quote', $data);
	}

	public function edit_quote($quote_id){
		$PageTitle = "Edit Invoice";

		$quote = $this->quotes->get_quote_by_id($quote_id);

		if( empty( $quote ) ){
			show_error("Sorry, unable to retrieve the Invoice", 404, "Error Retrieving Record");
		} else {
			$bill_to_address = $this->sir->get_settings_by_slug('bill_to');
			//echo "<pre>";print_r($quote[0]);exit;
			$address = $this->clients->get_client_address_by_id($quote[0]["client_id"]);
			$company_address = $this->sir->get_settings_by_slug('invoice_address_layout');
			$clients = $this->clients->get_all_clients();
			$company_name = $this->sir->get_settings_by_slug('company_name_invoice');

			$client_id = $quote[0]["client_id"];
			$client = $this->clients->get_client_by_id( $client_id );

			if( !empty( $address ) ){
				$address_string = ( $address[0]['address_line_1'] != null || $address[0]['address_line_1'] != '' ) ? $address[0]['address_line_1'] . '<br/>' : '';
				$address_string .= ( $address[0]['address_line_2'] != null || $address[0]['address_line_2'] != '' ) ? $address[0]['address_line_2'] . '<br/>' : '';
				$address_string .= ( $address[0]['city'] != null || $address[0]['city'] != '' ) ? $address[0]['city'] . '<br/>' : '';
				$address_string .= ( $address[0]['state'] != null || $address[0]['state'] != '' ) ? $address[0]['state'] . '<br/>' : '';
				$address_string .= ( $address[0]['zip'] != null || $address[0]['zip'] != '' ) ? $address[0]['zip'] . '<br/>' : '';
			}

			$data = array(
				"page_title" => $PageTitle,
				'quote' => $quote[0],
				"client_address" => $address_string,
				"bill_to_address" => $bill_to_address[0]['settings_value'],
				"company_address" => $company_address[0]["settings_value"],
				"clients" => $clients,
				"quote_id" => $quote_id,
				"company_name" => $company_name[0]["settings_value"]
				);

			$this->load->view('quotes/edit_quote', $data);
		}		
	}

	public function do_edit_quote(){
		//echo "<pre>";print_r($this->input->post());exit;
		$quote_id = $this->input->post("quote-id");
		$items_string = "";
		$client_id = $this->input->post("client-id");
		$quote_no = $this->input->post("quote_no");
		//$placed_by = $this->input->post("placed-by");
		//$approved_by = $this->input->post("approved-by");
		$no_of_items = $this->input->post("no_of_items");
		$total_cost = $this->input->post("total_cost");

		if( $no_of_items > 0 )
		{
			$counter = 0;
			$row = array();
			$quote_record = array();
			for($i = 1; $i <= $no_of_items; $i++)
			{
				$qty = $this->input->post("qty-" . $i);
				$desc = $this->input->post("desc-" . $i);
				$price = $this->input->post("price-" . $i);
				$extn = $this->input->post("extn-" . $i);

				if( !empty($qty)  ){ //&& !empty($price)
					$row["qty"] = $qty;
					$row["desc"] = $desc;
					$row["price"] = $price;
					$row["extn"] = $extn;

					array_push($quote_record, $row);

					unset($row);
					$counter++;
				}
			}

			$quote_details = json_encode($quote_record);
			//echo "<pre>";print_r($quote_record);exit;

			$data = array(
				"client_id" => $client_id,
				"quote_details" => $quote_details,
				"quote_total_amount" => $total_cost
			);

			try{
				$this->quotes->update_quote($data, $quote_id);

				$old_quote_data = $this->quotes->get_quote_by_id($quote_id);

				try{
					$this->logger->add_log(29, $this->session->userdata("user_id"), json_encode($old_quote_data), json_encode($data));
				} catch(Exception $x){
					$this->xxx->log_exception( $x->getMessage() );
				}
				
				$this->sir_session->add_status_message("Your Quote has been updated successfully!", "success");
			} catch( Exception $e ){
				$this->xxx->log_exception( $e->getMessage() );
				$this->sir_session->add_status_message("Sorry, your Quote was not updated successfully!", "danger");
			}

			redirect("/Quotes/edit_quote/" . $quote_id);
		}
	}
}