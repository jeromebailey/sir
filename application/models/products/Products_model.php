<?
class Products_model extends CI_Model
{
	var $table_name, $product_stock_levels_table, $minimum_product_stock_levels_table;

	function __construct()
	{
		parent::__construct();

		//models
		$this->load->model('sir/Sir_model', 'sir');

		$this->table_name = "products";
		$this->product_stock_levels_table = "product_stock_levels";
		$this->minimum_product_stock_levels_table = "minimum_product_stock_levels";
	}

	public function get_all_products()
	{
		$sql = "SELECT p.`product_id`, p.`product_name`, p.`description`, p.`price`, c.`category_name`, p.`barcode`, p.`product_category_id`
				FROM products p
				INNER JOIN product_location_categories c ON c.`category_id` = p.`product_category_id`
				ORDER BY p.`product_name`";

		return $this->sir->format_query_result_as_array($sql);
	}

	public function json_get_all_products()
	{
		$sql = "SELECT p.`product_id`, p.`product_name`
				FROM products p
				ORDER BY p.`product_name`";

		return json_encode($this->sir->format_query_result_as_array($sql));
	}

	public function _count_items()
	{
		$sql = "SELECT COUNT(*) _count_
				FROM $this->table_name";

		return $this->sir->format_query_result_as_array($sql);
	}

	public function count_no_of_products_in_categories()
	{
		$sql = "SELECT COUNT(p.`product_id`) 'product_count', c.`category_name`
				FROM products p
				INNER JOIN product_location_categories c ON c.`category_id` = p.`product_category_id`
				GROUP BY c.`category_id`
				ORDER BY c.`category_name`";

		return $this->sir->format_query_result_as_array($sql);
	}

	public function search_products($term)
	{
		$sql = "SELECT p.`product_id`, p.`product_name`
				FROM products p
				where p.product_name like '%$term%'";

		return json_encode($this->sir->format_query_result_as_array($sql));
	}

	public function search_product_by_barcode($bar_code){
	    $query = "SELECT p.`product_id`, p.`product_name`, p.`description`, p.`barcode`, c.`category_name`, p.`price`, p.`product_category_id`,
					u.`unit_abbreviation`, p.`weight`, l.`current_stock_level`, p.unit_id
					FROM products p
					INNER JOIN product_location_categories c ON c.`category_id` = p.`product_category_id`
					LEFT JOIN measurement_units u ON u.`unit_id` = p.`unit_id`
					LEFT JOIN $this->product_stock_levels_table l ON l.`product_id` = p.`product_id`
                    WHERE barcode = '$bar_code'";

	    return $this->sir->format_query_result_as_array($query);
	}

	public function get_product_by_product_id($product_id){
	    $query = "SELECT p.`product_id`, p.`product_name`, p.`description`, p.`barcode`, c.`category_name`, p.`price`, p.`product_category_id`,
					u.`unit_abbreviation`, p.`weight`, l.`current_stock_level`, p.unit_id
					FROM products p
					INNER JOIN product_location_categories c ON c.`category_id` = p.`product_category_id`
					LEFT JOIN measurement_units u ON u.`unit_id` = p.`unit_id`
					LEFT JOIN $this->product_stock_levels_table l ON l.`product_id` = p.`product_id`
                    WHERE p.product_id = $product_id";

	    return $this->sir->format_query_result_as_array($query);
	}

	public function get_product_by_product_name($product_name){
	    $query = "SELECT p.`product_id`, p.`product_name`, p.`description`, p.`barcode`, c.`category_name`, p.`price`, p.`product_category_id`,
					u.`unit_abbreviation`, p.`weight`, l.`current_stock_level`, pl.`maximum_stock_level`, pl.`minimum_stock_level`
					FROM products p
					INNER JOIN product_location_categories c ON c.`category_id` = p.`product_category_id`
					LEFT JOIN measurement_units u ON u.`unit_id` = p.`unit_id`
					LEFT JOIN product_stock_levels l ON l.`product_id` = p.`product_id`
					LEFT JOIN minimum_product_stock_levels pl ON pl.`product_id` = p.`product_id`
                    WHERE p.product_name = '$product_name'";

	    return $this->sir->format_query_result_as_array($query);
	}

