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
	<title>Delete restaurant</title>
	<?php include('partials/head.php'); ?>
</head>
<body>

	<?php include('partials/header.php'); ?>

	<?php
	$heading = 'Delete ' . $restaurant['name'];
	include('partials/page-heading.php');
	?>

	<main>
		<section class="page-content">
			<div class="container container-content">

				<?php
				if(isset($_GET['confirm']) && $_GET['confirm']) {
					// Assign the return value of the delete method (in this case a boolean)
					// to a variable so we can check if it returned true or false
					// It would still perform the action even if we didn't assign it to a variable,
					// we just wouldn't have access to the return value of $db->delete($id);
					$deleted = $db->delete($id);
					if($deleted) {
					?>
						<div class="alert alert-success">
							<p>Restaurant <?php echo $restaurant['name']; ?> has been deleted.</p>
						</div>
					<?php } else { ?>
						<div class="alert alert-error">
							<p>There was an error deleting the restaurant. Are you sure it exists?</p>
						</div>
					<?php } ?>
				<?php
				}
				else { ?>
					<h2>Are you sure you want to delete this restaurant?</h2>
					<?php
					$id = $restaurant['ID'];
					$url = "detail.php?id=$id";
					$name = $restaurant['name'];
					$description = $restaurant['description'];
					$imagePath = $restaurant['imagePath'];
					$linkTarget = '';

					if(!empty($name)) {
						include('partials/card.php');
					}
					?>
					<div class="button-wrap">
						<a href="admin.php" class="btn btn-primary">Cancel</a>
						<a href="delete.php?id=<?php echo $id; ?>&confirm=true" class="btn btn-secondary">Confirm</a>
					</div>
				<?php } ?>
			</div>
		</section>
	</main>

	<?php include('partials/footer.php'); ?>

</body>
</html>