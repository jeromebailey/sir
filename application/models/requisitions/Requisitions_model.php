<?
class Requisitions_model extends CI_Model
{
	var $requisitions;

	function __construct()
	{
		parent::__construct();
		$this->table_name = "requisitions";
	}

	public function delete_requisition($key){
		if( !empty($key) ){
			if( $this->db->delete( $this->table_name, array('requisition_id' => $key) ) ){
				echo "1";
			} else {
				echo "0";
			}
		}
	}

	public function insert_requisition($details)
	{
		$inserted = false;

		if( $this->db->insert($this->table_name, $details) ){
			$inserted = true;	
		} else {
			echo "<pre>";print_r($this->db->error());exit;
		}
		
		return $inserted;
	}

	public function update_requisition( $requisition_id, $data ){
		return $this->db->update( $this->table_name, $data, "requisition_id = " . $requisition_id );
	}

	public function get_all_requisitions(){
		$query = "SELECT r.*, c.`client_name`, c.`abbreviation`, ft.`flight_type`, cf.`flight_no`,
		(SELECT CONCAT(u.first_name, ' ', u.last_name) FROM sir_users u WHERE u.user_id = r.`store_keeper_employee_id` ) 'created_by',
		(SELECT CONCAT(u.first_name, ' ', u.last_name) FROM sir_users u WHERE u.user_id = r.`dispatched_by_employee_id` ) 'dispatched_by'
					FROM requisitions r
					INNER JOIN clients c ON c.`client_id` = r.`client_id`
					LEFT JOIN flight_types ft ON ft.`flight_type_id` = r.`flight_type_id`
					LEFT JOIN client_flights cf ON cf.`client_flight_id` = r.`client_flight_id`
					ORDER BY r.`requisition_date` DESC;";

		return $this->sir->format_query_result_as_array($query);
	}

	public function get_requisition_by_id( $requisition_id )
	{
		$query = "SELECT r.*, c.`client_name`, c.`abbreviation`, ft.`flight_type`, cf.`flight_no`, r.flight_type_id,
					(SELECT CONCAT(u.first_name, ' ', u.last_name) FROM sir_users u WHERE u.user_id = r.`store_keeper_employee_id` ) 'created_by',
					(SELECT CONCAT(u.first_name, ' ', u.last_name) FROM sir_users u WHERE u.user_id = r.`dispatched_by_employee_id` ) 'dispatched_by'
					FROM requisitions r
					INNER JOIN clients c ON c.`client_id` = r.`client_id`
					LEFT JOIN flight_types ft ON ft.`flight_type_id` = r.`flight_type_id`
					LEFT JOIN client_flights cf ON cf.`client_flight_id` = r.`client_flight_id`
					WHERE r.`requisition_id` = $requisition_id";

		return $this->sir->format_query_result_as_array($query);
	}

	public function set_requisition_as_dispatched($requisition_id){

		$data = array(
			"dispatched" => 1,
			"dispatched_date" => date("Y-m-d H:i:s"),
			"dispatched_by_employee_id" => $this->session->userdata('user_id')
		);

		return $this->db->update($this->table_name, $data, "requisition_id = " . $requisition_id);
	}

	public function _count_items()
	{
		$sql = "SELECT COUNT(*) _count_
				FROM $this->table_name";

		return $this->sir->format_query_result_as_array($sql);
	}

	public function get_total_items_requisitioned_for_the_last_7_days()
	{
		$query = "SELECT r.`requisition_date`, COUNT(r.`requisition_id`) amt
					FROM requisitions r
					WHERE r.`requisition_date` BETWEEN DATE_ADD(CURDATE(), INTERVAL -6 DAY)
					AND CURDATE() 
					AND r.`dispatched` = 1
					GROUP BY r.`requisition_date`;";

		return $this->sir->format_query_result_as_array($query);
	}

	public function set_requisition_cost($total_requisition_cost){
		if( !empty($total_requisition_cost) ){
			$todays_date = date("Y-m-d");
			$this_month = date("m");
			$this_year = date("Y");

			$this->insert_daily_requisition_cost( $todays_date, $total_requisition_cost );
			$this->insert_monthly_requisition_cost( $this_year, $this_month, $total_requisition_cost );
		}
	}

	public function insert_daily_requisition_cost( $todays_date, $total_requisition_cost ){
		$todays_date_total_cost = 0;

		$query = "select total_cost
					from daily_requisition_cost
					where requisition_date = '$todays_date'";

		$result = $this->sir->format_query_result_as_array($query);

		if( !empty( $result ) ){
			$todays_date_total_cost = $result[0]["total_cost"];
		}

		//check if a record exist for the date
		if( empty( $todays_date_total_cost ) || $todays_date_total_cost == 0 ){
			//no record exists so insert new record

			$data = array(
				"requisition_date" => $todays_date,
				"total_cost" => $total_requisition_cost
			);

			$this->db->insert( "daily_requisition_cost", $data );
		} else {
			//record exists so update the cost for the day
			$new_total_cost = $todays_date_total_cost + $total_requisition_cost;

			$update_query = "update daily_requisition_cost
							set total_cost = $new_total_cost
							where requisition_date = '$todays_date'";

			$this->db->query( $update_query );
		}
	}

