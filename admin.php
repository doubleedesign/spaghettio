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
			<div class="container container-content">
				<div class="button-wrap">
					<a href="insert.php" class="btn btn-secondary">Insert new restaurant</a>
				</div>
				<table>
					<thead>
						<tr>
							<th colspan="2">Restaurant</th>
							<th colspan="3">Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach($restaurants as $restaurant) { ?>
							<tr>
								<td class="image">
									<a class="image-wrap" href="detail.php?id=<?php echo $restaurant['ID']; ?>">
										<img src="<?php echo $restaurant['imagePath']; ?>" alt="<?php echo $restaurant['name'];?>"/>
									</a>
								</td>
								<td class="copy">
									<p>
										<a href="detail.php?id=<?php echo $restaurant['ID']; ?>"><?php echo $restaurant['name']; ?></a>
										<?php echo $restaurant['address']; ?>
									</p>
								</td>
								<td class="action"><a href="detail.php?id=<?php echo $restaurant['ID']; ?>" class="btn btn-small btn-secondary">View</a></td>
								<td class="action"><a href="insert.php?id=<?php echo $restaurant['ID']; ?>" class="btn btn-small btn-secondary">Edit</a></td>
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