<?php

class DirectorUser extends DirectorWrapper {
	
	function scope($options = array()) {
		$defaults = array('all' => false);
		$options = array_merge($defaults, $options);
		if (!isset($options['model']) || !isset($options['id'])) {
			$this->handle_error('Required parameter missing in user->scope');
		} else {
			$this->parent->user_scope = array($options['model'], $options['id'], $options['all']);
		}
	}
	
	function all($options = array()) {
		if (!empty($this->parent->user_scope)) {
			$options['user_scope_model'] = $this->parent->user_scope[0];
			$options['user_scope_id'] = $this->parent->user_scope[1];
			$options['user_scope_all'] = $this->parent->user_scope[2];
		}
		$response = $this->parent->send('get_users', $options);
		return $response->users;
	}
}

?>