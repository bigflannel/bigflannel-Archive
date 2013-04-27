<?php
	// (c) 2013 bigflannel
	// This code is licensed under MIT license (see LICENSE.txt for details)
	
	
	include('../conf.php');
	include('../bigflannel-archive/data/classes/DirectorPHP.php');
	$director = new Director($apiKey, $apiPath);
	$albumID = $_GET['albumID'];
	$director->cache->set('AlbumCache', '+3 hrs');
	$director->format->add(array('name' => 'thumbnail', 'width' => '10000', 'height' => '100', 'crop' => 0, 'quality' => 90, 'sharpening' => 0));	
	$album = $director->album->get($albumID, array('images_only' => false));
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
	<script type="text/javascript" src="../bigflannel-archive/js/app.js"></script>
	<link rel="stylesheet" href="../bigflannel-archive/css/style.css">
	<!-- initiate the application-->
	<script type="text/javascript" language="Javascript">
		$(document).ready(function pageLoaded() {
			srcPrefix = '../';
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
			</div><!-- .gallery-title -->
			<div id="home" class="gallery-title">
				<a href="../index.php">Home</a>
			</div><!-- .gallery-title -->
		</nav><!-- #main -->
		<header id="album-text">
			<div class="album-title">
				<?php echo $album->name ?>
			</div><!-- .album-title -->
			<div class="album-description">
				<?php echo $album->description ?>
			</div><!-- .album-description -->
			<div id="links">
			</div><!-- #links -->
		</header>
	</div><!-- #left-column -->
	<div id="right-column">
		<section>
		<?php // Loop through album content
			$contents = $album->contents;
			foreach($contents as $content) {
				echo '<div class="image-thumb"><a href="../content/?albumID=' . $album->id . '&contentID=' . $content->id . '"><img src="' . $content->thumbnail->url . '"></a></div>';
			}
		?>
		</section>
	</div><!-- #right-column -->
	<footer></footer>
</div><!-- #page -->
</body>
</html>