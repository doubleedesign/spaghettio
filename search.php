<?php
require_once('database/config.php');
require_once('database/dbController.php');
$db = new dbController();
$db->dbConnect(HOST, USER, PASS, DB);
$searchTerm = $_GET['s'];
$results = $db->search($searchTerm);
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

<?php
	$heading = "Search results for '$searchTerm'";
	include('partials/page-heading.php');
?>

<main class="home-cards">
	<div class="container">
		<?php if($results) { ?>
			<div class="row cards-row">
				<?php
				foreach ( $results as $restaurant ) {
					$id = $restaurant['ID'];
					$url = "detail.php?id=$id";
					$name = $restaurant['name'];
					$description = $restaurant['description'];
					$imagePath = $restaurant['imagePath'];

					if (!empty($name)) {
						include('partials/card.php');
					}
				} ?>
			</div>
		<?php
		} else { ?>
			<div class="alert alert-error">
				<p>No results found.</p>
			</div>
		<?php } ?>
	</div>
</main>

<?php include('partials/footer.php'); ?>

</body>
</html>