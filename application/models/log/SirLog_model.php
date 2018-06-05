<?
class SirLog_model extends CI_Model
{
	var $table_name;

	function __construct()
	{
		parent::__construct();
		$this->table_name = "notifications";
	}

	public function add_log($action_id, $taken_by_employee_id, $old_data, $new_data)
	{
		$data = array(
			"log_action_id" => $action_id,
			"action_taken_by_employee_id" => $taken_by_employee_id,
			"old_data" => $old_data,
			"new_data" => $new_data,
			"action_taken_on" => date("Y-m-d H:i:s")
		);

		//echo "<pre>";print_r($data);exit;
		$this->db->insert( "sir_log", $data);

	}
}