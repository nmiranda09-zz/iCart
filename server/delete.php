<?php 
if(isset($_POST)){
	include"db_conn.php";

	$deleteValue = $_POST['deleteValue'];
	$user = $_POST['user'];

	$sql_getQuantity = mysqli_query($db, "SELECT * FROM cart, products WHERE product_id = '$deleteValue' AND cart.user_id = '$user'");
	$getQuantity_query = mysqli_fetch_array($sql_getQuantity);

	$cartQty = $getQuantity_query['cart_qty'];
	$prodQty = $getQuantity_query['qty'];

	$qtyTotal = $prodQty + $cartQty;

	$sql_updateCart = "UPDATE cart, products SET cart.status = '0', cart.cart_qty = '0', products.qty = '$qtyTotal' WHERE cart.product_id = '$deleteValue' AND products.id = '$deleteValue' AND cart.user_id = '$user'";
	mysqli_query($db, $sql_updateCart);		
}
?>