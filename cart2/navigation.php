<!-- navbar -->
<div class="navbar navbar-default navbar-static-top" role="navigation">
	<div class="container">

		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="products.php">Webstore</a>
		</div>

		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav">

			
				<li <?php echo strpos($page_title, "Product")!==false || isset($category_id) ? "class='active dropdown'" : "class='dropdown'"; ?>>
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
						Products <span class="caret"></span>
					</a>
					<ul class="dropdown-menu" role="menu">

						
						<li <?php echo strpos($page_title, 'Product')!==false && !isset($category_name) ? "class='active'" : ""; ?>>
							<a href="products.php">All Products</a>
						</li>

						<?php
					
						$stmt=$category->readWithoutPaging();

					
						$num = $stmt->rowCount();

						if($num>0){
							while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

								
								if(isset($category_name) && $category_name==$row['name']){
									echo "<li class='active'><a href='category.php?id={$row['id']}'>{$row['name']}</a></li>";
								}

								
								else{
									echo "<li><a href='category.php?id={$row['id']}'>{$row['name']}</a></li>";
								}
							}
						}
						?>
					</ul>
				</li>

				<li <?php echo $page_title=="Cart" ? "class='active'" : ""; ?> >
					<a href="cart.php">
						<?php
					
						$cart_item->user_id=1; // default to user with ID "1" for now
						$cart_count=$cart_item->count();
						?>
						Cart <span class="badge" id="comparison-count"><?php echo $cart_count; ?></span>
					</a>
				</li>
			</ul>

			<form action="search.php" class="navbar-form navbar-left pull-right" role="search">
				<div class="form-group">
					<input type="text" name="s" class="form-control" placeholder="Type product name..." required>
				</div>
				<button type="submit" class="btn btn-default">Search</button>
			</form>

		</div>

	</div>
</div>
<!-- /navbar -->
