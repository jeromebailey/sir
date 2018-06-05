<?
class Categories_model extends CI_Model
{
	var $table_name;

	function __construct()
	{
		parent::__construct();
		$this->table_name = "product_location_categories";
	}

	public function insert_client($details)
	{
		$inserted = false;

		if( $this->db->insert($this->table_name, $details) ){
			$inserted = true;	
		} else {
			echo "<pre>";print_r($this->db->error());exit;
		}
		
		return $inserted;
	}

	public function get_all_categories(){
		$query = $this->db->query("select * from $this->table_name order by category_name asc");

		return $query->result_array();
	}

	public function _count_items()
	{
		$sql = "SELECT COUNT(*) _count_
				FROM $this->table_name";

		return $this->sir->format_query_result_as_array($sql);
	}
}