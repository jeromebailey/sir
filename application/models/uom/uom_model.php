<?
class MeasurementUnits_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function get_all_uom()
	{
		$sql = "select * from measurement_units order by unit_name asc";

		$result = $this->db->query($sql);

		return $result->result_array();
	}
}