	public function search_product_by_product_id($product_id){
	    $query = "SELECT p.`product_id`, p.`product_name`, p.`description`, p.`barcode`, c.`category_name`, p.`price`, p.`product_category_id`,
					u.`unit_abbreviation`, p.`weight`, l.`current_stock_level`, pl.`maximum_stock_level`, pl.`minimum_stock_level`
					FROM products p
					INNER JOIN product_location_categories c ON c.`category_id` = p.`product_category_id`
					LEFT JOIN measurement_units u ON u.`unit_id` = p.`unit_id`
					LEFT JOIN $this->product_stock_levels_table l ON l.`product_id` = p.`product_id`
					LEFT JOIN minimum_product_stock_levels pl ON pl.`product_id` = p.`product_id`
	    			WHERE p.product_id = '$product_id'";

	    return $this->sir->format_query_result_as_array($query);
	}

	public function get_total_product_category_cost(){
		$sql = "SELECT c.`category_name`, TRUNCATE(SUM(p.`price`), 2) total_cost
				FROM products p
				INNER JOIN product_location_categories c ON c.`category_id` = p.`product_category_id`
				GROUP BY c.`category_id`
				ORDER BY total_cost";

		return $this->sir->format_query_result_as_array($sql);
	}

	public function get_inventory_list(){
        $query = "SELECT p.`product_id`, p.`product_name`, p.`description`, c.`category_name`, p.`barcode`, p.`product_category_id`,
                    l.`current_stock_level`, p.price
                    FROM products p
                    INNER JOIN product_location_categories c ON c.`category_id` = p.`product_category_id`
                    INNER JOIN $this->product_stock_levels_table l ON l.`product_id` = p.`product_id`
                    ORDER BY p.`product_name`";

        return $this->sir->format_query_result_as_array($query);
	}

	public function get_product_id_from_product_name($product_name){
        $query = "select product_id from products where product_name = '$product_name'";

        return $this->sir->format_query_result_as_array($query);
	}

	public function get_stock_level_by_product_id($product_id){
		$query = "select * from $this->product_stock_levels_table where product_id = $product_id";

		return $this->sir->format_query_result_as_array($query);
	}

	public function insert_product( $product_info ){
		return $this->db->insert( $this->table_name, $product_info );
	}

	public function update_product($product_id, $product_info_data){
		return $this->db->update( $this->table_name, $product_info_data, array("product_id" => $product_id) );
	}

	public function update_product_stock_level($product_info_data, $current_stock_level, $new_stock_level, $product_id){
		//update the product information
		if( $this->update_product( $product_id, $product_info_data ) ){

			//get the previous stock level
			$previous_stock_level_result = $this->get_stock_level_by_product_id($product_id);
			$previous_stock_level = $previous_stock_level_result[0]["current_stock_level"];

			$new_product_stock_level = $current_stock_level + $new_stock_level;

			$stock_level_data = array(
				//"product_id" = >$product_id,
				"current_stock_level" => $new_product_stock_level
			);

			//update the product's current stock level
			if( $this->db->update($this->product_stock_levels_table, $stock_level_data, array("product_id" => $product_id)) ){

				//update the inventory history
				$inventory_history_data = array(
					"inventory_id" => $this->session->userdata("inventory_id"),
					"product_id" => $product_id,
					"previous_amount" => $previous_stock_level,
					"inventory_amount_added" => $new_stock_level,
					"total_amount" => $new_product_stock_level
				);

				if( $this->db->insert( "inventory_history", $inventory_history_data ) ){
					return true;
				}
				return false;
			}			
		}
	}

	public function insert_minimum_stock_level($product_id, $stock_level, $unit_id){
		$data = array(
			'product_id' => $product_id,
			'minimum_stock_level' => $stock_level,
			'unit_id' => $unit_id
		);

		$this->db->insert( 'minimum_product_stock_levels', $data );
	}

