
<header class="site-header">
	<div class="container">
		<div class="row">
			<div class="logo">
				<a href="index.php">Spaghettio</a>
			</div>
			<nav>
				<form class="search-form" action="search.php" method="get">
					<label for="search-field" class="screen-reader-text">Search</label>
					<input id="search-field" type="search" name="s" placeholder="Search our site"/>
					<button type="submit">
						<i class="fas fa-search"></i>
						<span class="screen-reader-text">Submit search</span>
					</button>
				</form>
				<ul class="menu">
					<?php
					// get the path after the domain using the $_SERVER global - may be different for local vs Jupiter
					$currentPath = $_SERVER['PHP_SELF'];
					// replace the part of the path we don't want with an empty string so we end up with just the .php filename we're linking to
					$filename = str_replace('/webdemo02/', '', $currentPath);
					?>
					<?php if($filename == 'index.php') { ?>
						<li><a class="current-page" href="index.php">Home</a></li>
					<?php } else { ?>
						<li><a href="index.php">Home</a></li>
					<?php } ?>

					<?php if($filename == 'about.php') { ?>
						<li><a class="current-page" href="about.php">About</a></li>
					<?php } else { ?>
						<li><a href="about.php">About</a></li>
					<?php } ?>

					<?php if($filename == 'contact.php') { ?>
						<li><a class="current-page" href="contact.php">Contact</a></li>
					<?php } else { ?>
						<li><a href="contact.php">Contact</a></li>
					<?php } ?>
				</ul>
			</nav>
		</div>
	</div>
</header>