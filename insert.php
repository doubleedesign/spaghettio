<?php
session_start();
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
$isLoggedIn = false;
if(isset($_SESSION['userID'])) {
	$isLoggedIn = true;
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
				<?php if($isLoggedIn) { ?>
					<form id="insert-form" class="page-form" method="post" action="process.php" enctype="multipart/form-data">

					<div class="form-row">
						<div class="message-box alert"></div>
					</div>

					<?php
					if(isset($restaurant['ID'])) { ?>
						<input type="hidden" name="ID" value="<?php echo $restaurant['ID']; ?>"/>
					<?php } ?>

					<fieldset>
						<legend>Restaurant Details</legend>
						<div class="form-row">
							<label for="name">Name</label>
							<input id="name" name="name" type="text" value="<?php echo $restaurant ? $restaurant['name'] : '';  ?>" required/>
						</div>
						<div class="form-row">
							<label for="address">Address</label>
							<input id="address" name="address" type="text" value="<?php echo $restaurant ? $restaurant['address'] : '';  ?>" required/>
						</div>
						<div class="form-row">
							<label for="description">Description</label>
							<textarea id="description" class="required" name="description" required><?php echo $restaurant ? $restaurant['address'] : '';
							?></textarea>
						</div>
						<div class="form-row">
							<label for="category">Category</label>
							<select id="category" name="category">
								<option disabled>Please select a category</option>
								<?php
								// Set up our categories as value => label pairs
								// The value is what gets saved in the database (and is often a category ID which associates it with more info about the
								// category in a categories table); the label is what the user sees
								$categories = array(
									'family-restaurant' => 'Family restaurant',
									'fine-dining' => 'Fine dining',
									'casual-dining' => 'Casual dining',
									'fast-food' => 'Fast food'
								);
								// Loop through the categories set above and if the value matches the pre-saved one, preselect that instead of  the first value
								// by adding the selected attribute when it does match
								foreach($categories as $value => $label) {
									if($value == $restaurant['category']) { ?>
										<option value="<?php echo $value; ?>" selected><?php echo $label; ?></option>
									<?php
									} else { ?>
										<option value="<?php echo $value; ?>"><?php echo $label; ?></option>
									<?php }
								}
								?>
							</select>
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
							<div class="form-row">
								<label for="image">Image</label>
								<input id="image" name="image" type="file"/>
							</div>
						<?php } else { ?>
							<div class="form-row">
								<label for="image">Image</label>
								<input id="image" name="image" type="file" required/>
							</div>
						<?php } ?>
						<div class="form-row">
							<label for="imageCreator">Image creator name</label>
							<input id="imageCreator" name="imageCreator" type="text" value="<?php echo $restaurant ? $restaurant['imageCreator'] : '';  ?>" required/>
						</div>
						<div class="form-row">
							<label for="imageSourceURL">Image source URL</label>
							<input id="imageSourceURL" name="imageSourceURL" type="text" value="<?php echo $restaurant ? $restaurant['imageSourceURL'] : ''; ?>" required/>
						</div>
					</fieldset>

					<div class="button-wrap">
						<input type="submit" value="Submit"/>
					</div>

				</form>
				<?php } else { ?>
					<div class="alert alert-error">
						<p>You must be logged in to perform that action.</p>
						<a href="admin.php">Log in</a>
					</div>
				<?php } ?>
			</div>
		</section>

	</main>

	<?php include('partials/footer.php'); ?>

</body>
</html>