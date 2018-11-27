<?
class Invoice_model extends CI_Model
{
	var $table_name, $ba_invoice_table, $basic_invoice_table;

	function __construct()
	{
		parent::__construct();
		$this->table_name = "invoices";
		$this->ba_invoice_table = "ba_type_invoices";
		$this->basic_invoice_table = "basic_invoices";
	}

	public function get_invoice_headings(){
		$query = "select * 
					from invoice_headings
					where for_iwsc = 1
					order by heading_title";

		return $this->sir->format_query_result_as_array($query);
	}

	public function get_ba_invoice_headings(){
		$query = "select * 
					from invoice_headings
					where for_ba = 1
					order by heading_title";

		return $this->sir->format_query_result_as_array($query);
	}

	public function delete_basic_invoice($key){
		if( !empty($key) ){
			if( $this->db->delete( $this->basic_invoice_table, array('invoice_id' => $key) ) ){
				echo "1";
			} else {
				echo "0";
			}
		}
	}

	public function delete_ba_type_invoice($key){
		if( !empty($key) ){
			if( $this->db->delete( $this->ba_invoice_table, array('invoice_id' => $key) ) ){
				echo "1";
			} else {
				echo "0";
			}
		}
	}

	public function delete_invoice($key, $type){
		//check if type is empty to get the table to delete the item from
		if( !empty($type) ){
			switch ($type) {
				case 'basic':
					if( !empty($key) ){
						if( $this->db->delete( $this->basic_invoice_table, array('invoice_id' => $key) ) ){
							echo "1";
						} else {
							echo "0";
						}
					}
					break;

				case 'ba_type':
					if( !empty($key) ){
						if( $this->db->delete( $this->ba_invoice_table, array('invoice_id' => $key) ) ){
							echo "1";
						} else {
							echo "0";
						}
					}
					break;
				
				default:
					# code...
					break;
			}
		} else { //if no type is used, delete from table with name "invoices"
			if( !empty($key) ){
				if( $this->db->delete( $this->table_name, array('invoice_id' => $key) ) ){
					echo "1";
				} else {
					echo "0";
				}
			}
		}		
	}

	public function update_invoice($details, $invoice_id)
	{
		return $this->db->update($this->table_name, $details, "invoice_id = " . $invoice_id);
	}

	public function update_basic_invoice($details, $invoice_id)
	{
		return $this->db->update($this->basic_invoice_table, $details, "invoice_id = " . $invoice_id);
	}

	public function update_ba_type_invoice($details, $invoice_id)
	{
		return $this->db->update($this->ba_invoice_table, $details, "invoice_id = " . $invoice_id);
	}

	public function insert_invoice($details)
	{
		return $this->db->insert($this->table_name, $details);
	}

	public function insert_basic_invoice($details)
	{
		return $this->db->insert($this->basic_invoice_table, $details);
	}

	public function insert_ba_type_invoice($details)
	{
		return $this->db->insert($this->ba_invoice_table, $details);
	}

	public function get_all_invoices(){
		$query = "SELECT a.*, c.`client_name`, 
					(SELECT CONCAT(u.first_name, ' ', u.last_name) FROM sir_users u WHERE u.user_id = a.`created_by_employee_id` ) 'created_by'
					FROM invoices a
					INNER JOIN clients c ON c.`client_id` = a.`client_id`
					ORDER BY a.`invoice_date` DESC";

		return $this->sir->format_query_result_as_array($query);
	}

	public function get_all_basic_invoices(){
		$query = "SELECT a.*, c.`client_name`, 
					(SELECT CONCAT(u.first_name, ' ', u.last_name) FROM sir_users u WHERE u.user_id = a.`created_by_employee_id` ) 'created_by'
					FROM basic_invoices a
					INNER JOIN clients c ON c.`client_id` = a.`client_id`
					ORDER BY a.`invoice_date` DESC";

		return $this->sir->format_query_result_as_array($query);
	}

	public function get_all_ba_type_invoices(){
		$query = "SELECT a.*, c.`client_name`, 
					(SELECT CONCAT(u.first_name, ' ', u.last_name) FROM sir_users u WHERE u.user_id = a.`created_by_employee_id` ) 'created_by'
					FROM ba_type_invoices a
					INNER JOIN clients c ON c.`client_id` = a.`client_id`
					ORDER BY a.`invoice_date` DESC";

		return $this->sir->format_query_result_as_array($query);
	}

	public function get_invoice_by_id($invoice_id)
	{
		$query = "SELECT a.*, c.`client_name`, fd.destination_abbreviation,
					(SELECT CONCAT(u.first_name, ' ', u.last_name) FROM sir_users u WHERE u.user_id = a.`created_by_employee_id` ) 'created_by'
					FROM invoices a
					INNER JOIN clients c ON c.`client_id` = a.`client_id`
					left join flight_destinations fd on fd.destination_id = a.routes_type_id
					where a.invoice_id = $invoice_id";

		return $this->sir->format_query_result_as_array($query);
	}

	public function get_basic_invoice_by_id($invoice_id)
	{
		$query = "SELECT a.*, c.`client_name`, 
					(SELECT CONCAT(u.first_name, ' ', u.last_name) FROM sir_users u WHERE u.user_id = a.`created_by_employee_id` ) 'created_by'
					FROM basic_invoices a
					INNER JOIN clients c ON c.`client_id` = a.`client_id`
					where a.invoice_id = $invoice_id";

		return $this->sir->format_query_result_as_array($query);
	}

	public function get_ba_type_invoice_by_id($invoice_id)
	{
		$query = "SELECT a.*, c.`client_name`, fd.destination_abbreviation,
					(SELECT CONCAT(u.first_name, ' ', u.last_name) FROM sir_users u WHERE u.user_id = a.`created_by_employee_id` ) 'created_by'
					FROM ba_type_invoices a
					INNER JOIN clients c ON c.`client_id` = a.`client_id`
					left join flight_destinations fd on fd.destination_id = a.routes_type_id
					where a.invoice_id = $invoice_id";

		return $this->sir->format_query_result_as_array($query);
	}

	public function _count_items()
	{
		$sql = "SELECT COUNT(*) _count_
				FROM $this->table_name";

		return $this->sir->format_query_result_as_array($sql);
	}

	public function increment_invoice_seq_no()
	{
		$sql = "UPDATE next_invoice_seq_no
				SET next_invoice_no = next_invoice_no + 1";

		$this->db->query($sql);
	}

	public function increment_basic_invoice_seq_no()
	{
		$sql = "UPDATE next_basic_invoice_seq_no
				SET next_invoice_no = next_invoice_no + 1";

		$this->db->query($sql);
	}

	public function increment_ba_type_invoice_seq_no()
	{
		$sql = "UPDATE next_ba_type_invoice_seq_no
				SET next_invoice_no = next_invoice_no + 1";

		$this->db->query($sql);
	}
}