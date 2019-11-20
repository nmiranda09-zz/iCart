<?php
if($_POST){
	include"db_conn.php";

	$qty = $_POST['qty'];
	$value = $_POST['value'];
    $user = $_POST['user'];

    $sql_getQuantity = mysqli_query($db, "SELECT * FROM cart, products WHERE cart.product_id = '$value' AND cart.product_id = products.id AND cart.user_id = '$user'");
	$getQuantity_query = mysqli_fetch_array($sql_getQuantity);
	$product_id = $getQuantity_query['product_id'];
	$cart_user = $getQuantity_query['user_id'];
	$cart_qty = $getQuantity_query['cart_qty'];
	$add_qty = $cart_qty + $qty;
	$sub_qty = $getQuantity_query['qty'] - $qty;

	if ($value == $product_id){

		$sql_updateCart = "UPDATE cart, products SET cart.cart_qty = '$add_qty', products.qty = '$sub_qty', status = '1', cart.user_id = '$user' WHERE cart.product_id = '$value' AND cart.product_id = products.id AND cart.user_id = '$user'";
	    mysqli_query($db, $sql_updateCart);

	} else {

		$sql_insertCart = "INSERT INTO cart (product_id, cart_qty, status, user_id) VALUES ('$value', '$qty', '1', '$user')";
		mysqli_query($db, $sql_insertCart);

		$sql_checkCart = mysqli_query($db, "SELECT * FROM cart, products WHERE cart.product_id = '$value' AND cart.product_id = products.id AND cart.user_id = '$user'");
		$checkCart_query = mysqli_fetch_array($sql_checkCart);
		$checkCart_qty = $checkCart_query['cart_qty'];
		$checkSub_qty = $checkCart_query['qty'] - $checkCart_qty;
		

		$sql_updateCart = "UPDATE products SET qty = '$checkSub_qty' WHERE id = '$value'";
        mysqli_query($db, $sql_updateCart);		

	}	
}

	
?>