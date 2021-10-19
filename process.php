<?php
require_once( 'database/config.php' );
require_once( 'database/dbController.php' );
$db = new dbController();
$db->dbConnect(HOST, USER, PASS, DB);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Spaghettio Admin</title>
	<?php include( 'partials/head.php' ); ?>
</head>
<body>

	<?php include( 'partials/header.php' ); ?>

	<?php
		$heading = 'Submit a restaurant';
		include( 'partials/page-heading.php' );
	?>

	<section class="page-content">
		<div class="container">

			<?php
			if($_FILES['image']['name']) {
				$from = $_FILES['image']['tmp_name'];
				$to = 'uploads/' . $_FILES['image']['name'];
				$file = move_uploaded_file( $from, $to );
			}

			// Assigning to variables for shorthand
			if(isset($_POST['ID'])) {
				$id = $_POST['ID'];
			}
			$name = $_POST['name'];
			$address = $_POST['address'];
			$description = $_POST['description'];
			if(isset($to)) { // a new image was uploaded
				$imagePath = $to;
			}
			else if(isset($id)) { // a new image was not uploaded and this is an existing restaurant being updated
				$restaurant = $db->getRestaurantById($id);
				$imagePath = $restaurant['imagePath'];
			}
			else {
				$imagePath = null;
			}
			$imageCreator = $_POST['imageCreator'];
			$imageSourceURL = $_POST['imageSourceURL'];

			// If ID is set, update the record by that ID
			if(isset($id)) {
				// Grab the post data and make sure the value if 'imagePath' is what we checked above
				// Alternatively, you could create an array of the data you definitely want instead of using the whole $_POST object like so:
				/*
				$newData = array(
					'name' => $name,
					'description' => $description,
					// etc etc
				) */
				$newData = $_POST;
				$newData['imagePath'] = $imagePath;
				$updated = $db->update($id, $newData); // will return ID if successful, false if not

				// If $updated returned true
				if($updated) {?>
					<div class="alert alert-success">
						<p>Record updated successfully.</p>
						<a href="detail.php?id=<?php echo $updated; ?>">View restaurant</a>
					</div>
					<?php
				}
				// Otherwise, if it returned false
				else { ?>
					<div class="alert alert-error">
						<p>Problem updating the record. (Tip: Did you actually change anything?)</p>
						<a href="insert.php?id=<?php echo $id; ?>">Try again</a>
					</div>
				<?php }
			}
			// Otherwise, create new record
			else {

				// Call the insertQuery method from our db connection object
				// and assign the value returned by it (in our case, true or false) to a variable so we can do stuff with it here
				// (Otherwise, it will succeed silently whereas we want to show a message)
				$inserted = $db->insert($name, $address, $description, $imagePath, $imageCreator, $imageSourceURL);

				// If the insertion was successful, it will return our custom array of the record from dbController->insert
				if(is_array($inserted) && isset($inserted['ID'])) { ?>
					<div class="alert alert-success">
						<p>Record inserted successfully.</p>
						<a href="detail.php?id=<?php echo $inserted['ID']; ?>">View restaurant</a>
					</div>
				<?php
				// If it wasn't and it returns the $statement object, we access that slightly differently to an array, using -> not []
				} else if(is_object($inserted) && isset($inserted->error_list)) { ?>
					<div class="alert alert-error">
						<div>
							<p>Problem inserting the record:</p>
							<ul>
								<?php foreach($inserted->error_list as $error) { ?>
									<li><?php echo $error['error']; ?></li>
								<?php } ?>
							</ul>
						</div>
						<a href="insert.php">Try again</a>
					</div>
				<?php } ?>

			<?php } ?>
		</div>
	</section>

	<?php include( 'partials/footer.php' ); ?>

</body>
</html>