<?
class FlightTypes_model extends CI_Model
{
	var $table_name;

	function __construct()
	{
		parent::__construct();
		$this->table_name = "flight_types";
	}

	public function get_flight_types()
	{
		$sql = "SELECT *
				FROM $this->table_name
				ORDER BY flight_type";

		return $this->sir->format_query_result_as_array($sql);
	}
}