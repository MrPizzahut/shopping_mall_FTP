<?php

header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');


include 'config/database.php';


include_once "objects/cart_item.php";


$database = new Database();
$db = $database->getConnection();


$cart_item = new CartItem($db);


$cart_item->user_id=1; // default to '1' because it does not have logged in user
$cart_item->deleteByUser();


header('Location: cart.php?action=cart_emptied');
die();
?>