	public function insert_monthly_requisition_cost( $this_year, $this_month, $total_requisition_cost ){
		$query = "select total_cost
					from monthly_requisition_cost
					where year = $this_year
					and month = $this_month";

		$result = $this->sir->format_query_result_as_array($query);

		$this_months_total_cost = $result[0]["total_cost"];

		//check if a record exist for the month
		if( empty( $this_months_total_cost ) ){
			//no record exists so insert new record

			$data = array(
				"year" => $this_year,
				"month" => $this_month,
				"total_cost" => $total_requisition_cost
			);

			$this->db->insert( "monthly_requisition_cost", $data );
		} else {
			//record exists so update the cost for the day
			$new_total_cost = $this_months_total_cost + $total_requisition_cost;

			$update_query = "update monthly_requisition_cost
							set total_cost = $new_total_cost
							where year = $this_year
							and month = $this_month";

			$this->db->query( $update_query );
		}
	}

	public function get_total_requisition_sales_for_a_today($date = null){
		$today = ( $date == null ) ? date("Y-m-d") : $date;

		$query = "SELECT SUM(total_cost) total_cost
					FROM daily_requisition_cost
					WHERE requisition_date = '$today'";

		return $this->sir->format_query_result_as_array($query);
	}

	public function get_total_requisition_sales_for_a_week($date = null){
		$today = ( $date == null ) ? date("Y-m-d") : $date;
		$year = date("Y");
		$week_no = $this->sir->get_week_number_from_date( $today );
		$start_and_end_of_week = $this->sir->get_start_and_end_date_of_week($week_no, $year);
		$start_of_week = $start_and_end_of_week["week_start"];
		$end_of_week = $start_and_end_of_week["week_end"];

		$query = "SELECT SUM(total_cost) total_cost
					FROM daily_requisition_cost
					WHERE requisition_date BETWEEN '$start_of_week' AND '$end_of_week'";

		return $this->sir->format_query_result_as_array($query);
	}

	public function get_total_requisition_sales_for_a_month($year= null, $month = null){
		$year = ($year == null) ? date("Y") : $year;
		$month = ($month == null) ? date("m") : $month;

		$query = "SELECT SUM(total_cost) total_cost
					FROM monthly_requisition_cost
					WHERE YEAR = $year
					AND MONTH = $month";

		return $this->sir->format_query_result_as_array($query);
	}

	public function get_total_requisition_sales_for_a_year($year= null){
		$year = ($year == null) ? date("Y") : $year;

		$query = "SELECT SUM(total_cost) total_cost
					FROM monthly_requisition_cost
					WHERE YEAR = $year";

		return $this->sir->format_query_result_as_array($query);
	}

	public function dispatch_requisition_service($requisition_id){

		$dispatched = 0;

		try{
			$requisition = $this->get_requisition_by_id( $requisition_id );

			try{
				$this->set_requisition_as_dispatched($requisition_id);

				$items = json_decode($requisition[0]["details"]);

				$low_stock_level_products = array();
				$products_reach_low_stock_level = false;
				$total_requisition_cost = 0;

				foreach($items as $key => $value)
				{
					$product_name = $value->product_name;
					$amount = $value->amount;

					$total_requisition_cost += $this->products->calculate_requisition_cost_for_product($product_name, $amount);

					//calculate and update product stock level
					if( $this->products->minimum_stock_level_reached_after_being_dispatched($product_name, $amount) ){
						$$products_reach_low_stock_level = true;
						$low_stock["product_name"] = $product_name;

						array_push($low_stock_level_products, $low_stock);
						unset( $low_stock );
					}
				} //end of loop

				try{
					$this->set_requisition_cost($total_requisition_cost);
				} catch(Exception $r_x){
					$this->xxx->log_exception( $r_x->getMessage() );
				}

				$dispatched = 1;
	
				//check if products have reached or gone below their individual low stock levels
				if( $products_reach_low_stock_level == true ){
					$admins = $this->users->get_user_info_to_send_notification_to_by_permission_group( 2 );
	
					try{
						$this->notifications->insert_user_notification_from_array($admins, 5); //set notification
					} catch(Exception $x){
						$this->xxx->log_exception( $x->getMessage() );
					}
	
					try{
						$this->notifications->send_notification_for_low_stock_level_after_requisition($admins, $low_stock_level_products); //send notification by email
					} catch(Exception $except){
						$this->xxx->log_exception( $except->getMessage() );	
					}				
				}
			} catch(Exception $xp){
				$this->xxx->log_exception( $xp->getMessage() );
				$dispatched = 0;
			}
		} catch( Exception $ex ){
			$this->xxx->log_exception( $ex->getMessage() );
			$dispatched = 0;
		}	

		echo $dispatched;
	}
}