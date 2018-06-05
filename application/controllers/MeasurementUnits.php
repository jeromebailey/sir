<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MeasurementUnits extends CI_Controller {

	function __construct(){
		parent::__construct();

		$this->load->model('uom/uom_model', 'uom');

		
	}

	public function index()
	{
		$PageTitle = "Units of Measurement";
		$all_units = $this->uom->get_all_uom();

		$data = array(
			"page_title" => $PageTitle,
			"uom" => $all_units
			);

		$this->load->view('uom/uom', $data);
	}

	public function get_all_units()
	{

	}

}
