<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends CI_Controller {

	function __construct(){
		parent::__construct();

		$this->load->model('sir/Sir_model', 'sir');
		$this->load->model('log/SirLog_model', 'logger');
		$this->load->model('session/Session_model', 'sir_session');
		$this->load->model('exceptions/AppExceptions_model', 'xxx');
		$this->load->model('categories/Categories_model', 'categories');		
		$this->load->model('notifications/Notifications_model', 'notifications');

		$this->load->library('encryption');
		
	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$PageTitle = "Categories";

		$this->sir_session->clear_status_message();

		$categories = $this->categories->get_all_categories();

		$data = array(
			"page_title" => $PageTitle,
			"categories" => $categories
			);

		$this->load->view('categories/categories_list', $data);
	}

	public function edit_category( $category_id ){
		$PageTitle = "Edit Category";

		$category = $this->categories->get_category_by_id( $category_id );

		if( empty($category) ){
			show_error( "Sorry, unable to retrieve category information", 404, "Error Retrieving category Information" );
		} else {
			$data = array(
			"page_title" => $PageTitle,
			"category" => $category[0],
			"category_id" => $category_id
			);

			$this->load->view('categories/edit_category', $data);
		}
	}

	public function do_edit_category(){
		$category_id = $this->input->post("category-id");
		$category_name = $this->input->post("category-name");

		$data = array(
			"category_name" => $category_name			
		);

		try{
			$this->categories->update_category( $data, $category_id );
			$old_data = $this->categories->get_category_by_id( $category_id );
			$this->logger->add_log(9, $this->session->userdata("user_id"), json_encode($old_data), json_encode($data));
			$this->sir_session->add_status_message("Category was successfully updated!", "success");
		} catch(Exception $ex){
			$this->xxx->log_exception( $ex->getMessage() );
			$this->sir_session->add_status_message("Category was NOT updated!", "danger");
		}
		redirect("/Categories/edit_category/" . $category_id);
	}

	public function add_category(){
		$PageTitle = "Add Category";

		$data = array(
			"page_title" => $PageTitle
			);

		$this->load->view('categories/add_category', $data);
	}

	public function do_add_category(){
		$category_name = $this->input->post("category-name");

		$data = array(
			"category_name" => $category_name
		);

		try{
			$this->categories->insert_category( $data );
			$this->logger->add_log(8, $this->session->userdata("user_id"), NULL, json_encode($data));
			$this->sir_session->add_status_message("Category was successfully added!", "success");
		} catch(Exception $ex){
			$this->xxx->log_exception( $ex->getMessage() );
			$this->sir_session->add_status_message("Category was NOT added!", "danger");
		}
		redirect("/Categories/add_category");
	}

	public function view_category( $category_id ){
		$PageTitle = "View Category";

		$category = $this->categories->get_category_by_id( $category_id );

		$data = array(
			"page_title" => $PageTitle,
			"category" => $category[0],
			);

		$this->load->view('categories/view_category', $data);
	}
}
