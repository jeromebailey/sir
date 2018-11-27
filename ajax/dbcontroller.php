<?php
class DBController {
	private $host = "localhost";
	private $user = "root";
	private $password = "password";
	private $database = "gcg_sir";
	private $conn;
	
	function __construct() {
		$this->conn = $this->connectDB();
	}
	
	function connectDB() {
		$conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
		return $conn;
	}
	
	function runQuery($query) {
		$result = mysqli_query($this->conn,$query);
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;
	}

	public function update_product_price_unit_level($product_id, $product_name, $description, $price, $level){
		$query = "update products 
					set price = '$price',
					product_name = '$product_name',
					description = '$description'
					where product_id = $product_id;";
                
        if(mysqli_query($this->conn,$query)){
        	return $this->update_product_level( $product_id, $level );
        } else {
        	return "0";
        }
	}

	public function update_product_level($product_id, $level){

		if( $this->product_level_exists( $product_id ) ){
			$query = "update product_stock_levels 
					set current_stock_level = $level
					where product_id = $product_id;";
                
        	return mysqli_query($this->conn,$query);
		} else {
			$query = "insert into product_stock_levels (product_id, current_stock_level)
					values ( $product_id, $level );";
                
        	return mysqli_query($this->conn,$query);
		}
	}

	public function product_level_exists( $product_id ){
		$query = "SELECT * FROM `product_stock_levels` WHERE product_id = $product_id";

		$result = mysqli_query($this->conn,$query);

        while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return true;
		else
			return false;
	}
	
	function numRows($query) {
		$result  = mysqli_query($this->conn,$query);
		$rowcount = mysqli_num_rows($result);
		return $rowcount;	
	}
}
?>