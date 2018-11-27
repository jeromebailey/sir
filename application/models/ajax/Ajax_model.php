<?
class Ajax_model extends CI_Model
{
	var $table_name;

	function __construct()
	{
		parent::__construct();
		$this->table_name = "product_location_categories";
	}

	public function change_currency_value( $currency_id, $value ){
		
		$conversion_value = $this->sir->get_settings_by_slug("usd_kyd_exchange_rate");
		$exchange_rate = $conversion_value[0]["settings_value"];

		if( $currency_id == 1 ){
			$result = sprintf("%.2f", ($value*$exchange_rate));
			//$result[1] = number_format($value*$exchange_rate, 2);
		} else {
			$result = sprintf("%.2f", ($value/$exchange_rate));
			//$result[1] = number_format($value/$exchange_rate, 2);
		}

		echo json_encode($result);
	}
}