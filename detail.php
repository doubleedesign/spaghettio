<?php
// TODO: Grab these values from database
$name = 'La Porchetta';
$description = 'Italian on a budget, family restaurant';
$address = ''
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Spaghettio - Restaurant Detail</title>
	<?php include('partials/head.php'); ?>
</head>
<body>

	<?php include('partials/header.php'); ?>

	<main class="restaurant-details">
		<div class="container">
			<div class="restaurant-details-image">
				<img src="images/tacyra-autrey-jYQd0TbO__0-unsplash.jpg" alt="Placeholder image"/>
			</div>
			<div class="row">
				<div class="restaurant-details-copy">
					<h1><?php echo $name; ?></h1>
					<p><?php echo $description; ?></p>
				</div>
				<div class="restaurant-details-address">
					<p>Shop RE1, Pacific Werribee, Cnr Derrimut Rd Heaths Rd Werribee 3030</p>
				</div>
			</div>
		</div>
	</main>

	<?php include('partials/footer.php'); ?>

</body>

</html>