<?php
session_start();
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
		$heading = 'Site admin';
		include( 'partials/page-heading.php' );
	?>

	<section class="page-content">
		<div class="container">
			<?php
			$email = $_POST['email'];
			$password = $_POST['password'];
			$loggedin = $db->login($email, $password);

			if($loggedin) { ?>
				<div class="alert alert-success">
					<p>Login successful</p>
					<a href="admin.php">Go to admin</a>
				</div>
			<?php } else { ?>
				<div class="alert alert-error">
					<p>Login failed</p>
					<a href="admin.php">Try again</a>
				</div>
			<?php } ?>
		</div>
	</section>

	<?php include( 'partials/footer.php' ); ?>

</body>
</html>