<?php 	
	include"db_conn.php";

	$selectedValue = $_POST['selectedValue'];
	$count = 0;

	$sql_getUserId = mysqli_query($db, "SELECT * FROM users WHERE id = '$selectedValue'");
  	$getUserId_query = mysqli_fetch_array($sql_getUserId);
  	$id = $getUserId_query['id'];
  	$cash = $getUserId_query['cash'];

	$sql_cartItems = "SELECT * FROM cart WHERE user_id = '$id'";
	$cartItems_query = mysqli_query($db, $sql_cartItems);

	while ($rows = mysqli_fetch_array($cartItems_query)) {
		$count++;
		$id = $rows['user_id'];	
	}
  	
	echo "<a href = 'cart.php?id=".$id."' title='View Cart'><i class='fas fa-cart-arrow-down'></i><em>( ".$count." )</em></a><span>$".$cash."</span>";
  	
  	
 ?>