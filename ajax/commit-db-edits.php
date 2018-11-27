<?php
header('Content-Type: application/json');

//echo session_id();exit;

require_once("dbcontroller.php");
$db_handle = new DBController();

if ($_SERVER['REQUEST_METHOD']=='POST') {
  $input = filter_input_array(INPUT_POST);
} else {
  $input = filter_input_array(INPUT_GET);
}

$price = str_replace("$", "", $input["price"]);
$product_id = $input["id"];
$product_name = strtoupper($input["product_name"]);
$description = $input["description"];
//$unit_id = $input["unit_id"];
$level = $input["level"];

$result = $db_handle->update_product_price_unit_level($product_id, $product_name, $description, $price, $level);
echo json_encode($input);