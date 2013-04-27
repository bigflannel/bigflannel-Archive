<?php

class DirectorContent extends DirectorWrapper {
	public function get($id) {
		$options = array('content_id' => $id);
		$response = $this->parent->send('get_content', $options);
		return $response;
	}
	
	public function all($options = array()) {
		if (isset($options['scope']) && !empty($options['scope'])) {
			$this->parent->params[] = 'scope=' . $options['scope'][0];
			$this->parent->params[] = 'scope_id=' . $options['scope'][1];
			unset($options['scope']);
		}
		if (isset($options['sort_on']) && $options['sort_on'] == 'random') {
			$this->parent->params[] = 'buster=' . rand(1,10);
		}
		$response = $this->parent->send('get_content_list', $options);
		return $response->contents;
	}
}

?>