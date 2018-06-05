<?
class AppExceptions_model extends CI_Model
{
	var $table_name;

	function __construct()
	{
		parent::__construct();
		//models
		$this->load->model('sir/Sir_model', 'sir');

		$this->table_name = "exceptions";
	}

	public function log_exception( $exception ){
		
		$data = array(
			"exception" => $exception,
			"date_occurred" => date( "Y-m-d H:i:s" )
		);

		$this->db->insert( $this->table_name, $data );
	}
}