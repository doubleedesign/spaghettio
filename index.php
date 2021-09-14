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
					$name = "La Porchetta";
					$description = 'Italian on a budget, family restaurant';
					include('partials/card.php');
				?>

				<?php
					$name = "Tartufo";
					$description = 'Sunny Brisbane!';
					include('partials/card.php');
				?>

				<?php
					$name = "Pellegrini's";
					$description = 'Classic Melbourne, Bourke St';
					include('partials/card.php');
				?>

				<?php
					$name = "Papa Gino's";
					$description = 'Lygon St goodness';
					include('partials/card.php');
				?>

				<?php
					$name = "Il Gambero";
					$description = 'Bruschetta pizza!';
					include('partials/card.php');
				?>

				<?php
					$name = "Cafe Trevi";
					$description = 'More Lygon St...if only it was within my 5km';
					include('partials/card.php');
				?>
			</div>
		</div>
	</main>

	<?php include('partials/footer.php'); ?>

</body>
</html>