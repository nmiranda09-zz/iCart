<?php 
	include "server/functions.php"; 
?>

<!DOCTYPE html>
<html>
<head>
	<title>Cart Demo</title>
	<?php include "meta.php"; ?>
</head>
<body class="page-index">
	<header>
		<div class="logo-container">
			<a href="./">
				<img src="img/iCart-logo.png" alt="iCart"/>
			</a>
		</div>
	</header>

	<div class="page-main">
		<div class="products-container">
			<h1>All Products</h1>
			<div class="products-wrapper">
				<?php getProducts(); ?>	
			</div>
		</div>
	</div>
	<?php include "footer.php"; ?>
</body>
</html>