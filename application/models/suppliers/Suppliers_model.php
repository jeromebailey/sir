<?
class Suppliers_model extends CI_Model
{
	var $table_name;

	function __construct()
	{
		parent::__construct();
		$this->table_name = "suppliers";
	}

	public function insert_supplier($details)
	{
		return $this->db->insert($this->table_name, $details);
	}

	public function update_supplier( $data, $supplier_id ){
		return $this->db->update( $this->table_name, $data, "supplier_id = " . $supplier_id );
	}

	public function get_all_suppliers(){
		$query = $this->db->query("select * from $this->table_name order by supplier_name asc");

		return $query->result_array();
	}

	public function _count_items()
	{
		$sql = "SELECT COUNT(*) _count_
				FROM $this->table_name";

		return $this->sir->format_query_result_as_array($sql);
	}

	public function get_supplier_address_by_id($supplier_id)
	{
		$sql = "SELECT s.`address_line_1`, s.`address_line_2`, s.`city`, s.`state`, s.`zip`
				FROM suppliers s
				WHERE s.`supplier_id` = $supplier_id";

		return $this->sir->format_query_result_as_array($sql);
	}

	public function get_supplier_by_id( $supplier_id ){
		$query = "select * from $this->table_name where supplier_id = " . $supplier_id;

		return $this->sir->format_query_result_as_array($query);
	}

	public function delete_supplier($key){
		if( !empty($key) ){
			if( $this->db->delete( $this->table_name, array('supplier_id' => $key) ) ){
				echo "1";
			} else {
				echo "0";
			}
		}
	}
}