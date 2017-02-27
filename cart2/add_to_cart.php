<?php

header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');


$product_id = isset($_GET['id']) ? $_GET['id'] : "";
$quantity = isset($_GET['quantity']) ? $_GET['quantity'] : 1;


$quantity=$quantity<=0 ? 1 : $quantity;


include 'config/database.php';


include_once "objects/cart_item.php";


$database = new Database();
$db = $database->getConnection();


$cart_item = new CartItem($db);


$cart_item->user_id=1; //default to '1' because it does not have logged in user
$cart_item->product_id=$product_id;
$cart_item->quantity=$quantity;


if($cart_item->exists()){

	header("Location: cart.php?action=exists");
}


else{
	
	if($cart_item->create()){
	
		header("Location: product.php?id={$product_id}&action=added");
	}else{
		header("Location: product.php?id={$product_id}&action=unable_to_add");
	}
}
?>
