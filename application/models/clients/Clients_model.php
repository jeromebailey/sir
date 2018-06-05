<?
class Clients_model extends CI_Model
{
	var $table_name;

	function __construct()
	{
		parent::__construct();
		$this->table_name = "clients";
	}

	/*public function insert_client($details)
	{
		$inserted = false;

		if( $this->db->insert($this->table_name, $details) ){
			$inserted = true;	
		} else {
			echo "<pre>";print_r($this->db->error());exit;
		}
		
		return $inserted;
	}*/

	public function get_all_clients(){
		$query = $this->db->query("select * from $this->table_name order by client_name asc");

		return $query->result_array();
	}

	public function json_get_client_flights($client_id){
		$query = "SELECT client_flight_id, flight_no
					FROM client_flights
					WHERE client_id = $client_id
					ORDER BY flight_no";

		echo json_encode($this->sir->format_query_result_as_array($query));
	}

	public function get_client_flights($client_id){
		$query = "SELECT client_flight_id, flight_no
					FROM client_flights
					WHERE client_id = $client_id
					ORDER BY flight_no";

		return $this->sir->format_query_result_as_array($query);
	}

	public function get_flight_no_from_client_flight_id( $client_flight_id ){
		$query = "SELECT flight_no
					FROM client_flights
					WHERE client_flight_id = $client_flight_id";

		return $this->sir->format_query_result_as_array($query);
	}

	public function _count_items()
	{
		$query = "SELECT COUNT(*) _count_
				FROM $this->table_name";

		return $this->sir->format_query_result_as_array($query);
	}

	public function get_flight_check_headings(){
		$query = "SELECT *
				FROM flight_check_sheet_headings
				order by heading";

		return $this->sir->format_query_result_as_array($query);
	}

	public function get_client_abbreviation_by_id($client_id){
		$query = "SELECT abbreviation
					FROM clients
					WHERE client_id = $client_id";

		$row = $this->sir->format_query_result_as_array($query);

		echo json_encode($row[0]["abbreviation"]);
	}

	public function get_client_by_id($client_id){
		$query = "SELECT *
					FROM clients
					WHERE client_id = $client_id";

		return $this->sir->format_query_result_as_array($query);
	}

	public function get_next_client_flight_check_no($client_id){
		$query = "SELECT next_flight_check_no
					FROM next_client_flight_check_seq_no
					WHERE client_id = $client_id";

		$row = $this->sir->format_query_result_as_array($query);

		echo json_encode($row[0]["next_flight_check_no"]);
	}

	public function increment_flight_check_sheet_no_for_client($client_id)
	{
		$sql = "UPDATE next_client_flight_check_seq_no
				SET next_flight_check_no = next_flight_check_no + 1
				where client_id = $client_id";

		$this->db->query($sql);
	}

	public function insert_client( $data ){
		return $this->db->insert( $this->table_name, $data );
	}

	public function insert_client_flight( $data ){
		return $this->db->insert( "client_flights", $data );
	}

	public function update_client( $data, $client_id ){
		return $this->db->update( $this->table_name, $data, "client_id = " . $client_id );
	}

	public function delete_client($key){
		if( !empty($key) ){
			if( $this->db->delete( $this->table_name, array('client_id' => $key) ) ){
				echo "1";
			} else {
				echo "0";
			}
		}
	}
}