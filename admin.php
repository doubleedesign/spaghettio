<?php
require_once('database/config.php');
require_once('database/dbController.php');
$db = new dbController();
$db->dbConnect(HOST, USER, PASS, DB);
$restaurants = $db->getAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Spaghettio Site Admin</title>
	<?php include('partials/head.php'); ?>
</head>
<body>

	<?php include('partials/header.php'); ?>

	<?php
	$heading = 'Site admin';
	include('partials/page-heading.php');
	?>

	<main>
		<section class="page-content">
			<div class="container">
				<div class="button-wrap">
					<a href="insert.php" class="btn btn-secondary">Insert new restaurant</a>
				</div>
				<table>
					<thead>
						<tr>
							<th colspan="2">Restaurant</th>
							<th colspan="2">Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach($restaurants as $restaurant) { ?>
							<tr>
								<td class="image">
									<div class="image-wrap">
										<img src="<?php echo $restaurant['imagePath']; ?>" alt="<?php echo $restaurant['name'];?>"/>
									</div>
								</td>
								<td class="copy">
									<p>
										<strong><?php echo $restaurant['name']; ?></strong>
										<?php echo $restaurant['address']; ?>
									</p>
								</td>
								<td class="action"><a href="update.php?id=<?php echo $restaurant['ID']; ?>" class="btn btn-small btn-secondary">Edit</a></td>
								<td class="action"><a href="delete.php?id=<?php echo $restaurant['ID']; ?>" class="btn btn-small btn-primary">Delete</a></td>
							</tr>
						<?php } ?>

					</tbody>
				</table>
			</div>
		</section>
	</main>

	<?php include('partials/footer.php'); ?>

</body>
</html>