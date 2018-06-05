<?
class Invoice_model extends CI_Model
{
	var $table_name;

	function __construct()
	{
		parent::__construct();
		$this->table_name = "invoices";
	}

	public function delete_invoice($key){
		if( !empty($key) ){
			if( $this->db->delete( $this->table_name, array('invoice_id' => $key) ) ){
				echo "1";
			} else {
				echo "0";
			}
		}
	}

	public function update_invoice($details, $invoice_id)
	{
		return $this->db->update($this->table_name, $details, "invoice_id = " . $invoice_id);
	}

	public function insert_invoice($details)
	{
		return $this->db->insert($this->table_name, $details);
	}

	public function get_all_invoices(){
		$query = "SELECT a.*, s.`supplier_name`, 
					(SELECT CONCAT(u.first_name, ' ', u.last_name) FROM sir_users u WHERE u.user_id = a.`created_by_employee_id` ) 'created_by'
					FROM invoices a
					INNER JOIN suppliers s ON s.`supplier_id` = a.`supplier_id`
					ORDER BY a.`invoice_date` DESC";

		return $this->sir->format_query_result_as_array($query);
	}

	public function get_invoice_by_id($invoice_id)
	{
		$query = "SELECT a.*, s.`supplier_name`, 
					(SELECT CONCAT(u.first_name, ' ', u.last_name) FROM sir_users u WHERE u.user_id = a.`created_by_employee_id` ) 'created_by'
					FROM invoices a
					INNER JOIN suppliers s ON s.`supplier_id` = a.`supplier_id`
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
}