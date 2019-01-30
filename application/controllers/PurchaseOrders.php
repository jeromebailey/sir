<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PurchaseOrders extends CI_Controller {

	function __construct(){
		parent::__construct();

		//load models
		$this->load->model('sir/Sir_model', 'sir');
		$this->load->model('log/SirLog_model', 'logger');
		$this->load->model('purchase_orders/PO_model', 'po');
		$this->load->model('users/Users_model', 'sir_users');
		$this->load->model('clients/Clients_model', 'clients');
		$this->load->model('session/Session_model', 'sir_session');
		$this->load->model('suppliers/Suppliers_model', 'suppliers');
		$this->load->model('job_titles/Jobtitles_model', 'job_titles');
		$this->load->model('departments/Departments_model', 'departments');
		//$this->load->model('uom/uom_model', 'uom');
		$this->load->model('notifications/Notifications_model', 'notifications');

		//load libraries
		$this->load->library('encryption');

		$this->sir->manage_session();
	}

	public function index()
	{

		$this->sir_session->clear_status_message();
		$PageTitle = "ALL Purchase Orders";

		$purchase_orders = $this->po->get_all_purchase_orders();

		$data = array(
			"page_title" => $PageTitle,
			'purchase_orders' => $purchase_orders
			);

		$this->load->view('purchase_orders/list_purchase_orders', $data);
	}

	public function view_po($po_id)
	{
		$this->sir_session->clear_status_message();
		$PageTitle = "Purchase Order";

		$purchase_order = $this->po->get_purchase_order_by_id($po_id);
		$bill_to_address = $this->sir->get_settings_by_slug('bill_to');

		if( !empty( $purchase_order ) ){
			$supplier_id = $purchase_order[0]["supplier_id"];

			$supplier = $this->suppliers->get_supplier_by_id( $supplier_id );
			$territory_id = $supplier[0]["is_local"];

			if( $territory_id == 1 || $territory_id == null){
				$ship_to_address = $this->sir->get_settings_by_slug('ship_to');
			} else {
				$ship_to_address = $this->sir->get_settings_by_slug('ship_to_overseas');
			}
		}
		
		//echo "<pre>";print_r($purchase_order[0]);exit;
		$address = $this->suppliers->get_supplier_address_by_id($purchase_order[0]["supplier_id"]);
		$company_address = $this->sir->get_settings_by_slug('address_for_forms');

		if( !empty( $address ) ){
			$address_string = ( $address[0]['address_line_1'] != null || $address[0]['address_line_1'] != '' ) ? $address[0]['address_line_1'] . '<br/>' : '';
			$address_string .= ( $address[0]['address_line_2'] != null || $address[0]['address_line_2'] != '' ) ? $address[0]['address_line_2'] . '<br/>' : '';
			$address_string .= ( $address[0]['city'] != null || $address[0]['city'] != '' ) ? $address[0]['city'] . '<br/>' : '';
			$address_string .= ( $address[0]['state'] != null || $address[0]['state'] != '' ) ? $address[0]['state'] . '<br/>' : '';
			$address_string .= ( $address[0]['zip'] != null || $address[0]['zip'] != '' ) ? $address[0]['zip'] . '<br/>' : '';
		}

		$data = array(
			"page_title" => $PageTitle,
			'purchase_order' => $purchase_order[0],
			"supplier_address" => $address_string,
			"ship_to_address" => $ship_to_address[0]['settings_value'],
			"bill_to_address" => $bill_to_address[0]['settings_value'],
			"company_address" => $company_address[0]["settings_value"]
			);

		$this->load->view('purchase_orders/view_purchase_order', $data);
	}

	public function approve_purchase_order(){
		$po_id = $this->input->post("po_id");

		if( !empty($po_id) ){
			try{
				$this->po->approve_purchase_order($po_id);

				$purchase_order = $this->po->get_purchase_order_by_id($po_id);

				try{
					$this->notifications->insert_user_notification($purchase_order[0]["placed_by_employee_id"], 4);
				} catch(Exception $ex){
					$this->xxx->log_exception( $ex->getMessage() );
				}

			} catch( Exception $ex ){
				$this->xxx->log_exception( $e->getMessage() );
				$this->sir_session->add_status_message("Sorry, your Purchase Order was not approved. Please try again!", "danger");
			}
		}

		return redirect( "PurchaseOrders" );
	}

	public function edit_purchase_order($po_id){
		$PageTitle = "Edit Purchase Order";

		$purchase_order = $this->po->get_purchase_order_by_id($po_id);

		if( empty( $purchase_order ) ){
			show_error("Sorry, unable to retrieve the Purchase Order", 404, "Error Retrieving Record");
		} else {
			$bill_to_address = $this->sir->get_settings_by_slug('bill_to');
			//echo "<pre>";print_r($purchase_order[0]);exit;
			$address = $this->suppliers->get_supplier_address_by_id($purchase_order[0]["supplier_id"]);
			$company_address = $this->sir->get_settings_by_slug('address_for_forms');
			$suppliers = $this->suppliers->get_all_suppliers();

			$supplier_id = $purchase_order[0]["supplier_id"];
			$supplier = $this->suppliers->get_supplier_by_id( $supplier_id );
			$territory_id = $supplier[0]["is_local"];

			if( $territory_id == 1 || $territory_id == null){
				$ship_to_address = $this->sir->get_settings_by_slug('ship_to');
			} else {
				$ship_to_address = $this->sir->get_settings_by_slug('ship_to_overseas');
			}

			if( !empty( $address ) ){
				$address_string = ( $address[0]['address_line_1'] != null || $address[0]['address_line_1'] != '' ) ? $address[0]['address_line_1'] . '<br/>' : '';
				$address_string .= ( $address[0]['address_line_2'] != null || $address[0]['address_line_2'] != '' ) ? $address[0]['address_line_2'] . '<br/>' : '';
				$address_string .= ( $address[0]['city'] != null || $address[0]['city'] != '' ) ? $address[0]['city'] . '<br/>' : '';
				$address_string .= ( $address[0]['state'] != null || $address[0]['state'] != '' ) ? $address[0]['state'] . '<br/>' : '';
				$address_string .= ( $address[0]['zip'] != null || $address[0]['zip'] != '' ) ? $address[0]['zip'] . '<br/>' : '';
			}

			$data = array(
				"page_title" => $PageTitle,
				'purchase_order' => $purchase_order[0],
				"supplier_address" => $address_string,
				"ship_to_address" => $ship_to_address[0]['settings_value'],
				"bill_to_address" => $bill_to_address[0]['settings_value'],
				"company_address" => $company_address[0]["settings_value"],
				"suppliers" => $suppliers,
				"po_id" => $po_id,
				"territory_id" => $territory_id
				);

			$this->load->view('purchase_orders/edit_purchase_order', $data);
		}		
	}

	public function do_edit_purchase_order(){
		//echo "<pre>";print_r($this->input->post());exit;
		$po_id = $this->input->post("po-id");
		$items_string = "";
		$supplier_id = $this->input->post("supplier-id");
		$po_no = $this->input->post("po_no");
		//$placed_by = $this->input->post("placed-by");
		//$approved_by = $this->input->post("approved-by");
		$no_of_items = $this->input->post("no_of_items");
		$total_cost = $this->sir->format_dollar_value_for_db($this->input->post("total_cost"));

		if( $no_of_items > 0 )
		{
			$counter = 0;
			$row = array();
			$po_record = array();
			for($i = 1; $i <= $no_of_items; $i++)
			{
				$qty = trim($this->input->post("qty-" . $i));
				$part_no = addslashes(trim($this->input->post("part-no-" . $i)));
				$desc = addslashes(trim($this->input->post("desc-" . $i)));
				$price = $this->sir->format_dollar_value_for_db($this->input->post("price-" . $i));
				$extn = $tgus->sir->format_dollar_value_for_db($this->input->post("extn-" . $i));

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
				"supplier_id" => $supplier_id,
				"po_details" => $po_details,
				"po_total_amount" => $total_cost
			);

			try{
				$this->po->update_po($data, $po_id);

				$old_po_data = $this->po->get_purchase_order_by_id($po_id);

				try{
					$this->logger->add_log(24, $this->session->userdata("user_id"), json_encode($old_po_data), json_encode($data));
				} catch(Exception $x){
					$this->xxx->log_exception( $x->getMessage() );
				}
				
				$this->sir_session->add_status_message("Your Purchase Order has been updated successfully!", "success");
			} catch( Exception $e ){
				$this->xxx->log_exception( $e->getMessage() );
				$this->sir_session->add_status_message("Sorry, your Purchase Order was not updated successfully!", "danger");
			}

			redirect("/PurchaseOrders/edit_purchase_order/" . $po_id);
		}
	}

	public function duplicate_purchase_order($po_id){
		
		$PageTitle = "Duplicate Purchase Order";

		$purchase_order = $this->po->get_purchase_order_by_id($po_id);

		if( empty( $purchase_order ) ){
			show_error("Sorry, unable to retrieve the Purchase Order", 404, "Error Retrieving Record");
		} else {
			$next_po_no = $this->sir->get_next_po_no();
			$bill_to_address = $this->sir->get_settings_by_slug('bill_to');
			$ship_to_address = $this->sir->get_settings_by_slug('ship_to');
			//echo "<pre>";print_r($purchase_order[0]);exit;
			$address = $this->suppliers->get_supplier_address_by_id($purchase_order[0]["supplier_id"]);
			$company_address = $this->sir->get_settings_by_slug('address_for_forms');
			$suppliers = $this->suppliers->get_all_suppliers();

			if( !empty( $address ) ){
				$address_string = ( $address[0]['address_line_1'] != null || $address[0]['address_line_1'] != '' ) ? $address[0]['address_line_1'] . '<br/>' : '';
				$address_string .= ( $address[0]['address_line_2'] != null || $address[0]['address_line_2'] != '' ) ? $address[0]['address_line_2'] . '<br/>' : '';
				$address_string .= ( $address[0]['city'] != null || $address[0]['city'] != '' ) ? $address[0]['city'] . '<br/>' : '';
				$address_string .= ( $address[0]['state'] != null || $address[0]['state'] != '' ) ? $address[0]['state'] . '<br/>' : '';
				$address_string .= ( $address[0]['zip'] != null || $address[0]['zip'] != '' ) ? $address[0]['zip'] . '<br/>' : '';
			}

			$data = array(
				"page_title" => $PageTitle,
				'purchase_order' => $purchase_order[0],
				"supplier_address" => $address_string,
				"ship_to_address" => $ship_to_address[0]['settings_value'],
				"bill_to_address" => $bill_to_address[0]['settings_value'],
				"company_address" => $company_address[0]["settings_value"],
				"suppliers" => $suppliers,
				"po_id" => $po_id,
				"next_po_no" => $next_po_no[0]["next_po_no"]
				);

			$this->load->view('purchase_orders/duplicate_purchase_order', $data);
		}
	}

	public function do_duplicate_purchase_order()
	{

		//echo "<pre>";print_r($this->input->post());exit;
		$items_string = "";
		$supplier_id = $this->input->post("supplier-id");
		$po_no = $this->input->post("po_no");
		$placed_by = $this->input->post("placed-by");
		//$approved_by = $this->input->post("approved-by");
		$no_of_items = $this->input->post("no_of_items");
		$total_cost = $this->sir->format_dollar_value_for_db($this->input->post("total_cost"));

		if( $no_of_items > 0 )
		{
			$counter = 0;
			$row = array();
			$po_record = array();
			for($i = 1; $i <= $no_of_items; $i++)
			{
				$qty = trim($this->input->post("qty-" . $i));
				$part_no = addslashes(trim($this->input->post("part-no-" . $i)));
				$desc = addslashes(trim($this->input->post("desc-" . $i)));
				$price = $this->sir->format_dollar_value_for_db($this->input->post("price-" . $i));
				$extn = $this->sir->format_dollar_value_for_db($this->input->post("extn-" . $i));

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

				$new_po_no = $this->db->insert_id();
				$this->po->increment_po_seq_no();

				try{
					$this->logger->add_log(25, $this->session->userdata("user_id"), NULL, json_encode($data));
				} catch(Exception $x){
					$this->xxx->log_exception( $x->getMessage() );
				}
				
				$this->sir_session->add_status_message("Your Purchase Order has been created successfully!", "success");
			} catch( Exception $e ){
				echo $this->xxx->log_exception( $e->getMessage() );exit;
				$this->sir_session->add_status_message("Sorry, your Purchase Order was not created successfully!", "danger");
			}

			redirect("/PurchaseOrders/edit_purchase_order/" . $new_po_no);
		}
	} //end of function
}