<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FlightCheckSheets extends CI_Controller {

	function __construct(){
		parent::__construct();

		//load models
		$this->load->model('sir/Sir_model', 'sir');
		$this->load->model('log/SirLog_model', 'logger');
		$this->load->model('users/Users_model', 'sir_users');
		$this->load->model('clients/Clients_model', 'clients');
		$this->load->model('session/Session_model', 'sir_session');
		$this->load->model('job_titles/Jobtitles_model', 'job_titles');
		$this->load->model('departments/Departments_model', 'departments');
		$this->load->model('notifications/Notifications_model', 'notifications');
		$this->load->model('flight_check_sheets/FlightCheckSheets_model', 'flight_check_sheet');
		//$this->load->model('uom/uom_model', 'uom');

		//load libraries
		$this->load->library('encryption');

		$this->sir->manage_session();
	}

	public function index()
	{

		$this->sir_session->clear_status_message();
		$PageTitle = "ALL Flight Check Sheets";
		$flight_check_sheets = $this->flight_check_sheet->get_all_flight_check_sheets();

		$data = array(
			"page_title" => $PageTitle,
			'flight_check_sheets' => $flight_check_sheets
			);

		$this->load->view('flight_check_sheets/list_flight_check_sheets', $data);
	}

	public function view_flight_check_sheet($flight_check_sheet_id)
	{
		$this->sir_session->clear_status_message();
		$PageTitle = "Check Sheet";

		$flight_check_sheet = $this->flight_check_sheet->get_flight_check_sheet_by_id($flight_check_sheet_id);
		$company_address = $this->sir->get_settings_by_slug('address_for_forms');

		if( $flight_check_sheet != null ){

			$client_id = $flight_check_sheet[0]["client_id"];
			$client_details = $this->clients->get_client_by_id($client_id);
			$headings = $this->clients->get_flight_check_headings();
			//echo "<pre>";print_r($client_details);exit;
			$data = array(
				'page_title' => $PageTitle,
				"flight_check_sheet" => $flight_check_sheet[0],
				'client_abbreviation' => $client_details[0]["abbreviation"],
				'client_name' => $client_details[0]["client_name"],
				"company_address" => $company_address[0]["settings_value"],
				"headings" => $headings
			);

			$this->load->view('flight_check_sheets/view_flight_check_sheet', $data);
		}		
	}

	public function edit_flight_check_sheet($flight_check_sheet_id)
	{
		//$this->sir_session->clear_status_message();
		$PageTitle = "Check Sheet";

		$flight_check_sheet = $this->flight_check_sheet->get_flight_check_sheet_by_id($flight_check_sheet_id);
		$clients = $this->clients->get_all_clients();
		$headings = $this->clients->get_flight_check_headings();

		if( $flight_check_sheet != null ){

			$client_id = $flight_check_sheet[0]["client_id"];
			$client_details = $this->clients->get_client_by_id($client_id);
			//echo "<pre>";print_r($client_details);exit;
			$data = array(
				'page_title' => $PageTitle,
				"flight_check_sheet" => $flight_check_sheet[0],
				'client_abbreviation' => $client_details[0]["abbreviation"],
				"clients" => $clients,
				"headings" => $headings,
				"flight_check_sheet_id" => $flight_check_sheet_id
			);

			$this->load->view('flight_check_sheets/edit_flight_check_sheet', $data);
		}		
	}

	public function do_edit_flight_check_sheet(){
		//echo "<pre>";print_r($_POST);exit;
		//echo "<pre>";print_r($this->input->post());exit;

		$flight_check_sheet_id = $this->input->post('flight_check_sheet_id');

		$old_flight_check_sheet_data = $this->flight_check_sheet->get_flight_check_sheet_by_id($flight_check_sheet_id);

		$temp_array = $_POST;

		//remove items from array
		unset( $temp_array['date-and-time'] );
		unset( $temp_array['client-id'] );
		unset( $temp_array['flight-no'] );
		unset( $temp_array['tail-no'] );
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
		unset( $temp_array['flight_check_sheet_id'] );

		//echo "<pre>";print_r($temp_array);exit;

		$client_id = $this->input->post("client-id");
		$date_and_time = trim($this->input->post("date-and-time"));
		$flight_no = trim($this->input->post("flight-no"));
		$tail_no = trim($this->input->post("tail-no"));
		$check_sheet_no = trim($this->input->post("check-sheet-no"));
		$cycle = $this->input->post("cycle");
		$total_items_added = $this->input->post("total_items_added");
		$section_id = 1;

		$breakfast_crew_meals = $breakfast_first_class = $lunch_crew_meals = $lunch_first_class_meals = 
		$dinner_crew_meals = $dinner_first_class_meals = $breakfast_economy = $lunch_economy = $dinner_economy = array();
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
					$temp_row["description"] = addslashes(trim($value));
					$record_counter++;	
				} else if( $record_counter == 2 ){
					$temp_row["qty"] = trim($value);

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
						
						default:
							# code...
							break;
//echo "<pre>";print_r($temp_row);exit;
						
					} //end of case
				}				
			} //end of check for empty $value variable
		}  //end of foreach loop

		//echo json_encode($breakfast_crew_member);exit;

		/*echo "<pre>";print_r($breakfast_crew_meals);
		echo "<pre>";print_r($breakfast_first_class_meals);
		echo "<pre>";print_r($miscellaneous);
		echo "<pre>";print_r($service_charge);exit;*/

		$data = array(
			'client_id' => $client_id,
			'date_time' => date("Y-m-d H:i:s", strtotime($date_and_time)),
			'flight_no' => $flight_no,
			'tail_no' => $tail_no,
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
			'miscellaneous' => json_encode($miscellaneous),
			'service_charge' => json_encode($service_charge),
			'created_by_employee_id' => $this->session->userdata("user_id")
		);
