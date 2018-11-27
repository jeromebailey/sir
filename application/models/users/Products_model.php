<?
class Products_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function get_all_products()
	{
		$sql = "select * from sir_users where email_address = '$email_address' and user_password = '$encrypted_password' and status_id = 1";

		return $this->db->query($sql);
	}
}