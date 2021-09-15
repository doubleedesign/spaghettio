<!DOCTYPE html>
<html lang="en">
<head>
	<title>Spaghettio Admin</title>
	<?php include('partials/head.php'); ?>
</head>
<body>

	<?php include('partials/header.php'); ?>

	<main>
		<?php
			$heading = 'Submit a restaurant';
			include('partials/page-heading.php');
		?>

		<section class="page-content">
			<div class="container">
				<form class="page-form" method="post" action="process.php" enctype="multipart/form-data">

					<fieldset>
						<legend>Restaurant Details</legend>
						<div class="form-row">
							<label for="name">Name</label>
							<input id="name" name="name" type="text"/>
						</div>
						<div class="form-row">
							<label for="address">Address</label>
							<input id="address" name="address" type="text"/>
						</div>
						<div class="form-row">
							<label for="description">Description</label>
							<textarea id="description" name="description"></textarea>
						</div>
					</fieldset>

					<fieldset>
						<legend>Restaurant Image</legend>
						<div class="form-row">
							<label for="image">Image</label>
							<input id="image" name="image" type="file"/>
						</div>
						<div class="form-row">
							<label for="imageCreator">Image creator name</label>
							<input id="imageCreator" name="imageCreator" type="text"/>
						</div>
						<div class="form-row">
							<label for="imageSourceURL">Image source URL</label>
							<input id="imageSourceURL" name="imageSourceURL" type="text"/>
						</div>
					</fieldset>

					<div class="button-wrap">
						<input type="submit" value="Submit"/>
					</div>

				</form>
			</div>
		</section>

	</main>

	<?php include('partials/footer.php'); ?>

</body>
</html>