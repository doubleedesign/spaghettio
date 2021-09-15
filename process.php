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
			$from = $_FILES['image']['tmp_name'];
			$to = 'uploads/' . $_FILES['image']['name'];
			move_uploaded_file($from, $to);

			// Assigning to variables for shorthand
			$name = $_POST['name'];
			$address = $_POST['address'];
			$description = $_POST['description'];
			$imagePath = $to;
			$imageCreator = $_POST['imageCreator'];
			$imageSourceURL = $_POST['imageSourceURL'];

			// Build SQL query
			$query = "INSERT INTO `restaurant_details` (`name`, `address`, `description`, `imagePath`, `imageCreator`, `imageSourceURL`) VALUES (?,?,?,?,?,?);";

			// Call the insertQuery method from our db connection object
			// and assign the value returned by it (in our case, true or false) to a variable so we can do stuff with it here
			// (Otherwise, it will succeed silently whereas we want to show a message)
			$inserted_id = $db->insert($query, $name, $address, $description, $imagePath, $imageCreator, $imageSourceURL);

			// If $inserted returned a value
			if(isset($inserted_id['ID'])) {
				?>
				<div class="alert alert-success">
					<p>Record inserted successfully.</p>
					<a href="detail.php?id=<?php echo $inserted_id['ID']; ?>">View restaurant</a>
				</div>
			<?php
			}
			// Otherwise, if it returned false
			else { ?>
				<div class="alert alert-error">
					<p>Problem inserting the record.</p>
					<a href="insert.php">Try again</a>
				</div>
			<?php }	?>
		</div>
	</section>

	<?php include( 'partials/footer.php' ); ?>

</body>
</html>