	public function count_number_of_low_stock_levels()
	{
		$query = "SELECT COUNT(ps.`product_id`) total
					FROM $this->product_stock_levels_table ps
					INNER JOIN minimum_product_stock_levels m ON m.`product_id` = ps.`product_id`
					WHERE ps.`current_stock_level` < m.`minimum_stock_level`;";

		return $this->sir->format_query_result_as_array($query);
	}

	public function get_low_stock_level_items()
	{
		$query = "SELECT p.`product_id`, p.`product_name`, ps.`current_stock_level`, c.`category_name`
					FROM products p
					INNER JOIN $this->product_stock_levels_table ps ON p.`product_id` = ps.`product_id`
					INNER JOIN minimum_product_stock_levels m ON m.`product_id` = ps.`product_id`
					INNER JOIN product_location_categories c ON c.`category_id` = p.`product_category_id`
					WHERE ps.`current_stock_level` < m.`minimum_stock_level`;";

		return $this->sir->format_query_result_as_array($query);
	}

	public function count_low_stock_items_per_category()
	{
		$query = "SELECT COUNT(ps.`product_id`) low_stock_count, c.`category_name`, c.`category_id`
					FROM products p
					INNER JOIN $this->product_stock_levels_table ps ON p.`product_id` = ps.`product_id`
					INNER JOIN minimum_product_stock_levels m ON m.`product_id` = ps.`product_id`
					INNER JOIN product_location_categories c ON c.`category_id` = p.`product_category_id`
					WHERE ps.`current_stock_level` < m.`minimum_stock_level`
					GROUP BY c.`category_name`, c.`category_id`;";

		return $this->sir->format_query_result_as_array($query);
	}

	public function low_stock_items_by_category_id($category_id)
	{
		$query = "SELECT p.`product_id`, p.`product_name`, ps.`current_stock_level`, c.`category_name`, c.`category_id`
					FROM products p
					INNER JOIN $this->product_stock_levels_table ps ON p.`product_id` = ps.`product_id`
					INNER JOIN minimum_product_stock_levels m ON m.`product_id` = ps.`product_id`
					INNER JOIN product_location_categories c ON c.`category_id` = p.`product_category_id`
					WHERE ps.`current_stock_level` < m.`minimum_stock_level`
					AND c.`category_id` = $category_id;";

		return $this->sir->format_query_result_as_array($query);
	}

	public function get_minimum_maximum_stock_level_by_product_id( $product_id )
	{
		$query = "select *
					from minimum_product_stock_levels
					where product_id = $product_id";

		return $this->sir->format_query_result_as_array($query);
	}

	public function update_stock_level_by_product_id($product_id, $new_stock_level){
		$query = "update $this->product_stock_levels_table
					set current_stock_level = $new_stock_level
					where product_id = $product_id;";

		return $this->db->query($query);
	}

	public function minimum_stock_level_reached_after_being_dispatched($product_name, $amount)
	{
		$product_id = $this->get_product_id_from_product_name($product_name);
		$product_id = $product_id[0]["product_id"];

		$minimum_stock_level = $this->get_minimum_maximum_stock_level_by_product_id($product_id);
		$min_level = $minimum_stock_level[0]["minimum_stock_level"];

		$product_level_info = $this->get_stock_level_by_product_id($product_id);
		$current_stock_level = $product_level_info[0]["current_stock_level"];

		$stock_level_after_requisition = $current_stock_level - $amount;
		
		$this->update_stock_level_by_product_id($product_id, $stock_level_after_requisition);		

		if( $stock_level_after_requisition < $min_level ){
			return true;
		}
		return false;
	}

	public function calculate_requisition_cost_for_product($product_name, $amount){
		$product_information = $this->get_product_by_product_name( $product_name );
		if( empty($product_information) ){
			return 0;
		} else {
			$price = $product_information[0]["price"];
			return $price * $amount;
		}	
	}

