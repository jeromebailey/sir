<?
class Users_model extends CI_Model
{
	var $table_name;

	function __construct()
	{
		parent::__construct();
		$this->load->config("sir_config");

		//libraries
		$this->load->library('encryption');

		//models
		$this->load->model('sir/Sir_model', 'sir');

		$this->table_name = "sir_users";
	}

	public function show_user_access(){
		$query = "SELECT u.`user_id`, u.`first_name`, u.`last_name`, d.`department_name`, GROUP_CONCAT(p.`permission`) AS permissions
					FROM sir_users u
					INNER JOIN user_permissions upr ON upr.`user_id` = u.`user_id`
					INNER JOIN permissions p ON p.`permission_id` = upr.`permission_id`
					INNER JOIN departments d ON d.`department_id` = u.`department_id`
					WHERE u.`user_id` <> 5292
					GROUP BY u.`user_id`, u.`first_name`, u.`last_name`
					ORDER BY u.`user_id`;";

		return $this->sir->format_query_result_as_array( $query );
	}

	public function get_all_users(){

		$logged_in_user_id = $this->session->userdata('user_id');

		$_query_where_str = "";

		if( $logged_in_user_id != $this->config->item("developer_user_id") ){
			$_query_where_str = " WHERE su.`user_id` <> " . $this->config->item("developer_user_id");
		} 

		$query = "SELECT su.`user_id`, su.`first_name`, su.`last_name`, su.`email_address`, aps.`status_`,
					g.`gender`, d.`department_name`, su.`gender_id`, su.`department_id`, su.`gender_id`, su.`status_id`
					FROM sir_users su
					LEFT JOIN genders g ON g.`gender_id` = su.`gender_id`
					INNER JOIN app_statuses aps ON aps.`status_id` = su.`status_id`
					LEFT JOIN departments d ON d.`department_id` = su.`department_id`
					$_query_where_str
					ORDER BY su.`user_id`";

		$result = $this->db->query($query)->result_array();
		return $result;
	}

	public function get_all_users_by_status_code( $status_id ){

		$logged_in_user_id = $this->session->userdata('user_id');

		$_query_where_str = "";

		if( $logged_in_user_id != $this->config->item("developer_user_id") ){
			$_query_where_str = " and su.`user_id` <> " . $this->config->item("developer_user_id");
		}

		$query = "SELECT su.`user_id`, su.`first_name`, su.`last_name`, su.`email_address`, aps.`status_`,
					g.`gender`, d.`department_name`, su.`gender_id`, su.`department_id`, su.`gender_id`, su.`status_id`
					FROM sir_users su
					LEFT JOIN genders g ON g.`gender_id` = su.`gender_id`
					INNER JOIN app_statuses aps ON aps.`status_id` = su.`status_id`
					LEFT JOIN departments d ON d.`department_id` = su.`department_id`
					WHERE su.status_id = $status_id
					$_query_where_str
					ORDER BY su.`first_name`";

		$result = $this->db->query($query)->result_array();
		return $result;
	}

	public function validate_user($email_address, $password)
	{
		$options = [
		    'cost' => $this->config->item("sir_salt_cost"),
		];

		$encrypted_password = password_hash($password, PASSWORD_BCRYPT, $options);
		$result = Users_model::get_user_details_by_email_address($email_address);

		if( empty( $result ) ){
			return false;
		} else {
			//$result_2 = $result->result_array();
			$pwd = $result[0]["user_password"];

			if( password_verify($password, $pwd) ){
				$user_id = $result[0]["user_id"];
				$this->sir->log_login($user_id);
				//echo "valid";exit;
				//set user details in session

				$permissions = Users_model::get_user_permissions($user_id);
				$permissions_array = $this->sir->format_result_array_as_array($permissions, "permission");

				$encrypted_user_id = $this->encryption->encrypt($user_id);
				$this->session->set_userdata($result[0]);
				$this->session->set_userdata('logged_in', 1);
				$this->session->set_userdata('encrypted_user_id', $encrypted_user_id);
				$this->session->set_userdata("permissions", $permissions_array);
				return true;
			} 
		//echo "not valid";
		return false;
		//exit;
		}

		
		//echo $sql = "select * from sir_users where email_address = '$email_address' and user_password = '$encrypted_password' and status_id = 1";exit;
	}

