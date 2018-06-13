<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forms extends CI_Controller {

	const staff_requisition_key = 6;

	function __construct(){
		parent::__construct();

		//load models
		$this->load->model('sir/Sir_model', 'sir');		
		$this->load->model('log/SirLog_model', 'logger');
		$this->load->model('quotes/Quotes_model', 'quotes');
		$this->load->model('users/Users_model', 'sir_users');
		$this->load->model('purchase_orders/PO_model', 'po');
		$this->load->model('clients/Clients_model', 'clients');
		$this->load->model('invoices/Invoice_model', 'invoice');
		$this->load->model('emails/AppEmailer_model', 'emailer');
		$this->load->model('products/Products_model', 'products');
		$this->load->model('session/Session_model', 'sir_session');
		$this->load->model('exceptions/AppExceptions_model', 'xxx');
		$this->load->model('suppliers/Suppliers_model', 'suppliers');
		$this->load->model('job_titles/Jobtitles_model', 'job_titles');
		$this->load->model('departments/Departments_model', 'departments');
		$this->load->model('flight_types/FlightTypes_model', 'flight_types');		
		$this->load->model('requisitions/Requisitions_model', 'requisitions');
		$this->load->model('notifications/Notifications_model', 'notifications');
		$this->load->model('flight_check_sheets/FlightCheckSheets_model', 'flight_check_sheet');		

		//load libraries
		$this->load->library('encryption');

		$this->sir->manage_session();

	}

	public function index()
	{

		$this->sir_session->clear_status_message();
		$PageTitle = "ALL SIR Users";
		$allUsers = $this->sir_users->get_all_users();

		$data = array(
			"page_title" => $PageTitle,
			'all_users' => $allUsers
			);

		$this->load->view('users/list_users', $data);
	}

	public function create_requisition()
	{
		//manage session
		//$this->sir_session->clear_status_message();

		$PageTitle = "Create Requisition";
		$clients = $this->clients->get_all_clients();
		$uom = $this->sir->get_all_uom();
		$flight_types = $this->flight_types->get_flight_types();

		$data = array(
			"page_title" => $PageTitle,
			"clients" => $clients,
			"uom" => $uom,
			"flight_types" => $flight_types
			);

		$this->load->view('forms/create_requisition', $data);
	}

	public function do_create_requisition()
	{
		$items_string = "";
		$client_id = $this->input->post("client-id");

		if( $client_id == self::staff_requisition_key ){
			$flight_type_id = 0;
			$client_flight_id = 0;
		} else {
			$flight_type_id = $this->input->post("flight-type-id");
			$client_flight_id = $this->input->post("client-flight-id");
		}
		
		$passenger_count = $this->input->post("passenger-count");
		$no_of_items = $this->input->post("no_of_items");

		if( $no_of_items > 0 )
		{
			$counter = 0;
			$row = array();
			$record = array();
			$low_stock_level_products = array();
			$products_reach_low_stock_level = false;
			$total_requisition_cost = 0;

			for($i = 1; $i <= $no_of_items; $i++)
			{
				$product_name_id = $this->input->post("requisition-product-name-" . $i);
				$amount = $this->input->post("requisition-amount-" . $i);
				$unit = $this->input->post("requisition-unit-" . $i);

				if( !empty($product_name_id) && !empty($amount) ){

					$product_name = trim($this->products->get_product_name_from_product_name_id($product_name_id));

					$row["product_name"] = $product_name;
					$row["amount"] = $amount;
					$row["unit"] = $unit;					

					array_push($record, $row);

					unset($row);
					$counter++;
				}
			} //end of for loop			

			$details = json_encode($record);
			

			$data = array(
				"client_id" => $client_id,
				"flight_type_id" => $flight_type_id,
				"client_flight_id" => $client_flight_id,
				"passenger_count" => $passenger_count,
				"requisition_date" => date("Y-m-d"),
				"details" => $details,
				"store_keeper_employee_id" => $this->session->userdata("user_id"),
				"dispatched" => 0
			);

			//echo "<pre>";print_r($data);exit;

			try{
				$this->requisitions->insert_requisition($data);

				try{
					$this->logger->add_log(1, $this->session->userdata("user_id"), NULL, json_encode($data));
				} catch(Exception $x){
					$this->xxx->log_exception( $x->getMessage() );
				}

				$users = $this->sir_users->get_user_info_to_send_notification_to_by_action_name("requisitions");

				$client = $this->clients->get_client_by_id($client_id);
				$client_name = $client[0]["client_name"];

				if( $client_id == self::staff_requisition_key ){
					$flight_no = "Staff";
				} else {
					$client_flight_record = $this->clients->get_flight_no_from_client_flight_id( $client_flight_id );
					$flight_no = $client_flight_record[0]["flight_no"];
				}

				try{
					$this->notifications->insert_user_notification_from_array($users, 1);
				} catch(Exception $ex){
					$this->xxx->log_exception( $ex->getMessage() );
				}

				try{
					$this->notifications->send_notification_to_dispatch_requisition($users, $client_name, $flight_no); //send notification by email
				} catch(Exception $except){
					$this->xxx->log_exception( $except->getMessage() );	
				}
				
				$this->sir_session->add_status_message("Your Requisition has been created successfully!", "success");
			} catch( Exception $e ){
				$this->xxx->log_exception( $e->getMessage() );
				$this->sir_session->add_status_message("Sorry, your Requisition was not created successfully!", "danger");
			}

			redirect("/Forms/create_requisition");
		}
	}	

	public function create_quote()
	{
		//manage session
		//$this->sir_session->clear_status_message();

		$PageTitle = "Create Quote";
		$suppliers = $this->suppliers->get_all_suppliers();
		$bill_to_address = $this->sir->get_settings_by_slug('bill_to');
		$ship_to_address = $this->sir->get_settings_by_slug('ship_to');
		$next_quote_no = $this->sir->get_next_quote_no();
		$company_address = $this->sir->get_settings_by_slug('invoice_address_layout');
		$company_name = $this->sir->get_settings_by_slug('company_name_invoice');

		$data = array(
			"page_title" => $PageTitle,
			"suppliers" => $suppliers,
			"ship_to_address" => $ship_to_address[0]['settings_value'],
			"bill_to_address" => $bill_to_address[0]['settings_value'],
			"next_quote_no" => $next_quote_no[0]['next_quote_no'],
			"company_address" => $company_address[0]["settings_value"],
			"company_name" => $company_name[0]["settings_value"]
			);

		$this->load->view('forms/create_quote', $data);
	}

	public function do_add_quote()
	{

		//echo "<pre>";print_r($this->input->post());exit;
		$items_string = "";
		$supplier_id = $this->input->post("supplier-id");
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
			//echo "<pre>";print_r($po_record);exit;

			$data = array(
				"quote_no" => $quote_no,
				"supplier_id" => $supplier_id,
				"quote_date" => date("Y-m-d"),
				"quote_details" => $quote_details,
				"quote_total_amount" => $total_cost,
				"created_by_employee_id" => $this->session->userdata("user_id")
			);

			try{
				$this->quotes->insert_quote($data);
				$this->quotes->increment_quote_seq_no();

				try{
					$this->logger->add_log(27, $this->session->userdata("user_id"), NULL, json_encode($data));
				} catch(Exception $x){
					$this->xxx->log_exception( $x->getMessage() );
				}
				
				$this->sir_session->add_status_message("Your Quote has been created successfully!", "success");
			} catch( Exception $e ){
				$this->xxx->log_exception( $e->getMessage() );
				$this->sir_session->add_status_message("Sorry, your Quote was not created successfully!", "danger");
			}

			redirect("/Forms/create_quote");
		}
	} //end of function

	public function create_invoice()
	{
		//manage session
		//$this->sir_session->clear_status_message();

		$PageTitle = "Create Invoice";
		$suppliers = $this->suppliers->get_all_suppliers();
		$bill_to_address = $this->sir->get_settings_by_slug('bill_to');
		$ship_to_address = $this->sir->get_settings_by_slug('ship_to');
		$next_invoice_no = $this->sir->get_next_invoice_no();
		$company_address = $this->sir->get_settings_by_slug('invoice_address_layout');
		$company_name = $this->sir->get_settings_by_slug('company_name_invoice');

		$data = array(
			"page_title" => $PageTitle,
			"suppliers" => $suppliers,
			"ship_to_address" => $ship_to_address[0]['settings_value'],
			"bill_to_address" => $bill_to_address[0]['settings_value'],
			"next_invoice_no" => $next_invoice_no[0]['next_invoice_no'],
			"company_address" => $company_address[0]["settings_value"],
			"company_name" => $company_name[0]["settings_value"]
			);

		$this->load->view('forms/create_invoice', $data);
	}

	public function do_add_invoice()
	{

		//echo "<pre>";print_r($this->input->post());exit;
		$items_string = "";
		$supplier_id = $this->input->post("supplier-id");
		$invoice_no = $this->input->post("invoice_no");
		//$placed_by = $this->input->post("placed-by");
		//$approved_by = $this->input->post("approved-by");
		$no_of_items = $this->input->post("no_of_items");
		$total_cost = $this->input->post("total_cost");

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

			$invoice_details = json_encode($invoice_record);
			//echo "<pre>";print_r($po_record);exit;

			$data = array(
				"invoice_no" => $invoice_no,
				"supplier_id" => $supplier_id,
				"invoice_date" => date("Y-m-d"),
				"invoice_details" => $invoice_details,
				"invoice_total_amount" => $total_cost,
				"created_by_employee_id" => $this->session->userdata("user_id")
			);

			try{
				$this->invoice->insert_invoice($data);
				$this->invoice->increment_invoice_seq_no();

				try{
					$this->logger->add_log(26, $this->session->userdata("user_id"), NULL, json_encode($data));
				} catch(Exception $x){
					$this->xxx->log_exception( $x->getMessage() );
				}
				
				$this->sir_session->add_status_message("Your Invoice has been created successfully!", "success");
			} catch( Exception $e ){
				$this->xxx->log_exception( $e->getMessage() );
				$this->sir_session->add_status_message("Sorry, your Invoice was not created successfully!", "danger");
			}

			redirect("/Forms/create_invoice");
		}
	} //end of function

	public function create_purchase_order()
	{
		//manage session
		//$this->sir_session->clear_status_message();

		$PageTitle = "Create Purchase Order";
		$suppliers = $this->suppliers->get_suppliers_by_territory_id( 1 );
		$uom = $this->sir->get_all_uom();
		$bill_to_address = $this->sir->get_settings_by_slug('bill_to');
		$ship_to_address = $this->sir->get_settings_by_slug('ship_to');
		$company_address = $this->sir->get_settings_by_slug('address_for_forms');
		$next_po_no = $this->sir->get_next_po_no();

		$data = array(
			"page_title" => $PageTitle,
			"suppliers" => $suppliers,
			"uom" => $uom,
			"ship_to_address" => $ship_to_address[0]['settings_value'],
			"bill_to_address" => $bill_to_address[0]['settings_value'],
			"company_address" => $company_address[0]["settings_value"],
			"next_po_no" => $next_po_no[0]['next_po_no']
			);

		$this->load->view('forms/create_purchase_order', $data);
	}

	public function do_add_purchase_order()
	{

		//echo "<pre>";print_r($this->input->post());exit;
		$items_string = "";
		$supplier_id = $this->input->post("supplier-id");
		$po_no = $this->input->post("po_no");
		$placed_by = $this->input->post("placed-by");
		$approved_by = $this->input->post("approved-by");
		$no_of_items = $this->input->post("no_of_items");
		$total_cost = $this->input->post("total_cost");

		if( $no_of_items > 0 )
		{
			$counter = 0;
			$row = array();
			$po_record = array();
			for($i = 1; $i <= $no_of_items; $i++)
			{
				$qty = $this->input->post("qty-" . $i);
				$part_no = $this->input->post("part-no-" . $i);
				$desc = $this->input->post("desc-" . $i);
				$price = $this->input->post("price-" . $i);
				$extn = $this->input->post("extn-" . $i);

				if( !empty($qty)  ){ //&& !empty($price)
					$row["qty"] = $qty;
					$row["part_no"] = $part_no;
					$row["desc"] = $desc;
					$row["price"] = $price;
					$row["extn"] = $extn;

					array_push($po_record, $row);

					unset($row);
					$counter++;
				}
			}

			$po_details = json_encode($po_record);
			//echo "<pre>";print_r($po_record);exit;

			$data = array(
				"po_no" => $po_no,
				"supplier_id" => $supplier_id,
				"po_date" => date("Y-m-d"),
				"po_details" => $po_details,
				"po_total_amount" => $total_cost,
				"placed_by_employee_id" => $this->session->userdata("user_id"),
				"approved" => 0
			);

			try{
				$this->po->insert_po($data);
				$this->po->increment_po_seq_no();

				try{
					$this->logger->add_log(2, $this->session->userdata("user_id"), NULL, json_encode($data));
				} catch(Exception $x){
					$this->xxx->log_exception( $x->getMessage() );
				}

				try{
					$this->notifications->insert_user_notification($this->session->userdata("user_id"), 3);
				} catch(Exception $ex){
					$this->xxx->log_exception( $ex->getMessage() );
				}

				$admins = $this->sir_users->get_user_info_to_send_notification_to_by_permission_group( 2 );

				try{
					$this->notifications->send_notification_to_approve_purchase_order($admins, $po_no); //send notification by email
				} catch(Exception $except){
					$this->xxx->log_exception( $except->getMessage() );	
				}
				
				$this->sir_session->add_status_message("Your Purchase Order has been created successfully!", "success");
			} catch( Exception $e ){
				echo $this->xxx->log_exception( $e->getMessage() );exit;
				$this->sir_session->add_status_message("Sorry, your Purchase Order was not created successfully!", "danger");
			}

			redirect("/Forms/create_purchase_order");
		}
	} //end of function

	public function create_flight_check_sheet(){
		//manage session
		//$this->sir_session->clear_status_message();

		$PageTitle = "Create Flight Check Sheet";
		$clients = $this->clients->get_all_clients();
		$headings = $this->clients->get_flight_check_headings();

		$data = array(
			"page_title" => $PageTitle,
			"clients" => $clients,
			"headings" => $headings
			);

		$this->load->view('forms/create_flight_check_sheet', $data);
	} //end of function

	public function do_add_flight_check_sheet(){
		//echo "<pre>";print_r($_POST);exit;
		//echo "<pre>";print_r($this->input->post());exit;

		$temp_array = $_POST;

		//remove items from array
		unset( $temp_array['date-and-time'] );
		unset( $temp_array['client-id'] );
		unset( $temp_array['flight-no'] );
		unset( $temp_array['check-sheet-no'] );
		unset( $temp_array['cycle'] );
		unset( $temp_array['section-id'] );
		unset( $temp_array['desc'] );
		unset( $temp_array['qty'] );

		unset( $temp_array['crew_comment'] );
		unset( $temp_array['crew_signature'] );
		unset( $temp_array['delivery_personnel_comment'] );
		unset( $temp_array['supervisors_signature'] );
		unset( $temp_array['delivery_personnel_signature'] );
		unset( $temp_array['total_items_added'] );

		//echo "<pre>";print_r($temp_array);exit;

		$client_id = $this->input->post("client-id");
		$date_and_time = $this->input->post("date-and-time");
		$flight_no = $this->input->post("flight-no");
		$check_sheet_no = $this->input->post("check-sheet-no");
		$cycle = $this->input->post("cycle");
		$total_items_added = $this->input->post("total_items_added");
		$section_id = 1;

		$breakfast_crew_meals = $breakfast_first_class = $lunch_crew_meals = $lunch_first_class_meals = 
		$dinner_crew_meals = $dinner_first_class_meals = $breakfast_economy = $lunch_economy = $dinner_economy = $spml = array();
		$miscellaneous = array();
		$service_charge = array();
		$temp_row = array();
		$record_counter = 1; //used to count record pairs: desc and qty

		foreach ($temp_array as $key => $value) {
			//echo "<pre>";print_r($key);
			//echo "<pre>";print_r($value);exit;

			if( $value != null ){ //only do operation if there is a value for a description or qty
				$key_parts = explode("-", $key);

				$section_id = $key_parts[0];

				if( $record_counter == 1 ){
					$temp_row["description"] = $value;
					$record_counter++;	
				} else if( $record_counter == 2 ){
					$temp_row["qty"] = $value;

					switch ($section_id) {
						case 1:
							array_push($breakfast_crew_meals, $temp_row);
							unset($temp_row);
						$record_counter = 1;
							break;

						case 2:
							array_push($breakfast_first_class, $temp_row);
							unset($temp_row);
						$record_counter = 1;
							break;

						case 3:
							array_push($lunch_crew_meals, $temp_row);
							unset($temp_row);
						$record_counter = 1;
							break;

						case 4:
							array_push($lunch_first_class_meals, $temp_row);
							unset($temp_row);
						$record_counter = 1;
							break;

						case 5:
							array_push($dinner_crew_meals, $temp_row);
							unset($temp_row);
						$record_counter = 1;
							break;

						case 6:
							array_push($dinner_first_class_meals, $temp_row);
							unset($temp_row);
						$record_counter = 1;
							break;

						case 7:
							array_push($miscellaneous, $temp_row);
							unset($temp_row);
						$record_counter = 1;
							break;

						case 8:
							array_push($service_charge, $temp_row);
							unset($temp_row);
						$record_counter = 1;
							break;

						case 9:
							array_push($breakfast_economy, $temp_row);
							unset($temp_row);
						$record_counter = 1;
							break;

						case 10:
							array_push($lunch_economy, $temp_row);
							unset($temp_row);
						$record_counter = 1;
							break;

						case 11:
							array_push($dinner_economy, $temp_row);
							unset($temp_row);
						$record_counter = 1;
							break;

						case 12:
							array_push($spml, $temp_row);
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

		//echo json_encode($breakfast_crew_member);exit;

		/*echo "<pre>";print_r($breakfast_crew_member);
		echo "<pre>";print_r($breakfast_first_class);
		echo "<pre>";print_r($miscellaneous);
		echo "<pre>";print_r($service_charge);exit;*/

		$data = array(
			'client_id' => $client_id,
			'date_time' => date("Y-m-d H:i:s", strtotime($date_and_time)),
			'flight_no' => $flight_no,
			'check_sheet_no' => $check_sheet_no,
			'cycle' => $cycle,
			'breakfast_crew_meals' => json_encode($breakfast_crew_meals),
			'breakfast_first_class_meals' => json_encode($breakfast_first_class),
			'breakfast_economy' => json_encode($breakfast_economy),			
			'lunch_crew_meals' => json_encode($lunch_crew_meals),
			'lunch_first_class_meals' => json_encode($lunch_first_class_meals),
			'lunch_economy' => json_encode($lunch_economy),
			'dinner_crew_meals' => json_encode($dinner_crew_meals),
			'dinner_first_class_meals' => json_encode($dinner_first_class_meals),
			'dinner_economy' => json_encode($dinner_economy),
			'spml' => json_encode($spml),
			'miscellaneous' => json_encode($miscellaneous),
			'service_charge' => json_encode($service_charge),
			'created_by_employee_id' => $this->session->userdata("user_id")
		);

		try{
			$this->flight_check_sheet->insert_flight_check_sheet($data);	

			try{
				$this->logger->add_log(22, $this->session->userdata("user_id"), NULL, json_encode($data));
			} catch(Exception $x){
				$this->xxx->log_exception( $x->getMessage() );
			}		

			try{
				$this->clients->increment_flight_check_sheet_no_for_client($client_id);
			} catch(Exception $ex){
				$this->xxx->log_exception( $ex->getMessage() );
			}
			
			$this->sir_session->add_status_message("Your Flight Check Sheet has been created successfully!", "success");
		} catch( Exception $e ){
			$this->xxx->log_exception( $e->getMessage() );
			$this->sir_session->add_status_message("Sorry, your Flight Check Sheet was not created successfully!", "danger");
		}

		redirect("/Forms/create_flight_check_sheet");
	}
}