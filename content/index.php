<?php
	// (c) 2013 bigflannel
	// This code is licensed under MIT license (see LICENSE.txt for details)
	
	
	include('../conf.php');
	include('../bigflannel-archive/data/classes/DirectorPHP.php');
	$director = new Director($apiKey, $apiPath);
	$albumID = $_GET['albumID'];
	$contentID = $_GET['contentID'];
	$director->cache->set('AlbumCache', '+3 hrs');
	$album = $director->album->get($albumID, array('images_only' => false));
	$albumCount = sizeof($album->contents);
	for ($i = 0; $i < $albumCount; $i++) { 
		if ($contentID == $album->contents[$i]->id) {
			$contentUse = $i;
		}
	}
	$contents = $album->contents;
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
	<script type="text/javascript" src="../bigflannel-archive/js/jquery.touchwipe.min.js"></script>
	<script type="text/javascript" src="../bigflannel-archive/js/app.js"></script>
	<link rel="stylesheet" href="../bigflannel-archive/css/style.css">
	<!-- initiate the slideshow -->
	<script type="text/javascript" language="Javascript">
		$(document).ready(function pageLoaded() {
			srcPrefix = '../';
			settingsData = <?php echo json_encode($settings) ?>;
			constructor();
			var imageData = <?php echo json_encode($contents) ?>;
			var imageCount = <?php echo $contentUse ?>;
			var totalCount = <?php echo $albumCount ?>;
			slideshowConstructor(imageData,imageCount,totalCount);
			$("#next").click(function(){
				next();
			});
			$("#image").click(function(){
				next();
			});
			$("#previous").click(function(){
				previous();
			});
			$("#play").click(function(){
				$('#play').css('display','none');
				$('#pause').css('display','inline-block');
				slideshowStart();
			});
			$("#pause").click(function(){
				$('#pause').css('display','none');
				$('#play').css('display','inline-block');
				slideshowStop();
			});	
			$("#image").touchwipe({
			    wipeLeft: function() {
			    	next();
			    },
			    wipeRight: function() {
			    	previous();
			    },
			    min_move_x: 20,
			    min_move_y: 20,
			    preventDefaultEvents: true
			});
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
			<div class="album-description" id="image-count">
				<?php echo $contentUse+1 ?> of <?php echo $albumCount ?>
			</div><!-- .album-description -->
		</header>
		<nav id="image-nav">
			<?php if ($albumCount>1) { ?>
				<div class="gallery-title">
					<div id="previous">&#60;</div> <div id="pause">pause</div> <div id="play">play</div> <div id="next">&#62;</div><br />
				</div><!-- .gallery-title -->
				<div class="gallery-title">
					<a href="../album/?albumID=<?php echo $album->id ?>">Thumbnails</a>
				</div><!-- .gallery-title -->
				<div class="album-description" id="image-caption">
				</div><!-- .album-description #image-caption -->
			<?php } ?>
			<div id="links">
			</div><!-- #links -->
		</nav><!-- #image-nav -->
	</div><!-- #left-column -->
	<div id="right-column">
		<section>
			<div id="image">
			</div>
		</section>
	</div><!-- #right-column -->
	<footer></footer>
</div><!-- #page -->
</body>
</html>