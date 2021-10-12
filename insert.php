<?php
require_once('database/config.php');
require_once('database/dbController.php');
$db = new dbController();
$db->dbConnect(HOST, USER, PASS, DB);
if(isset($_GET['id'])) {
	$id = $_GET['id'];
	$restaurant = $db->getRestaurantById($id);
}
else {
	$restaurant = false;
}
?>

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
		if(is_array($restaurant)) {
			$heading = 'Update restaurant';
		}
		else {
			$heading = 'Submit a restaurant';
		}
		include('partials/page-heading.php');
		?>

		<section class="page-content">
			<div class="container">
				<form class="page-form" method="post" action="process.php" enctype="multipart/form-data">

					<?php
					if(isset($restaurant['ID'])) { ?>
						<input type="hidden" name="ID" value="<?php echo $restaurant['ID']; ?>"/>
					<?php } ?>

					<fieldset>
						<legend>Restaurant Details</legend>
						<div class="form-row">
							<label for="name">Name</label>
							<input id="name" name="name" type="text" value="<?php echo $restaurant ? $restaurant['name'] : '';  ?>"/>
						</div>
						<div class="form-row">
							<label for="address">Address</label>
							<input id="address" name="address" type="text" value="<?php echo $restaurant ? $restaurant['address'] : '';  ?>"/>
						</div>
						<div class="form-row">
							<label for="description">Description</label>
							<textarea id="description" name="description"><?php echo $restaurant ? $restaurant['address'] : '';  ?></textarea>
						</div>
					</fieldset>

					<fieldset>
						<legend>Restaurant Image</legend>
							<?php if(isset($restaurant['imagePath'])) { ?>
							<div class="form-row">
								<div class="image-wrap">
									<img src="<?php echo $restaurant['imagePath']; ?>" alt="Listing image for <?php echo $restaurant['name']; ?>"/>
								</div>
							</div>
						<?php } ?>
						<div class="form-row">
							<label for="image">Image</label>
							<input id="image" name="image" type="file"/>
						</div>
						<div class="form-row">
							<label for="imageCreator">Image creator name</label>
							<input id="imageCreator" name="imageCreator" type="text" value="<?php echo $restaurant ? $restaurant['imageCreator'] : '';  ?>"/>
						</div>
						<div class="form-row">
							<label for="imageSourceURL">Image source URL</label>
							<input id="imageSourceURL" name="imageSourceURL" type="text" value="<?php echo $restaurant ? $restaurant['imageSourceURL'] : '';
							?>"/>
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