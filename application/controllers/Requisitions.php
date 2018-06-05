<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Requisitions extends CI_Controller {

	function __construct(){
		parent::__construct();

		//load models
		$this->load->model('sir/Sir_model', 'sir');
		$this->load->model('users/Users_model', 'sir_users');
		$this->load->model('clients/Clients_model', 'clients');
		$this->load->model('products/Products_model', 'products');
		$this->load->model('session/Session_model', 'sir_session');
		$this->load->model('exceptions/AppExceptions_model', 'xxx');
		$this->load->model('requisitions/Requisitions_model', 'requisitions');
		//$this->load->model('job_titles/Jobtitles_model', 'job_titles');
		//$this->load->model('departments/Departments_model', 'departments');
		$this->load->model('notifications/Notifications_model', 'notifications');
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

	public function edit_requisition($requisition_id){
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

				$this->load->view('requisitions/edit_requisition', $data);
			}
		} catch( Exception $ex ){
			$this->xxx->log_exception( $ex->getMessage() );
			show_error("Sorry, error trying to retrieve your request", 404);
		}		
	}

	public function dispatch_requisition(){
		$requisition_id = $this->input->post("requisition_id");

		try{
			$requisition = $this->requisitions->get_requisition_by_id( $requisition_id );

			try{
				$this->requisitions->set_requisition_as_dispatched($requisition_id);

				$items = json_decode($requisition[0]["details"]);

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
		}	
		redirect("/Requisitions/view_requisition/" . $requisition_id);
	}	
}