/* (c) 2013 bigflannel */
/* This code is licensed under MIT license (see LICENSE.txt for details) */


/* variables for the all pages */
var columnMaxWidth;
var columnMaxHeight;
var imageBorder = 40;

/* functions for all pages */
function constructor() {
	// do the content column width
	columnMaxWidth = $(window).width() - $("#left-column").width();
	columnMaxHeight = $(window).height();
	$("#right-column").css("width", columnMaxWidth);
	// add and or load the logo
	if (settingsData.logoType == 'text') {
		$('#logo').html('<a href="' + srcPrefix + 'index.php">' + settingsData.logoText + '</a>');
		$('#home').remove();
	} else if (settingsData.logoType == 'graphic') {
		$('#logo').html('<a href="' + srcPrefix + 'index.php"><img id="logo-file" src="' + srcPrefix + settingsData.logoFile + '"></a>');
		$('#home').remove();
	}
	// add additional links
	if (settingsData.hasLink) {
		$('#links').html('<a href="' + settingsData.siteLinkAddress + '">' + settingsData.siteLinkText + '</a>');
	}
	$(window).resize(function windowResized() {
		columnMaxWidth = $(window).width() - $("#left-column").width();
		columnMaxHeight = $(window).height();
		$("#right-column").css("width", columnMaxWidth);
		$(".image-main").css("max-width", columnMaxWidth-imageBorder);
		$(".image-main").css("max-height", columnMaxHeight-imageBorder);
	});
}


/* variables for the slideshow on content pages */
var imageCount;
var imageData;
var totalCount;
var slideshowState = false;

/* functions for the slideshow on content pages */
function slideshowConstructor(imageDataSent,imageCountSent,totalCountSent) {
	imageData = imageDataSent;
	imageCount = imageCountSent;
	totalCount = totalCountSent;
	addContent();
}
function addContent() {
	if (imageData[imageCount].is_video == 0) {
		$("#image").html('<img src="' + imageData[imageCount].original.url + '" class="image-main">');
	} else {
		$("#image").html(
			'<video controls preload autoplay x-webkit-airplay="allow" class="image-main" >' +
			'<source src="' + imageData[imageCount].original.url + '?cache=0" type="video/mp4" />' +
			'</video>'
		);
	}
	$("#image-caption").html(imageData[imageCount].caption);
	$(".image-main").css("max-width", columnMaxWidth-imageBorder);
	$(".image-main").css("max-height", columnMaxHeight-imageBorder);
}
function slideshowStart() {
	slideshowState = true;
	next();
	loadCounter = setTimeout('next()', 3000);	
}
function slideshowStop() {
	slideshowState = false;
	clearTimeout(loadCounter);
}
function next() {
	imageCount = imageCount + 1;
	if (imageCount == totalCount) {
		imageCount = 0;
	}
	$('#image').fadeOut('fast', 'swing', function() {
	    // animation complete
	    if (imageData[imageCount].is_video == 0) {
	    	$("#image").html('<img src="' + imageData[imageCount].original.url + '" class="image-main">');
	    } else {
	    	$("#image").html(
	    		'<video controls preload autoplay x-webkit-airplay="allow" class="image-main" >' +
	    		'<source src="' + imageData[imageCount].original.url + '?cache=0" type="video/mp4" />' +
	    		'</video>'
	    	);
	    }
	    $("#image-caption").html(imageData[imageCount].caption);
	    $(".image-main").css("max-width", columnMaxWidth-imageBorder);
	    $(".image-main").css("max-height", columnMaxHeight-imageBorder);
	    $('#image').css('display', 'block');
	    $("#image-count").text((imageCount+1) + ' of ' + totalCount);
	    if (slideshowState == true) {
	    	clearTimeout(loadCounter);
		    loadCounter = setTimeout('next()', 3000);
		}
	});
}
function previous() {
	imageCount = imageCount - 1;
	if (imageCount <  0) {
		imageCount = totalCount-1;
	}
	$('#image').fadeOut('fast', 'swing', function() {
	    // animation complete
	    if (imageData[imageCount].is_video == 0) {
	    	$("#image").html('<img src="' + imageData[imageCount].original.url + '" class="image-main">');
	    } else {
	    	$("#image").html(
	    		'<video controls preload autoplay x-webkit-airplay="allow" class="image-main" >' +
	    		'<source src="' + imageData[imageCount].original.url + '?cache=0" type="video/mp4" />' +
	    		'</video>'
	    	);
	    }
	    $("#image-caption").html(imageData[imageCount].caption);
	    $(".image-main").css("max-width", columnMaxWidth-imageBorder);
	    $(".image-main").css("max-height", columnMaxHeight-imageBorder);
	    $('#image').css('display', 'block');
	    $("#image-count").text((imageCount+1) + ' of ' + totalCount);
	});
}
