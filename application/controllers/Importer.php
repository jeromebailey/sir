<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Importer extends CI_Controller {

	function __construct(){
		parent::__construct();

		//load models
		$this->load->model('sir/Sir_model', 'sir');
		$this->load->model('users/Users_model', 'sir_users');
		$this->load->model('session/Session_model', 'sir_session');
		$this->load->model('job_titles/Jobtitles_model', 'job_titles');
		$this->load->model('departments/Departments_model', 'departments');
		$this->load->model('products/Products_model', 'products');
		$this->load->model('notifications/Notifications_model', 'notifications');
		$this->load->model('emails/AppEmailer_model', 'emailer');

		//load libraries
		$this->load->library('csvreader');
	}

	public function test_send_email_notifications()
	{
		$low_stock_level_products = array();
		$low_stock["product_name"] = "BUTTER FOIL";
		array_push($low_stock_level_products, $low_stock);
		$admins = $this->sir_users->get_user_info_to_send_notification_to_by_permission_group( 2 );
		$this->notifications->insert_user_notification_from_array($admins, 5); //set notification
		$this->notifications->send_notification_for_low_stock_level_after_requisition($admins, $low_stock_level_products);
	}

	public function import_file()
	{
        $this->load->view('importer/upload_csv');
	}

	public function do_import_stock_file()
	{


	    //echo "<pre>";print_r($_FILES);exit;
	    $config['upload_path']          = './uploads/';
	    $config['allowed_types']        = 'csv';
	    $config['max_size']             = 100000;
	    //$config['max_width']            = 1024;
	    //$config['max_height']           = 768;

	    $this->load->library('upload', $config);

	    if ( ! $this->upload->do_upload('csv_file'))
	    {
	        $error = array('error' => $this->upload->display_errors());

	        $this->load->view('upload_form', $error);
	    }
	    else
	    {

	        $file_upload_data = $this->upload->data();
	        $full_file_path = $file_upload_data["full_path"];
	        $result =   $this->csvreader->parse_file($full_file_path);
	        //echo "<pre>";print_r($result);exit;
	        if(!empty($result)){
	            foreach ($result as $key => $value) {
	                # code...
	                //echo "<pre>";print_r($value["product"]);exit;
	                if(empty($value)){
	                    continue;
	                } else {
	                    $product = isset($value["product"]) ? $value["product"] : "";
	                    $amount = isset($value["amount"]) ? $value["amount"] : "";

	                    if(!empty($product)){

	                        $product_id_array = $this->products->get_product_id_from_product_name( addslashes( $product));

	                        if( !empty($product_id_array) ){
	                            $product_id = $product_id_array[0]["product_id"];

	                            $data = array(
	                                "product_id" => $product_id,
	                                "current_stock_level" => $amount
	                            );

	                            $this->db->insert("product_stock_levels", $data);
	                        } else {
	                            continue;
	                        }
	                    }
	                }
	            }
	        } else {
	            echo "here";exit;
	        }


	        $data = array('upload_data' => $this->upload->data());
	        $this->load->view('upload_success', $data);
	    }

	    $data['csvData'] =  $result;
	    $this->load->view('importer/upload_csv', $data);
	}

	public function do_import_file()
	{


		//echo "<pre>";print_r($_FILES);exit;
        $config['upload_path']          = './uploads/';
        $config['allowed_types']        = 'csv';
        $config['max_size']             = 100000;
        //$config['max_width']            = 1024;
        //$config['max_height']           = 768;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('csv_file'))
        {
                $error = array('error' => $this->upload->display_errors());

                $this->load->view('upload_form', $error);
        }
        else
        {

        	$file_upload_data = $this->upload->data();
        	$full_file_path = $file_upload_data["full_path"];
        	$result =   $this->csvreader->parse_file($full_file_path);
//echo "<pre>";print_r($result);exit;
        	if(!empty($result)){
        		foreach ($result as $key => $value) {
        			# code...
        			//echo "<pre>";print_r($value["product"]);exit;
        			if(empty($value)){
        				continue;
        			} else {
        				$category = isset($value["category"]) ? $value["category"] : "";
	        			$product = isset($value["product"]) ? $value["product"] : "";
	        			$price = isset($value["price"]) ? $value["price"] : "";

	        			if(!empty($product)){
	        				$category_id = $this->sir->get_category_id($category);

		        			if(empty($category_id) || $category_id == null){
		        				$category_id = $this->sir->get_category_id_from_new_category($category);
		        			}

		        			$data = array(
		        				"product_name" => $product,
		        				"product_category_id" => $category_id,
		        				"price" => str_replace("$", "", $price)
		        			);

		        			$this->db->insert("products", $data);
	        			}
        			}
        		}
        	} else {
        		echo "here";exit;
        	}


            $data = array('upload_data' => $this->upload->data());
            $this->load->view('upload_success', $data);
        }

        $data['csvData'] =  $result;
        $this->load->view('importer/upload_csv', $data);
	}

	public function set_minimum_stock_level_for_all_products(){
		for( $i = 1; $i <= 938; $i++ ){
			$this->products->insert_minimum_stock_level($i, 10, NULL);	
		}
		
	}
}