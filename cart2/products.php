<?php

header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');


include 'config/database.php';


include_once "objects/product.php";
include_once "objects/category.php";
include_once "objects/product_image.php";
include_once "objects/cart_item.php";


$database = new Database();
$db = $database->getConnection();


$product = new Product($db);
$category = new Category($db);
$product_image = new ProductImage($db);
$cart_item = new CartItem($db);


$page_title="Products";


include 'layout_head.php';


$action = isset($_GET['action']) ? $_GET['action'] : "";
$product_id = isset($_GET['product_id']) ? $_GET['product_id'] : "1";
$quantity = isset($_GET['quantity']) ? $_GET['quantity'] : "1";


$page = isset($_GET['page']) ? $_GET['page'] : 1; 
$records_per_page = 6; 
$from_record_num = ($records_per_page * $page) - $records_per_page; 


$stmt=$product->read($from_record_num, $records_per_page);


$num = $stmt->rowCount();


if($num>0){
	
	$page_url="products.php?";
	$total_rows=$product->count();

	
	include_once "read_products_template.php";
}


else{
	echo "<div class='col-md-12'>";
    	echo "<div class='alert alert-danger'>No products found.</div>";
	echo "</div>";
}

include 'layout_foot.php';
?>
