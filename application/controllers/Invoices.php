<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoices extends CI_Controller {

	function __construct(){
		parent::__construct();

		//load models
		$this->load->model('sir/Sir_model', 'sir');
		$this->load->model('log/SirLog_model', 'logger');
		$this->load->model('purchase_orders/PO_model', 'po');
		$this->load->model('users/Users_model', 'sir_users');
		$this->load->model('clients/Clients_model', 'clients');
		$this->load->model('invoices/Invoice_model', 'invoice');
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
		$PageTitle = "All Invoices";

		$invoices = $this->invoice->get_all_invoices();

		$data = array(
			"page_title" => $PageTitle,
			'invoices' => $invoices
			);

		$this->load->view('invoices/list_invoices', $data);
	}

	public function view_invoice($invoice_id)
	{
		$this->sir_session->clear_status_message();
		$PageTitle = "Invoice";

		$invoice = $this->invoice->get_invoice_by_id($invoice_id);
		$bill_to_address = $this->sir->get_settings_by_slug('bill_to');
		//echo "<pre>";print_r($invoice[0]);exit;
		$address = $this->clients->get_client_address_by_id($invoice[0]["client_id"]);
		$company_address_top = $this->sir->get_settings_by_slug('address_for_forms');

		$company_address = $this->sir->get_settings_by_slug('invoice_address_layout');
		$company_name = $this->sir->get_settings_by_slug('company_name_invoice');

		$headings = $this->invoice->get_invoice_headings();
			$extra_heading = array(
				"heading_id" => 0,
				"heading_title" => "invoice_details",
				"for_ba" => 0,
				"for_iwsc" => 1,
				"heading_order" => null
			);
			array_push($headings, $extra_heading);

		$invoice_headings = $this->invoice->get_invoice_headings();

		if( !empty( $address ) ){
			$address_string = ( $address[0]['address_line_1'] != null || $address[0]['address_line_1'] != '' ) ? $address[0]['address_line_1'] . '<br/>' : '';
			$address_string .= ( $address[0]['address_line_2'] != null || $address[0]['address_line_2'] != '' ) ? $address[0]['address_line_2'] . '<br/>' : '';
			$address_string .= ( $address[0]['city'] != null || $address[0]['city'] != '' ) ? $address[0]['city'] . '<br/>' : '';
			$address_string .= ( $address[0]['state'] != null || $address[0]['state'] != '' ) ? $address[0]['state'] . '<br/>' : '';
			$address_string .= ( $address[0]['zip'] != null || $address[0]['zip'] != '' ) ? $address[0]['zip'] . '<br/>' : '';
		}

		$data = array(
			"page_title" => $PageTitle,
			'invoice' => $invoice[0],
			"client_address" => $address_string,
			"headings" => $headings,
			"bill_to_address" => $bill_to_address[0]['settings_value'],
			"company_address_top" => $company_address_top[0]["settings_value"],
			"company_name" => $company_name[0]["settings_value"],
			"company_address" => $company_address[0]["settings_value"]
			);

		$this->load->view('invoices/view_invoice', $data);
	}

	public function edit_invoice($invoice_id){
		$PageTitle = "Edit Invoice";

		$invoice = $this->invoice->get_invoice_by_id($invoice_id);

		if( empty( $invoice ) ){
			show_error("Sorry, unable to retrieve the Invoice", 404, "Error Retrieving Record");
		} else {
			$client_id = $invoice[0]["client_id"];
			$bill_to_address = $this->sir->get_settings_by_slug('bill_to');
			
			$address = $this->clients->get_client_address_by_id($invoice[0]["client_id"]);
			$company_address = $this->sir->get_settings_by_slug('invoice_address_layout');
			$clients = $this->clients->get_all_clients();
			$company_name = $this->sir->get_settings_by_slug('company_name_invoice');
			$client_routes = $this->clients->get_client_routes_types($client_id);
			$headings = $this->invoice->get_invoice_headings();
			$extra_heading = array(
				"heading_id" => 0,
				"heading_title" => "invoice_details",
				"for_ba" => 0,
				"for_iwsc" => 1,
				"heading_order" => null
			);
			array_push($headings, $extra_heading);

			$invoice_headings = $this->invoice->get_invoice_headings();

			//echo "<pre>";print_r($client_routes);exit;

			//$client_id = $invoice[0]["client_id"];
			//$client = $this->client->get_client_by_id( $client_id );

			if( !empty( $address ) ){
				$address_string = ( $address[0]['address_line_1'] != null || $address[0]['address_line_1'] != '' ) ? $address[0]['address_line_1'] . '<br/>' : '';
				$address_string .= ( $address[0]['address_line_2'] != null || $address[0]['address_line_2'] != '' ) ? $address[0]['address_line_2'] . '<br/>' : '';
				$address_string .= ( $address[0]['city'] != null || $address[0]['city'] != '' ) ? $address[0]['city'] . '<br/>' : '';
				$address_string .= ( $address[0]['state'] != null || $address[0]['state'] != '' ) ? $address[0]['state'] . '<br/>' : '';
				$address_string .= ( $address[0]['zip'] != null || $address[0]['zip'] != '' ) ? $address[0]['zip'] . '<br/>' : '';
			}

			$data = array(
				"page_title" => $PageTitle,
				'invoice' => $invoice[0],
				"client_address" => $address_string,
				"bill_to_address" => $bill_to_address[0]['settings_value'],
				"company_address" => $company_address[0]["settings_value"],
				"clients" => $clients,
				"invoice_id" => $invoice_id,
				"headings" => $headings,
				"client_routes" => $client_routes,
				"invoice_headings" => $invoice_headings,
				"company_name" => $company_name[0]["settings_value"]
				);

			$this->load->view('invoices/edit_invoice', $data);
		}		
	}

	public function do_edit_invoice(){
		//echo "<pre>";print_r($this->input->post());exit;
		$temp_array = $_POST;

		//remove items from array
		unset( $temp_array['invoice_no'] );
		unset( $temp_array['flight-date'] );
		unset( $temp_array['tail-no'] );
		unset( $temp_array['disbursement-no'] );
		unset( $temp_array['client-id'] );
		unset( $temp_array['client-routes-types'] );
		unset( $temp_array['currency-id'] );
		//unset( $temp_array['flight-quantity'] );
		unset( $temp_array['heading_id'] );
		unset( $temp_array['desc'] );
		//unset( $temp_array['flt-qty-pctg'] );
		unset( $temp_array['qty'] );
		unset( $temp_array['price'] );
		unset( $temp_array['extn'] );
		unset( $temp_array['base_total'] );
		unset( $temp_array['alternate_total_value'] );
		unset( $temp_array['base_service_charge'] );
		unset( $temp_array['alternate_service_charge'] );
		unset( $temp_array['grand_base_total'] );
		unset( $temp_array['grand_alternate_total_value'] );
		unset( $temp_array['no_of_items'] );
		unset( $temp_array['invoice-id'] );

		//echo "<pre>";print_r($temp_array);exit;

		$items_string = "";
		$invoice_id = $this->input->post("invoice-id");
		$items_string = "";
		$client_id = $this->input->post("client-id");
		$invoice_no = $this->input->post("invoice_no");
		$flight_date = ($this->input->post("flight-date") == null) ? date("Y-m-d") : date("Y-m-d", strtotime($this->input->post("flight-date")));
		$disbursement_no = $this->input->post("disbursement-no");
		$tail_no = $this->input->post("tail-no");
		$no_of_items = $this->input->post("no_of_items");
		$total_cost = $this->input->post("base_total");
		$base_currency = $this->input->post("currency-id");
		$service_charge = $this->input->post("base_service_charge");
		$grand_base_total = $this->input->post("grand_base_total");
		$routes_type_id = $this->input->post("client-routes-types");
		$calculated_total_cost = 0;		

		$crew_items = $passenger_items = $main_invoice_items = array();

		$temp_row = array();
		$record_counter = 1; //used to count record pairs: desc and qty

		$old_invoice_data = $this->invoice->get_invoice_by_id($invoice_id);

		foreach ($temp_array as $key => $value) {
			//echo "<pre>";print_r($key);
			//echo "<pre>";print_r($value);exit;

			if( $value != null ){ //only do operation if there is a value for a description or qty
				$key_parts = explode("-", $key);

				$section_id = $key_parts[0];

				if( $record_counter == 1 ){
					$temp_row["qty"] = $value;
					$record_counter++;	
				} else if( $record_counter == 2 ){
					$temp_row["desc"] = $value;
					$record_counter++;	
				} else if($record_counter == 3){
					$temp_row["price"] = $value;
					$record_counter++;
				} else if($record_counter == 4){
					$temp_row["extn"] = $value;					

					switch ($section_id) {
						case 0:
							array_push($main_invoice_items, $temp_row);
							unset($temp_row);
						$record_counter = 1;
							break;

						case 1:
							array_push($passenger_items, $temp_row);
							unset($temp_row);
						$record_counter = 1;
							break;

						case 2:
							array_push($crew_items, $temp_row);
							unset($temp_row);
						$record_counter = 1;
							break;						
						
						default:
							# code...
							break;
//echo "<pre>";print_r($temp_row);exit;
						
					} //end of case
				}				
			} //end of check for empty $value variable
		}  //end of foreach loop

		/*if( str_replace(",", "", $total_cost) != str_replace(",", "", $calculated_total_cost) ){
			$total_cost = str_replace(",", "", $calculated_total_cost);
		} else {
			$total_cost = str_replace(",", "", $total_cost);
		}*/

		$data = array(
			"client_id" => $client_id,
			"routes_type_id" => $routes_type_id,
			'tail_no' => trim($tail_no),
			"flight_date" => $flight_date,
			"disbursement_no" => $disbursement_no,
			"invoice_details" => json_encode($main_invoice_items),
			"crew_details" => json_encode($crew_items),
			"passenger_details" => json_encode($passenger_items),
			"invoice_total_amount" => str_replace(",", "", $total_cost),
			"currency_id" => $base_currency,
			"service_charge_amount" => str_replace(",", "", $service_charge),
			"grand_total_amount" => str_replace(",", "", $grand_base_total)
		);

		//echo "<pre>";print_r($data);exit;

		try{
			$this->invoice->update_invoice($data, $invoice_id);

			try{
				$this->logger->add_log(28, $this->session->userdata("user_id"), json_encode($old_invoice_data), json_encode($data));
			} catch(Exception $x){
				$this->xxx->log_exception( $x->getMessage() );
			}
			
			$this->sir_session->add_status_message("Your Invoice has been updated successfully!", "success");
		} catch( Exception $e ){
			$this->xxx->log_exception( $e->getMessage() );
			$this->sir_session->add_status_message("Sorry, your Invoice was not updated successfully!", "danger");
		}

		redirect("/Invoices/edit_invoice/" . $invoice_id);
		
	}

	public function duplicate_invoice($invoice_id){
		$PageTitle = "Creating Invoice from Duplicate";

		$invoice = $this->invoice->get_invoice_by_id($invoice_id);

		if( empty( $invoice ) ){
			show_error("Sorry, unable to retrieve the Invoice", 404, "Error Retrieving Record");
		} else {
			$bill_to_address = $this->sir->get_settings_by_slug('bill_to');
			//echo "<pre>";print_r($invoice[0]);exit;
			$address = $this->clients->get_client_address_by_id($invoice[0]["client_id"]);
			$company_address = $this->sir->get_settings_by_slug('invoice_address_layout');
			$clients = $this->clients->get_all_clients();
			$company_name = $this->sir->get_settings_by_slug('company_name_invoice');
			$next_invoice_no = $this->sir->get_next_invoice_no();

			//$client_id = $invoice[0]["client_id"];
			//$client = $this->client->get_client_by_id( $client_id );
			//echo $next_invoice_no[0]['next_invoice_no'];exit;

			if( !empty( $address ) ){
				$address_string = ( $address[0]['address_line_1'] != null || $address[0]['address_line_1'] != '' ) ? $address[0]['address_line_1'] . '<br/>' : '';
				$address_string .= ( $address[0]['address_line_2'] != null || $address[0]['address_line_2'] != '' ) ? $address[0]['address_line_2'] . '<br/>' : '';
				$address_string .= ( $address[0]['city'] != null || $address[0]['city'] != '' ) ? $address[0]['city'] . '<br/>' : '';
				$address_string .= ( $address[0]['state'] != null || $address[0]['state'] != '' ) ? $address[0]['state'] . '<br/>' : '';
				$address_string .= ( $address[0]['zip'] != null || $address[0]['zip'] != '' ) ? $address[0]['zip'] . '<br/>' : '';
			}

			$data = array(
				"page_title" => $PageTitle,
				'invoice' => $invoice[0],
				"client_address" => $address_string,
				"bill_to_address" => $bill_to_address[0]['settings_value'],
				"company_address" => $company_address[0]["settings_value"],
				"clients" => $clients,
				"next_invoice_no" => $next_invoice_no[0]['next_invoice_no'],
				"invoice_id" => $invoice_id,
				"company_name" => $company_name[0]["settings_value"]
				);

			$this->load->view('invoices/duplicate_invoice', $data);
		}		
	}

	public function do_duplicate_invoice(){
		//echo "<pre>";print_r($this->input->post());exit;
		$invoice_id = $this->input->post("invoice-id");
		$items_string = "";
		$client_id = $this->input->post("client-id");
		$invoice_no = $this->input->post("invoice_no");
		$flight_date = ($this->input->post("flight-date") == null) ? date("Y-m-d") : date("Y-m-d", strtotime($this->input->post("flight-date")));
		$disbursement_no = $this->input->post("disbursement-no");
		$tail_no = $this->input->post("tail-no");
		$no_of_items = $this->input->post("no_of_items");
		$total_cost = $this->input->post("base_total");
		$base_currency = $this->input->post("currency-id");
		$calculated_total_cost = 0;

		if( $no_of_items > 0 )
		{
			$counter = 0;
			$row = array();
			$invoice_record = array();
			for($i = 1; $i <= $no_of_items; $i++)
			{
				$qty = $this->input->post("qty-" . $i);
				$desc = $this->input->post("desc-" . $i);
				$price = $this->input->post("price-" . $i);
				$extn = $this->input->post("extn-" . $i);

				$calculated_total_cost += $extn;

				if( !empty($qty)  ){ //&& !empty($price)
					$row["qty"] = $qty;
					$row["desc"] = $desc;
					$row["price"] = $price;
					$row["extn"] = $extn;

					array_push($invoice_record, $row);

					unset($row);
					$counter++;
				}
			}

			//echo "<pre>";print_r($invoice_record);exit;

			$invoice_details = json_encode($invoice_record);
			

			if( str_replace(",", "", $total_cost) != str_replace(",", "", $calculated_total_cost) ){
				$total_cost = str_replace(",", "", $calculated_total_cost);
			} else {
				$total_cost = str_replace(",", "", $total_cost);
			}

			$data = array(
				"invoice_no" => $invoice_no,
				"client_id" => $client_id,
				"invoice_date" => date("Y-m-d"),
				'tail_no' => trim($tail_no),
				"flight_date" => $flight_date,
				"disbursement_no" => $disbursement_no,
				"invoice_details" => $invoice_details,
				"invoice_total_amount" => $total_cost,
				"currency_id" => $base_currency,
				"created_by_employee_id" => $this->session->userdata("user_id")
			);

			//echo "<pre>";print_r($data);exit;

			try{
				$this->invoice->insert_invoice($data);
				$last_inserted_id = $this->sir->get_last_insert_key_for_table( "invoices", "invoice_id" );
				$this->invoice->increment_invoice_seq_no();

				$old_invoice_data = $this->invoice->get_invoice_by_id($invoice_id);

				try{
					$this->logger->add_log(32, $this->session->userdata("user_id"), json_encode($old_invoice_data), json_encode($data));
				} catch(Exception $x){
					$this->xxx->log_exception( $x->getMessage() );
				}
				
				$this->sir_session->add_status_message("Your Invoice has been created successfully!", "success");
			} catch( Exception $e ){
				$this->xxx->log_exception( $e->getMessage() );
				$this->sir_session->add_status_message("Sorry, your Invoice was not created successfully!", "danger");
			}

			redirect("/Invoices/duplicate_invoice/" . $last_inserted_id);
		}
	}

	////////////////////////// ba type invoices //////////////////////////////////

	public function list_ba_type_invoices()
	{

		$this->sir_session->clear_status_message();
		$PageTitle = "All BA Type Invoices";

		$invoices = $this->invoice->get_all_ba_type_invoices();

		$data = array(
			"page_title" => $PageTitle,
			'invoices' => $invoices
			);

		$this->load->view('invoices/list_ba_type_invoices', $data);
	}

	public function view_ba_type_invoice($invoice_id)
	{
		$this->sir_session->clear_status_message();
		$PageTitle = "Invoice";

		$invoice = $this->invoice->get_ba_type_invoice_by_id($invoice_id);
		$bill_to_address = $this->sir->get_settings_by_slug('bill_to');
		//echo "<pre>";print_r($invoice[0]);exit;
		$address = $this->clients->get_client_address_by_id($invoice[0]["client_id"]);
		$company_address_top = $this->sir->get_settings_by_slug('address_for_forms');

		$company_address = $this->sir->get_settings_by_slug('invoice_address_layout');
		$company_name = $this->sir->get_settings_by_slug('company_name_invoice');

		$headings = $this->invoice->get_ba_invoice_headings();

		if( !empty( $address ) ){
			$address_string = ( $address[0]['address_line_1'] != null || $address[0]['address_line_1'] != '' ) ? $address[0]['address_line_1'] . '<br/>' : '';
			$address_string .= ( $address[0]['address_line_2'] != null || $address[0]['address_line_2'] != '' ) ? $address[0]['address_line_2'] . '<br/>' : '';
			$address_string .= ( $address[0]['city'] != null || $address[0]['city'] != '' ) ? $address[0]['city'] . '<br/>' : '';
			$address_string .= ( $address[0]['state'] != null || $address[0]['state'] != '' ) ? $address[0]['state'] . '<br/>' : '';
			$address_string .= ( $address[0]['zip'] != null || $address[0]['zip'] != '' ) ? $address[0]['zip'] . '<br/>' : '';
		}

		$data = array(
			"page_title" => $PageTitle,
			'invoice' => $invoice[0],
			"client_address" => $address_string,
			"headings" => $headings,
			"bill_to_address" => $bill_to_address[0]['settings_value'],
			"company_address_top" => $company_address_top[0]["settings_value"],
			"company_name" => $company_name[0]["settings_value"],
			"company_address" => $company_address[0]["settings_value"]
			);

		$this->load->view('invoices/view_ba_type_invoice', $data);
	}

	public function edit_ba_type_invoice($invoice_id){
		$PageTitle = "Edit Invoice (BA Type)";

		$invoice = $this->invoice->get_ba_type_invoice_by_id($invoice_id);

		if( empty( $invoice ) ){
			show_error("Sorry, unable to retrieve the Invoice", 404, "Error Retrieving Record");
		} else {
			$client_id = $invoice[0]["client_id"];
			$bill_to_address = $this->sir->get_settings_by_slug('bill_to');
			
			$address = $this->clients->get_client_address_by_id($invoice[0]["client_id"]);
			$company_address = $this->sir->get_settings_by_slug('invoice_address_layout');
			$clients = $this->clients->get_all_clients();
			$company_name = $this->sir->get_settings_by_slug('company_name_invoice');
			$client_routes = $this->clients->get_client_routes_types($client_id);
			$headings = $this->invoice->get_ba_invoice_headings();
			/*$extra_heading = array(
				"heading_id" => 0,
				"heading_title" => "invoice_details",
				"for_ba" => 0,
				"for_iwsc" => 1,
				"heading_order" => null
			);
			array_push($headings, $extra_heading);*/

			$invoice_headings = $this->invoice->get_ba_invoice_headings();

			//echo "<pre>";print_r($client_routes);exit;

			//$client_id = $invoice[0]["client_id"];
			//$client = $this->client->get_client_by_id( $client_id );

			if( !empty( $address ) ){
				$address_string = ( $address[0]['address_line_1'] != null || $address[0]['address_line_1'] != '' ) ? $address[0]['address_line_1'] . '<br/>' : '';
				$address_string .= ( $address[0]['address_line_2'] != null || $address[0]['address_line_2'] != '' ) ? $address[0]['address_line_2'] . '<br/>' : '';
				$address_string .= ( $address[0]['city'] != null || $address[0]['city'] != '' ) ? $address[0]['city'] . '<br/>' : '';
				$address_string .= ( $address[0]['state'] != null || $address[0]['state'] != '' ) ? $address[0]['state'] . '<br/>' : '';
				$address_string .= ( $address[0]['zip'] != null || $address[0]['zip'] != '' ) ? $address[0]['zip'] . '<br/>' : '';
			}

			$data = array(
				"page_title" => $PageTitle,
				'invoice' => $invoice[0],
				"client_address" => $address_string,
				"bill_to_address" => $bill_to_address[0]['settings_value'],
				"company_address" => $company_address[0]["settings_value"],
				"clients" => $clients,
				"invoice_id" => $invoice_id,
				"headings" => $headings,
				"client_routes" => $client_routes,
				"invoice_headings" => $invoice_headings,
				"company_name" => $company_name[0]["settings_value"]
				);

			$this->load->view('invoices/edit_ba_type_invoice', $data);
		}		
	}

	public function do_edit_ba_type_invoice(){
		//echo "<pre>";print_r($this->input->post());exit;
		$temp_array = $_POST;

		//remove items from array
		unset( $temp_array['invoice-id'] );
		unset( $temp_array['invoice_no'] );
		unset( $temp_array['flight-date'] );
		unset( $temp_array['tail-no'] );
		unset( $temp_array['disbursement-no'] );
		unset( $temp_array['client-id'] );
		unset( $temp_array['client-routes-types'] );
		unset( $temp_array['currency-id'] );
		unset( $temp_array['flight-quantity'] );
		unset( $temp_array['heading_id'] );
		unset( $temp_array['desc'] );
		unset( $temp_array['flt-qty-pctg'] );
		unset( $temp_array['qty'] );
		unset( $temp_array['price'] );
		unset( $temp_array['extn'] );
		unset( $temp_array['base_total'] );
		unset( $temp_array['alternate_total_value'] );
		unset( $temp_array['base_service_charge'] );
		unset( $temp_array['alternate_service_charge'] );
		unset( $temp_array['grand_base_total'] );
		unset( $temp_array['grand_alternate_total_value'] );
		unset( $temp_array['no_of_items'] );
		unset( $temp_array['invoice-id'] );

		//echo "<pre>";print_r($temp_array);exit;

		$items_string = "";
		$invoice_id = $this->input->post("invoice-id");
		$items_string = "";
		$client_id = $this->input->post("client-id");
		$invoice_no = $this->input->post("invoice_no");
		$flight_date = ($this->input->post("flight-date") == null) ? date("Y-m-d") : date("Y-m-d", strtotime($this->input->post("flight-date")));
		$disbursement_no = $this->input->post("disbursement-no");
		$tail_no = $this->input->post("tail-no");
		$no_of_items = $this->input->post("no_of_items");
		$total_cost = $this->input->post("base_total");
		$base_currency = $this->input->post("currency-id");
		$service_charge = $this->input->post("base_service_charge");
		$grand_base_total = $this->input->post("grand_base_total");
		$routes_type_id = $this->input->post("client-routes-types");
		$calculated_total_cost = 0;		
		$flight_quantity = $this->input->post("flight-quantity");

		$breakfast_items = $entree_items = $cabin_crew_items = $misc_items =
		$wtp_items = $wt_items = $cw_items = $retro_items = $ii_items = $tech_crew_items = array();

		$temp_row = array();
		$record_counter = 1; //used to count record pairs: desc and qty

		$old_invoice_data = $this->invoice->get_ba_type_invoice_by_id($invoice_id);

		foreach ($temp_array as $key => $value) {
			//echo "<pre>";print_r($key);
			//echo "<pre>";print_r($value);exit;

			if( $value != null ){ //only do operation if there is a value for a description or qty
				$key_parts = explode("-", $key);

				$section_id = $key_parts[0];

				if( $record_counter == 1 ){
					$temp_row["desc"] = $value;
					$record_counter++;	
				} else if( $record_counter == 2 ){
					$temp_row["percentage"] = $value;
					$record_counter++;	
				} else if($record_counter == 3){
					$temp_row["qty"] = $value;
					$record_counter++;
				} else if($record_counter == 4){
					$temp_row["price"] = $value;
					$record_counter++;
				} else if( $record_counter == 5 ){
					$temp_row["extn"] = $value;

					switch ($section_id) {
						case 3:
							array_push($wtp_items, $temp_row);
							unset($temp_row);
						$record_counter = 1;
							break;

						case 4:
							array_push($wt_items, $temp_row);
							unset($temp_row);
						$record_counter = 1;
							break;

						case 5:
							array_push($cw_items, $temp_row);
							unset($temp_row);
						$record_counter = 1;
							break;

						case 6:
							array_push($retro_items, $temp_row);
							unset($temp_row);
						$record_counter = 1;
							break;

						case 7:
							array_push($breakfast_items, $temp_row);
							unset($temp_row);
						$record_counter = 1;
							break;

						case 8:
							array_push($entree_items, $temp_row);
							unset($temp_row);
						$record_counter = 1;
							break;

						case 9:
							array_push($ii_items, $temp_row);
							unset($temp_row);
						$record_counter = 1;
							break;

						case 10:
							array_push($tech_crew_items, $temp_row);
							unset($temp_row);
						$record_counter = 1;
							break;

						case 11:
							array_push($cabin_crew_items, $temp_row);
							unset($temp_row);
						$record_counter = 1;
							break;

						case 12:
							array_push($misc_items, $temp_row);
							unset($temp_row);
						$record_counter = 1;
							break;
						
						default:
							# code...
							break;
//echo "<pre>";print_r($temp_row);exit;
						
					} //end of case
				}				
			} //end of check for empty $value variable
		}  //end of foreach loop

		/*if( str_replace(",", "", $total_cost) != str_replace(",", "", $calculated_total_cost) ){
			$total_cost = str_replace(",", "", $calculated_total_cost);
		} else {
			$total_cost = str_replace(",", "", $total_cost);
		}*/

		$data = array(
			"client_id" => $client_id,
			"routes_type_id" => $routes_type_id,
			'tail_no' => trim($tail_no),
			"flight_date" => $flight_date,
			"flt_qty" => $flight_quantity,
			"disbursement_no" => $disbursement_no,
			"cc_details" => json_encode($cabin_crew_items),
			"cw_details" => json_encode($cw_items),
			"entree_details" => json_encode($entree_items),
			"ii_details" => json_encode($ii_items),
			"retro_details" => json_encode($retro_items),
			"wt_details" => json_encode($wt_items),
			"wtp_details" => json_encode($wtp_items),
			"misc_details" => json_encode($misc_items),
			"bf_details" => json_encode($breakfast_items),
			"tech_crew_details" => json_encode($tech_crew_items),
			"invoice_total_amount" => str_replace(",", "", $total_cost),
			"currency_id" => $base_currency,
			"service_charge_amount" => str_replace(",", "", $service_charge),
			"grand_total_amount" => str_replace(",", "", $grand_base_total)
		);

		//echo "<pre>";print_r($data);exit;

		try{
			$this->invoice->update_ba_type_invoice($data, $invoice_id);

			try{
				$this->logger->add_log(28, $this->session->userdata("user_id"), json_encode($old_invoice_data), json_encode($data));
			} catch(Exception $x){
				$this->xxx->log_exception( $x->getMessage() );
			}
			
			$this->sir_session->add_status_message("Your Invoice has been updated successfully!", "success");
		} catch( Exception $e ){
			$this->xxx->log_exception( $e->getMessage() );
			$this->sir_session->add_status_message("Sorry, your Invoice was not updated successfully!", "danger");
		}

		redirect("/Invoices/edit_ba_type_invoice/" . $invoice_id);
		
	}

	public function duplicate_ba_type_invoice($invoice_id){
		$PageTitle = "Creating Invoice from Duplicate";

		$invoice = $this->invoice->get_ba_type_invoice_by_id($invoice_id);

		if( empty( $invoice ) ){
			show_error("Sorry, unable to retrieve the Invoice", 404, "Error Retrieving Record");
		} else {
			$bill_to_address = $this->sir->get_settings_by_slug('bill_to');
			//echo "<pre>";print_r($invoice[0]);exit;
			$client_id = $invoice[0]["client_id"];
			$address = $this->clients->get_client_address_by_id($client_id);
			$company_address = $this->sir->get_settings_by_slug('invoice_address_layout');
			$clients = $this->clients->get_all_clients();
			$company_name = $this->sir->get_settings_by_slug('company_name_invoice');
			$next_invoice_no = $this->sir->get_next_ba_type_invoice_no();
			$headings = $this->invoice->get_ba_invoice_headings();
			$client_routes = $this->clients->get_client_routes_types($client_id);

			//$client_id = $invoice[0]["client_id"];
			//$client = $this->client->get_client_by_id( $client_id );
			//echo $next_invoice_no[0]['next_invoice_no'];exit;

			if( !empty( $address ) ){
				$address_string = ( $address[0]['address_line_1'] != null || $address[0]['address_line_1'] != '' ) ? $address[0]['address_line_1'] . '<br/>' : '';
				$address_string .= ( $address[0]['address_line_2'] != null || $address[0]['address_line_2'] != '' ) ? $address[0]['address_line_2'] . '<br/>' : '';
				$address_string .= ( $address[0]['city'] != null || $address[0]['city'] != '' ) ? $address[0]['city'] . '<br/>' : '';
				$address_string .= ( $address[0]['state'] != null || $address[0]['state'] != '' ) ? $address[0]['state'] . '<br/>' : '';
				$address_string .= ( $address[0]['zip'] != null || $address[0]['zip'] != '' ) ? $address[0]['zip'] . '<br/>' : '';
			}

			$data = array(
				"page_title" => $PageTitle,
				'invoice' => $invoice[0],
				"client_address" => $address_string,
				"bill_to_address" => $bill_to_address[0]['settings_value'],
				"company_address" => $company_address[0]["settings_value"],
				"clients" => $clients,
				"client_routes" => $client_routes,
				"headings" => $headings,
				"next_invoice_no" => $next_invoice_no[0]['next_invoice_no'],
				"invoice_id" => $invoice_id,
				"company_name" => $company_name[0]["settings_value"]
				);

			$this->load->view('invoices/duplicate_ba_type_invoice', $data);
		}		
	}

	public function do_duplicate_ba_type_invoice(){
		//echo "<pre>";print_r($this->input->post());exit;
		$temp_array = $_POST;

		//remove items from array
		unset( $temp_array['invoice-id'] );
		unset( $temp_array['invoice_no'] );
		unset( $temp_array['flight-date'] );
		unset( $temp_array['tail-no'] );
		unset( $temp_array['disbursement-no'] );
		unset( $temp_array['client-id'] );
		unset( $temp_array['client-routes-types'] );
		unset( $temp_array['currency-id'] );
		unset( $temp_array['flight-quantity'] );
		unset( $temp_array['heading_id'] );
		unset( $temp_array['desc'] );
		unset( $temp_array['flt-qty-pctg'] );
		unset( $temp_array['qty'] );
		unset( $temp_array['price'] );
		unset( $temp_array['extn'] );
		unset( $temp_array['base_total'] );
		unset( $temp_array['alternate_total_value'] );
		unset( $temp_array['base_service_charge'] );
		unset( $temp_array['alternate_service_charge'] );
		unset( $temp_array['grand_base_total'] );
		unset( $temp_array['grand_alternate_total_value'] );
		unset( $temp_array['no_of_items'] );
		unset( $temp_array['invoice-id'] );

		//echo "<pre>";print_r($temp_array);exit;

		$items_string = "";
		$invoice_id = $this->input->post("invoice-id");
		$items_string = "";
		$client_id = $this->input->post("client-id");
		$invoice_no = $this->input->post("invoice_no");
		$flight_date = ($this->input->post("flight-date") == null) ? date("Y-m-d") : date("Y-m-d", strtotime($this->input->post("flight-date")));
		$disbursement_no = $this->input->post("disbursement-no");
		$tail_no = $this->input->post("tail-no");
		$no_of_items = $this->input->post("no_of_items");
		$total_cost = $this->input->post("base_total");
		$base_currency = $this->input->post("currency-id");
		$service_charge = $this->input->post("base_service_charge");
		$grand_base_total = $this->input->post("grand_base_total");
		$routes_type_id = $this->input->post("client-routes-types");
		$calculated_total_cost = 0;		
		$flight_quantity = $this->input->post("flight-quantity");

		$breakfast_items = $entree_items = $cabin_crew_items = $misc_items =
		$wtp_items = $wt_items = $cw_items = $retro_items = $ii_items = $tech_crew_items = array();

		$temp_row = array();
		$record_counter = 1; //used to count record pairs: desc and qty

		$old_invoice_data = $this->invoice->get_ba_type_invoice_by_id($invoice_id);

		foreach ($temp_array as $key => $value) {
			//echo "<pre>";print_r($key);
			//echo "<pre>";print_r($value);exit;

			if( $value != null ){ //only do operation if there is a value for a description or qty
				$key_parts = explode("-", $key);

				$section_id = $key_parts[0];

				if( $record_counter == 1 ){
					$temp_row["desc"] = $value;
					$record_counter++;	
				} else if( $record_counter == 2 ){
					$temp_row["percentage"] = $value;
					$record_counter++;	
				} else if($record_counter == 3){
					$temp_row["qty"] = $value;
					$record_counter++;
				} else if($record_counter == 4){
					$temp_row["price"] = $value;
					$record_counter++;
				} else if( $record_counter == 5 ){
					$temp_row["extn"] = $value;

					switch ($section_id) {
						case 3:
							array_push($wtp_items, $temp_row);
							unset($temp_row);
						$record_counter = 1;
							break;

						case 4:
							array_push($wt_items, $temp_row);
							unset($temp_row);
						$record_counter = 1;
							break;

						case 5:
							array_push($cw_items, $temp_row);
							unset($temp_row);
						$record_counter = 1;
							break;

						case 6:
							array_push($retro_items, $temp_row);
							unset($temp_row);
						$record_counter = 1;
							break;

						case 7:
							array_push($breakfast_items, $temp_row);
							unset($temp_row);
						$record_counter = 1;
							break;

						case 8:
							array_push($entree_items, $temp_row);
							unset($temp_row);
						$record_counter = 1;
							break;

						case 9:
							array_push($ii_items, $temp_row);
							unset($temp_row);
						$record_counter = 1;
							break;

						case 10:
							array_push($tech_crew_items, $temp_row);
							unset($temp_row);
						$record_counter = 1;
							break;

						case 11:
							array_push($cabin_crew_items, $temp_row);
							unset($temp_row);
						$record_counter = 1;
							break;

						case 12:
							array_push($misc_items, $temp_row);
							unset($temp_row);
						$record_counter = 1;
							break;
						
						default:
							# code...
							break;
//echo "<pre>";print_r($temp_row);exit;
						
					} //end of case
				}				
			} //end of check for empty $value variable
		}  //end of foreach loop

		/*if( str_replace(",", "", $total_cost) != str_replace(",", "", $calculated_total_cost) ){
			$total_cost = str_replace(",", "", $calculated_total_cost);
		} else {
			$total_cost = str_replace(",", "", $total_cost);
		}*/

		$data = array(
			"invoice_no" => $invoice_id,
			"invoice_date" => date("Y-m-d"),
			"client_id" => $client_id,
			"routes_type_id" => $routes_type_id,
			'tail_no' => trim($tail_no),
			"flight_date" => $flight_date,
			"flt_qty" => $flight_quantity,
			"disbursement_no" => $disbursement_no,
			"cc_details" => json_encode($cabin_crew_items),
			"cw_details" => json_encode($cw_items),
			"entree_details" => json_encode($entree_items),
			"ii_details" => json_encode($ii_items),
			"retro_details" => json_encode($retro_items),
			"wt_details" => json_encode($wt_items),
			"wtp_details" => json_encode($wtp_items),
			"misc_details" => json_encode($misc_items),
			"bf_details" => json_encode($breakfast_items),
			"tech_crew_details" => json_encode($tech_crew_items),
			"invoice_total_amount" => str_replace(",", "", $total_cost),
			"currency_id" => $base_currency,
			"service_charge_amount" => str_replace(",", "", $service_charge),
			"grand_total_amount" => str_replace(",", "", $grand_base_total),
			"created_by_employee_id" => $this->session->userdata("user_id")
		);

		//echo "<pre>";print_r($data);exit;

		try{
			$this->invoice->insert_ba_type_invoice($data);
			$last_inserted_id = $this->sir->get_last_insert_key_for_table( "ba_type_invoices", "invoice_id" );
			$this->invoice->increment_ba_type_invoice_seq_no();

			try{
				$this->logger->add_log(32, $this->session->userdata("user_id"), json_encode($old_invoice_data), json_encode($data));
			} catch(Exception $x){
				$this->xxx->log_exception( $x->getMessage() );
			}
			
			$this->sir_session->add_status_message("Your Invoice has been created successfully!", "success");
		} catch( Exception $e ){
			$this->xxx->log_exception( $e->getMessage() );
			$this->sir_session->add_status_message("Sorry, your Invoice was not created successfully!", "danger");
		}

		redirect("/Invoices/duplicate_ba_type_invoice/" . $last_inserted_id);
		
	}

	//////////////// basic invoice //////////////////////

	public function list_basic_invoices()
	{

		$this->sir_session->clear_status_message();
		$PageTitle = "All Invoices";

		$invoices = $this->invoice->get_all_basic_invoices();

		$data = array(
			"page_title" => $PageTitle,
			'invoices' => $invoices
			);

		$this->load->view('invoices/list_basic_invoices', $data);
	}

	public function view_basic_invoice($invoice_id)
	{
		$this->sir_session->clear_status_message();
		$PageTitle = "Invoice";

		$invoice = $this->invoice->get_basic_invoice_by_id($invoice_id);
		$bill_to_address = $this->sir->get_settings_by_slug('bill_to');
		//echo "<pre>";print_r($invoice[0]);exit;
		$address = $this->clients->get_client_address_by_id($invoice[0]["client_id"]);
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
			'invoice' => $invoice[0],
			"client_address" => $address_string,
			"bill_to_address" => $bill_to_address[0]['settings_value'],
			"company_address_top" => $company_address_top[0]["settings_value"],
			"company_name" => $company_name[0]["settings_value"],
			"company_address" => $company_address[0]["settings_value"]
			);

		$this->load->view('invoices/view_basic_invoice', $data);
	}

	public function edit_basic_invoice($invoice_id){
		$PageTitle = "Edit Invoice";

		$invoice = $this->invoice->get_basic_invoice_by_id($invoice_id);

		if( empty( $invoice ) ){
			show_error("Sorry, unable to retrieve the Invoice", 404, "Error Retrieving Record");
		} else {
			$bill_to_address = $this->sir->get_settings_by_slug('bill_to');
			//echo "<pre>";print_r($invoice[0]);exit;
			$address = $this->clients->get_client_address_by_id($invoice[0]["client_id"]);
			$company_address = $this->sir->get_settings_by_slug('invoice_address_layout');
			$clients = $this->clients->get_all_clients();
			$company_name = $this->sir->get_settings_by_slug('company_name_invoice');

			//$client_id = $invoice[0]["client_id"];
			//$client = $this->client->get_client_by_id( $client_id );

			if( !empty( $address ) ){
				$address_string = ( $address[0]['address_line_1'] != null || $address[0]['address_line_1'] != '' ) ? $address[0]['address_line_1'] . '<br/>' : '';
				$address_string .= ( $address[0]['address_line_2'] != null || $address[0]['address_line_2'] != '' ) ? $address[0]['address_line_2'] . '<br/>' : '';
				$address_string .= ( $address[0]['city'] != null || $address[0]['city'] != '' ) ? $address[0]['city'] . '<br/>' : '';
				$address_string .= ( $address[0]['state'] != null || $address[0]['state'] != '' ) ? $address[0]['state'] . '<br/>' : '';
				$address_string .= ( $address[0]['zip'] != null || $address[0]['zip'] != '' ) ? $address[0]['zip'] . '<br/>' : '';
			}

			$data = array(
				"page_title" => $PageTitle,
				'invoice' => $invoice[0],
				"client_address" => $address_string,
				"bill_to_address" => $bill_to_address[0]['settings_value'],
				"company_address" => $company_address[0]["settings_value"],
				"clients" => $clients,
				"invoice_id" => $invoice_id,
				"company_name" => $company_name[0]["settings_value"]
				);

			$this->load->view('invoices/edit_basic_invoice', $data);
		}		
	}

	public function do_edit_basic_invoice(){
		//echo "<pre>";print_r($this->input->post());exit;
		$invoice_id = $this->input->post("invoice-id");
		$items_string = "";
		$client_id = $this->input->post("client-id");
		$invoice_no = $this->input->post("invoice_no");
		$flight_date = ($this->input->post("flight-date") == null) ? date("Y-m-d") : date("Y-m-d", strtotime($this->input->post("flight-date")));
		$disbursement_no = $this->input->post("disbursement-no");
		$tail_no = $this->input->post("tail-no");
		$no_of_items = $this->input->post("no_of_items");
		$total_cost = $this->input->post("base_total");
		$base_currency = $this->input->post("currency-id");
		$calculated_total_cost = 0;

		$old_invoice_data = $this->invoice->get_basic_invoice_by_id($invoice_id);

		if( $no_of_items > 0 )
		{
			$counter = 0;
			$row = array();
			$invoice_record = array();
			for($i = 1; $i <= $no_of_items; $i++)
			{
				$qty = $this->input->post("qty-" . $i);
				$desc = $this->input->post("desc-" . $i);
				$price = $this->input->post("price-" . $i);
				$extn = $this->input->post("extn-" . $i);

				$calculated_total_cost += $extn;

				if( !empty($qty)  ){ //&& !empty($price)
					$row["qty"] = $qty;
					$row["desc"] = $desc;
					$row["price"] = $price;
					$row["extn"] = $extn;

					array_push($invoice_record, $row);

					unset($row);
					$counter++;
				}
			}

			//echo "<pre>";print_r($invoice_record);exit;

			$invoice_details = json_encode($invoice_record);
			

			if( str_replace(",", "", $total_cost) != str_replace(",", "", $calculated_total_cost) ){
				$total_cost = str_replace(",", "", $calculated_total_cost);
			} else {
				$total_cost = str_replace(",", "", $total_cost);
			}

			$data = array(
				"client_id" => $client_id,
				'tail_no' => trim($tail_no),
				"flight_date" => $flight_date,
				"disbursement_no" => $disbursement_no,
				"invoice_details" => $invoice_details,
				"invoice_total_amount" => $total_cost,
				"currency_id" => $base_currency
			);

			//echo "<pre>";print_r($data);exit;

			try{
				$this->invoice->update_basic_invoice($data, $invoice_id);

				try{
					$this->logger->add_log(28, $this->session->userdata("user_id"), json_encode($old_invoice_data), json_encode($data));
				} catch(Exception $x){
					$this->xxx->log_exception( $x->getMessage() );
				}
				
				$this->sir_session->add_status_message("Your Invoice has been updated successfully!", "success");
			} catch( Exception $e ){
				$this->xxx->log_exception( $e->getMessage() );
				$this->sir_session->add_status_message("Sorry, your Invoice was not updated successfully!", "danger");
			}

			redirect("/Invoices/edit_basic_invoice/" . $invoice_id);
		}
	}

	public function duplicate_basic_invoice($invoice_id){
		$PageTitle = "Creating Invoice from Duplicate";

		$invoice = $this->invoice->get_basic_invoice_by_id($invoice_id);

		if( empty( $invoice ) ){
			show_error("Sorry, unable to retrieve the Invoice", 404, "Error Retrieving Record");
		} else {
			$bill_to_address = $this->sir->get_settings_by_slug('bill_to');
			//echo "<pre>";print_r($invoice[0]);exit;
			$address = $this->clients->get_client_address_by_id($invoice[0]["client_id"]);
			$company_address = $this->sir->get_settings_by_slug('invoice_address_layout');
			$clients = $this->clients->get_all_clients();
			$company_name = $this->sir->get_settings_by_slug('company_name_invoice');
			$next_invoice_no = $this->sir->get_next_basic_invoice_no();

			//$client_id = $invoice[0]["client_id"];
			//$client = $this->client->get_client_by_id( $client_id );
			//echo $next_invoice_no[0]['next_invoice_no'];exit;

			if( !empty( $address ) ){
				$address_string = ( $address[0]['address_line_1'] != null || $address[0]['address_line_1'] != '' ) ? $address[0]['address_line_1'] . '<br/>' : '';
				$address_string .= ( $address[0]['address_line_2'] != null || $address[0]['address_line_2'] != '' ) ? $address[0]['address_line_2'] . '<br/>' : '';
				$address_string .= ( $address[0]['city'] != null || $address[0]['city'] != '' ) ? $address[0]['city'] . '<br/>' : '';
				$address_string .= ( $address[0]['state'] != null || $address[0]['state'] != '' ) ? $address[0]['state'] . '<br/>' : '';
				$address_string .= ( $address[0]['zip'] != null || $address[0]['zip'] != '' ) ? $address[0]['zip'] . '<br/>' : '';
			}

			$data = array(
				"page_title" => $PageTitle,
				'invoice' => $invoice[0],
				"client_address" => $address_string,
				"bill_to_address" => $bill_to_address[0]['settings_value'],
				"company_address" => $company_address[0]["settings_value"],
				"clients" => $clients,
				"next_invoice_no" => $next_invoice_no[0]['next_invoice_no'],
				"invoice_id" => $invoice_id,
				"company_name" => $company_name[0]["settings_value"]
				);

			$this->load->view('invoices/duplicate_basic_invoice', $data);
		}		
	}

	public function do_duplicate_basic_invoice(){
		//echo "<pre>";print_r($this->input->post());exit;
		$invoice_id = $this->input->post("invoice-id");
		$items_string = "";
		$client_id = $this->input->post("client-id");
		$invoice_no = $this->input->post("invoice_no");
		$flight_date = ($this->input->post("flight-date") == null) ? date("Y-m-d") : date("Y-m-d", strtotime($this->input->post("flight-date")));
		$disbursement_no = $this->input->post("disbursement-no");
		$tail_no = $this->input->post("tail-no");
		$no_of_items = $this->input->post("no_of_items");
		$total_cost = $this->input->post("base_total");
		$base_currency = $this->input->post("currency-id");
		$calculated_total_cost = 0;

		$old_invoice_data = $this->invoice->get_basic_invoice_by_id($invoice_id);

		if( $no_of_items > 0 )
		{
			$counter = 0;
			$row = array();
			$invoice_record = array();
			for($i = 1; $i <= $no_of_items; $i++)
			{
				$qty = $this->input->post("qty-" . $i);
				$desc = $this->input->post("desc-" . $i);
				$price = $this->input->post("price-" . $i);
				$extn = $this->input->post("extn-" . $i);

				$calculated_total_cost += $extn;

				if( !empty($qty)  ){ //&& !empty($price)
					$row["qty"] = $qty;
					$row["desc"] = $desc;
					$row["price"] = $price;
					$row["extn"] = $extn;

					array_push($invoice_record, $row);

					unset($row);
					$counter++;
				}
			}

			//echo "<pre>";print_r($invoice_record);exit;
			$invoice_details = json_encode($invoice_record);

			if( str_replace(",", "", $total_cost) != str_replace(",", "", $calculated_total_cost) ){
				$total_cost = str_replace(",", "", $calculated_total_cost);
			} else {
				$total_cost = str_replace(",", "", $total_cost);
			}

			$data = array(
				"invoice_no" => $invoice_no,
				"client_id" => $client_id,
				"invoice_date" => date("Y-m-d"),
				'tail_no' => trim($tail_no),
				"flight_date" => $flight_date,
				"disbursement_no" => $disbursement_no,
				"invoice_details" => $invoice_details,
				"invoice_total_amount" => $total_cost,
				"currency_id" => $base_currency,
				"created_by_employee_id" => $this->session->userdata("user_id")
			);

			//echo "<pre>";print_r($data);exit;

			try{
				$this->invoice->insert_basic_invoice($data);
				$last_inserted_id = $this->sir->get_last_insert_key_for_table( "basic_invoices", "invoice_id" );
				$this->invoice->increment_basic_invoice_seq_no();

				try{
					$this->logger->add_log(32, $this->session->userdata("user_id"), json_encode($old_invoice_data), json_encode($data));
				} catch(Exception $x){
					$this->xxx->log_exception( $x->getMessage() );
				}
				
				$this->sir_session->add_status_message("Your Invoice has been created successfully!", "success");
			} catch( Exception $e ){
				$this->xxx->log_exception( $e->getMessage() );
				$this->sir_session->add_status_message("Sorry, your Invoice was not created successfully!", "danger");
			}

			redirect("/Invoices/duplicate_basic_invoice/" . $last_inserted_id);
		}
	}


}