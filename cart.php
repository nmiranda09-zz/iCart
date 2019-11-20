<?php 
	include "server/functions.php"; 
?>

<!DOCTYPE html>
<html>
<head>
	<title>Cart Demo</title>
	<?php include "meta.php"; ?>
</head>
<body class="page-cart">
	<header>
		<div class="logo-container">
			<a href="./">
				<img src="img/iCart-logo.png" alt="iCart"/>
			</a>
		</div>

		<div class="cart-container"></div>
	</header>

	<div class="page-main">
		

		<div class="checkout-container">
			<div class="users-container">
				<?php getUsers(); ?>
			</div>

			<h1>Cart Summary</h1>

			<?php getCart(); ?>

			<div id="myModal" class="modal" style="display: none;">

				<!-- Modal content -->
				<div class="modal-content">
				    <span class="close" style="text-align: right;">
				    	<i class="fa fa-window-close" aria-hidden="true"></i>
				    </span>

				    <div class="action">
				    	<input type="text" id="qtyUpdate" placeholder="Add New Quantity">
				    	<button id="updateValue" type="submit" onclick="saveUpdate()" >Update</button>	
				    </div>

				    
				</div>
			</div>

		</div>
	</div>
	<?php include "footer.php"; ?>
</body>
</html>