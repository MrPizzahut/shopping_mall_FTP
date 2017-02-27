<?php
if(!isset($_SESSION['cart'])){
	$_SESSION['cart']=array();
}

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
	extract($row);

	
	echo "<div class='col-md-4 m-b-20px'>";

		
		echo "<div class='product-id display-none'>{$id}</div>";

		echo "<a href='product.php?id={$id}' class='product-link'>";
		
			$product_image->product_id=$id;
			$stmt_product_image=$product_image->readFirst();

			while ($row_product_image = $stmt_product_image->fetch(PDO::FETCH_ASSOC)){
				echo "<div class='m-b-10px', id='pic'>";
					echo "<img src='uploads/images/{$row_product_image['name']}' class='w-100-pct' />";
				echo "</div>";
			}

		
			echo "<div class='product-name m-b-10px'>{$name}</div>";
		echo "</a>";

		
		if($stock>0){
			echo "<div class='m-b-10px'>";
				echo "&#36;" . number_format($price, 2, '.', ',') . " / " . $category_name . " / ";
				echo "<span class='stock-text'>Only {$stock} stocks left.</span>";
			echo "</div>";

		
			echo "<div class='m-b-10px'>";
			
				$cart_item->user_id=1; // default to a user with ID "1" for now
				$cart_item->product_id=$id;

			
				if($cart_item->exists()){
					echo "<a href='cart.php' class='btn btn-success w-100-pct'>";
						echo "Update Cart";
					echo "</a>";
				}else{
					echo "<a href='add_to_cart.php?id={$id}&page={$page}' class='btn btn-primary w-100-pct'>Add to Cart</a>";
				}
			echo "</div>";

		}

	
		else if($stock==0){
			echo "<div class='m-b-10px'>";
				echo "&#36;" . number_format($price, 2, '.', ',') . " / " . $category_name . " / ";
				echo "<span class='stock-text-red'>Out of stock.</span>";
			echo "</div>";
			echo "<div class='m-b-10px'>";
				echo "<a href='product.php?id={$id}' class='btn btn-info w-100-pct'>";
					echo "View Product";
				echo "</a>";
			echo "</div>";
		}

	echo "</div>";
}

include_once "paging.php";
?>
