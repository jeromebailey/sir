<?
class PO_model extends CI_Model
{
	var $table_name;

	function __construct()
	{
		parent::__construct();
		$this->table_name = "purchase_orders";
	}

	public function delete_po($key){
		if( !empty($key) ){
			if( $this->db->delete( $this->table_name, array('purchase_order_id' => $key) ) ){
				echo "1";
			} else {
				echo "0";
			}
		}
	}

	public function insert_po($details)
	{
		return $this->db->insert($this->table_name, $details);
	}

	public function update_po($details, $po_id)
	{
		return $this->db->update($this->table_name, $details, "purchase_order_id = " . $po_id);
	}

	public function get_all_purchase_orders(){
		$query = "SELECT a.*, s.`supplier_name`, a.approved,
					(SELECT CONCAT(u.first_name, ' ', u.last_name) FROM sir_users u WHERE u.user_id = a.`placed_by_employee_id` ) 'placed_by',
					(SELECT CONCAT(u.first_name, ' ', u.last_name) FROM sir_users u WHERE u.user_id = a.`approved_by_employee_id` ) 'approved_by'
					FROM purchase_orders a
					INNER JOIN suppliers s ON s.`supplier_id` = a.`supplier_id`
					ORDER BY a.`po_date` DESC";

		return $this->sir->format_query_result_as_array($query);
	}

	public function get_purchase_order_by_id($po_id)
	{
		$query = "SELECT a.*, s.`supplier_name`, a.approved,
					(SELECT CONCAT(u.first_name, ' ', u.last_name) FROM sir_users u WHERE u.user_id = a.`placed_by_employee_id` ) 'placed_by',
					(SELECT CONCAT(u.first_name, ' ', u.last_name) FROM sir_users u WHERE u.user_id = a.`approved_by_employee_id` ) 'approved_by'
					FROM purchase_orders a
					INNER JOIN suppliers s ON s.`supplier_id` = a.`supplier_id`
					where a.purchase_order_id = $po_id";

		return $this->sir->format_query_result_as_array($query);
	}

	public function _count_items()
	{
		$sql = "SELECT COUNT(*) _count_
				FROM $this->table_name";

		return $this->sir->format_query_result_as_array($sql);
	}

	public function increment_po_seq_no()
	{
		$sql = "UPDATE next_po_seq_no
				SET next_po_no = next_po_no + 1";

		$this->db->query($sql);
	}

	public function approve_purchase_order($purchase_order_id){
		$data = array(
			"approved_by_employee_id" => $this->session->userdata('user_id'),
			"approved_date" => date("Y-m-d H:i:s"),
			"approved" => 1
		);

		return $this->db->update( $this->table_name, $data, "purchase_order_id = " .$purchase_order_id );
	}
}