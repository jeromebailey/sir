<?
class Requisitions_model extends CI_Model
{
	var $requisitions, $other_client_name_table;

	function __construct()
	{
		parent::__construct();

		//load models
		$this->load->model('sir/Products_model', 'products');
		$this->load->model('exceptions/AppExceptions_model', 'xxx');

		$this->table_name = "requisitions";
		$this->other_client_name_table = "requisition_other_client_name";
	}

	public function add_requisition_category_log( $requisition_id ){
		$dairy_cooler = $dry_stores = $freezer = $meat_freezer = $vegetable_cooler = $paper_packaging = $sanitation = $prepared_meals = array();
		$todays_date = date("Y-m-d");
		$inventory_category_ids = array(1,2,3,4,5,6,7,9);
		$bLog_for_today = false;

		$log_for_today = $this->get_requisition_log_for_today( $todays_date );

		if( !empty( $log_for_today ) ){
			$bLog_for_today = true;
			$dairy_cooler = (empty(json_decode($log_for_today[0]["dairy_cooler_log"]))) ? $dairy_cooler : json_decode($log_for_today[0]["dairy_cooler_log"]);
			$dry_stores = (empty(json_decode($log_for_today[0]["dry_stores_log"]))) ? $dry_stores : json_decode($log_for_today[0]["dry_stores_log"]);
			$freezer = (empty(json_decode($log_for_today[0]["freezer_log"]))) ? $freezer : json_decode($log_for_today[0]["freezer_log"]);
			$meat_freezer = (empty(json_decode($log_for_today[0]["meat_freezer_log"]))) ? $meat_freezer : json_decode($log_for_today[0]["meat_freezer_log"]);
			$vegetable_cooler = (empty(json_decode($log_for_today[0]["vegetable_cooler_log"]))) ? $vegetable_cooler : json_decode($log_for_today[0]["vegetable_cooler_log"]);
			$paper_packaging = (empty(json_decode($log_for_today[0]["paper_packaging_log"]))) ? $paper_packaging : json_decode($log_for_today[0]["paper_packaging_log"]);
			$sanitation = (empty(json_decode($log_for_today[0]["sanitation_log"]))) ? $sanitation : json_decode($log_for_today[0]["sanitation_log"]);
			$prepared_meals = (empty(json_decode($log_for_today[0]["prepared_meals_log"]))) ? $prepared_meals : json_decode($log_for_today[0]["prepared_meals_log"]);
		}

		if( $requisition_id != null ){
			$selected_requisition = $this->get_requisition_by_id( $requisition_id );
			$requisition_date = $selected_requisition[0]["requisition_date"];

			if( !empty( $selected_requisition ) ){
				$items = json_decode( $selected_requisition[0]["details"] );
				foreach ($items as $key => $value) {
					$product_id = (!isset($value->product_id)) ? 0 : $value->product_id;
                  	$product_name_id = ($product_id == 0) ? stripslashes($value->product_name) : stripslashes($value->product_name) .' ('.$product_id.')';
                  	$price = ( !isset($value->price) ) ? 0 : $value->price;
                  	$unit = $value->unit;
                  	$amount = $value->amount;

                  	$product_details = $this->products->get_product_by_product_id( $product_id );
                  	$category_id = $product_details[0]["product_category_id"];

                  	if( in_array( $category_id, $inventory_category_ids ) ){ 
                  		//remove id from inventory category ids to mark it being used and leave the ids that did not have any values for the requisition
                  		unset( $inventory_category_ids[$category_id] );
                  	}

                  	$product_category_item = $this->products->get_inventory_item_by_category_with_product_item_total_cost( $product_id );

                  	$data_array_to_use = array(
                  		"product_id" => $product_id,
                  		"product_name" => $product_category_item[0]["product_name"],
                  		"price" => $price,
                  		"unit" => $unit,
                  		"amount" => $amount,
                  		"category_id" => $product_category_item[0]["product_category_id"],
                  		"category_name" => $product_category_item[0]["category_name"]
                  	);//echo "<pre>";print_r($data_array_to_use);

                  	switch( $category_id ){
                  		case 1:
                  			array_push($dairy_cooler, $data_array_to_use);
                  		break;

                  		case 2:
                  			array_push($dry_stores, $data_array_to_use);
                  		break;

                  		case 3:
                  			array_push($freezer, $data_array_to_use);
                  		break;

                  		case 4:
                  			array_push($meat_freezer, $data_array_to_use);
                  		break;

                  		case 5:
                  			array_push($vegetable_cooler, $data_array_to_use);
                  		break;

                  		case 6:
                  			array_push($paper_packaging, $data_array_to_use);
                  		break;

                  		case 7:
                  			array_push($sanitation, $data_array_to_use);
                  		break;

                  		case 9:
                  			array_push($prepared_meals, $data_array_to_use);
                  		break;
                  	} //end of switch
				} //end of foreach

				$dairy_cooler = json_encode($dairy_cooler);
      			$dry_stores = json_encode($dry_stores);
                $freezer = json_encode($freezer);
                $meat_freezer = json_encode($meat_freezer);
                $vegetable_cooler = json_encode($vegetable_cooler);
                $paper_packaging = json_encode($paper_packaging);
                $sanitation = json_encode($sanitation);
                $prepared_meals = json_encode($prepared_meals);

				$inventory_log_data = array(
					"log_date" => $todays_date,
					"requisition_date" => $requisition_date,
					"dairy_cooler_log" => $dairy_cooler,
					"dry_stores_log" => $dry_stores,
					"freezer_log" => $freezer,
					"meat_freezer_log" => $meat_freezer,
					"vegetable_cooler_log" => $vegetable_cooler,
					"paper_packaging_log" => $paper_packaging,
					"sanitation_log" => $sanitation,
					"prepared_meals_log" => $prepared_meals
				);//echo "<pre>";print_r($inventory_log_data);exit;

				if( $bLog_for_today == true ){
					$log_id = $log_for_today[0]["log_id"];
					try{
						return $this->db->update( "requisition_category_log", $inventory_log_data, "log_id = " . $log_id );
					} catch( Exception $ex ){
						$this->xxx->log_exception( "Tried to update inventory category log for date: " . date("Y-m-d") . " --" .$ex->getMessage() );
					}					
				} else {
					try{
						return $this->db->insert( "requisition_category_log", $inventory_log_data );
					} catch( Exception $ex ){
						$this->xxx->log_exception( "Tried to insert inventory category log for date: " . date("Y-m-d") . " --" .  $ex->getMessage() );
					}					
				} //end of else for inventory log for today
			} //
		} //end of check for requisition id
	} //end of function

