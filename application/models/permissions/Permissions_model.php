<?
class Permissions_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		//models
		$this->load->model('sir/Sir_model', 'sir');
	}

	public function get_all_permissions()
	{
		$sql = "select * from permissions order by permission";

		return $this->sir->format_query_result_as_array( $sql );
	}

	public function set_permissions_for_user($user_id, $permissions_to_set){

		//create main array
		$all_permission_rows = array();
		
		$this->db->delete( "user_permissions", array("user_id" => $user_id ));

		foreach ($permissions_to_set as $key => $value) {
			if( !empty($value) ){
				$row = array(
					"user_id" => $user_id,
					"permission_id" => $value
				);

				array_push($all_permission_rows, $row);
				unset( $row );
			}			
		} //end of foreach

		return $this->db->insert_batch( "user_permissions", $all_permission_rows );
	}

	public function get_ids_of_permissions_assigned_to_user( $user_id ){
		$query = "SELECT permission_id
					FROM user_permissions
					WHERE user_id = $user_id;";

		return $this->sir->format_query_result_as_array( $query );
	}

	public function insert_permission( $data ){
		if( !empty( $data ) ){
			$data["permission"] = strtolower( str_replace(" ", "_", $data["permission"]) );

			return $this->db->insert( "permissions", $data );
		}
	}
}