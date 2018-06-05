<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clients extends CI_Controller {

	function __construct(){
		parent::__construct();

		$this->load->model('sir/Sir_model', 'sir');
		$this->load->model('log/SirLog_model', 'logger');
		$this->load->model('clients/Clients_model', 'clients');
		$this->load->model('session/Session_model', 'sir_session');
		$this->load->model('exceptions/AppExceptions_model', 'xxx');
		$this->load->model('notifications/Notifications_model', 'notifications');

		$this->sir->manage_session();

		//load libraries
		$this->load->library('encryption');
		
	}

	public function index()
	{
		$PageTitle = "Clients";

		$this->sir_session->clear_status_message();

		$clients = $this->clients->get_all_clients();


		$data = array(
			"page_title" => $PageTitle,
			"clients" => $clients
			);

		$this->load->view('clients/clients_list', $data);
	}

	public function edit_client( $client_id ){
		$PageTitle = "Edit Client";

		$client = $this->clients->get_client_by_id( $client_id );

		if( empty($client) ){
			show_error( "Sorry, unable to retrieve client information", 404, "Error Retrieving Client Information" );
		} else {
			$data = array(
			"page_title" => $PageTitle,
			"client" => $client[0],
			"client_id" => $client_id
			);

			$this->load->view('clients/edit_client', $data);
		}
	}

	public function do_edit_client(){
		$client_id = $this->input->post("client-id");
		$client_name = $this->input->post("client-name");
		$abbreviation = $this->input->post("abbreviation");
		$address_line_1 = $this->input->post("address-line-1");
		$address_line_2 = $this->input->post("address-line-2");
		$city = $this->input->post("city");
		$state = $this->input->post("state");
		$zip = $this->input->post("zip");

		$data = array(
			"client_name" => $client_name,
			"abbreviation" => $abbreviation,
			"address_line_1" => $address_line_1,
			"address_line_2" => $address_line_2,
			"city" => $city,
			"state" => $state,
			"zip" => $zip
		);

		try{
			$this->clients->update_client( $data, $client_id );
			$old_data = $this->clients->get_client_by_id( $client_id );
			$this->logger->add_log(9, $this->session->userdata("user_id"), json_encode($old_data), json_encode($data));
			$this->sir_session->add_status_message("Client was successfully updated!", "success");
		} catch(Exception $ex){
			$this->xxx->log_exception( $ex->getMessage() );
			$this->sir_session->add_status_message("Client was NOT updated!", "danger");
		}
		redirect("/Clients/edit_client/" . $client_id);
	}

	public function add_client(){
		$PageTitle = "Add Client";

		$data = array(
			"page_title" => $PageTitle
			);

		$this->load->view('clients/add_client', $data);
	}

	public function do_add_client(){
		$client_name = $this->input->post("client-name");
		$abbreviation = $this->input->post("abbreviation");
		$address_line_1 = $this->input->post("address-line-1");
		$address_line_2 = $this->input->post("address-line-2");
		$city = $this->input->post("city");
		$state = $this->input->post("state");
		$zip = $this->input->post("zip");

		$data = array(
			"client_name" => $client_name,
			"abbreviation" => $abbreviation,
			"address_line_1" => $address_line_1,
			"address_line_2" => $address_line_2,
			"city" => $city,
			"state" => $state,
			"zip" => $zip
		);

		try{
			$this->clients->insert_client( $data );
			$this->logger->add_log(8, $this->session->userdata("user_id"), NULL, json_encode($data));
			$this->sir_session->add_status_message("Client was successfully added!", "success");
		} catch(Exception $ex){
			$this->xxx->log_exception( $ex->getMessage() );
			$this->sir_session->add_status_message("Client was NOT added!", "danger");
		}
		redirect("/Clients/add_client");
	}

	public function add_client_flight(){
		$PageTitle = "Add Client Flight";

		$clients = $this->clients->get_all_clients();

		$data = array(
			"page_title" => $PageTitle,
			"clients" => $clients,
			);

		$this->load->view('clients/add_client_flight', $data);
	}

	public function do_add_client_flight(){
		$client_id = $this->input->post("client-id");
		$flight_no = $this->input->post("flight-no");

		$data = array(
			"client_id" => $client_id,
			"flight_no" => $flight_no
		);

		try{
			$this->clients->insert_client_flight( $data );
			$this->logger->add_log(19, $this->session->userdata("user_id"), NULL, json_encode($data));
			$this->sir_session->add_status_message("Client flight was successfully added!", "success");
		} catch( Exception $ex ){
			$this->xxx->log_exception( $ex->getMessage() );
			$this->sir_session->add_status_message("Client flight was NOT added! Please try again!", "danger");
		}

		return redirect("Clients/add_client_flight");
	}

	public function view_client( $client_id ){
		$PageTitle = "View Client";

		$client = $this->clients->get_client_by_id( $client_id );

		$data = array(
			"page_title" => $PageTitle,
			"client" => $client[0],
			);

		$this->load->view('clients/view_client', $data);
	}

}
