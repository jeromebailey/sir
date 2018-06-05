<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifications extends CI_Controller {

	function __construct(){
		parent::__construct();

		//load models
		$this->load->model('sir/Sir_model', 'sir');
		$this->load->model('purchase_orders/PO_model', 'po');
		$this->load->model('users/Users_model', 'sir_users');
		$this->load->model('clients/Clients_model', 'clients');
		$this->load->model('emails/AppEmailer_model', 'emailer');
		$this->load->model('session/Session_model', 'sir_session');
		$this->load->model('exceptions/AppExceptions_model', 'xxx');
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

		$PageTitle = "ALL Notifications";

		$notifications = $this->notifications->get_notifications_for_user($this->session->userdata('user_id'));

		$data = array(
			"page_title" => $PageTitle,
		    'notifications' => $notifications
			);

		$this->load->view('notifications/all_notifications', $data);
	}

	public function view_notification($notification_id)
	{
		$PageTitle = "View Notification";

		try{
			$notification = $this->notifications->get_notification_by_id($notification_id);

			try{
	    		$this->notifications->set_notification_as_read($notification_id);
	    	} catch(Exception $e){
	    		$this->xxx->log_exception( $e->getMessage() );
	    	}	        

	        $data = array(
	            "page_title" => $PageTitle,
	            'notification' => $notification[0]
	        );

	        $this->load->view('notifications/view_notification', $data);
		} catch(Exception $ex){
			$this->xxx->log_exception( $ex->getMessage() );
			show_error("Sorry, unable to locate notificaton.", 404, "An Error has occurred");
		}
	}
}