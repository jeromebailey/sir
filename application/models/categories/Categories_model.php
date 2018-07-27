<?
class Categories_model extends CI_Model
{
	var $table_name;

	function __construct()
	{
		parent::__construct();
		$this->table_name = "product_location_categories";
	}

	public function get_all_categories(){
		$query = $this->db->query("select * from $this->table_name order by category_name asc");

		return $query->result_array();
	}

	public function get_category_by_id($category_id){
		$query = "SELECT *
					FROM $this->table_name
					WHERE category_id = $category_id";

		return $this->sir->format_query_result_as_array($query);
	}

	public function insert_category( $data ){
		return $this->db->insert( $this->table_name, $data );
	}

	public function update_category( $data, $category_id ){
		return $this->db->update( $this->table_name, $data, "category_id = " . $category_id );
	}

	public function delete_category($key){
		if( !empty($key) ){
			if( $this->db->delete( $this->table_name, array('category_id' => $key) ) ){
				echo "1";
			} else {
				echo "0";
			}
		}
	}

	public function _count_items()
	{
		$sql = "SELECT COUNT(*) _count_
				FROM $this->table_name";

		return $this->sir->format_query_result_as_array($sql);
	}
}