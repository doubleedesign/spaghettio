<?php
	require_once('database/config.php');
	require_once('database/dbController.php');
	$db = new dbController();
	$db->dbConnect(HOST, USER, PASS, DB);
	$credits = $db->getAll('SELECT imagePath, imageCreator, imageSourceURL from restaurant_details');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Spaghettio Image Credits</title>
	<?php include('partials/head.php'); ?>
</head>
<body>

	<?php include('partials/header.php'); ?>

	<main>

		<?php
		$heading = 'Image Credits';
		include('partials/page-heading.php');
		?>

		<section class="page-content">
			<div class="container">
				<div class="row cards-row">
					<?php
					foreach($credits as $credit) {
						$url = $credit['imageSourceURL'];
						$linkTarget = '_blank';
						$imagePath = $credit['imagePath'];
						$description = $credit['imageCreator'];

						include('partials/card.php');
					} ?>
				</div>
			</div>
		</section>
	</main>

	<?php include('partials/footer.php'); ?>

</body>
</html>