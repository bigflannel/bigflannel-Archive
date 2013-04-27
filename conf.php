<?php
	// (c) 2013 bigflannel
	// This code is licensed under MIT license (see LICENSE.txt for details)
	
	
	// REQUIRED
	// ADD settings to connect to SlideShowPro Director
	$apiKey = '';
	$apiPath = '';
	
	// OPTIONAL
	$settings = array (
		// CHANGE the options below	
		'hasUnwantedGalleries' => true,
		'siteUnwantedGalleries' => '1,2,4',
		'hasWantedGalleries' => false,
		'siteWantedGalleries' => '1,4',
		'galleryOrder' => 'byTitle',
		'logoType' => 'text',
		'logoText' => 'bigflannel Archive',
		'logoFile' => 'bigflannel-archive/bigflannel-archive-logo.png',
		'hasLink' => true,
		'siteLinkText' => 'bigflannel Portfolio',
		'siteLinkAddress' => 'http://bigflannel.com/portfolio/light'
	);
?>