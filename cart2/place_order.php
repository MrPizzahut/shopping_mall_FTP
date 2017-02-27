<?php

header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');

if($_POST){

	include_once "config/database.php";
	include_once "libs/php/util.php";
	include_once "objects/product.php";
	include_once "objects/category.php";
	include_once "objects/order.php";
	include_once "objects/order_item.php";
	include_once "objects/cart_item.php";

	
	$database = new Database();
	$db = $database->getConnection();

	
	$util = new Util();
	$product = new Product($db);
	$category = new Category($db);
	$order = new Order($db);
	$order_item = new OrderItem($db);
	$cart_item = new CartItem($db);

	
	$customer_name=isset($_POST['name']) ? htmlspecialchars(strip_tags($_POST['name'])) : "";
	$customer_address=isset($_POST['address']) ? htmlspecialchars(strip_tags($_POST['address'])) : "";
	$customer_phone=isset($_POST['phone']) ? htmlspecialchars(strip_tags($_POST['phone'])) : "";
	$customer_email=isset($_POST['email']) ? htmlspecialchars(strip_tags($_POST['email'])) : "";


	$page_title="Thank You!";

	
	include_once 'layout_head.php';

	echo "<div class='col-md-12'>";

		
		if($cart_count>0){

		
			$transaction_id=strtoupper(uniqid());

		
			$cart_item->user_id="1";
			$stmt=$cart_item->read();

		
			$total_price=0;
			$item_count=0;

			
			$body="";

			$body.="<table cellpadding='8'>";
			$body.="<tr><td>Dear Admin,</td></tr>";
			$body.="<tr><td>Someone sent an order.</td></tr>";
			$body.="</table>";

			$body.="<table cellpadding='8'>";
				$body.="<tr>";
					$body.="<td>Name:</td>";
					$body.="<td>{$customer_name}</td>";
				$body.="</tr>";
				$body.="<tr>";
					$body.="<td>Address:</td>";
					$body.="<td>{$customer_address}</td>";
				$body.="</tr>";
				$body.="<tr>";
					$body.="<td>Phone:</td>";
					$body.="<td>{$customer_phone}</td>";
				$body.="</tr>";
				$body.="<tr>";
					$body.="<td>Email:</td>";
					$body.="<td>{$customer_email}</td>";
				$body.="</tr>";
			$body.="</table>";

			$body.="<table cellpadding='8'>";
			$body.="<tr>";
				$body.="<td><b>Product</b></td>";
				$body.="<td><b>Pice</b></td>";
				$body.="<td><b>Quantity</b></td>";
			$body.="</tr>";

			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);

			
				$body.="<tr>";
					$body.="<td>{$name}</td>";
					$body.="<td>&#36;{$price}</td>";
					$body.="<td>{$quantity}</td>";
				$body.="</tr>";

			
				$order_item->transaction_id=$transaction_id;
				$order_item->product_id=$id;
				$order_item->price=$price;
				$order_item->quantity=$quantity;

			
				$order_item->create();

			
				$sub_total=$price*$quantity;

			
				$total_price+=$sub_total;

			
			
				$product->id=$id;
				$product->readOne();

			
				$new_stock=$product->stock - $quantity;

			
				$product->stock=$new_stock;
				$product->updateStock();

			}

			$body.="<tr>";
				$body.="<td></td>";
				$body.="<td>Total:</td>";
				$body.="<td>&#36;{$total_price}</td>";
			$body.="</tr>";

			$body.="<tr>";
				$body.="<td colspan='3'>You may reply to contact the customer.</td>";
			$body.="</tr>";

			$body.="</table>";

		
			$order->user_id="1"; // sample user id only
			$order->transaction_id=$transaction_id;
			$order->total_cost=$total_price;
			$order->status="Pending";
			$order->created=date("Y-m-d H:i:s");

	
			$order->create();

		
			$cart_item->user_id=1; // default to '1' because it does not have logged in user
			$cart_item->deleteByUser();

			
			$from_name=$customer_name;
			$from_email=$customer_email;
			$send_to_email="yiyobaby2@naver.com";
			$subject="New Order from {$customer_name}";
			$body=$body;
			$util->sendEmailViaPhpMail($from_name, $from_email, $send_to_email, $subject, $body);

			
			echo "<div class='alert alert-success'>";
				echo "<strong>Your order has been placed!</strong> Thank you very much!";
			echo "</div>";
		}

	
		else{
			echo "<div class='alert alert-danger'>";
				echo "<strong>No products found</strong> in your cart!";
			echo "</div>";
		}

	echo "</div>";


	include_once 'layout_foot.php';
}

else{
	die('Data not posted.');
}
?>
