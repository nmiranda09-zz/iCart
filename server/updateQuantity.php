<?php 
if(isset($_POST)){
	include"db_conn.php";

	$updateValue = $_POST['updateValue'];
	$qtyValue = $_POST['qtyValue'];
	$user = $_POST['user'];

	$sql_getQuantity = mysqli_query($db, "SELECT * FROM cart, products WHERE product_id = '$updateValue' AND cart.user_id = '$user'");
	$getQuantity_query = mysqli_fetch_array($sql_getQuantity);

	$cartQty = $getQuantity_query['cart_qty'];
	$prodQty = $getQuantity_query['qty'];

	$qtyTotal = ($prodQty + $cartQty) - $qtyValue;

	if ($qtyTotal < 0) {
		echo "error";
	} else {
		$sql_updateCart = "UPDATE cart, products SET cart.cart_qty = '$qtyValue', products.qty = '$qtyTotal' WHERE cart.product_id = '$updateValue' AND products.id = '$updateValue' AND cart.user_id";
		mysqli_query($db, $sql_updateCart);
	}
}
?>