	public function insert_user($user_details){
		
		$options = [
		    'cost' => $this->config->item("sir_salt_cost"),
		];

		$encrypted_password = password_hash($user_details["user_password"], PASSWORD_BCRYPT, $options);
		$user_details["user_password"] = $encrypted_password;

		//echo "<pre>";print_r($user_details);exit;
		if($this->db->insert('sir_users', $user_details)){
			return true;
		}
		return false;
	}

	public function update_user($user_details, $user_id, $update_password){

		if( $update_password == true )
		{
			$options = [
			    'cost' => $this->config->item("sir_salt_cost"),
			];

			$encrypted_password = password_hash($user_details["user_password"], PASSWORD_BCRYPT, $options);
			$user_details["user_password"] = $encrypted_password;

			//echo "<pre>";print_r($user_details);exit;
			if($this->db->update('sir_users', $user_details, "user_id = " . $user_id)){
				return true;
			}
			return false;
		} else {
			if($this->db->update('sir_users', $user_details, "user_id = " . $user_id)){
				return true;
			}
			return false;
		}
	}

	public function get_user_details_by_email_address($email_address){
		$sql = "select * from sir_users where email_address = '$email_address' and status_id = 1";

		$result = $this->db->query( $sql );

		$details = $result->result_array();
		//echo "<pre>";print_r($details);exit;
		return $details;
	}

	public function get_user_details_by_encrypted_id($encrypted_user_id){
		$decrypted_user_id = base64_decode(urldecode($encrypted_user_id));
		//$decrypted_user_id = $this->encryption->decrypt($encrypted_user_id);

		$sql = "select *
				from sir_users 
				where user_id = $decrypted_user_id";

		return $this->sir->format_query_result_as_array( $sql );
	}

	public function get_user_details_by_id($user_id){

		$sql = "select *
				from sir_users 
				where user_id = $user_id";

		return $this->sir->format_query_result_as_array( $sql );
	}

	public function get_user_profile_details_by_encrypted_id($encrypted_user_id){
		//$decrypted_user_id = $this->encryption->decrypt($encrypted_user_id);
		$decrypted_user_id = base64_decode(urldecode($encrypted_user_id));

		$query = "SELECT su.`user_id`, su.`first_name`, su.`last_name`, su.`email_address`, aps.`status_`,
					g.`gender`, d.`department_name`, su.`gender_id`, su.`department_id`, su.`gender_id`, su.`status_id`
					FROM sir_users su
					LEFT JOIN genders g ON g.`gender_id` = su.`gender_id`
					INNER JOIN app_statuses aps ON aps.`status_id` = su.`status_id`
					LEFT JOIN departments d ON d.`department_id` = su.`department_id`
					WHERE su.`user_id` = $decrypted_user_id";

		$result = $this->db->query($query)->result_array();
	}

	public function get_user_permissions($user_id){
		$sql = "SELECT p.`permission`
					FROM user_permissions up
					INNER JOIN permissions p ON p.`permission_id` = up.`permission_id`
					WHERE user_id = $user_id";

		return $this->sir->format_query_result_as_array( $sql );
	}

	public function _count_items()
	{
		$sql = "SELECT COUNT(*) _count_
				FROM $this->table_name";

		return $this->sir->format_query_result_as_array($sql);
	}

	public function get_user_info_to_send_notification_to_by_permission_group( $group_id )
	{
		$query = "SELECT u.`user_id`, u.`first_name`, u.`last_name`, u.`email_address`
					FROM sir_users u
					INNER JOIN user_permission_group g ON g.`user_id` = u.`user_id`
					WHERE g.`permission_group_id` = $group_id;";

		return $this->sir->format_query_result_as_array($query);
	}

	public function get_user_info_to_send_notification_to_by_action_name($action_name){

		$query = "SELECT u.`user_id`, u.`first_name`, u.`last_name`, u.`email_address`
					FROM sir_users u
					INNER JOIN user_email_notifications g ON g.`user_id` = u.`user_id`
					WHERE g." . $action_name . " = 1;";

		return $this->sir->format_query_result_as_array($query);
	}

	public function delete_user_by_encrypted_id( $encrypted_id )
	{
		$id = base64_decode(urldecode($encrypted_id));
		if( $this->db->delete($this->table_name, array('user_id' => $id)) )
		{
			return true;
		} 
		return false;
	}

	public function get_last_login_date($user_id){
		$query = "SELECT login_date
					FROM login_log
					WHERE user_id = $user_id
					ORDER BY login_date DESC
					LIMIT 1, 1;";

		return $this->sir->format_query_result_as_array($query);
	}
}