	public function get_product_id_from_product_name_id($product_name_id){
		if( !empty($product_name_id) ){
			$last_occurrence_of_open_bracket = strrpos($product_name_id, "(");
			$last_occurrence_of_close_bracket = strrpos($product_name_id, ")");

			return substr($product_name_id, $last_occurrence_of_open_bracket, $last_occurrence_of_close_bracket);
		} //end of if
	} //end of function

	public function get_product_name_from_product_name_id($product_name_id){
		if( !empty($product_name_id) ){
			$last_occurrence_of_open_bracket = strrpos($product_name_id, "(");

			return substr($product_name_id, 0, $last_occurrence_of_open_bracket);
		} //end of if
	} //end of function

	private function barcode_exist_for_product( $product_id ){
		$query = "SELECT *
					FROM generated_barcodes
					WHERE product_id = $product_id;";

		$result = $this->sir->format_query_result_as_array($query);

		if( empty($result) ){
			return false;
		}
		return true;
	}

	public function save_generated_product_barcode( $product_id, $barcode ){

		if( !Products_model::barcode_exist_for_product( $product_id ) ){
			$data = array(
				"product_id" => $product_id,
				"barcode" => $barcode,
				"date_generated" => date("Y-m-d H:i:s"),
				"generated_by_employee_id" => $this->session->userdata('user_id')
			);

			return $this->db->insert( "generated_barcodes", $data );
		}		
	}

	public function store_generated_barcode( $barcode ){

		//$barcode_image = Zend_Barcode::render('code128', 'image', array('text'=>$barcode), array());
		$barcode_image = Zend_Barcode::draw('upca', 'image', array('text' => $barcode), array());
		$store_image = imagepng($barcode_image,"uploads/generated-barcodes/{$barcode}.png");
	}

	public function get_all_generated_barcodes(){
		$query = "SELECT p.`product_id`, p.`product_name`, gb.`barcode`, gb.`date_generated`, 
					CONCAT(u.`first_name`, ' ', u.`last_name`) generated_by, c.`category_name`
					FROM products p
					INNER JOIN generated_barcodes gb ON p.`product_id` = gb.`product_id`
					INNER JOIN product_location_categories c ON c.`category_id` = p.`product_category_id`
					INNER JOIN sir_users u ON u.`user_id` = gb.`generated_by_employee_id`
					ORDER BY gb.`generated_by_employee_id` DESC;";

		return $this->sir->format_query_result_as_array($query);
	}

	public function get_generated_barcode_by_product_id( $product_id ){
		$query = "SELECT p.`product_id`, p.`product_name`, gb.`barcode`, gb.`date_generated`, 
					CONCAT(u.`first_name`, ' ', u.`last_name`) generated_by, c.`category_name`
					FROM products p
					INNER JOIN generated_barcodes gb ON p.`product_id` = gb.`product_id`
					INNER JOIN product_location_categories c ON c.`category_id` = p.`product_category_id`
					INNER JOIN sir_users u ON u.`user_id` = gb.`generated_by_employee_id`
					WHERE p.`product_id` = $product_id;";

		return $this->sir->format_query_result_as_array($query);
	}

