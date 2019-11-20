<?php 
		include "db_conn.php";

		$sql_getProducts = "SELECT * FROM products WHERE id = '$id' ";
		$getProducts_query = mysqli_query($db, $sql_getProducts);

		while ($rows = mysqli_fetch_array($getProducts_query)) {
			
			echo $qty = $rows['qty'];
		}
	

 ?>