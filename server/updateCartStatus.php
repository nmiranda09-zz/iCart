<?php 
if(isset($_POST)){
	include"db_conn.php";

	$id = $_POST['id'];
 	$cartStatus = $_POST['cartStatus'];
 	$total = $_POST['total'];
 

	$sql_updateCart = "UPDATE cart, users SET cart.status = '0', cart.cart_qty = '0', users.cash = '$total' WHERE users.id = '$id' AND cart.user_id = '$id'";
    mysqli_query($db, $sql_updateCart);		
}
?>
