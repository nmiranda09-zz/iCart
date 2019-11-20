<?php 

	function cartItems() {
		include "db_conn.php";

		$sql_countCart = "SELECT * FROM cart, users WHERE cart.status = '1' AND cart.user_id = users.id";
		$countCart_query = mysqli_query($db, $sql_countCart);
		$count = 0;

		while ($rows = mysqli_fetch_array($countCart_query)) {
		$count++;
		

		}

		echo $count;
	}
	
	function getProducts() {
		include "db_conn.php";
		
		$sql_getProducts = "SELECT * FROM products";
		$getProducts_query = mysqli_query($db, $sql_getProducts);

		while ($rows = mysqli_fetch_array($getProducts_query)) {
			$name = $rows['name'];
			$price = $rows['price'];
			$ratings = $rows['ratings'];
			$thumbnail = $rows['thumbnail'];

			?>
				<div class="product">
					<div class="product-img" style="background-image: url('<?php echo 'img/'.$thumbnail; ?>')"></div>
					<div class="product-info">
						<div class="ratings-container">
							<span class="product-ratings rating-<?php echo $ratings; ?>">
								<span class="fa fa-star"></span>
								<span class="fa fa-star"></span>
								<span class="fa fa-star"></span>
								<span class="fa fa-star"></span>
								<span class="fa fa-star"></span>
							</span>	
						</div>
						
						<span class="product-name"><?php echo $name; ?></span><br/>
						<span class="product-price">Price: $<?php echo $price; ?></span><br/>
						<?php echo "<a href = 'product-details.php?id=".$rows['id']."&user=1'"; ?> title="View Details">View Details</a>
					</div>
				</div>
			<?php
		}
	}

	function productDetails() {
		include "server/db_conn.php";
		$id = $_GET['id'];

		$sql_getProducts = "SELECT * FROM products WHERE id = '$id' ";
		$getProducts_query = mysqli_query($db, $sql_getProducts);

		while ($rows = mysqli_fetch_array($getProducts_query)) {
			$name = $rows['name'];
			$desc = $rows['description'];
			$price = $rows['price'];
			$qty = $rows['qty'];
			$ratings = $rows['ratings'];
			$thumbnail = $rows['thumbnail'];

			?>
				<div class="product-image" style="background-image: url('<?php echo 'img/'.$thumbnail; ?>')">
				</div>

				<div class="product-info">
					<div class="name-description">
						<span><?php echo $name; ?></span><br/>
						<p><?php echo $desc; ?></p>	
					</div>

					<div class="others">
						<div class="ratings-container">
							<span>Overall Rating: </span>
							<span class="product-ratings rating-<?php echo $ratings; ?>">
								<span class="fa fa-star"></span>
								<span class="fa fa-star"></span>
								<span class="fa fa-star"></span>
								<span class="fa fa-star"></span>
								<span class="fa fa-star"></span>
							</span><br/>
						</div>
						
						<span class="price">Price: $<?php echo $price; ?></span><br/>
						<span class="qty">Quantity: <?php echo $qty; ?></span><br/>

						<div class="action">
							<span class="qty-ticker">

								<button class="sub"><i class="fas fa-minus"></i></button>
								<input class="qty" type="text" name="qty" value="1" />
								<button class="add"><i class="fas fa-plus"></i></button>
							</span>
							<button class="addto" type="submit" value="<?php echo $_GET['id']; ?>" onclick="addToCart()">Add to Cart</button>
						</div>
					</div>
					
				</div>
			<?php
		}
	}

	function ratings() {
		include "db_conn.php";

		$id = $_GET['id'];

		$sql_getRatingID = mysqli_query($db, "SELECT * FROM products WHERE id = '$id'");
		$getRatingID_query = mysqli_fetch_array($sql_getRatingID);
		$ratings = $getRatingID_query['ratings'];

		?>
		<div class="add-rating">
			<h2>Rate this product</h2>
			<span>5 highest - 1 lowest</span><br/>
			<div class='rating-stars'>
				<input type="hidden" id="productID" value="<?php echo $getRatingID_query['id']; ?>">
			    <ul id='stars'>
			      <li class='star' title='Poor' data-value='1'>
			        <i class='fa fa-star fa-fw'></i>
			      </li>
			      <li class='star' title='Fair' data-value='2'>
			        <i class='fa fa-star fa-fw'></i>
			      </li>
			      <li class='star' title='Good' data-value='3'>
			        <i class='fa fa-star fa-fw'></i>
			      </li>
			      <li class='star' title='Excellent' data-value='4'>
			        <i class='fa fa-star fa-fw'></i>
			      </li>
			      <li class='star' title='WOW!!!' data-value='5'>
			        <i class='fa fa-star fa-fw'></i>
			      </li>
			    </ul>
			  </div>
			  <button type="submit" value="<?php echo $_GET['id']; ?>" onclick="addRate()">Rate Now!</button>
		</div>
		<?php
	}

	function getCart() {
		include "db_conn.php";
		$userId = $_GET['id'];
		$pick_up = '0';
		$ups = '5';
		$cart_total = 0;

		$sql_userCash = mysqli_query($db, "SELECT * FROM users WHERE id = '$userId'");
		$userCash_query = mysqli_fetch_array($sql_userCash);
		$cash = $userCash_query['cash'];


		$sql_cartProducts = "SELECT *  FROM cart, products WHERE cart.product_id = products.id AND cart.status='1' AND cart.user_id = '$userId' ORDER BY cart.id DESC";
		$cartProducts_query = mysqli_query($db, $sql_cartProducts);

		?>
		<table>
			<thead>
				<tr>
					<th class="name">Name</th>
					<th class="qty">Quantity</th>
					<th class="price">Total Price</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php 
			$count = 0;
			$product_id;
			
			if (mysqli_num_rows($cartProducts_query) == 0) {
				echo "<tr><td style='width: 100%; text-align: center;'>No Items in Cart</td></tr>";
			} else {
				while ($rows = mysqli_fetch_array($cartProducts_query)) {
					$name = $rows['name'];
					$prod_price = $rows['price'];
					$qty = $rows['cart_qty'];
					$total_price = $rows['price'] * $qty;
					$cart_total += $total_price;
					$count++;
					$productID = $rows['product_id'];
					?>

					<tr>
						<td class="name"><?php echo $name . '<br/>$' . $prod_price; ?></td>
						<td class="qty" data-needed="<?php echo $qty; ?>"><?php echo $qty; ?></td>
						<td class="price">$<?php echo $total_price; ?></td>
						<td>
							<button id="updateCart" type="submit" onclick="openModal(this)" value="<?php echo $rows['product_id']; ?>"><i class="far fa-edit"></i></button>
							<button type="submit"  onclick="deleteCart(this)" value="<?php echo $rows['product_id']; ?>"><i class="fas fa-trash"></i></button></td>
						
					</tr>
					<?php
				}	
			}
			
			?>
			</tbody>
		</table>
		<input type="hidden" id="countValue" value="<?php echo $count; ?>">
		<div class="transport-options">
			<strong>Select Transport:</strong><br/>
			<div class="radio">
				<input type="radio" name="radio" value="0" onclick="radioValue()">Pick Up: $<?php echo $pick_up; ?></input><br/>	
			</div>
			<div class="radio">
				<input type="radio" name="radio" value="5" onclick="radioValue()">UPS: $<?php echo $ups; ?></input>
			</div>
		</div>
		<div class="summary">
			<span class="cart-total" data-needed="<?php echo $cart_total; ?>">Cart Total: $<?php echo $cart_total; ?></span><br/>
			<span class="options"></span><br/>
			<span class="grand-total"></span><br/>
			<span class="v-cash" data-needed="<?php echo $cash; ?>">Virtual Cash: $<?php echo $cash; ?></span><br/>
			<button class="pay" type="submit" title="Submit" onclick="payment()">Pay</button>
		</div>
		<?php
	}

	function getUsers() {
		include "db_conn.php";

		$sql_getUsers = "SELECT * FROM users";
		$getUsers_query = mysqli_query($db, $sql_getUsers);
		?>
		<span>Select Customer</span>
		<select name="users">
			<?php
			while ($rows = mysqli_fetch_array($getUsers_query)) {
				$id = $rows['id'];
				
				?>
				<option value="<?php echo $id; ?>"><?php echo $id; ?></option>
				<?php
			}
		?>
		</select>
		<?php
	}

	function ratingSummary() {
		include "db_conn.php";
		$id = $_GET['id'];

		$sql_getSummary = "SELECT *  FROM rate WHERE product_id = '$id' ORDER BY id DESC";
		$getSummary_query = mysqli_query($db, $sql_getSummary);

	  	if (mysqli_num_rows($getSummary_query) == 0) {
	  	  	echo "<p>No ratings available</p>";
	  	} else {
				while ($rows = mysqli_fetch_array($getSummary_query)) {
	  			?>
	  			<span class="user">User: <?php echo $rows['user_id']; ?></span><br/>
		  		<div class="ratings-container">
					<span class="product-ratings rating-<?php echo $rows['rate']; ?>">
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
					</span>	
				</div>
	  			<?php
	  		}
	  	}
	}
?>