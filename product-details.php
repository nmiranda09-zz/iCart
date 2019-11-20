<?php 
	include "server/functions.php";
?>

<!DOCTYPE html>
<html>
<head>
	<title>Cart Demo</title>
	<?php include "meta.php"; ?>
</head>
<body class="page-product">
	<header>
		<div class="logo-container">
			<a href="./">
				<img src="img/iCart-logo.png" alt="iCart"/>
			</a>
		</div>

		<div class="cart-container"></div>
	</header>

	<div class="page-main">
		<div class="product-details-container">
			<div class="users-container">
				<?php getUsers(); ?>
			</div>
			<?php productDetails(); ?>	
		</div>

		<div class="rating-summary-container">
			<h2>Rating Summary</h2>
			<?php ratingSummary(); ?>	
		</div>

		<?php ratings(); ?>
	</div>
	<?php include "footer.php"; ?>
</body>
</html>