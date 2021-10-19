<?php
require_once('database/config.php');
require_once('database/dbController.php');
$db = new dbController();
$db->dbConnect(HOST, USER, PASS, DB);
$id = $_GET['id'];
$restaurant = $db->getRestaurantById($id);
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
			<div class="restaurant-details-banner">
				<img src="<?php echo $restaurant['imagePath']; ?>" alt=""/>
				<h1><?php echo $restaurant['name']; ?></h1>
			</div>
			<div class="row">
				<div class="restaurant-details-copy">
					<p><?php echo $restaurant['description']; ?></p>
				</div>
				<div class="restaurant-details-address">
					<i class="fas fa-map-marker-alt"></i>
					<p><strong><?php echo $restaurant['category']; ?></strong></p>
					<p><?php echo $restaurant['address']; ?></p>
				</div>
			</div>
		</div>
	</main>

	<?php include('partials/footer.php'); ?>

</body>

</html>