	public function get_requisition_log_for_today( $todays_date ){
		$query = "SELECT * FROM `requisition_category_log` WHERE log_date = '$todays_date'";

		return $this->sir->format_query_result_as_array($query);
	}

	public function requisition_log_exists_for_today( $todays_date ){
		$query = "SELECT * FROM `requisition_category_log` WHERE log_date = '$todays_date'";

		$result = $this->sir->format_query_result_as_array($query);

		if( empty($result) )
			return false;
		else
			return true;
	}

	public function search_requisition_category_log($start_date, $end_date, $category_id){
		if( $start_date == null && $end_date == null ){
			return null;
		} else {

			switch( $category_id ){
          		case 1:
          			$column_data = "dairy_cooler_log";
          		break;

          		case 2:
          			$column_data = "dry_stores_log";
          		break;

          		case 3:
          			$column_data = "freezer_log";
          		break;

          		case 4:
          			$column_data = "meat_freezer_log";
          		break;

          		case 5:
          			$column_data = "vegetable_cooler_log";
          		break;

          		case 6:
          			$column_data = "paper_packaging_log";
          		break;

          		case 7:
          			$column_data = "sanitation_log";
          		break;

          		case 9:
          			$column_data = "prepared_meals_log";
          		break;
          	} //end of switch

			$query = "SELECT log_id, log_date, $column_data 'column_data'
						FROM `requisition_category_log` 
						where requisition_date between '$start_date' and '$end_date';";

			return $this->sir->format_query_result_as_array($query);
		}		
	}

	public function search_requisitions_by_date_range($start_date, $end_date){
		if( $start_date == null && $end_date == null ){
			return null;
		} else {
			$query = "SELECT r.*, c.`abbreviation`, ft.`flight_type`, cf.`flight_no`,
			(SELECT CONCAT(u.first_name, ' ', u.last_name) FROM sir_users u WHERE u.user_id = r.`store_keeper_employee_id` ) 'created_by',
			(SELECT CONCAT(u.first_name, ' ', u.last_name) FROM sir_users u WHERE u.user_id = r.`dispatched_by_employee_id` ) 'dispatched_by',
			(case 
	                    	when r.client_id = 8000 then 'Sanitation'
	                        when r.client_id = 9000 then 'Other'
	                        else c.`client_name`
	                    END) as client_name, ro.other_client_name
						FROM requisitions r
						LEFT JOIN clients c ON c.`client_id` = r.`client_id`
						LEFT JOIN requisition_other_client_name ro on ro.requisition_id = r.requisition_id
						LEFT JOIN flight_types ft ON ft.`flight_type_id` = r.`flight_type_id`
						LEFT JOIN client_flights cf ON cf.`client_flight_id` = r.`client_flight_id`
						where r.requisition_date between '$start_date' and '$end_date'
						ORDER BY r.`requisition_date` DESC;";

			return $this->sir->format_query_result_as_array($query);
		}		
	}

