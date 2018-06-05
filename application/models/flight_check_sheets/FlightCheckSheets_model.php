<?
class FlightCheckSheets_model extends CI_Model
{
	var $requisitions;

	function __construct()
	{
		parent::__construct();
		$this->table_name = "flight_check_sheets";
	}

	public function delete_check_sheets( $key ){
		if( !empty($key) ){
			if( $this->db->delete( $this->table_name, array('sheet_no' => $key) ) ){
				echo "1";
			} else {
				echo "0";
			}
		}
	}

	public function insert_flight_check_sheet($data)
	{
		return $this->db->insert($this->table_name, $data);
	}

	public function edit_flight_check_sheet( $data, $flight_check_sheet_id ){
		return $this->db->update( $this->table_name, $data, "sheet_no = " . $flight_check_sheet_id );
	}

	public function create_flight_check_sheet_from_duplicate( $data ){
		return $this->db->insert($this->table_name, $data);
	}

	public function get_all_flight_check_sheets(){
		$query = "
					SELECT f.*, c.`client_name`, CONCAT(u.`first_name`, ' ', u.`last_name`) 'created_by'
					FROM flight_check_sheets f
					INNER JOIN clients c ON c.`client_id` = f.`client_id`
					INNER JOIN sir_users u ON u.`user_id` = f.`created_by_employee_id`
					ORDER BY f.`date_time` DESC;";

		return $this->sir->format_query_result_as_array($query);
	}

	public function get_flight_check_sheet_by_id($flight_check_sheet_id)
	{
		$query = "SELECT f.*, c.`abbreviation`
					FROM flight_check_sheets f
					INNER JOIN clients c ON c.`client_id` = f.`client_id`
					WHERE sheet_no = $flight_check_sheet_id;";

		return $this->sir->format_query_result_as_array($query);
	}

	public function _count_items()
	{
		$sql = "SELECT COUNT(*) _count_
				FROM $this->table_name";

		return $this->sir->format_query_result_as_array($sql);
	}

	public function get_total_items_requisitioned_for_the_last_7_days()
	{
		$query = "SELECT r.`requisition_date`, COUNT(r.`requisition_id`) amt
					FROM requisitions r
					WHERE r.`requisition_date` BETWEEN DATE_ADD(CURDATE(), INTERVAL -6 DAY)
					AND CURDATE() 
					AND r.`dispatched` = 1
					GROUP BY r.`requisition_date`;";

		return $this->sir->format_query_result_as_array($query);
	}
}