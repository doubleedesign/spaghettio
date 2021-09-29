<?php
if(!isset($url)) {
	$url = "";
}
if(isset($linkTarget)) {
	$linkTargetHTML = 'target="'.$linkTarget.'"';
}
else {
	$linkTargetHTML = "";
}
?>

<a class="card" href="<?php echo $url; ?>" <?php echo $linkTargetHTML; ?>>
	<div class="card-inner">
		<div class="card-top">
			<?php if(isset($imagePath)) { ?>
				<img src="<?php echo $imagePath; ?>" alt=""/>
			<?php } ?>
			<?php if(isset($name)) { ?>
				<h2><?php echo $name; ?></h2>
			<?php } ?>
		</div>
		<?php if(isset($description)) { ?>
			<div class="card-text">
				<p><?php echo $description; ?></p>
			</div>
		<?php } ?>
	</div>
</a>