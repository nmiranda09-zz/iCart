<?php 	
 if (isset($_POST['username_check'])) {
	include"db_conn.php";

	$userID = $_POST['userID'];
	$productID = $_POST['productID'];
	$rateValue = $_POST['rateValue'];

	$sql_checkUser = "SELECT * FROM rate WHERE user_id = '$userID' AND product_id = '$productID'";
  	$checkUser_query = mysqli_query($db, $sql_checkUser);

  	if (mysqli_num_rows($checkUser_query) > 0) {
  	  	echo "true";
  	} else {
  		$sql_insertRate = "INSERT INTO rate (user_id,product_id,rate) VALUES ('$userID', '$productID','$rateValue')";
		mysqli_query($db, $sql_insertRate);

		$sqlRate = "SELECT SUM(rate) As ratecount  FROM rate WHERE product_id = '$productID'";
	    $rate_query = mysqli_query($db, $sqlRate);
	    
	    while ($rows = mysqli_fetch_array($rate_query)) {
	        $rateSum = $rows['ratecount'];
	    }

	    $sql_counter = "SELECT *  FROM rate WHERE product_id = '$productID'";
	    $counter_query = mysqli_query($db, $sql_counter);
	    $count = 0;

	    while ($rows = mysqli_fetch_array($counter_query)) {
	      $count++;
	    }

	    $totalRating = $rateSum / $count;

	    if ($totalRating >= 5) {
	        $totalRating = 5;
	      
	        $sql_prodRating = "UPDATE products SET ratings = '$totalRating' WHERE id = '$productID'";
	        mysqli_query($db, $sql_prodRating);
	    } else {
	        $sql_prodRating = "UPDATE products SET ratings = '$totalRating' WHERE id = '$productID'";
	        mysqli_query($db, $sql_prodRating);
	    }
  	}
}

 ?>