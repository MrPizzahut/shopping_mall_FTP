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


$category_id = isset($_GET['id']) ? $_GET['id'] : die('Category ID not found.');


$category->id=$category_id;
$category_name=$category->readCategoryNameById();


$page_title=$category_name;


include 'layout_head.php';


$page = isset($_GET['page']) ? $_GET['page'] : 1; 
$records_per_page = 5; 
$from_record_num = ($records_per_page * $page) - $records_per_page; 


$product->category_id=$category_id;
$stmt=$product->readByCategoryId($from_record_num, $records_per_page);


$num = $stmt->rowCount();

if($num>0){
	
	$page_url="category.php?id={$category_id}";
	$total_rows=$product->countByCategoryId();

	
	include_once "read_products_template.php";
}


else{
	echo "<div class='col-md-12'>";
    	echo "<div class='alert alert-danger'>No products found in this category.</div>";
	echo "</div>";
}

include 'layout_foot.php';
?>
