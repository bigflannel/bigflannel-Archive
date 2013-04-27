<?php
	// (c) 2013 bigflannel
	// This code is licensed under MIT license (see LICENSE.txt for details)
	

	include('conf.php');
	include('bigflannel-archive/data/classes/DirectorPHP.php');
	include('bigflannel-archive/data/data.php');	
	$galleryRead = $_GET['galleryID'];
	if (isset($galleryRead)) {
		for ($i = 0; $i < count($galleries); $i++) { 
			if ($galleryRead == $galleries[$i]->id) {
				$galleryUse = $i;
			}
		}
	} else {
		$galleryUse = 0;
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>bigflannel Archive</title>
	<meta name="description" content="">
	<meta name="keywords" content="">
    <!--[if IE]>
	<script type="text/javascript" src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<!-- load open sans font -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet' type='text/css'>
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
	<script type="text/javascript" src="bigflannel-archive/js/app.js"></script>
	<link rel="stylesheet" href="bigflannel-archive/css/style.css">
	<!-- initiate the application-->
	<script type="text/javascript" language="Javascript">
		$(document).ready(function pageLoaded() {
			srcPrefix = '';
			settingsData = <?php echo json_encode($settings) ?>;
			constructor();
		});
	</script> 
</head>
<body>
<div id="page">
	<div id="left-column">	
		<nav id="main">
			<div id="logo" class="gallery-title">
			</div><!-- #logo -->
			<div id="home" class="gallery-title">
				<a href="index.php">Home</a>
			</div><!-- #home -->
			<?php foreach($galleries as $gallery) { ?>
					<div class="gallery-title">
						<a href="?galleryID=<?php echo $gallery->id ?>"><?php echo $gallery->name ?></a>
				    </div><!-- .gallery-title -->
			<?php } ?>
			<div id="links">
			</div><!-- #links -->
		</nav><!-- #main -->
	</div><!-- #left-column -->
	<div id="right-column">
		<section>
		<?php $count = sizeof($galleries[$galleryUse]->albums);
		for ($i = 0; $i < $count; $i++) { ?>
			<article class="album-button">
				<a href="album/?albumID=<?php echo $galleries[$galleryUse]->albums[$i]->id ?>"><img src="<?php echo $galleries[$galleryUse]->albums[$i]->preview->url ?>" alt="<?php echo $galleries[$galleryUse]->albums[$i]->name ?>" class="album-thumb"/></a><br/>
				<div class="album-title">
					<a href="album/?albumID=<?php echo $galleries[$galleryUse]->albums[$i]->id ?>"><?php echo $galleries[$galleryUse]->albums[$i]->name ?></a>
				</div><!-- .album-title -->
				<div class="album-description">
					<?php echo $galleries[$galleryUse]->albums[$i]->description ?>
				</div><!-- .album-description -->
			</article><!-- .album-thumb -->
		<?php  } ?>
		</section>
	</div><!-- #right-column -->
	<footer></footer>
</div><!-- #page -->
</body>
</html>