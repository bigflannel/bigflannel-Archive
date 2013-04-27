<?php

class DirectorGallery extends DirectorWrapper {
	public function get($id, $options = array()) {
		$options['gallery_id'] = $id;
		$response = $this->parent->send('get_gallery', $options);
		return $response;
	}
	
	public function all($options = array()) {
		$response = $this->parent->send('get_gallery_list', $options);
		return $response->galleries;
	}
}

?>