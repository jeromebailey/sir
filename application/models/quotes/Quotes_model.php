<?
class Quotes_model extends CI_Model
{
	var $table_name;

	function __construct()
	{
		parent::__construct();
		$this->table_name = "quotes";
	}

	public function delete_quote($key){
		if( !empty($key) ){
			if( $this->db->delete( $this->table_name, array('quote_id' => $key) ) ){
				echo "1";
			} else {
				echo "0";
			}
		}
	}

	public function update_quote($details, $quote_id)
	{
		return $this->db->update($this->table_name, $details, "quote_id = " . $quote_id);
	}

	public function insert_quote($details)
	{
		return $this->db->insert($this->table_name, $details);
	}

	public function get_all_quotes(){
		$query = "SELECT a.*, c.`client_name`, 
					(SELECT CONCAT(u.first_name, ' ', u.last_name) FROM sir_users u WHERE u.user_id = a.`created_by_employee_id` ) 'created_by'
					FROM quotes a
					INNER JOIN clients c ON c.`client_id` = a.`client_id`
					ORDER BY a.`quote_date` DESC";

		return $this->sir->format_query_result_as_array($query);
	}

	public function get_quote_by_id($quote_id)
	{
		$query = "SELECT a.*, c.`client_name`, 
					(SELECT CONCAT(u.first_name, ' ', u.last_name) FROM sir_users u WHERE u.user_id = a.`created_by_employee_id` ) 'created_by'
					FROM quotes a
					INNER JOIN clients c ON c.`client_id` = a.`client_id`
					where a.quote_id = $quote_id";

		return $this->sir->format_query_result_as_array($query);
	}

	public function _count_items()
	{
		$sql = "SELECT COUNT(*) _count_
				FROM $this->table_name";

		return $this->sir->format_query_result_as_array($sql);
	}

	public function increment_quote_seq_no()
	{
		$sql = "UPDATE next_quote_seq_no
				SET next_quote_no = next_quote_no + 1";

		$this->db->query($sql);
	}
}