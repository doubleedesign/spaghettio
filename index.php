<?php
require_once('database/config.php');
require_once('database/dbController.php');
$db = new dbController();
$db->dbConnect(HOST, USER, PASS, DB);
$restaurants = $db->getAll('SELECT * from restaurant_details');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Spaghettio - Italian Restaurant Directory</title>
	<?php include('partials/head.php'); ?>
</head>
<body>

	<?php include('partials/header.php'); ?>

	<section class="banner">
		<div class="banner-inner">
			<div class="container">
				<h1>Italian Restaurant Directory</h1>
			</div>
		</div>
	</section>

	<main class="home-cards">
		<div class="container">
			<div class="row cards-row">
				<?php
				foreach($restaurants as $restaurant) {
					$id = $restaurant['ID'];
					$url = "detail.php?id=$id";
					$name = $restaurant['name'];
					$description = $restaurant['description'];
					$imagePath = $restaurant['imagePath'];

					if(!empty($name)) {
						include( 'partials/card.php' );
					}
				} ?>
			</div>
		</div>
	</main>

	<?php include('partials/footer.php'); ?>

</body>
</html>