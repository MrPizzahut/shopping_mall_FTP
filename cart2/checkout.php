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


$page_title="Checkout";


include 'layout_head.php';


if($cart_count>0){

	$cart_item->user_id="1";
	$stmt=$cart_item->read();

	$total=0;
	$item_count=0;

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);

		$sub_total=$price*$quantity;

		echo "<div class='cart-row'>";
			echo "<div class='col-md-8'>";

				echo "<div class='product-name m-b-10px'><h4>{$name}</h4></div>";
                echo $quantity>1 ? "<div>{$quantity} items</div>" : "<div>{$quantity} item</div>";

			echo "</div>";

			echo "<div class='col-md-4'>";
				echo "<h4>&#36;" . number_format($price, 2, '.', ',') . "</h4>";
			echo "</div>";
		echo "</div>";

		$item_count += $quantity;
		$total+=$sub_total;
	}

	echo "<form action='place_order.php' method='post'>";
		echo "<div class='col-md-8'>";
			echo "<div class='cart-row'>";
				echo "<table class='table table-responsive table-hover'>";
					echo "<tr>";
						echo "<td>Name:</td>";
						echo "<td><input type='text' name='name' class='form-control' required /></td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td>Address:</td>";
						echo "<td><input type='text' name='address' class='form-control' required /></td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td>Phone:</td>";
						echo "<td><input type='text' name='phone' class='form-control' required /></td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td>Email:</td>";
						echo "<td><input type='text' name='email' class='form-control' required /></td>";
					echo "</tr>";
				echo "</table>";
			echo "</div>";
		echo "</div>";

		echo "<div class='col-md-4 text-align-center'>";
			echo "<div class='cart-row'>";
	            if($item_count>1){
	    			echo "<h4 class='m-b-10px'>Total ({$item_count} items)</h4>";
	            }else{
	                echo "<h4 class='m-b-10px'>Total ({$item_count} item)</h4>";
	            }
				echo "<h4>&#36;" . number_format($total, 2, '.', ',') . "</h4>";

		        echo "<button type='submit' class='btn btn-lg btn-success m-b-10px'>";
		        	echo "<span class='glyphicon glyphicon-shopping-cart'></span> Place Order";
		        echo "</button>";
			echo "</div>";
		echo "</div>";
	echo "</form>";

}

else{
	echo "<div class='col-md-12'>";
		echo "<div class='alert alert-danger'>";
			echo "No products found in your cart!";
		echo "</div>";
	echo "</div>";
}

include 'layout_foot.php';
?>