	public function insert_product_minimum_maximum_stock_level( $product, $new_stock_level, $min_max_data ){
		$product_stock_level = Products_model::get_stock_level_by_product_id($product_id);

		if( empty($product_stock_level) ){ //no stock level exist for product

			$new_stock_level_data = array(
				"product_id" => $product_id,
				"current_stock_level" => $new_stock_level
			);

			if(Products_model::insert_single_product_stock_level( $new_stock_level_data )){ //insert new record
				
				$product_min_max_data = Products_model::get_minimum_maximum_stock_level_by_product_id($product_id);

				if( empty( $product_min_max_data ) ){ //if no min max record exist
					$min_max_data["product_id"] = $product_id;
					if( $this->db->insert( $this->minimum_product_stock_levels_table, $min_max_data ) ){
						return true;
					} else {
						Products_model::delete_product_stock_level_record($product_id);
						return false;
					}
				} else { //record exist and should be updated
					if( $this->db->update( $this->minimum_product_stock_levels_table, $min_max_data, "product_id = " . $product_id ) ){
						return true;
					} else {
						Products_model::delete_product_stock_level_record($product_id);
						return false;
					}
				}
			} else { //return false if stock level was not inserted
				return false;
			}
		} else {
			if(Products_model::update_single_product_stock_level( $product_id, $new_stock_level )){
				
				$product_min_max_data = Products_model::get_minimum_maximum_stock_level_by_product_id($product_id);

				if( empty( $product_min_max_data ) ){ //if no min max record exist
					$min_max_data["product_id"] = $product_id;
					if( $this->db->insert( $this->minimum_product_stock_levels_table, $min_max_data ) ){
						return true;
					} else {
						Products_model::delete_product_stock_level_record($product_id);
						return false;
					}
				} else { //record exist and should be updated
					if( $this->db->update( $this->minimum_product_stock_levels_table, $min_max_data, "product_id = " . $product_id ) ){
						return true;
					} else {
						Products_model::delete_product_stock_level_record($product_id);
						return false;
					}
				}
			} else {
				return false;
			}
		}
	}

	public function update_product_minimum_maximum_stock_level( $product_id, $new_stock_level, $min_max_data ){
		$product_stock_level = Products_model::get_stock_level_by_product_id($product_id);

		if( empty($product_stock_level) ){ //no stock level exist for product

			$new_stock_level_data = array(
				"product_id" => $product_id,
				"current_stock_level" => $new_stock_level
			);

			if(Products_model::insert_single_product_stock_level( $new_stock_level_data )){ //insert new record
				
				$product_min_max_data = Products_model::get_minimum_maximum_stock_level_by_product_id($product_id);

				if( empty( $product_min_max_data ) ){ //if no min max record exist
					$min_max_data["product_id"] = $product_id;
					if( $this->db->insert( $this->minimum_product_stock_levels_table, $min_max_data ) ){
						return true;
					} else {
						Products_model::delete_product_stock_level_record($product_id);
						return false;
					}
				} else { //record exist and should be updated
					if( $this->db->update( $this->minimum_product_stock_levels_table, $min_max_data, "product_id = " . $product_id ) ){
						return true;
					} else {
						Products_model::delete_product_stock_level_record($product_id);
						return false;
					}
				}
			} else { //return false if stock level was not inserted
				return false;
			}
		} else {
			$update_stock_level_data = array(
				"current_stock_level" => $new_stock_level
			);

			if(Products_model::update_single_product_stock_level( $product_id, $update_stock_level_data )){
				
				$product_min_max_data = Products_model::get_minimum_maximum_stock_level_by_product_id($product_id);

				if( empty( $product_min_max_data ) ){ //if no min max record exist
					$min_max_data["product_id"] = $product_id;
					if( $this->db->insert( $this->minimum_product_stock_levels_table, $min_max_data ) ){
						return true;
					} else {
						Products_model::delete_product_stock_level_record($product_id);
						return false;
					}
				} else { //record exist and should be updated
					if( $this->db->update( $this->minimum_product_stock_levels_table, $min_max_data, "product_id = " . $product_id ) ){
						return true;
					} else {
						Products_model::delete_product_stock_level_record($product_id);
						return false;
					}
				}
			} else {
				return false;
			}
		}
	}

	public function insert_single_product_stock_level( $new_stock_level_data ){
		return $this->db->insert( $this->product_stock_levels_table, $new_stock_level_data );
	}

	public function update_single_product_stock_level( $product_id, $new_stock_level_data ){
		return $this->db->update( $this->product_stock_levels_table, $new_stock_level_data, "product_id = " . $product_id );
	}

	public function delete_minimum_product_stock_level_record( $product_id ){
		return $this->db->delete($this->minimum_product_stock_levels_table, array('product_id' => $product_id)); 
	}

	public function delete_product_stock_level_record( $product_id ){
		return $this->db->delete($this->product_stock_levels_table, array('product_id' => $product_id)); 
	}
}