//echo "<pre>";print_r($data);exit;
		try{
			$this->flight_check_sheet->edit_flight_check_sheet($data, $flight_check_sheet_id);

			try{
				$this->logger->add_log(21, $this->session->userdata("user_id"), json_encode($old_flight_check_sheet_data), json_encode($data));
			} catch(Exception $x){
				$this->xxx->log_exception( $x->getMessage() );
			}
			
			$this->sir_session->add_status_message("Your Flight Check Sheet has been edited successfully!", "success");
		} catch( Exception $e ){
			$this->xxx->log_exception( $e->getMessage() );
			$this->sir_session->add_status_message("Sorry, your Flight Check Sheet was not edited successfully!", "danger");
		}

		redirect("/FlightCheckSheets/edit_flight_check_sheet/" . $flight_check_sheet_id);
	}

	public function duplicate_flight_check_sheet($flight_check_sheet_id)
	{
		//$this->sir_session->clear_status_message();
		$PageTitle = "Duplicate Flight Check Sheet";

		$flight_check_sheet = $this->flight_check_sheet->get_flight_check_sheet_by_id($flight_check_sheet_id);
		$clients = $this->clients->get_all_clients();
		$headings = $this->clients->get_flight_check_headings();

		if( $flight_check_sheet != null ){

			$client_id = $flight_check_sheet[0]["client_id"];
			$client_details = $this->clients->get_client_by_id($client_id);
			//echo "<pre>";print_r($client_details);exit;

			/*try{
				$this->clients->increment_flight_check_sheet_no_for_client($client_id);
			} catch(Exception $ex){
				$this->xxx->log_exception( $ex->getMessage() );
			}*/

			$data = array(
				'page_title' => $PageTitle,
				"flight_check_sheet" => $flight_check_sheet[0],
				'client_abbreviation' => $client_details[0]["abbreviation"],
				"clients" => $clients,
				"headings" => $headings,
				"flight_check_sheet_id" => $flight_check_sheet_id
			);

			$this->load->view('flight_check_sheets/duplicate_flight_check_sheet', $data);
		}		
	}

	public function do_create_flight_check_sheet_from_duplicate(){
		//echo "<pre>";print_r($_POST);exit;
		//echo "<pre>";print_r($this->input->post());exit;

		$flight_check_sheet_id = $this->input->post('flight_check_sheet_id');

		$old_flight_check_sheet_data = $this->flight_check_sheet->get_flight_check_sheet_by_id($flight_check_sheet_id);

		$temp_array = $_POST;

		//remove items from array
		unset( $temp_array['date-and-time'] );
		unset( $temp_array['client-id'] );
		unset( $temp_array['flight-no'] );
		unset( $temp_array['tail-no'] );
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
		unset( $temp_array['flight_check_sheet_id'] );

		//echo "<pre>";print_r($temp_array);exit;

		$client_id = $this->input->post("client-id");
		$date_and_time = trim($this->input->post("date-and-time"));
		$flight_no = trim($this->input->post("flight-no"));
		$tail_no = trim($this->input->post("tail-no"));
		$check_sheet_no = trim($this->input->post("check-sheet-no"));
		$cycle = $this->input->post("cycle");
		$total_items_added = $this->input->post("total_items_added");
		$section_id = 1;

		$breakfast_crew_meals = $breakfast_first_class = $lunch_crew_meals = $lunch_first_class_meals = 
		$dinner_crew_meals = $dinner_first_class_meals = $breakfast_economy = $lunch_economy = $dinner_economy = array();
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
					$temp_row["description"] = addslashes(trim($value));
					$record_counter++;	
				} else if( $record_counter == 2 ){
					$temp_row["qty"] = trim($value);

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
						
						default:
							# code...
							break;
//echo "<pre>";print_r($temp_row);exit;
						
					} //end of case
				}				
			} //end of check for empty $value variable
		}  //end of foreach loop

		//echo json_encode($breakfast_crew_member);exit;

		/*echo "<pre>";print_r($breakfast_crew_meals);
		echo "<pre>";print_r($breakfast_first_class_meals);
		echo "<pre>";print_r($miscellaneous);
		echo "<pre>";print_r($service_charge);exit;*/

		$data = array(
			'client_id' => $client_id,
			'date_time' => date("Y-m-d H:i:s", strtotime($date_and_time)),
			'flight_no' => trim($flight_no),
			'tail_no' => trim($tail_no),
			'check_sheet_no' => trim($check_sheet_no),
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
			'miscellaneous' => json_encode($miscellaneous),
			'service_charge' => json_encode($service_charge),
			'created_by_employee_id' => $this->session->userdata("user_id")
		);
//echo "<pre>";print_r($data);exit;
		try{
			$this->flight_check_sheet->create_flight_check_sheet_from_duplicate($data);

			$new_flight_check_sheet_no = $this->db->insert_id();

			try{
				$this->clients->increment_flight_check_sheet_no_for_client($client_id);
			} catch(Exception $ex){
				$this->xxx->log_exception( $ex->getMessage() );
			}

			try{
				$this->logger->add_log(23, $this->session->userdata("user_id"), json_encode($old_flight_check_sheet_data), json_encode($data));
			} catch(Exception $x){
				$this->xxx->log_exception( $x->getMessage() );
			}
			
			$this->sir_session->add_status_message("Your Flight Check Sheet has been created successfully!", "success");
		} catch( Exception $e ){
			$this->xxx->log_exception( $e->getMessage() );
			$this->sir_session->add_status_message("Sorry, your Flight Check Sheet was not created successfully!", "danger");
		}

		redirect("/FlightCheckSheets/edit_flight_check_sheet/" . $new_flight_check_sheet_no);
	}
}