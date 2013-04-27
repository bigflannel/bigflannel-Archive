<?php
	// (c) 2013 bigflannel
	// This code is licensed under MIT license (see LICENSE.txt for details)
	
	
	$director = new Director($apiKey, $apiPath);
	$director->cache->set('GalleryCache', '+3 hrs');
	$preview = array(
		'width' => '190',
		'height' => '110',
		'crop' => 1,
		'quality' => 90,
		'sharpening' => 0
		);
	$director->format->preview($preview);
	// if hasWantedGalleries is true, load some galleries, else load all and amend the array
	if ( $settings['hasWantedGalleries'] ) {
		// load separate galleries
		$galleries = array ();
		$siteWantedGalleries = explode( "," , $settings['siteWantedGalleries'] );
		for ($i=0; $i<count( $siteWantedGalleries ); $i++) {
			// load that gallery's data
			$gallery = $director->gallery->get($siteWantedGalleries[$i],array('with_content' => false));
			array_push($galleries, $gallery);
		}
	} else {
		// load all galleries
		$allGalleries = $director->gallery->all();
		$galleries = array();
		if ( $settings['hasUnwantedGalleries'] ) {
			// remove unwanted galleries
			$siteUnwantedGalleries = explode( "," , $settings['siteUnwantedGalleries'] );
			foreach($allGalleries as $gallery) {
				$unwanted = false;
				for ($i=0; $i<count( $siteUnwantedGalleries ); $i++) {
					if ( $gallery->id == $siteUnwantedGalleries[$i] ) {
						// gallery unwanted
						$unwanted = true;
					}
				}
				if ( $unwanted == false ) {
					array_push($galleries, $gallery);
				}
			}
		} else {
			$galleries = $allGalleries;
		}
	}
	// galleryOrder
	if ( $settings['galleryOrder'] == 'byTitle' ) {
	    // sort by name, case insensitive (strcmp is case sensitive)
		function sortByName( $a,$b ) {
		    return strcasecmp( $a->name, $b->name );
		}
		usort( $galleries, 'sortByName' );
	} else if ( $settings['galleryOrder'] == 'byID' ) {
		// sort by id, case insensitive (strcmp is case sensitive)
	    function sortByID( $a,$b ) {
	        return strcasecmp( $a->id, $b->id );
	    }
		usort( $galleries, 'sortByID' );
	}
?>