	public function insert_other_requisition_client_name($data){
		return $this->db->insert($this->other_client_name_table, $data);
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
		$query = "SELECT r.*, c.`abbreviation`, ft.`flight_type`, cf.`flight_no`,
		(SELECT CONCAT(u.first_name, ' ', u.last_name) FROM sir_users u WHERE u.user_id = r.`store_keeper_employee_id` ) 'created_by',
		(SELECT CONCAT(u.first_name, ' ', u.last_name) FROM sir_users u WHERE u.user_id = r.`dispatched_by_employee_id` ) 'dispatched_by',
		(case 
                    	when r.client_id = 8000 then 'Sanitation'
                        when r.client_id = 9000 then 'Other'
                        else c.`client_name`
                    END) as client_name, ro.other_client_name
					FROM requisitions r
					LEFT JOIN clients c ON c.`client_id` = r.`client_id`
					LEFT JOIN requisition_other_client_name ro on ro.requisition_id = r.requisition_id
					LEFT JOIN flight_types ft ON ft.`flight_type_id` = r.`flight_type_id`
					LEFT JOIN client_flights cf ON cf.`client_flight_id` = r.`client_flight_id`
					ORDER BY r.`date_created` DESC;";

		return $this->sir->format_query_result_as_array($query);
	}

	public function get_requisition_by_id( $requisition_id )
	{
		$query = "SELECT r.*, c.`abbreviation`, ft.`flight_type`, cf.`flight_no`, r.flight_type_id,
					(SELECT CONCAT(u.first_name, ' ', u.last_name) FROM sir_users u WHERE u.user_id = r.`store_keeper_employee_id` ) 'created_by',
					(SELECT CONCAT(u.first_name, ' ', u.last_name) FROM sir_users u WHERE u.user_id = r.`dispatched_by_employee_id` ) 'dispatched_by',
					(case 
                    	when r.client_id = 8000 then 'Sanitation'
                        when r.client_id = 9000 then 'Other'
                        else c.`client_name`
                    END) as client_name, ro.other_client_name
					FROM requisitions r
					LEFT JOIN clients c ON c.`client_id` = r.`client_id`
					LEFT JOIN requisition_other_client_name ro on ro.requisition_id = r.requisition_id
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

	/**
	 * takes items in json format. uses the product id to deplete the item amount in the inventory
	 * @param string $items All the items to be requisitioned
	 * @return void
	 */

	public function deplete_inventory($items){

		if( !empty( $items ) ){
			foreach($items as $key => $value)
			{
				$product_id = $value->product_id;
				$product_name = $value->product_name;
				$amount = $value->amount;
				$price = $value->price;

				$total_requisition_cost += $this->products->calculate_requisition_cost_for_product($product_name, $amount);

				//calculate and update product stock level
				if( $this->products->_minimum_stock_level_reached_after_being_dispatched($product_name, $amount) ){
					$products_reach_low_stock_level = true;
					$low_stock["product_name"] = $product_name;

					array_push($low_stock_level_products, $low_stock);
					unset( $low_stock );
				}
			} //end of loop
		}
		return false;
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

	/**
	 * Sets the daily and monthly total Requisition cost.
	 * @param double $total_requisition_cost
	 * @return void
	 */

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

		if( !empty( $result ) ){
			$this_months_total_cost = $result[0]["total_cost"];
		}

		//check if a record exist for the month
		if( empty( $this_months_total_cost ) || $this_months_total_cost == 0 ){
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
					$product_id = $value->product_id;
					$product_name = $value->product_name;
					$amount = $value->amount;
					$price = $value->price;

					$item_cost = $amount * $price;

					$total_requisition_cost += $item_cost; //$this->products->calculate_requisition_cost_for_product($product_name, $amount);

					//calculate and update product stock level
					if( $this->products->_minimum_stock_level_reached_after_being_dispatched($product_id, $amount) ){
						$products_reach_low_stock_level = true;
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

		return $dispatched;
	}

	/**
	 * Gets the requisition by the requisition id and then dispatches it.
	 * @param int $requisition_id
	 * @return void
	 */

	public function dispatch_requisition($requisition_id){

		$dispatched = 0;

		try{
			$requisition = $this->get_requisition_by_id( $requisition_id );

			try{
				$this->set_requisition_as_dispatched($requisition_id); //should be the last thing i do

				$items = json_decode($requisition[0]["details"]);
//echo "<pre>";print_r($items);exit;
				//depletes the items in the inventory
				//$this->deplete_inventory($items);

				$low_stock_level_products = array();
				$products_reach_low_stock_level = false;
				$total_requisition_cost = 0;

				foreach($items as $key => $value)
				{
					$product_id = $value->product_id;
					$product_name = $value->product_name;
					$amount = $value->amount;
					$price = $value->price;

					$item_cost = $price * $amount;

					$total_requisition_cost += $item_cost; //$this->products->calculate_requisition_cost_for_product($product_name, $amount);

					//calculate and update product stock level
					if( $this->products->_minimum_stock_level_reached_after_being_dispatched($product_id, $amount) ){
						$products_reach_low_stock_level = true;
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
	}
}