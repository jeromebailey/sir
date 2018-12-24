<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Requisitions extends CI_Controller {

	const staff_requisition_key = 6, other_requisition_key = "other", sanitation_requisition_key = "sanitation";
	const other_requisition_client_id = 9000, sanitation_requisition_client_id = 8000;

	function __construct(){
		parent::__construct();

		//load models
		$this->load->model('sir/Sir_model', 'sir');
		$this->load->model('log/SirLog_model', 'logger');
		$this->load->model('users/Users_model', 'sir_users');
		$this->load->model('clients/Clients_model', 'clients');
		$this->load->model('emails/AppEmailer_model', 'emailer');
		$this->load->model('products/Products_model', 'products');
		$this->load->model('session/Session_model', 'sir_session');
		$this->load->model('exceptions/AppExceptions_model', 'xxx');
		$this->load->model('flight_types/FlightTypes_model', 'flight_types');
		$this->load->model('requisitions/Requisitions_model', 'requisitions');
		$this->load->model('notifications/Notifications_model', 'notifications');
		//$this->load->model('job_titles/Jobtitles_model', 'job_titles');
		//$this->load->model('departments/Departments_model', 'departments');		
		//$this->load->model('uom/uom_model', 'uom');

		//load libraries
		$this->load->library('encryption');

		$this->sir->manage_session();
	}

	public function index()
	{
		$this->sir_session->clear_status_message();
		$PageTitle = "ALL Requisitions";
		$requisitions = $this->requisitions->get_all_requisitions();
		//echo "<pre>";print_r($requisitions);exit;
		$data = array(
			"page_title" => $PageTitle,
			'requisitions' => $requisitions
			);

		$this->load->view('requisitions/list_requisitions', $data);
	}

	public function view_requisition($requisition_id){
		$PageTitle = "Requisition";

		try{
			$requisition = $this->requisitions->get_requisition_by_id( $requisition_id );
			$company_address = $this->sir->get_settings_by_slug('address_for_forms');

			if( empty($requisition) ){
				show_error("Sorry, invalid request", 404);
			} else {
				$data = array(
					'page_title' => $PageTitle,
					"requisition" => $requisition[0],
					"company_address" => $company_address[0]["settings_value"]
				);

				$this->load->view('requisitions/view_requisition', $data);
			}
		} catch( Exception $ex ){
			$this->xxx->log_exception( $ex->getMessage() );
			show_error("Sorry, error trying to retrieve your request", 404);
		}		
	}

	public function edit_duplicate_requisition($requisition_id){
		$PageTitle = "Duplicate Requisition";

		try{
			$requisition = $this->requisitions->get_requisition_by_id( $requisition_id );
			//echo "<pre>";print_r($requisition);exit;
			$company_address = $this->sir->get_settings_by_slug('address_for_forms');
			$clients = $this->clients->get_all_clients();
			$uom = $this->sir->get_all_uom();
			$flight_types = $this->flight_types->get_flight_types();

			if( empty($requisition) ){
				show_error("Sorry, invalid request", 404);
			} else {

				$client_id = $requisition[0]["client_id"];

				$client_flights = $this->clients->get_client_flights($client_id);

				$data = array(
					'page_title' => $PageTitle,
					"requisition" => $requisition[0],
					"requisition_id" => $requisition_id,
					"company_address" => $company_address[0]["settings_value"],
					"clients" => $clients,
					"uom" => $uom,
					"client_flights" => $client_flights,
					"flight_types" => $flight_types
				);

				$this->load->view('requisitions/duplicate_requisition', $data);
			}
		} catch( Exception $ex ){
			$this->xxx->log_exception( $ex->getMessage() );
			show_error("Sorry, error trying to retrieve your request", 404);
		}		
	}

	public function do_duplicate_requisition(){
		$items_string = "";
		$client_id = $this->input->post("client-id");
		
		if( $client_id == self::staff_requisition_key ){
			$flight_type_id = 0;
			$client_flight_id = 0;
		} else if( $client_id == self::sanitation_requisition_key ){
			$client_id = self::sanitation_requisition_client_id;
			$flight_type_id = self::sanitation_requisition_client_id;
			$client_flight_id = self::sanitation_requisition_client_id;
		} else if( $client_id == self::other_requisition_key ){
			$client_id = self::other_requisition_client_id;
			$flight_type_id = self::other_requisition_client_id;
			$client_flight_id = self::other_requisition_client_id;
			$other_client_name = $this->input->post("other-client");
		} else {
			$flight_type_id = $this->input->post("flight-type-id");
			$client_flight_id = $this->input->post("client-flight-id");
		}

		$passenger_count = $this->input->post("passenger-count");
		$no_of_items = $this->input->post("no_of_items");
		$requisition_date = $this->input->post("requisition-date");
		$total_requisition_cost = 0;

		if( $no_of_items > 0 )
		{
			$counter = 0;
			$row = array();
			$record = array();
			$changed_product_prices = $old_new_product_prices = array();

			for($i = 1; $i <= $no_of_items; $i++)
			{
				$product_name_id = addslashes( $this->input->post("requisition-product-name-" . $i) );
				$amount = $this->input->post("requisition-amount-" . $i);
				$unit = $this->input->post("requisition-unit-" . $i);
				$price = $this->input->post("requisition-price-" . $i);

				if( !empty($product_name_id) && !empty($amount) ){

					$product_name = trim($this->products->get_product_name_from_product_name_id($product_name_id));
					$product_id = $this->products->get_product_id_from_product_name_id(trim($product_name_id));
					
					if( empty($product_id) ){
						//echo "nothing";exit;
						$selected_product_price = 0;

						$row["product_name"] = addslashes($product_name);
						$row["amount"] = $amount;
						$row["unit"] = $unit;
						$row["price"] = $price;

						$total_requisition_cost += $price*$amount;
							
						/*$price_change_product = array(
							"product_id" => $product_id[0]["product_id"],
							"price" => $price
						);
						array_push( $changed_product_prices, $price_change_product );*/

						array_push($record, $row);

						unset($row);
						$counter++;
					} else {
						$product_details = $this->products->get_product_by_product_id( $product_id );

						//echo "<pre>";print_r($product_details);exit;
						$selected_product_price = $product_details[0]["price"];

						$row["product_id"] = $product_id;
						$row["product_name"] = addslashes($product_name);
						$row["amount"] = $amount;
						$row["unit"] = $unit;
						$row["price"] = $price;

						$total_requisition_cost += $price*$amount;

						if( !empty($selected_product_price) ){
							if( $selected_product_price != $price ){
								$price_change_product = array(
									"product_id" => $product_id,
									"price" => $price
								);

								$product_old_new_price = array(
									"product_id" => $product_id,
									"old_price" => $selected_product_price,
									"new_price" => $price,
									"date_changed" => date("Y-m-d h:i:s")
								);
								array_push( $changed_product_prices, $price_change_product );
								array_push( $old_new_product_prices, $product_old_new_price );
							}
						}

						array_push($record, $row);

						unset($row);
						$counter++;
					}
				}
			} //end of for loop			

			$details = json_encode($record);
			

			$data = array(
				"client_id" => $client_id,
				"date_created" => date("Y-m-d"),
				"flight_type_id" => $flight_type_id,
				"client_flight_id" => $client_flight_id,
				"passenger_count" => $passenger_count,
				"requisition_date" => date("Y-m-d", strtotime($requisition_date)),
				"details" => $details,
				"total_cost" => $total_requisition_cost,
				"store_keeper_employee_id" => $this->session->userdata("user_id"),
				"dispatched" => 0
			);

			//echo "<pre>";print_r($data);exit;

			try{
				$this->requisitions->insert_requisition($data);

				if( !empty( $changed_product_prices ) ){
					$this->products->update_product_prices_for_requisition_items( $changed_product_prices );
					$this->products->log_product_price_changes( $old_new_product_prices );
				}

				$new_requisition_id = $this->db->insert_id();

				try{
					$this->logger->add_log(31, $this->session->userdata("user_id"), NULL, json_encode($data));
				} catch(Exception $x){
					$this->xxx->log_exception( $x->getMessage() );
				}

				$users = $this->sir_users->get_user_info_to_send_notification_to_by_action_name("requisitions");

				$client = $this->clients->get_client_by_id($client_id);
				$client_name = $client[0]["client_name"];

				$client_flight_record = $this->clients->get_flight_no_from_client_flight_id( $client_flight_id );
				$flight_no = $client_flight_record[0]["flight_no"];

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

			redirect("/Requisitions/edit_duplicate_requisition/" . $new_requisition_id);
		}
	}

	public function edit_requisition($requisition_id){
		$PageTitle = "Edit Requisition";

		try{
			$requisition = $this->requisitions->get_requisition_by_id( $requisition_id );
			//echo "<pre>";print_r($requisition);exit;
			$company_address = $this->sir->get_settings_by_slug('address_for_forms');
			$clients = $this->clients->get_all_clients();
			$uom = $this->sir->get_all_uom();
			$flight_types = $this->flight_types->get_flight_types();

			if( empty($requisition) ){
				show_error("Sorry, invalid request", 404);
			} else {

				$client_id = $requisition[0]["client_id"];

				$client_flights = $this->clients->get_client_flights($client_id);

				$data = array(
					'page_title' => $PageTitle,
					"requisition" => $requisition[0],
					"requisition_id" => $requisition_id,
					"company_address" => $company_address[0]["settings_value"],
					"clients" => $clients,
					"uom" => $uom,
					"client_flights" => $client_flights,
					"flight_types" => $flight_types
				);

				$this->load->view('requisitions/edit_requisition', $data);
			}
		} catch( Exception $ex ){
			$this->xxx->log_exception( $ex->getMessage() );
			show_error("Sorry, error trying to retrieve your request", 404);
		}		
	}

	public function do_edit_requisition(){
		$requisition_id = $this->input->post("requisition_id");
		$items_string = "";
		$client_id = $this->input->post("client-id");

		if( $client_id == self::staff_requisition_key ){
			$flight_type_id = 0;
			$client_flight_id = 0;
		} else if( $client_id == self::sanitation_requisition_key ){
			$client_id = self::sanitation_requisition_client_id;
			$flight_type_id = self::sanitation_requisition_client_id;
			$client_flight_id = self::sanitation_requisition_client_id;
		} else if( $client_id == self::other_requisition_key ){
			$client_id = self::other_requisition_client_id;
			$flight_type_id = self::other_requisition_client_id;
			$client_flight_id = self::other_requisition_client_id;
			$other_client_name = $this->input->post("other-client");
		} else {
			$flight_type_id = $this->input->post("flight-type-id");
			$client_flight_id = $this->input->post("client-flight-id");
		}

		$passenger_count = $this->input->post("passenger-count");
		$no_of_items = $this->input->post("no_of_items");
		$requisition_date = $this->input->post("requisition-date");

		$old_data = $this->requisitions->get_requisition_by_id($requisition_id);

		//echo "<pre>";print_r($this->input->post());exit;

		$total_requisition_cost = 0;

		if( $no_of_items > 0 )
		{
			$counter = 0;
			$row = array();
			$record = array();
			$changed_product_prices = array();
			$old_new_product_prices = array();
			//$low_stock_level_products = array();
			//$products_reach_low_stock_level = false;
			//$total_requisition_cost = 0;

			for($i = 1; $i <= $no_of_items; $i++)
			{
				$product_name_id = addslashes($this->input->post("requisition-product-name-" . $i));
				$amount = $this->input->post("requisition-amount-" . $i);
				$unit = $this->input->post("requisition-unit-" . $i);
				$price = $this->input->post("requisition-price-" . $i);

				if( !empty($product_name_id) && !empty($amount) ){

					$product_name = trim($this->products->get_product_name_from_product_name_id($product_name_id));
					$product_id = $this->products->get_product_id_from_product_name_id(trim($product_name_id));
					//echo "<pre>";print_r($product_id_result);exit;
					//echo $product_id = $product_id_result[0]["product_id"];exit;
					
					if( empty($product_id) ){
						//echo "nothing";exit;
						$selected_product_price = 0;

						$row["product_name"] = addslashes($product_name);
						$row["amount"] = $amount;
						$row["unit"] = $unit;
						$row["price"] = $price;

						$total_requisition_cost += $price*$amount;
							
						/*$price_change_product = array(
							"product_id" => $product_id[0]["product_id"],
							"price" => $price
						);
						array_push( $changed_product_prices, $price_change_product );*/

						array_push($record, $row);

						unset($row);
						$counter++;
					} else {
						$product_details = $this->products->get_product_by_product_id( $product_id );

						//echo "<pre>";print_r($product_details);exit;
						$selected_product_price = $product_details[0]["price"];

						$row["product_name"] = addslashes($product_name);
						$row["product_id"] = $product_id;
						$row["amount"] = $amount;
						$row["unit"] = $unit;
						$row["price"] = $price;

						$total_requisition_cost += $price*$amount;

						if( !empty($selected_product_price) ){
							if( $selected_product_price != $price ){
								$price_change_product = array(
									"product_id" => $product_id,
									"price" => $price
								);

								$product_old_new_price = array(
									"product_id" => $product_id,
									"old_price" => $selected_product_price,
									"new_price" => $price,
									"date_changed" => date("Y-m-d h:i:s")
								);
								array_push( $changed_product_prices, $price_change_product );
								array_push( $old_new_product_prices, $product_old_new_price );
							}
						}

						array_push($record, $row);

						unset($row);
						$counter++;
					}
				}
			} //end of for loop			

			$details = json_encode($record);
			//echo "<pre>";print_r($details);exit;

			$data = array(
				"client_id" => $client_id,
				"requisition_date" => date("Y-m-d", strtotime($requisition_date)),
				"flight_type_id" => $flight_type_id,
				"client_flight_id" => $client_flight_id,
				"passenger_count" => $passenger_count,
				"details" => $details,
				"total_cost" => $total_requisition_cost
			);
//echo "<pre>";print_r($data);exit;
			try{
				$this->requisitions->update_requisition( $requisition_id, $data);

				if( !empty( $changed_product_prices ) ){
					$this->products->update_product_prices_for_requisition_items( $changed_product_prices );
					$this->products->log_product_price_changes( $old_new_product_prices );
				}

				try{
					$this->logger->add_log(30, $this->session->userdata("user_id"), json_encode($old_data), json_encode($data));
				} catch(Exception $x){
					$this->xxx->log_exception( $x->getMessage() );
				}

				$this->sir_session->add_status_message("Your Requisition has been updated successfully!", "success");
			} catch( Exception $e ){
				$this->xxx->log_exception( $e->getMessage() );
				$this->sir_session->add_status_message("Sorry, your Requisition was not updated successfully!", "danger");
			}

			redirect("/Requisitions/edit_requisition/" . $requisition_id);
		}
	}

	public function dispatch_requisition(){
		$requisition_id = $this->input->post("requisition_id");

		try{
			$this->requisitions->dispatch_requisition($requisition_id);
			$this->sir_session->add_status_message("Your Requisition has been dispatched!", "success");
		} catch( Exception $ex ){
			$this->xxx->log_exception( $ex->getMessage() );
			$this->sir_session->add_status_message("Sorry, there was an error dispatching your Requisition!", "danger");
		}

		/*try{
			$requisition = $this->requisitions->get_requisition_by_id( $requisition_id );

			try{
				$this->requisitions->set_requisition_as_dispatched($requisition_id);

				$items = json_decode($requisition[0]["details"]);

				//deplete the inventory
				$this->requisitions->deplete_inventory($items);

				$low_stock_level_products = array();
				$products_reach_low_stock_level = false;
				$total_requisition_cost = 0;

				foreach($items as $key => $value)
				{
					$product_name = $value->product_name;
					$amount = $value->amount;

					$total_requisition_cost += $this->products->calculate_requisition_cost_for_product($product_name, $amount);

					//calculate and update product stock level
					if( $this->products->minimum_stock_level_reached_after_being_dispatched($product_name, $amount) ){
						$$products_reach_low_stock_level = true;
						$low_stock["product_name"] = $product_name;

						array_push($low_stock_level_products, $low_stock);
						unset( $low_stock );
					}
				} //end of loop

				try{
					$this->requisitions->set_requisition_cost($total_requisition_cost);
				} catch(Exception $r_x){
					$this->xxx->log_exception( $r_x->getMessage() );
				}

				$this->sir_session->add_status_message("Your Requisition has been dispatched!", "success");
	
				//check if products have reached or gone below their individual low stock levels
				if( $products_reach_low_stock_level == true ){
					$admins = $this->users->get_user_info_to_send_notification_to_by_permission_group( 2 );
	
					try{
						$this->notifications->insert_user_notification_from_array($admins, 5); //set notification
					} catch(Exception $x){
						$this->xxx->log_exception( $x->getMessage() );
					}
	
					try{
						$this->notifications->send_notification_for_low_stock_level_after_requisition($admins, $low_stock_level_products); //send notification by email
					} catch(Exception $except){
						$this->xxx->log_exception( $except->getMessage() );	
					}				
				}
			} catch(Exception $xp){
				$this->xxx->log_exception( $xp->getMessage() );
			}
		} catch( Exception $ex ){
			$this->xxx->log_exception( $ex->getMessage() );
			$this->sir_session->add_status_message("Sorry, there was an error dispatching your Requisition!", "danger");
		}	*/
		redirect("/Requisitions/view_requisition/" . $requisition_id);
	}	
}