<?php

class DirectorAlbum extends DirectorWrapper {
	public function get($id, $options = array()) {
		$options['album_id'] = $id;
		return $this->parent->send('get_album', $options);
	}
	
	public function all($options = array()) {
		$response = $this->parent->send('get_album_list', $options);
		return $response->albums;
	}
	
	public function galleries($album_id, $options = array()) {
		if (isset($options['exclude']) && is_array($options['exclude'])) {
			$options['exclude'] = join(',', $options['exclude']);
		}
		$options['album_id'] = $album_id;
		$response = $this->parent->send('get_associated_galleries', $options);
		return $response->galleries;
	}
}

?>