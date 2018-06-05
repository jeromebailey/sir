<?
class AppEmailer_model extends CI_Model
{
	var $table_name;

	function __construct()
	{
		parent::__construct();
		$this->table_name = "emails";
	}

	public function get_email_by_slug( $slug )
	{
		$query = "select * from $this->table_name where slug = '$slug'";

		return $this->sir->format_query_result_as_array($query);
	}
}